<?php
define('NS_TAOQUAL', 'http://www.tao.lu/middleware/taoqual.rdf');

$todefine = array(
	'TAO_DELIVERY_CLASS' 		=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#Delivery',
	'TAO_SUBJECT_CLASS' 	=> 'http://www.tao.lu/Ontologies/TAOSubject.rdf#Subject',
	'TAO_GROUP_CLASS' => 'http://www.tao.lu/Ontologies/TAOGroup.rdf#Group',
	'TAO_TEST_CLASS' 		=> 'http://www.tao.lu/Ontologies/TAOTest.rdf#Test',
	'TAO_ITEM_MODEL_CLASS' 	=> 'http://www.tao.lu/Ontologies/TAOItem.rdf#ItemModels',
	'TAO_RESULT_CLASS' 		=> 'http://www.tao.lu/Ontologies/TAOResult.rdf#Result',
	// 'LOCAL_NAMESPACE' 		=> 'http://127.0.0.1/middleware/demo.rdf',
	'TEST_RELATED_ITEMS_PROP' 	=> 'http://www.tao.lu/Ontologies/TAOTest.rdf#RelatedItems',
	'TEST_TESTCONTENT_PROP' 	=> 'http://www.tao.lu/Ontologies/TAOTest.rdf#TestContent',
	'TEST_COMPILED_PROP' 	=> 'http://www.tao.lu/Ontologies/TAOTest.rdf#compiled',
	'TEST_ACTIVE_PROP' 	=> 'http://www.tao.lu/Ontologies/TAOTest.rdf#active',
	'ITEM_ITEMCONTENT_PROP' 	=> 'http://www.tao.lu/Ontologies/TAOItem.rdf#ItemContent',
	'ITEM_ITEMMODEL_PROP' 	=> 'http://www.tao.lu/Ontologies/TAOItem.rdf#ItemModel',
	'ITEM_MODEL_RUNTIME_PROP' 	=> 'http://www.tao.lu/Ontologies/TAOItem.rdf#SWFFile', 
	'SUBJECT_LOGIN_PROP' => 'http://www.tao.lu/Ontologies/TAOSubject.rdf#Login',
	'SUBJECT_PASSWORD_PROP' => 'http://www.tao.lu/Ontologies/TAOSubject.rdf#Password',
	
	// 'TAO_DELIVERY_SUBJECTS_PROP'=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#Subjects',
	'TAO_DELIVERY_EXCLUDEDSUBJECTS_PROP'=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#ExcludedSubjects',
	'TAO_DELIVERY_TESTS_PROP'	=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#Tests',
	
	'TAO_ITEM_MODEL_PROPERTY' 			=> 'http://www.tao.lu/Ontologies/TAOItem.rdf#ItemModel', 
	'TAO_ITEM_MODEL_WATERPHENIX'		=> 'http://www.tao.lu/Ontologies/TAOItem.rdf#125933161031263',
	'TAO_ITEM_CLASS' 					=> 'http://www.tao.lu/Ontologies/TAOItem.rdf#Item',
	'TAO_ITEM_AUTHORING_BASE_URI' 		=> $_SERVER['DOCUMENT_ROOT'].'/taoItems/data',
	'TAO_ITEM_AUTHORING_TPL_FILE' 		=> $_SERVER['DOCUMENT_ROOT'].'/taoItems/data/black_ref.xml',
	
	'GENERIS_BOOLEAN'		=> 'http://www.tao.lu/Ontologies/generis.rdf#Boolean',
	'RDFS_LABEL'			=> 'http://www.w3.org/2000/01/rdf-schema#label',
	'RDFS_TYPE'				=> 'http://www.w3.org/1999/02/22-rdf-syntax-ns#type',
	
	'TAO_DELIVERY_COMPILED_PROP'	=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#Compiled',
	
	'TAO_DELIVERY_CAMPAIGN_CLASS'	=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#DeliveryCampaign',	
	'TAO_DELIVERY_CAMPAIGN_PROP'	=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#Campaign',
	'TAO_DELIVERY_RESULTSERVER_CLASS'	=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#DeliveryResultServer',	
	'TAO_DELIVERY_RESULTSERVER_PROP'	=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#ResultServer',
	'TAO_DELIVERY_HISTORY_CLASS'	=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#History',	
	'TAO_DELIVERY_HISTORY_SUBJECT_PROP'	=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#HistorySubject',
	'TAO_DELIVERY_HISTORY_DELIVERY_PROP'	=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#HistoryDelivery',
	'TAO_DELIVERY_HISTORY_TIMESTAMP_PROP'	=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#HistoryTimestamp',
	'TAO_DELIVERY_DELIVERYCONTENT'	=> 'http://www.tao.lu/Ontologies/TAODelivery.rdf#DeliveryContent',
	
	'CLASS_PROCESS' => NS_TAOQUAL . '#118588753722590',
	'CLASS_CALLOFSERVICES' => NS_TAOQUAL . '#118595077025536',
	'CLASS_TRANSITIONRULES' => NS_TAOQUAL . '#122206969324866',
	'CLASS_CONNECTORS' => NS_TAOQUAL . '#118589215756172',
	'CLASS_ACTIVITIES' => NS_TAOQUAL . '#118588757437650',
	'CLASS_SERVICESDEFINITION' => NS_TAOQUAL . '#118588759532084',
	'CLASS_ROLE' => NS_TAOQUAL . '#118588820437156',
	'CLASS_FORMALPARAMETER' => NS_TAOQUAL . '#118588904546812',
	'CLASS_WEBSERVICES' => NS_TAOQUAL . '#118588763446870',
	'CLASS_SUPPORTSERVICES' => NS_TAOQUAL . '#118588779325312',
	'CLASS_ACTUALPARAMETER' =>  NS_TAOQUAL . '#118588960462136',
	'PROPERTY_PROCESS_ACTIVITIES' => NS_TAOQUAL . '#118735548956256',
	// 'PROPERTY_CONNECTORS_PRECACTIVITIES' => NS_TAOQUAL . '#118589245545368',
	'PROPERTY_CALLOFSERVICES_SERVICEDEFINITION' => NS_TAOQUAL . '#11859509039346',
	'PROPERTY_CALLOFSERVICES_ACTUALPARAMOUT' => NS_TAOQUAL . '#118596586150000',//Used for saving the param value
	'PROPERTY_CALLOFSERVICES_ACTUALPARAMIN' => NS_TAOQUAL . '#118595099928140',//Used for saving the param value
	'PROPERTY_SERVICESDEFINITION_FORMALPARAMOUT' => NS_TAOQUAL . '#118588897651172',
	'PROPERTY_SERVICESDEFINITION_FORMALPARAMIN' => NS_TAOQUAL . '#118588892919658',
	'PROPERTY_ACTUALPARAM_FORMALPARAM' => NS_TAOQUAL . '#118588973457282',
	'PROPERTY_ACTUALPARAM_CONSTANTVALUE' => NS_TAOQUAL . '#1185890127346',
	'PROPERTY_ACTUALPARAM_PROCESSVARIABLE' => NS_TAOQUAL . '#11858901499008',
	'PROPERTY_ACTUALPARAM_QUALITYMETRIC' => NS_TAOQUAL . '#118589023027962',
	'PROPERTY_FORMALPARAM_DEFAULTVALUE' => NS_TAOQUAL . '#118588964565322',
	'PROPERTY_CONNECTORS_TYPE' => NS_TAOQUAL . '#118595164231830',
	'PROPERTY_CONNECTORS_TRANSITIONRULE' => NS_TAOQUAL . '#122207114241798',
	'PROPERTY_CONNECTORS_PRECACTIVITIES' => NS_TAOQUAL . '#118589245545368',
	'PROPERTY_CONNECTORS_NEXTACTIVITIES' => NS_TAOQUAL . '#118589252058280',
	'PROPERTY_TRANSITIONRULE_THEN' => NS_TAOQUAL . '#122207070428322',
	'PROPERTY_TRANSITIONRULE_ELSE' => NS_TAOQUAL . '#122207096147834',
	'PROPERTY_ACTIVITIES_INTERACTIVESERVICES' => NS_TAOQUAL . '#118588789618848',
	'PROPERTY_ACTIVITIES_CONSISTENCYRULE' => NS_TAOQUAL . '#122346640532066',
	'PROPERTY_ACTIVITIES_ONAFTERINFERENCERULE' => NS_TAOQUAL . '#activityInferenceRule',
	'PROPERTY_ACTIVITIES_ONBEFOREINFERENCERULE' => NS_TAOQUAL . '#activityOnBeforeInferenceRule'
	
);

foreach($todefine as $constName => $constValue){
	if(!defined($constName)){
		define($constName, $constValue);
	}
}
unset($todefine);
?>
