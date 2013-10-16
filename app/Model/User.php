<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property Password $Password
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	public $validate = [
		'last_name' => [
			'rule' => 'notEmpty',
			'message' => '姓を入力してください。'
		],
		'first_name' => [
			'rule' => 'notEmpty',
			'message' => '名を入力してください。'
		],
		'gender' => [
			'rule' => 'notEmpty',
			'message' => '性別を選択してください。'
		],
		'email' => [
			'rule1' => [
				'rule' => 'notEmpty',
				'message' => 'メールアドレスを入力してください。'
			],
			'rule2' => [
				'rule' => 'email',
				'message' => '不正なメールアドレスです。'
			]
		],
		'detail' => [
			'rule' => 'prohibition',
			'message' => '禁則内容が含まれています。',
			'allowEmpty' => true
		]
	];

	public function prohibition($data) {
		$data = str_replace('-', '', mb_convert_kana($data['detail'], 'as'));
		$data = preg_replace("/<.*>|[\r\n]|\s/", "", $data);

		if (preg_match("/0\d{9,10}/", $data)) {
			return false;
		}
		if (preg_match("/ttp:|www\./", $data)) {
			return false;
		}
		if (preg_match("/[a-z\.]+@[a-z\.]+/", $data)) {
			return false;
		}

		return true;
	}


	public function getLoginData($fb) {
		$user = $this->findByFacebookId($fb);

		switch ($user['User']['role_id']) {
			case ROLE_CUTMODEL:
				$model = ClassRegistry::init('CutModel');
				$data = $model->findByUserId($user['User']['id']);
				$user['CutModel'] = $data['CutModel'];
				break;
			case ROLE_STYLIST:
				$model = ClassRegistry::init('Stylist');
				$data = $model->findByUserId($user['User']['id']);
				$user['Stylist'] = $data['Stylist'];
				break;
		}
		return $user;
	}

	public function getLoginDataTest($id) {
		$user = $this->findById($id);

		switch ($user['User']['role_id']) {
			case ROLE_CUTMODEL:
				$model = ClassRegistry::init('CutModel');
				$data = $model->findByUserId($user['User']['id']);
				$user['CutModel'] = $data['CutModel'];
				break;
			case ROLE_STYLIST:
				$model = ClassRegistry::init('Stylist');
				$data = $model->findByUserId($user['User']['id']);
				$user['Stylist'] = $data['Stylist'];
				break;
		}
		return $user;

	}
}
