<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property Password $Password
 */
class Review extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'review';

	public $belongsTo = [
		'CutModelUser' => [
			'type' => 'inner',
			'className' => 'User',
			'foreignKey' => false,
			'conditions' => ['CutModelUser.id = Review.cut_model_user_id']
		],
		'CutModel' => [
			'type' => 'inner',
			'foreignKey' => false,
			'conditions' => ['CutModel.user_id = Review.cut_model_user_id']
		]
	];

	public function beforeSave($options = []) {
		if (!empty($this->data['Review']['review'])) {
			$this->data['Review']['review'] = str_replace(["\r\n", "\r", "\n"], '<br>', $this->data['Review']['review']);
		}
	}
}
