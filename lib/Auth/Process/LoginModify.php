<?php

namespace SimpleSAML\Module\lshostel\Auth\Process;

use SimpleSAML\Auth\ProcessingFilter;
use SimpleSAML\Error\Exception;
use SimpleSAML\Logger;

/**
 * Class LoginModify
 *
 * This filter takes username entered by user and modifies it in the following way:
 * 1) trim whitespaces around input,
 * 2) replace '@' from email with '_',
 * 3) replace "domain" with lowercase string
 *
 * @author Dominik Frantisek Bucik <bucik@ics.muni.cz>
 */
class LoginModify extends ProcessingFilter
{

	private $loginAttrName;

	public function __construct($config, $reserved)
	{
		parent::__construct($config, $reserved);

		assert('is_array($config)');

		if (!isset($config['loginAttrName'])) {
			throw new Exception(
				"lshostel:LoginModify missing mandatory configuration option 'loginAttrName'."
			);
		}

		$this->loginAttrName = (string) $config['loginAttrName'];
	}

	public function process(&$request)
	{
		assert('is_array($request)');

		$oldUserName = $request['Attributes'][$this->loginAttrName][0];

		$userName = trim($oldUserName);
		$userNameParts = explode('@', $userName, 2);
		$userName = $userNameParts[0] . '_' . strtolower($userNameParts[1]);

		$request['Attributes'][$this->loginAttrName][0] = $userName;
		Logger::debug("lshostel:LoginModify - Modified " . $oldUserName . " to new format " . $userName);
	}

}
