<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property Password $Password
 */
class CutModel extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public $belongsTo = [
		'User' => [
			'type' => 'inner'
		]
	];

	public $validate = [
		'city01' => [
			'rule' => 'notEmpty',
			'message' => '少なくとも一つは希望地域を入力してください。'
		],
		'style' => [
			'rule' => 'notEmpty',
			'message' => '募集内容はひとつ以上選択してください。'
		]
	];

	public function getlist($conditions = null, $page = null) {
		if (empty($page)) {
			$page = 1;
		}
		$limit = SEARCH_DISP_NUM * $page;
		$order = ['User.last_login' => 'DESC'];
		$cut_models = $this->find('all', compact('conditions', 'order', 'limit'));

		return $cut_models;
	}

	public function beforeValidate($options = []) {
		if (!empty($this->data['CutModel']['introduce'])) {
			$this->data['CutModel']['introduce'] = nl2br(htmlspecialchars(($this->data['CutModel']['introduce'])));
		}

		return true;
	}
}
