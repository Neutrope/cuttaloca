<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property Password $Password
 */
class OfferMessage extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = '';

	public $belongsTo = [
	];

	public $validate = [
		'message' => [
			'rule' => 'notEmpty',
			'message' => 'メッセージを入力してください。'
		]
	];

	public function beforeSave($options = []) {
		$this->data['OfferMessage']['message'] = str_replace(["\r\n", "\r", "\n"], '<br />', $this->data['OfferMessage']['message']);
	}

	public function getMessages($offer_id) {
		$conditions = [
			'OfferMessage.offer_id' => $offer_id
		];
		$order = ['OfferMessage.created' => ASC];
		$limit = 30;

		return $this->find('all', compact('conditions', 'order', 'limit'));
	}
}
