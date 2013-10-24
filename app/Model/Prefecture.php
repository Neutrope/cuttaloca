<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property Password $Password
 */
class Prefecture extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	private $area = [
		1 => '北海道 ',
		2 => '東北',
		3 => '関東',
		4 => '北陸',
		5 => '甲信越',
		6 => '東海',
		7 => '関西',
		8 => '中国四国',
		9 => '九州',
		10 => '沖縄'
	];

	public function getList() {
		$result = [];
		foreach ($this->area as $value) {
			$result[$value] = [];
		}

		$list = $this->find('all', ['order' => 'id']);

		foreach ($list as $value) {
			$result[$this->area[$value['Prefecture']['group_id']]][$value['Prefecture']['id']] = $value['Prefecture']['name'];
		}

		return $result;
	}

	public function getProfList() {
		return $this->find('list', ['order' => 'id']);
	}
}
