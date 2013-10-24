<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property Password $Password
 */
class Account extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'login_id';

	public function getLoginData($login_id) {
		if (strpos($login_id, '@') !== false) {
			$conditions = ["Account.email = '{$login_id}'"];
		} else {
			$conditions = ["Account.login_id = '{$login_id}'"];
		}
		
		return $this->find('first', compact('joins', 'conditions'));
	}

	public function getUniqueLogin_id() {
		do {
			$login_id = getRandomString(STRING_LOGIN_ID);
			$data = $this->get_login_data($login_id);
		} while(!empty($data));

		return $login_id;
	}
	
	public function getPasswordHash($password) {
		return hash_hmac('sha512', $password, Configure::read('Security.salt'));
	}

	public function getRandomString($sCharList = STRING_PASSWORD, $nLengthRequired = 8) {
		mt_srand();
		$sRes = '';
		for ($i = 0; $i < $nLengthRequired; $i++) {
			if ($i == 0) {
				$rCharList = substr($sCharList, 1, strlen($sCharList) - 1);
			} else {
				$rCharList = $sCharList;
			}

			$sRes .= $rCharList{mt_rand(0, strlen($rCharList) - 1)};
		}
		return $sRes;
	}
}
