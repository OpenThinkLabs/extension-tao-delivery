<?php
if (0 > version_compare(PHP_VERSION, '5')) {
	die('This file was generated for PHP 5');
}

require_once('class.GenerisConnector.php');

class ConditionDescriptor
	extends GenerisConnector 
{
	//Recursive subExpressions case
	public $bool; //and, or, not
	public $subConditionsList = null; //allways two subExpressions

	//terminal condition
	public $leftPart;
	public $rightPart;

	public $cmp; //("equal","notEqual","greater","greaterEqual","less","lessEqual")

	public $leftPartType; //variable,constant, aroperation
	public $rightPartType; //variable,constant, aroperation
	public $arithmeticOperator; //+,-,*,/,. (concat)



	public function __toString(){
		if (sizeOf($this->subConditionsList)>1) //sic test 
		{
			return ' ( '. $this->subConditionsList[0] .' ' .  $this->bool . '' . $this->subConditionsList[1].")";
		}
		else {

			return ' '. $this->leftPart .' '. $this->cmp .' '. $this->rightPart;
		}
	}

	public function import(){
			/*
			move this to constants.php
			 */


		//create an instance of expression

		$expressionClass = new core_kernel_classes_Class(CLASS_EXPRESSION,__METHOD__);
		$firstExpressionProperty = new core_kernel_classes_Property(PROPERTY_FIRST_EXPRESSION,__METHOD__);
		$secondExpressionProperty = new core_kernel_classes_Property(PROPERTY_SECOND_EXPRESSION,__METHOD__);
		$logicalOperatorProperty = new core_kernel_classes_Property(PROPERTY_HASLOGICALOPERATOR,__METHOD__);
		$terminalExpressionProperty = new core_kernel_classes_Property(PROPERTY_TERMINAL_EXPRESSION,__METHOD__);
		$termValueProperty = new core_kernel_classes_Property(PROPERTY_TERM_VALUE,__METHOD__);
		//check if it is a terminal expression , do not create subExpression

		//we enter recursive case if there are subconditions defined
		//the operator value could be either AND OR, (we have then two subconditions ) 
		if (sizeOf($this->subConditionsList)>1) //sic test
		{
			$expressionInstance =$expressionClass->createInstance("Expression : " . $this , __(" generated by Condition Descriptor on ") . date(DATE_ISO8601));	
			//creates the first sub expression


			//call recursively for the first subcondition

			$firstExpression = $this->subConditionsList[0]->import();
			//link it with the expression
			$expressionInstance->setPropertyValue($firstExpressionProperty ,$firstExpression->uriResource);	


			//creates the second subexpression
			//call recursively for the second subcondition
			$secondExpression = $this->subConditionsList[1]->import();

			//link it with the expression
			$expressionInstance->setPropertyValue($secondExpressionProperty,$secondExpression->uriResource);	
			//call recursively for the second subcondition

			//defines the operator type

			switch (strtoupper($this->bool))
			{
			case "AND":{
				$operator = INSTANCE_AND_OPERATOR;
				break;}
			case "OR":{
				$operator = INSTANCE_OR_OPERATOR;
				break;}

			case "NOT":{
				$operator = INSTANCE_NOT_OPERATOR;
				break;}

				//NAND
			default:{
				$operator = INSTANCE_OR_OPERATOR;
				break;}
			}

			$expressionInstance->setPropertyValue($logicalOperatorProperty ,$operator);	
			$expressionInstance->setPropertyValue($terminalExpressionProperty,INSTANCE_EMPTY_TERM_URI);

		}
		else{
			//analyse left and right part and call the right import function to get the right terminal term (SPX, const, or operation)
			switch ($this->leftPartType){
				//if left part is a variable , creates a term -> SPX
				case "variable":{ $leftTerm = $this->importTermSPX($this->leftPart);break;}
				case "constant":{ $leftTerm = $this->importTermConstant($this->leftPart);break;}
				case "aroperation":{ 
					//recursive call on left part 
					if ($this->leftPart instanceOf ConditionDescriptor){
						$leftTerm = $this->leftPart->importTermOperation();
					}
					break;
				}
				default:{}
			}

			//if right part is a constant

			switch ($this->rightPartType){
				case "variable":{ $rightTerm = $this->importTermSPX($this->rightPart);break;}
				case "constant":{ $rightTerm = $this->importTermConstant($this->rightPart);break;}
				case "aroperation":{ 
					//recursive call on right part 
					if ($this->rightPart instanceOf ConditionDescriptor){
						$rightTerm = $this->rightPart->importTermOperation();
					}
					break;
				}
				default:{}
			}

			$expressionClass = new core_kernel_classes_Class(CLASS_EXPRESSION,__METHOD__);

			$leftExpression =$expressionClass->createInstance("Left Expr:" . $this->leftPart , __(" generated by CapiImport on ") . date(DATE_ISO8601));
			$rightExpression =$expressionClass->createInstance("Right Expr:" . $this->rightPart , __(" generated by CapiImport on ") . date(DATE_ISO8601));

			$leftExpression->setPropertyValue($terminalExpressionProperty,$leftTerm->uriResource);
			$leftExpression->setPropertyValue($logicalOperatorProperty,INSTANCE_EXISTS_OPERATOR_URI);
			//unary operator

			if (isset($rightTerm)){
				$rightExpression->setPropertyValue($terminalExpressionProperty,$rightTerm->uriResource);
				$rightExpression->setPropertyValue($logicalOperatorProperty,INSTANCE_EXISTS_OPERATOR_URI);
			}
			$expressionInstance  = $expressionClass->createInstance($this, __(" generated by CapiImport on ") . date(DATE_ISO8601));

			//creates the term and link it with the expressioninstance

			$expressionInstance->setPropertyValue($firstExpressionProperty,$leftExpression->uriResource);
			//unary operator
			if (isset($rightExpression)){
				$expressionInstance->setPropertyValue($secondExpressionProperty,$rightExpression->uriResource);
			}
			$expressionInstance->setPropertyValue($terminalExpressionProperty,INSTANCE_EMPTY_TERM_URI);

			switch($this->cmp){
				case 'equal' : {
					$expressionInstance->setPropertyValue($logicalOperatorProperty ,INSTANCE_EQUALS_OPERATOR_URI);
					break;
				}
				case 'notEqual' : {
					$expressionInstance->setPropertyValue($logicalOperatorProperty ,INSTANCE_DIFFERENT_OPERATOR_URI);
					break;
				}
				case 'greaterEqual' : {
					$expressionInstance->setPropertyValue($logicalOperatorProperty ,INSTANCE_SUP_EQ_OPERATOR_URI);
					break;
				}
				case 'lessEqual' : {
					$expressionInstance->setPropertyValue($logicalOperatorProperty ,INSTANCE_INF_EQ_OPERATOR_URI);
					break;
				}
				case 'greater' : {
					$expressionInstance->setPropertyValue($logicalOperatorProperty ,INSTANCE_SUP_OPERATOR_URI);
					break;
				}
				case 'less' : {
					$expressionInstance->setPropertyValue($logicalOperatorProperty ,INSTANCE_INF_OPERATOR_URI);
					break;
				}
		
				case 'exists' : {
					trigger_error("exists not implemented yet");
				}
				
				case 'answered' : {
					trigger_error("answered not implemented yet");
				}
				default : {
					echo "\n[".$this->cmp ."] in ".$this." is not implemented yet \n" ;
				}
			}
		}

		//returns the instance of expression
		return $expressionInstance;
	}

	/**
	 * import either $leftPart or $rightpart given in $variable, $variable must be a variable
	 **/

	private function importTermSPX($variable){

		$termClass = new core_kernel_classes_Class(CLASS_TERM_SUJET_PREDICATE_X,__METHOD__);
		//creates a Term
		$termInstance =$termClass->createInstance("Term : SPX " . $variable , __(" generated by CapiImport on ") . date(DATE_ISO8601));

		$subjectProperty = new core_kernel_classes_Property(PROPERTY_TERM_SPX_SUBJET,__METHOD__);
		$predicateProperty = new core_kernel_classes_Property(PROPERTY_TERM_SPX_PREDICATE,__METHOD__);
		$codeProperty = new core_kernel_classes_Property(PROPERTY_CODE,__METHOD__);

		//get the resource with the code "$variable"
		$processInstancePropertyCollection = $this->generisApi->getSubject($codeProperty->uriResource, $variable);
		if(!$processInstancePropertyCollection->isEmpty()){
		
			$processInstanceProperty = $processInstancePropertyCollection->get(0);
			
			$termInstance->setPropertyValue($subjectProperty , VAR_PROCESSINSTANCE_URI);
			$termInstance->setPropertyValue($predicateProperty , $processInstanceProperty->uriResource);
		}
		else{
			throw new common_Exception("the variable $variable doesn't exist, please create it before");//perform a check 
		}

		return $termInstance;



	}
	/**
	 * import either $leftPart or $rightpart given in $constant, $variable must be a constant
	 **/
	private function importTermConstant($constant){
		if ( strtoupper($constant) == 'NULL') {
			return new core_kernel_classes_Resource(INSTANCE_TERM_IS_NULL, __METHOD__);
		}
		$termValueProperty = new core_kernel_classes_Property(PROPERTY_TERM_VALUE,__METHOD__);
		$logicalOperatorProperty = new core_kernel_classes_Property(PROPERTY_HASLOGICALOPERATOR,__METHOD__);
		$terminalExpressionProperty = new core_kernel_classes_Property(PROPERTY_TERMINAL_EXPRESSION,__METHOD__);

		$termConstClass = new core_kernel_classes_Class(CLASS_TERM_CONST,__METHOD__); 
		$termConstInstance =  $termConstClass->createInstance("Term : Constante " . $constant , __(" generated by CapiImport on ") . date(DATE_ISO8601));
		$termConstInstance->setPropertyValue($terminalExpressionProperty,$termConstInstance->uriResource);
		$termConstInstance->setPropertyValue($logicalOperatorProperty,INSTANCE_EXISTS_OPERATOR_URI);
		$termConstInstance->setPropertyValue($termValueProperty,$constant);

		return $termConstInstance;
	}
	
	public function importTermOperation(){		

		$operatorProperty = new core_kernel_classes_Property(PROPERTY_OPERATION_OPERATOR,__METHOD__);

		$thisClass = new core_kernel_classes_Class(CLASS_OPERATION,__METHOD__); 
		echo $thisClass->uriResource;
		$termOperationInstance =  $thisClass->createInstance("Term Operation : " . $this->arithmeticOperator, __(" generated by CapiImport on ") . date(DATE_ISO8601));

		switch($this->arithmeticOperator) {
			case '+' : {
				$termOperationInstance->setPropertyValue($operatorProperty,INSTANCE_OPERATOR_ADD);
				break;
			}
			case '-' : {
				$termOperationInstance->setPropertyValue($operatorProperty,INSTANCE_OPERATOR_MINUS);
				break;
			}
			case '*' : {
				$termOperationInstance->setPropertyValue($operatorProperty,INSTANCE_OPERATOR_MULTIPLY);
				break;
			}
			case '/' : {
				$termOperationInstance->setPropertyValue($operatorProperty,INSTANCE_OPERATOR_DIVISION);
				break;
			}
			case '.' : {
				$termOperationInstance->setPropertyValue($operatorProperty,INSTANCE_OPERATOR_CONCAT);
				break;
			}
		}

		//if left part is again an operation call recursively an retrieve the term for the operand
		switch ($this->leftPartType)
		{
			case "variable":{ $leftTerm = $this->importTermSPX($this->leftPart);break;}
			case "constant":{ $leftTerm = $this->importTermConstant($this->leftPart);break;}
			case "aroperation":
			{ 
				//recursive call on left part 
				if ($this->leftPart instanceOf ConditionDescriptor)
				{
					$leftTerm = $this->leftPart->importTermOperation();
				}
				break;
			}
			default:{
				var_dump($this);

				trigger_error("Problem of type in (".$this.":".$this->leftPartType.") ");
			}
		}
		//if right part is again an operation call recursively an retrieve the term for the operand
		switch ($this->rightPartType)
		{
			case "variable":{ $rightTerm = $this->importTermSPX($this->rightPart);break;}
			case "constant":{ $rightTerm = $this->importTermConstant($this->rightPart);break;}
			case "aroperation":
			{ 
				//recursive call on right part 
				if ($this->rightPart instanceOf ConditionDescriptor)
				{
					$rightTerm = $this->rightPart->importTermOperation();
				}
				break;
			}
			default:{
				trigger_error("Problem of type in (".$this.":".$this->rightPartType.")");
			}
		}

		//put operands on the operationInstance

		$firstOperand = new core_kernel_classes_Property(PROPERTY_OPERATION_FIRST_OP,__METHOD__);
		$secondOperand = new core_kernel_classes_Property(PROPERTY_OPERATION_SECND_OP,__METHOD__);

		$termOperationInstance->setPropertyValue($firstOperand,$leftTerm->uriResource);
		$termOperationInstance->setPropertyValue($secondOperand,$rightTerm->uriResource);


		return $termOperationInstance;
	}


}




?>
