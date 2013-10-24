<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property Password $Password
 */
class Portfolio extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'review';

	public $belongsTo = [
		'Stylist' => [
			'type' => 'inner'
		]
	];
}
