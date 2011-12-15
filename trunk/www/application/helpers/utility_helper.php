<?php

if(!function_exists('buildKeyList'))
{
	/**
	 * This will provide you with an array with a key'd index based on your keyName and value based on your passed keyValue
	 * @param string $keyName
	 * @param string $keyValue
	 * @param array $array
	 * @return array
	 */
	function & buildKeyList($keyName = null, $keyValue = null, array $array = array())
	{
		$tmpArray = array();
		foreach ($array as $row)
		{
			$tmpArray[$row[$keyName]] = $row[$keyValue];
		}
		return $tmpArray;
	}

}

if(!function_exists('buildOptions'))
{
	/**
	 * This will provide you with an option list for html select / combo boxes, very useful so you don't have to recreate this.
	 * @param array $array
	 * @param string $selected
	 * @param string $key_or_value
	 * @param bool $shorten
	 * @param int $shortenLength
	 * @return string
	 */
	function buildOptions(array $array, $selected = null, $key_or_value = 'key', $shorten = false, $shortenLength = 25)
	{
		$tmpOutput = array();
		foreach ($array as $key => $val)
		{
			$selectedAttr = '';
			if (
				(null != $selected)
				&&
				(
					($key_or_value == 'key' && $key == $selected)
					^
					($key_or_value == 'value' && $val == $selected)
				)
			)
			{
				$selectedAttr = 'selected="selected"';
			}

			$title = $val;
			$label = $val;
			if ($shorten && strlen($val) > $shortenLength)
			{
				$label = substr($val, 0, $shortenLength) . ' ... ';
			}
			$tmpOutput[] = '<option title="' . $title . '" value="' . $key . '" ' . $selectedAttr . '>' . $label . '</option>';
		}

		unset($title);
		unset($label);

		return implode("\n", $tmpOutput);
	}
}

if(!function_exists('validateArrays'))
{
	/**
	 * Validates fields and returns errors based on those post field names
	 * @param array $rules
	 * @param array $values
	 * @param array $valid
	 * @return array
	 */
	function validateArrays(array $rules, array &$values, array &$valid = array())
	{
		$errors = array();

		/*
		 *	sample structure

			$rules['iosAppTypeId'] = array(
				'field_name'=>'package',
				'required'=>true
			);
		 */
		foreach($rules as $_fieldName=>$rule)
		{

			if(
				(
					isset($values[$_fieldName])
					&&
					!isset($rule['trim'])
				)
				||
				(
					isset($rule['trim'])
					&&
					(bool)$rule['trim'] == true
				)
			)
			{
				$values[$_fieldName] = trim($values[$_fieldName]);
			}

			if(!isset($rule['field_name']))
			{
				$rule['field_name'] = 'Field';
			}

			if(isset($rule['required']) && (bool)$rule['required'] == true)
			{
				if(
					!isset($values[$_fieldName])
					||
					(isset($values[$_fieldName]) && !strlen($values[$_fieldName]))
				)
				{
					if(isset($rule['requiredMessage']))
					{
						$msg = $rule['requiredMessage'];
					}
					else
					{
						$msg = "{$rule['field_name']} Is Required";
					}
					$errors[$_fieldName] = $msg;
				}
			}
			elseif(isset($rule['required']) && (bool)$rule['required'] == false)
			{
				if(!isset($values[$_fieldName]))
				{
					$errors[$_fieldName] = "{$rule['field_name']} form key should exist.";
					continue;
				}
				elseif(isset($values[$_fieldName]) && (bool)strlen($values[$_fieldName]) == false)
				{
					$valid[$_fieldName] = true;
					continue;
				}
			}
			else
			{
				$valid[$_fieldName] = true;
			}

			if(
				!isset($errors[$_fieldName])
				&&
				isset($values[$_fieldName])
				&&
				strlen($values[$_fieldName])
				&&
				(
					(isset($rule['int']) && (bool)$rule['int'] == true)
					||
					(isset($rule['integer']) && (bool)$rule['integer'] == true)
				)
			)
			{
				unset($valid[$_fieldName]);
				if(!preg_match('/^[0-9]+$/', $values[$_fieldName]))
				{
					$errors[$_fieldName] = "{$rule['field_name']} should be an integer";
					continue;
				}
			}
			else
			{
				$valid[$_fieldName] = true;
			}

			if(
				!isset($errors[$_fieldName])
				&&
				isset($values[$_fieldName])
				&&
				isset($rule['length'])
			)
			{
				unset($valid[$_fieldName]);
				if(isset($rule['length']['or']) && $rule['length']['or'] == true)
				{
					if(
						!(
							(isset($rule['length']['min']) && (strlen($values[$_fieldName]) == $rule['length']['min']))
							^
							(isset($rule['length']['max']) && (strlen($values[$_fieldName]) == $rule['length']['max']))
						)
					)
					{
						$min = $rule['length']['min'];
						$max = $rule['length']['max'];
						$errors[$_fieldName] = "{$rule['field_name']} Must be either {$min} or {$max} Characters Long";
						continue;
					}
					else
					{
						$valid[$_fieldName] = true;
					}
				}
				elseif(isset($rule['length']['min']) && (strlen($values[$_fieldName]) < $rule['length']['min']))
				{
					$errors[$_fieldName] = "{$rule['field_name']} is shorter than {$rule['length']['min']} characters";
					continue;
				}
				elseif(isset($rule['length']['max']) && (strlen($values[$_fieldName]) > $rule['length']['max']))
				{
					$errors[$_fieldName] = "{$rule['field_name']} is longer than {$rule['length']['max']} characters";
					continue;
				}
				else
				{
					$valid[$_fieldName] = true;
				}
			}
			else
			{
				$valid[$_fieldName] = true;
			}

			if(
				!isset($errors[$_fieldName])
				&&
				(isset($rule['notEmpty']) && $rule['notEmpty'] == true)
				&&
				(isset($values[$_fieldName]) && strlen($values[$_fieldName]) > 0)
				&&
				(isset($rule['custom']) && $rule['custom'] instanceof Closure || is_array($rule['custom']))
			)
			{
				unset($valid[$_fieldName]);

				if(is_array($rule['custom']))
				{
					foreach($rule['custom'] as $custom)
					{
						$test = $custom($_fieldName, $rule, $values);
						if(is_bool($test) && $test == true)
						{
							$valid[$_fieldName] = true;
							continue;
						}
						unset($valid[$_fieldName]);
						$errors[$_fieldName] = $test;
						continue;
					}
				}
				else
				{
					$test = $rule['custom']($_fieldName, $rule, $values);
					if(is_bool($test) && $test == true)
					{
						$valid[$_fieldName] = true;
						continue;
					}
					unset($valid[$_fieldName]);
					$errors[$_fieldName] = $test;
					continue;
				}
			}
		}
		return $errors;
	}
}