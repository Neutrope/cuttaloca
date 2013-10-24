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
abstract class JsonBaseController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
 	public $name = 'Json';
	public $_mergeParent = 'JsonBaseController';
	public $components = ['Session', 'Auth'];
	public $layout = 'ajax';


/**
 * This controller does not use a model
 *
 * @var array
 */
	public function beforeFilter() {
		parent::beforeFilter();
		if (!$this->request->is('ajax')) {
			throw new ForbiddenException('不正な操作です');
		}
		$this->Auth->allow();
		$this->logindata = $this->Auth->user();
		$this->response->header('Content-Type: application/json; charset=UTF-8');
	}

	public function beforeRender() {
		parent::beforeRender();
		$this->set('result', $this->result);
	}

	public function render($view = null, $layout = null) {
		return parent::render('index', $layout);
	}
}
