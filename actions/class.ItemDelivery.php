<?php 
/**
 * This class is a container to call TAO XHTML items.
 * 
 * It enables you to run this kind of item in the context of a TAO server
 * by initiliazing it (set the context varaibles) and by rendering it.   
 * 
 * @author CRP Henri Tudor - TAO Team - {@link http://www.tao.lu}
 * @package taoDelivery
 * @subpackage actions
 * @license GPLv2  http://www.opensource.org/licenses/gpl-2.0.php
 */
class taoDelivery_actions_ItemDelivery extends tao_actions_Api {
	
	/**
	 * @see ItemDelivery::runner
	 */
	public function index(){
		$this->forward(get_class($this), 'runner');
	}
	
	/**
	 * This action run an item during a delivery execution
	 * @return void
	 */
	public function runner(){
		
		if(Session::hasAttribute('processUri') && 
				$this->hasRequestParameter('itemUri') && 
				$this->hasRequestParameter('testUri') &&
				$this->hasRequestParameter('deliveryUri') ){
			
			$user = $this->userService->getCurrentUser();
			if(is_null($user)){
				throw new Exception(__('No user is logged in'));
			}
			
			$process	= new core_kernel_classes_Resource(tao_helpers_Uri::decode(Session::getAttribute('processUri')));
			$item 		= new core_kernel_classes_Resource(tao_helpers_Uri::decode($this->getRequestParameter('itemUri')));
			$test 		= new core_kernel_classes_Resource(tao_helpers_Uri::decode($this->getRequestParameter('testUri')));
			$delivery 	= new core_kernel_classes_Resource(tao_helpers_Uri::decode($this->getRequestParameter('deliveryUri')));
			
			$executionEnvironment = $this->createExecutionEnvironment($process, $item, $test, $delivery, $user);
			
			//retrieving of the compiled item content
			$compiledFolder = $this->getCompiledFolder($executionEnvironment);
			$compiled = $compiledFolder .'index.html';	

			if(!file_exists($compiled)){
				throw new Exception(__("Unable to load the compiled item content"));
			}
			
			$apis = array(
				'taoApi', 
				'taoMatching', 
				'wfApi'
			);
			
			// We inject the data directly in the item file
			try{
				$doc = new DOMDocument();
				$doc->loadHTMLFile($compiled);
				
				$initScriptElt = $doc->createElement('script');
				$initScriptElt->setAttribute('type', 'text/javascript');
				$initScriptElt->setAttribute('src', _url('initApis', 'ItemDelivery', 'taoDelivery', array('token' => $executionEnvironment['token'])));
				
				$headNodes = $doc->getElementsByTagName('head');
				
				foreach($headNodes as $headNode){
					$inserted = false;
					$scriptNodes = $headNode->getElementsByTagName('script');
					$poisition = 0;
					if($scriptNodes->length > 0){
						foreach($scriptNodes as $index => $scriptNode){
							if($scriptNode->hasAttribute('src')){
								foreach($apis as $api){
									if(preg_match("/$api.min\.js$/", $scriptNode->getAttribute('src'))){
										if($index > $position){
											$position = $index;
										}
										break;
									}
								}
							}
						}
						if($scriptNodes->item($position + 1)){
							$headNode->insertBefore($initScriptElt, $scriptNodes->item($position + 1));
							$inserted = true;
						}
					}
					if(!$inserted){
						$apiUrl = str_replace(ROOT_PATH, ROOT_URL, $compiledFolder).'/js/';
						foreach($apis as $api){
							$apiScriptElt = $doc->createElement('script');
							$apiScriptElt->setAttribute('type', 'text/javascript');
							$apiScriptElt->setAttribute('src', $apiUrl.$api.'.min.js');
							$headNode->appendChild($apiScriptElt);
						}
						
						$headNode->appendChild($initScriptElt);
					}
					break;
				}
				
				//render the item
				echo $doc->saveHTML();
				
			}
			catch(DOMException $de){
				if(DEBUG_MODE){
					throw new Exception(__("An error occured while loading the item: ") . $de);
				}
				else{
					error_log($de->getMessage);		//log the error in the log file and display a common message
					throw new Exception(__("An error occured while loading the item"));
				}
			}
		}
	}
	
	/**
	 * Action to render a dynamic javascript page
	 * containing the APIs initialization for the current execution context
	 */
	public function initApis(){
		
		if($this->hasRequestParameter('token')){

			$executionEnvironment = $this->getExecutionEnvironment();
			if(isset($executionEnvironment['token'])){
				if($this->getRequestParameter('token') == $executionEnvironment['token'] && !empty($executionEnvironment['token'])){
				
					//get the deployment parameters
					$deploymentParams 	= array();
					$deliveryService 	= tao_models_classes_ServiceFactory::get('taoDelivery_models_classes_DeliveryService');
					$delivery 			= new core_kernel_classes_Resource($executionEnvironment[TAO_DELIVERY_CLASS]['uri']);
					$resultServer 		= $deliveryService->getResultServer($delivery);
					if(!is_null($resultServer)){
						$resultServerService 	= tao_models_classes_ServiceFactory::get('taoDelivery_models_classes_ResultServerService');
						$resultServer 			= new core_kernel_classes_Resource(TAO_DELIVERY_DEFAULT_RESULT_SERVER);
						$deploymentParams 		= $resultServerService->getDelpoymentParameters($resultServer);
					}

					//response is a javascript stream 
					$this->setContentHeader('application/javascript');
					
					//initialize taoApi data source
					$this->setData('envVarName', self::ENV_VAR_NAME);
					$this->setData('executionEnvironment', json_encode($executionEnvironment));
					
					//initialize taoApi push parameters
					if(isset($deploymentParams['save_result_url'])){
						$this->setData('pushParams', json_encode(array(
								'url' 		=> $deploymentParams['save_result_url'], 
								'params'	=> array('token' => $executionEnvironment['token'])
						)));
					}
					
					//initialize taoApi events tracing parameters
					$compiledFolder = $this->getCompiledFolder($executionEnvironment);
					if(file_exists($compiledFolder .'/events.xml')){
						$eventService = tao_models_classes_ServiceFactory::get("tao_models_classes_EventsService");
						$eventData =  $eventService->getEventList($compiledFolder .'/events.xml');
						
						$this->setData('eventData', json_encode($eventData));
						$eventParams = 'null';
						if(isset($deploymentParams['save_event_url'])){
							$eventParams = json_encode(array(
								'url' 		=> $deploymentParams['save_event_url'], 
								'params'	=> array('token' => $executionEnvironment['token'])
							));
						}
						$this->setData('eventParams', $eventParams);
					}
					
					
					//initialize the matching Api
					if(isset($deploymentParams['matching_server'])){
						
						$this->setData('matchingServer', $deploymentParams['matching_server']);
						
						if($deploymentParams['matching_server'] === true){
							if(isset($deploymentParams['matching_url'])){
								$this->setData('matchingParams', json_encode( array(
									'url'		=> $deploymentParams['matching_url'],
									'params'	=> array('token' => $executionEnvironment['token']) 
								)));
							}
						}
						else{
							$itemService 	= tao_models_classes_ServiceFactory::get('taoItems_models_classes_ItemService');
							$item			= new core_kernel_classes_Resource($executionEnvironment[TAO_ITEM_CLASS]['uri']);
							$this->setData('matchingData', json_encode($itemService->getMatchingData($item)));
						}
					}
					
					//initialize the wfApi recovery context
					$ctxParams = array('params' => array('token' => $executionEnvironment['token']));
					$this->setData('contextSourceParams', json_encode($ctxParams));
					$this->setData('contextDestinationParams', json_encode($ctxParams));
					
					
					$this->setView('init_api.js.tpl');
				}
			}
		}
		return;
	}
}
?>