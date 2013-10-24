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
			'message' => '������͂��Ă��������B'
		],
		'first_name' => [
			'rule' => 'notEmpty',
			'message' => '������͂��Ă��������B'
		],
		'gender' => [
			'rule' => 'notEmpty',
			'message' => '���ʂ�I�����Ă��������B'
		],
		'email' => [
			'rule1' => [
				'rule' => 'notEmpty',
				'message' => '���[���A�h���X����͂��Ă��������B'
			],
			'rule2' => [
				'rule' => 'email',
				'message' => '�s���ȃ��[���A�h���X�ł��B'
			]
		],
		'detail' => [
			'rule' => 'prohibition',
			'message' => '�֑����e���܂܂�Ă��܂��B',
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
