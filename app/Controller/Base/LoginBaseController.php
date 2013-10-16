<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	 Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link		  http://cakephp.org CakePHP(tm) Project
 * @package	   app.Controller
 * @since		 CakePHP(tm) v 0.2.9
 * @license	   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package	   app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
abstract class LoginBaseController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $_mergeParent = 'LoginBaseController';
	public $components = ['Auth', 'Session'];
	public $auth = true;

/**
 * This controller does not use a model
 *
 * @var array
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$user = $this->Auth->user();
		if (empty($user)) {
			$fb = $this->connectFb();
			$user = $this->User->getLoginData($fb);
			if (!empty($user)) {
				$this->Auth->login($user);
			} else {
				$this->redirect('/');
			}
		}

		$this->logindata = $user;
	}

	public function beforeRender() {
		$this->set('logindata', $this->logindata);
		parent::beforeRender();
	}

	protected function getWeeks() {
		if (empty($this->Calendar)) {
			$this->load_models(['Calendar']);
		}

		$year = date('Y');
		$month = date('n');
		$day = date('j') - date('w');
		$time = mktime(0, 0, 0, $month, $day, $year);

		$before = [
			'year' => date('Y', $time),
			'month' => date('n', $time),
			'day' => date('j', $time)
		];

		$time = mktime(0, 0, 0, $month, $day+20, $year);

		$after = [
			'year' => date('Y', $time),
			'month' => date('n', $time),
			'day' => date('j', $time)
		];

		if ($before['year'] != $after['year']) {
			$conditions = [
				'OR' => [
					[
						'Calendar.year' => $before['year'],
						'Calendar.month' => $before['month'],
						'Calendar.day >=' => $before['day']
					],
					[
						'Calendar.year' => $after['year'],
						'Calendar.month' => $after['month'],
						'Calendar.day <=' => $after['day']
					]
				]
			];
		} else if ($before['month'] != $after['month']) {
			$conditions = [
				'Calendar.year' => $before['year'],
				'OR' => [
					[
						'Calendar.month' => $before['month'],
						'Calendar.day >=' => $before['day']
					],
					[
						'Calendar.month' => $after['month'],
						'Calendar.day <=' => $after['day']
					]
				]
			];
		} else {
			$conditions = [
				'Calendar.year' => $before['year'],
				'Calendar.month' => $before['month'],
				'Calendar.day BETWEEN ? AND ?' => [$before['day'], $after['day']]
			];
		}

		$order = ['Calendar.year' => 'ASC', 'Calendar.month' => 'ASC', 'Calendar.day' => 'ASC'];

		return array_chunk($this->Calendar->find('all', compact('conditions', 'order')), 7);
	}

}
