<?php

/**
 * Will define the rules to check for one (form) field.
 */
class HappyRules {

	protected $field;
	protected $label;
	protected $rules = array();
	
	protected $fieldErrors = array();
	protected $debugErrors = array();


	/**
	 * Will construct a new HappyRules
	 * @param string $fieldName the name of the field in the form
	 * @param string|array $rules the rules to check
	 * @param string $label the label of the field for the error message
	 */
	public function __construct($fieldName, $rules, $label = '')
	{
		$this->field = $fieldName;
		$this->rules = $this->parseRules($rules);

		$label == '' 
		? $this->label = $fieldName 
		: $this->label = $label;
	}

	/**
	 * Will parse the rules string for return
	 * an array of rules.
	 * The rules must be an array or a string
	 * where rules are separed by the | character.
	 * @param string/array $rules 
	 * @throws Exception if $rules is not a string or an array
	 * @return An array containing the parsed rules
	 */
	protected function parseRules($rules)
	{
		if(is_array($rules))
			return $rules;
		else if(is_string($rules))
			return explode('|', $rules);
		else if($rules == null)
			return array();
		else
			throw new Exception(
				"Invalid rules (type) submitted", 1);
		return false;
	}

	/**
	 * Will check if each rule exists.
	 * @param array $rules the rules to check
	 * @return true if all the rules exists, false otherwise.
	 */
	protected function checkRulesExists($rules)
	{
		$valid = True;
		$errors = array();

		foreach ($this->rules as $key => $rule) {

			$ruleArr = explode(' ',$rule);

			if(count($ruleArr) > 0 and !function_exists($ruleArr[0]))
			{
				$errors[$rule] = 'The rule ['.$rule.'] doesn\'t exists !';
				$valid = False;
			}
		}

		/**
		 * We add the incorrect rules to display them
		 * in a debug environment.
		 */
		if(count($errors))
			$this->debugErrors = $errors;

		return $valid;
	}

	/**
	 * Add the rule to the other rules.
	 * The rule can be a simple rule, an array
	 * of rules or a string where rules are 
	 * separed by the | character.
	 * @param string|array the rule to add
	 * @return true if succes, false otherwise.
	 */
	public function addRule($rule)
	{
		return (array_push($this->rules, $this->parseRules($rule)) > 0);
	}


	/**
	 * Will check each rule.
	 * @param array $rules the rules to check
	 * @return true if all the rules are checked, false otherwise.
	 */
	public function checkRules($rules)
	{

		if($this->checkRulesExists($rules))
		{
			$valid = True;
			$errors = array();

			foreach ($this->rules as $key => $rule) {

				$ruleArr = explode(' ',$rule);
				$function_to_call = array_shift($ruleArr);
				$result = call_user_func_array($function_to_call,$ruleArr);
				if($result !== true)
				{
					if(is_string($result))
					{
						$errors[$rule] = $result;
					}
					$valid = False;
				}

			}

			/**
			 * We add the unchecked rules to the error
			 * array
			 */
			if(count($errors))
				$this->fieldErrors = $errors;

			return $valid;
		}
		else
			return false;
	}
}

?>