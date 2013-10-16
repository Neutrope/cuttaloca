<?php
App::uses('JsonBaseController', 'Controller');
/**
 * Json Controller
 *
 */
class CutmodelController extends JsonBaseController {

	public $uses = ['CutModel', 'User'];

	public function entry() {
		$data = $this->request->data;

		if (isset($data['User'])) {
			$this->result = ['success' => 1];
			$this->User->saveField('detail', $data['User']['detail']);
			$this->logindata['User']['detail'] = $data['User']['detail'];
			$this->Auth->login($this->logindata);
			return;
		}

		if (!isset($this->logindata['CutModel'])) {
			$this->result = ['success' => 0];
			return;
		}

		$data['id'] = $this->logindata['CutModel']['id'];

		try {
			$this->begin(['CutModel']);
			if ($this->CutModel->save($data) === false) {
				$this->raiseException($this->CutModel);
			}
			$this->result = ['success' => 1];
			$this->commit();
		} catch (Exception $e) {
			$this->result = ['success' => 0];
			$this->rollback($e);
		}

		foreach ($data as $key => $value) {
			$this->logindata['CutModel'][$key] = $value;
		}
		$this->Auth->login($this->logindata);
	}
}