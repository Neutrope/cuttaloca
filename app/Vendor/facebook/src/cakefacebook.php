<?php
/**
* Copyright 2013 mogya.
* Copyright 2011 Facebook, Inc.
*
* Licensed under the Apache License, Version 2.0 (the "License"); you may
* not use this file except in compliance with the License. You may obtain
* a copy of the License at
*
* http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
* WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
* License for the specific language governing permissions and limitations
* under the License.
*/
 
require_once "base_facebook.php";

/**
* Extends the BaseFacebook class with the intent of using
* PHP sessions to store user ids and access tokens.
*/
class CakeFacebook extends BaseFacebook
{
/**
* Identical to the parent constructor, except that
* we start a CakePHP session to store the user ID and
* access token if during the course of execution
* we discover them.
*
* @param Array $config the application configuration.
* "sharedSession" is not supported.
* @see BaseFacebook::__construct in facebook.php
*/
	public function __construct($config) {
		if (!CakeSession::started()) {
			CakeSession::start();
		}
		parent::__construct($config);
	}
 
	protected static $kSupportedKeys = ['state', 'code', 'access_token', 'user_id'];
 
/**
* Provides the implementations of the inherited abstract
* methods. The implementation uses CakePHP CakeSession.
*/
	protected function setPersistentData($key, $value) {
		if (!in_array($key, self::$kSupportedKeys)) {
			self::errorLog('Unsupported key passed to setPersistentData.');
			return;
		}
		 
		$session_var_name = $this->constructSessionVariableName($key);
		CakeSession::write($session_var_name,$value);
	}
 
	protected function getPersistentData($key, $default = false) {
		if (!in_array($key, self::$kSupportedKeys)) {
			self::errorLog('Unsupported key passed to getPersistentData.');
			return $default;
		}
 
		$session_var_name = $this->constructSessionVariableName($key);
		return CakeSession::check($session_var_name) ?
			CakeSession::read($session_var_name) : $default;
	}
 
	protected function clearPersistentData($key) {
		if (!in_array($key, self::$kSupportedKeys)) {
			self::errorLog('Unsupported key passed to clearPersistentData.');
			return;
		}
		 
		$session_var_name = $this->constructSessionVariableName($key);
		CakeSession::delete($session_var_name);
	}
 
	protected function clearAllPersistentData() {
		foreach (self::$kSupportedKeys as $key) {
			$this->clearPersistentData($key);
		}
	}
 
	protected function constructSessionVariableName($key) {
		$parts = array('fb', $this->getAppId(), $key);
		return implode('_', $parts);
	}
}