<?php
App::uses('JsonBaseController', 'Controller');
/**
 * Json Controller
 *
 */
class CityController extends JsonBaseController {

	public $uses = ['City'];

	public function get_list() {
		$this->result = $this->City->get_list($this->request->data['prefecture_id']);
	}
}