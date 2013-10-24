<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package	   app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $viewClass = 'TwigView.Twig';
	public $helpers = ['Form'];
	public $components = ['Auth'];
	protected $header = [];

	public $facebook;

	private $transactions = array ();

	public function beforeFilter() {
		App::import('Vendor', 'facebook/src/cakefacebook');
		$this->facebook = new CakeFacebook([
			'appId' => '202894476528576',
			'secret' => 'd2d7e9faa4d1daa8dacdbbf28a0bf057',
			'cookie' => true
		]);
		parent::beforeFilter();
	}

	public function beforeRender() {
		if($this->name == 'CakeError') {
			$this->layout = 'error';
		}
		if ($this->isSmartPhone() === true) {
			if (!is_array($this->header['css'])) {
				$this->header['css'] = [$this->header['css']];
			}
			$this->header['css'][] = 'smartphone';
		}
		$this->set('header', $this->header);
	}

	protected function connectFb() {
		if (TEST_MODE) {
			return 4;
		}
		$fb = $this->facebook->getUser();
		if (empty($fb)) {
			$this->authFacebook();
		}
		return $fb;
	}

	private function isSmartPhone() {
		$useragents = array(
			'iPhone',         // Apple iPhone
			'iPod',           // Apple iPod touch
			'Android.+Mobile',// 1.5+ Android
			'IEMobile',       // Windows phone
			'dream',          // Pre 1.5 Android
			'CUPCAKE',        // 1.5+ Android
			'blackberry9500', // Storm
			'blackberry9530', // Storm
			'blackberry9520', // Storm v2
			'blackberry9550', // Storm v2
			'blackberry9800', // Torch
			'webOS',          // Palm Pre Experimental
			'incognito',      // Other iPhone browser
			'webmate',         // Other iPhone browser
		);
		$pattern = '/'.implode('|', $useragents).'/i';
		return (bool) preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
	}

	private function authFacebook() {
		$login_url = $this->facebook->getLoginUrl([
			'scope' => 'email'
		]);
		$this->redirect($login_url);
	}

	protected function getMonthlySchedule() {

		return $result;
	}

	/*
	 * トランザクション開始
	 */
	protected function begin($models) {
		$this->transactions = $models;

		foreach ($models as $model) {
			$this->{$model}->begin();
		}
	}

	protected function raiseException($model) {
		throw new Exception(print_r($model->validationErrors, true));
	}

	protected function commit() {
		foreach ($this->transactions as $model) {
			$this->{$model}->commit();
		}
	}

	protected function rollback(Exception $e) {
		$this->set('message', $e->getMessage());
		$this->log($e->getMessage(), 'error_message');
		$this->log($e->getTraceAsString(), 'error_message');

		foreach ($this->transactions as $model) {
			$this->{$model}->rollback();
		}
	}

	protected function load_models($models) {
		foreach ($models as $model) {
			$this->{$model} = ClassRegistry::init($model);
		}
	}
}
