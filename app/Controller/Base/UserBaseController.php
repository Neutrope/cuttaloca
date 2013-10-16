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

App::uses('LoginBaseController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package	   app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
abstract class UserBaseController extends LoginBaseController {

/**
 * Controller name
 *
 * @var string
 */
	public $layout = 'front';
	public $role_id = ROLE_USER;
	public $_mergeParent = 'UserBaseController';
	public $uses = ['User', 'Offer', 'Prefecture'];

	public $logindata;

	public $components = array ('Auth', 'Session');

	public function beforeFilter() {
		parent::beforeFilter();
		if ($this->logindata['User']['role_id'] != ROLE_CUTMODEL) {
			$this->redirect('/');
		}elseif($this->logindata['User']['status'] == USER_STATUS_DELETE){
			// ユーザーのステータスが 9：DELETEの時は、トップへリダイレクト
			$this->redirect('/');
		}
	}

	public function beforeRender() {
		parent::beforeRender();
		$this->set('count_success', $this->Offer->find('count', ['conditions' => ['Offer.paid' => 1, 'Offer.cut_model_id' => $this->logindata['CutModel']['id']]]));
		$this->set('count_offers', $this->Offer->find('count', ['conditions' => ['NOT' => ['Offer.paid' => 1, 'Offer.status' => STATUS_CANCEL], 'Offer.cut_model_id' => $this->logindata['CutModel']['id']]]));
		$this->set('prefecture', $this->Prefecture->getProfList());
		$this->set('gender', [1 => '女性', 2 => '男性', 9 => '男女']);
		$this->set('stylelist', Configure::read('StyleList'));
		$this->set('hairlengthlist', Configure::read('HairLengthList'));
		$this->set('hairlengthafterlist', Configure::read('HairLengthAfterList'));
		$this->set('cutmodelstyle', Configure::read('CutModelStyle'));
		$this->set('colorbefore', Configure::read('ColorBefore'));
		$this->set('colorafter', Configure::read('ColorAfter'));
		$this->set('permbefore', Configure::read('PermBefore'));
		$this->set('permafter', Configure::read('PermAfter'));
		$this->set('colorlist', Configure::read('ColorBefore'));
		$this->set('permlist', Configure::read('PermBefore'));
		$this->set('cutlength', Configure::read('CutLength'));
	}
}
