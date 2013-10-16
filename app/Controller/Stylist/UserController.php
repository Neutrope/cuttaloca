<?php
App::uses('StylistBaseController', 'Controller');
/**
 * Accounts Controller
 *
 * @property Account $Account
 */
class UserController extends StylistBaseController {

	public $uses = [];
	public $header = [
		'title' => 'カットモデル詳細',
		'css' => ['stylist'],
		'js' => 'stylist'
	];

/**
 * index method
 *
 * @return void
 */
	public function index($id) {
		$this->load_models(['CutModel', 'Review', 'Portfolio']);
		$cutmodel = $this->CutModel->findById($id);

		$stylist = $this->Stylist->getlist(['Stylist.id' => $this->logindata['Stylist']['id']]);
		$stylist = $stylist[0];

		$this->header['title'] = 'カットモデル【'.$cutmodel['User']['last_name'].' '.$cutmodel['User']['first_name'].'】さんの詳細';
		$this->set('stylist', $cutmodel);
		$this->set('my_schedule', $stylist);
		$this->set('weeks', $this->getWeeks());
		$this->set('apply_time', Configure::read('ApplyCutModel'));
		$this->set('reviews', $this->Review->findAllByStylistUserId($stylist['User']['id']));
		$this->set('portfolios', $this->Portfolio->findAllByStylistId($id));
	}
}
