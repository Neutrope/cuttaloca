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
class RegisterController extends FrontBaseController {

/**
 * Controller name
 *
 * @var string
 */
	public $header = [
		'title' => 'カットモデル登録',
		'css' => 'register',
		'js' => ['stylist', 'register']
	];

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	public $components = ['Email'];
	public $helpers = ['Form'];

	public function beforeFilter() {
		$this->Auth->allow();
		parent::beforeFilter();
	}

	public function user() {
		$fb = $this->connectFb();
		$this->load_models(['User']);

		$user = $this->User->findByFacebookId($fb);
		if (!empty($user) && !TEST_MODE) {
			if ($user['User']['role_id'] == ROLE_CUTMODEL) {
				//$this->redirect('/thanks_for_user.html');
				$this->Auth->login($this->User->getLoginData($fb));
				$this->redirect('/user/search/');
			} else {
				//$this->redirect('/thanks_for_stylist.html');
				$this->Auth->login($this->User->getLoginData($fb));
				$this->redirect('/stylist/search/');
			}
		}

		if ($this->request->is('post') && isset($this->request->data['User'])) {
			$this->load_models(['User', 'CutModel']);

			$data = $this->request->data;

			$data['User']['facebook_id'] = $fb;
			$data['User']['role_id'] = ROLE_CUTMODEL;
			$data['User']['status'] = USER_STATUS_ACCEPT;

			try {
				$this->begin(['User', 'CutModel']);

				$this->User->save($data['User']);
				$data['CutModel']['user_id'] = $this->User->id;
				$this->CutModel->save($data['CutModel']);

				$this->Email->sendmail([
					'to' => $data['User']['email'],
					'subject' => '500円でサロンに行けるCUTTALOCA（カッタロカ）：登録が完了しました',
					'template' => 'register_cutmodel',
					'body' => ['data' => $data]
				]);

				$this->commit();
				$this->Auth->login($this->User->getLoginData($fb));
				$this->redirect('/user/search/');
				//$this->redirect('/thanks_for_user.html');
			} catch (Exception $e) {
				$this->rollback($e);
			}
		}

		$this->load_models(['Prefecture', 'Calendar']);
		if (!TEST_MODE) {
			$me = $this->facebook->api('/me');
		}

		switch ($me['gender']) {
			case 'female':
				$me['gender'] = [1, '女性'];
				break;
			case 'male':
				$me['gender'] = [2, '男性'];
				break;
		}

		$stylelist = Configure::read('HairLengthList');
		$stylelist_after = Configure::read('HairLengthAfterList');
		$this->set('cut_before', $stylelist);
		$this->set('cut_after', $stylelist_after);
		
		$this->set('fb', $me);
		$this->set('cut_week', $this->Calendar->getCutWeek());
		$this->set('cutmodelstyle', Configure::read('CutModelStyle'));
		$this->set('color_before', Configure::read('ColorBefore'));
		$this->set('color_after', Configure::read('ColorAfter'));
		$this->set('perm_before', Configure::read('PermBefore'));
		$this->set('perm_after', Configure::read('PermAfter'));
		$this->set('prefecture', $this->Prefecture->getList());
		
		// モバイル判定（iPad除く）
		if( $this->request->is('mobile') && !preg_match('/iPad/i', $_SERVER['HTTP_USER_AGENT']) ){
			// モバイルテーマ /View/Front/Themed/Mobile/ 以下を参照させる
			$this->theme = 'Mobile';
		
			// レイアウトもスマホ用
			$this->layout = 'front_sp';
		}
	}

	public function stylist() {
		$this->header['title'] = 'スタイリスト登録';
		$fb = $this->connectFb();
		$this->load_models(['User']);

		$user = $this->User->findByFacebookId($fb);
		if (!empty($user) && !TEST_MODE) {
			if ($user['User']['role_id'] == ROLE_CUTMODEL) {
				//$this->redirect('/thanks_for_user.html');
				$this->Auth->login($this->User->getLoginData($fb));
				$this->redirect('/user/search/');
			} else {
				//$this->redirect('/thanks_for_stylist.html');
				$this->Auth->login($this->User->getLoginData($fb));
				$this->redirect('/user/stylist/');
			}
		}

		if ($this->request->is('post') && isset($this->request->data['User'])) {
			$this->load_models(['Stylist', 'Schedule']);

			$data = $this->request->data;
			$temp = [];

			foreach ($data['Stylist']['apply_content'] as $value) {
				if ($value > 0) {
					$temp[] = $value;
				}
			}
			$data['Stylist']['apply_content'] = $temp;
			
			$temp = [];
			foreach ($data['Stylist']['apply_price'] as $value) {
				$temp[] = $value;
			}
			$data['Stylist']['apply_price'] = $temp;

			$data['User']['facebook_id'] = $fb;
			$data['User']['role_id'] = ROLE_STYLIST;
			$data['User']['status'] = USER_STATUS_PENDING;

			try {
				$this->begin(['User','Stylist']);
				if ($this->User->save($data) === false) {
					$this->raiseExeption($this->User);
				}
				$data['Stylist']['user_id'] = $this->User->id;
				if ($this->Stylist->save($data) === false) {
					$this->raiseException($this->Stylist);
				}
				$this->Schedule->saveFromCalendar($data);

				$this->Email->sendmail([
					'to' => $data['User']['email'],
					'subject' => 'カットモデル検索サイトCUTTALOCA（カッタロカ）：登録を受付ました',
					'template' => 'register_stylist',
					'body' => ['data' => $data]
				]);

				$this->commit();
				$this->Auth->login($this->User->getLoginData($fb));
				
				// for admin
				try {
					$str_tmp = "【要対応：スタイリスト本人確認】　".$data['User']['email']." さんが、スタイリストで新規登録しました";
					$this->Email->sendmail([
							'to' => 'cuttaloca+taio_stylist@gmail.com',
							'subject' => $str_tmp,
							'template' => 'for_admin_register_stylist',
							'body' => ['data' => $data]
							]);
				} catch (Exception $e) {
					$this->log($e, 'for_admin_mail_error');
				}
				
				$this->redirect('/stylist/search/');
				//$this->redirect('/thanks_for_stylist.html');
			} catch (Exception $e) {
				$this->rollback($e);
			}
		}

		$this->load_models(['Prefecture', 'Calendar']);
		if (!TEST_MODE) {
			$me = $this->facebook->api('/me');
		}

		switch ($me['gender']) {
			case 'female':
				$me['gender'] = [1, '女性'];
				break;
			case 'male':
				$me['gender'] = [2, '男性'];
				break;
		}

		$this->set('fb', $me);
		$this->set('calendars', $this->Calendar->getCalendar());
		$this->set('stylelist', Configure::read('StyleList'));
		$this->set('apply_gender', Configure::read('ApplyGender'));
		$this->set('apply_style', Configure::read('HairLengthList'));
		$this->set('apply_cutmodel', Configure::read('ApplyCutModel'));
		$this->set('prefecture', $this->Prefecture->getList());
	}
}