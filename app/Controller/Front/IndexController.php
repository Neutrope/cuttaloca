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
class IndexController extends FrontBaseController {

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

	public function index() {
		$user = $this->Auth->user();
		if ($user) {
			if ($user['User']['role_id'] == ROLE_CUTMODEL) {
				$this->redirect('/user/search/');
			} else if ($user['User']['role_id'] == ROLE_STYLIST) {
				$this->redirect('/stylist/search/');
			}
		}
		$this->set('top', true);
		$this->header['js'] = 'index';

		// モバイル判定（iPad除く）
		if( $this->request->is('mobile') && !preg_match('/iPad/i', $_SERVER['HTTP_USER_AGENT']) ){
			// モバイルテーマ /View/Front/Themed/Mobile/ 以下を参照させる
			$this->theme = 'Mobile';

			// レイアウトもスマホ用
			$this->layout = 'front_sp';
		}
	}

	public function login() {
		//$user = $this->Auth->user();

		// ログインされてない時の処理
		//if (empty($user)) {
			$fb = $this->connectFb();
			if (!empty($fb)) {
				$this->load_models(['User']);
				$user = $this->User->getLoginData($fb);
			}
			// ユーザ登録されていなければ、登録画面に進む
			if (empty($user)) {
				$this->redirect('/register/user');
			}
			$this->Auth->login($user);
		//}

		$this->User->id = $user['User']['id'];
		$this->User->saveField('last_login', date('Y-m-d H:i:s'));

		// ログインされていれば各ユーザの検索画面へ
		if ($user['User']['role_id'] == ROLE_CUTMODEL) {
			$this->redirect('/user/search/');
		} else if ($user['User']['role_id'] == ROLE_STYLIST) {
			$this->redirect('/stylist/search/');
		}
	}

	public function logout() {
		$this->Auth->logout();
		$this->redirect('/');
	}

	public function terms($file = null) {
		$this->header = [
			'title' => 'インフォメーション',
			'css' => 'terms'
		];
		$this->render($file);
	}

	public function howto($file = null) {
		$this->header = [
		'title' => 'CUTTALOCAについて',
		'css' => 'howto',
		'js' => ['howto/stylist', 'howto/howto']
		];
		$this->set('howto', true);
		$this->render($file);
	}

	private function pref() {
		$json = file_get_contents('http://geoapi.heartrails.com/api/json?method=getPrefectures', true);
		$pref = json_decode($json, true);
		$pref = $pref['response']['prefecture'];


		$this->load_models(['Prefecture']);
		foreach ($pref as $value) {
			$this->Prefecture->create();
			$data = ['name' => $value];
			$this->Prefecture->save($data);
		}
	}

	private function city() {
		$this->load_models(['Prefecture', 'City']);
		$prefectures = $this->Prefecture->find('all');

		foreach ($prefectures as $data) {
			$json = file_get_contents('http://geoapi.heartrails.com/api/json?method=getCities&prefecture='.urlencode($data['Prefecture']['name']), true);
			$cities = json_decode($json, true);

			$cities = $cities['response']['location'];

			$data = ['prefecture_id' => $data['Prefecture']['id']];

			foreach ($cities as $city) {
				$data['name'] = $city['city'];
				$this->City->create();
				$this->City->save($data);
			}
		}
	}
}
