<?php
App::uses('JsonBaseController', 'Controller');
/**
 * Json Controller
 *
 */
class OfferController extends JsonBaseController {

	public $uses = ['CutModel'];

	public function accept() {
		$data = $this->request->data;
		$this->CutModel->id = $this->logindata['CutModel']['id'];
		$this->CutModel->saveField('accept_offer', $data['accept']);

		$this->logindata['CutModel']['accept_offer'] = $data['accept'];
		$this->Auth->login($this->logindata);
		$this->result = ['success' => 1];
	}
}