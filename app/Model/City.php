<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property Password $Password
 */
class City extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public function get_list($prefecture_id) {
		return $this->findAllByPrefectureId($prefecture_id, ['id', 'name'], ['id' => 'ASC']);
	}

	public function getCity($prefecture_id) {
		$cities = $this->get_list($prefecture_id);

		$result = [];
		foreach ($cities as $city) {
			$result[$city['City']['name']] = $city['City']['name'];
		}
		return $result;
	}
}
