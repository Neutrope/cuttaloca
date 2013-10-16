<?php
App::uses('StylistBaseController', 'Controller');
/**
 * Accounts Controller
 *
 * @property Account $Account
 */
class MypageController extends StylistBaseController {

	public $uses = [];
	public $header = [
		'title' => 'マイページ',
		'css' => ['stylist', 'cutmodel']
	];

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->load_models(['Prefecture']);
		$this->set('prefecture', $this->Prefecture->getList());
		$this->set('stylelist', Configure::read('StyleList'));
		$this->set('gender', [1 => '女性', 2 => '男性']);
	}
}
