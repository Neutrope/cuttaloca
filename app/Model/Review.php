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
		]
	];
}
