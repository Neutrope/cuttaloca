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

App::uses('FrontBaseController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package	   app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class TestController extends FrontBaseController {

/**
 * Controller name
 *
 * @var string
 */
	public $header = [
		'title' => 'トップページ',
		'css' => 'index'
	];

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public function beforeFilter() {
		$this->Auth->allow();
		parent::beforeFilter();
	}

	public function login() {
		$this->load_models(['User']);
		if ($this->request->is('post')) {
			$data = $this->request->data;
			foreach ($data['User'] as $hash) {
				foreach($hash as $key => $value) {
					if (!empty($value)) {
						$user = $this->User->getLoginDataTest($value);
						$this->Auth->login($user);

						$this->User->id = $user['User']['id'];
						$this->User->saveField('last_login', date('Y-m-d H:i:s'));

						if ($user['User']['role_id'] == ROLE_CUTMODEL) {
							$this->redirect('/user/search/');
						} else {
							$this->redirect('/stylist/search/');
						}
					}
				}
			}
		}


		$this->set('users', $this->User->find('all'));
	}
	
	public function ctm_login($page = null) {
		if ($this->request->is('post')) {
			$this->login();
		}else{
			$this->load_models(['User']);
			$this->set('users', $this->User->find('all'));
			
			$min_id = 1;
			$max_id = 1000;
			$next_page = 1;
			if(is_numeric($page) && $page > 0){
				$min_id = $page * 1000;
				$max_id = $min_id + 1000;
				$next_page = $page + 1;
			}
			
			$this->set('min_id', $min_id);
			$this->set('max_id', $max_id);
			$this->set('next_page', $next_page);
		}
	}
		
	public function sty_login($page = null) {
		if ($this->request->is('post')) {
			$this->login();
		}else{
			$this->load_models(['User']);
			$this->set('users', $this->User->find('all'));
			
			$min_id = 1;
			$max_id = 1000;
			$next_page = 1;
			if(is_numeric($page) && $page > 0){
				$min_id = $page * 1000;
				$max_id = $min_id + 1000;
				$next_page = $page + 1;
			}
			
			$this->set('min_id', $min_id);
			$this->set('max_id', $max_id);
			$this->set('next_page', $next_page);
		}
	}
	
}
