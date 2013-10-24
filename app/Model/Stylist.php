<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property Password $Password
 */
class Stylist extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public $validate = [
		'apply_price' => [
			'rule' => 'priceCheck',
			'message' => '料金は数字で入力してください。',
			'allowEmpty' => true
		],
		'city' => [
			'rule' => 'notEmpty',
			'message' => '店舗の市区町村を入力してください。'
		]
	];

	public $belongsTo = [
		'User' => [
			'type' => 'inner'
		]
	];

	public function priceCheck() {
		$result = true;
		if (is_array($this->data['Stylist']['apply_price'])) {
			foreach ($this->data['Stylist']['apply_price'] as $key => $price) {
				$price = mb_convert_kana($price, 'n');
				$this->data['Stylist']['apply_price'][$key] = $price;
				if (!preg_match('/\d+/', $price)) {
					$result = false;
					break;
				}
			}
		}
		return $result;
	}

	public function getlist($conditions = null, $page = null) {
		$this->Schedule = ClassRegistry::init('Schedule');


		if (empty($page)) {
			$page = 1;
		}

		$order = ['User.last_login' => 'DESC'];
		$limit = SEARCH_DISP_NUM * $page;

		$stylists = $this->find('all', compact('conditions', 'order', 'limit'));

		$year = date('Y');
		$month = date('n');
		$day = date('j') - date('w');
		$end = mktime(0, 0, 0, $month, $day+20, $year);

		$date = [[$year, $month] , [date('Y', $end), date('n', $end)]];

		if ($date[0][1] == $date[1][1] && $date[0][0] == $date[1][0]) {
			$date = [$date[0]];
		}

		foreach ($stylists as $key => $stylist) {
			$schedules = $this->Schedule->getSchedule($stylist['User']['id'], $date);
			foreach ($schedules as $schedule) {
				$schedule = $schedule['Schedule'];
				$stylists[$key]['Schedule'][$schedule['year']][$schedule['month']] = $schedule[$schedule['year']][$schedule['month']];
			}
		}

		return $stylists;
	}

	private $apply = ['apply_content', 'apply_price', 'apply_style', 'apply_current_style'];
	public function beforeSave($options = []) {
		foreach ($this->apply as $key) {
			if (is_array($this->data['Stylist'][$key])) {
				$this->data['Stylist'][$key] = implode(',', $this->data['Stylist'][$key]);
			}
		}
		return true;
	}

	public function afterFind($results, $primary = false) {
		foreach ($this->apply as $first_key) {
			foreach ($results as $second_key => $result) {
				$results[$second_key]['Stylist'][$first_key] = explode(',', $result['Stylist'][$first_key]);
			}
		}

		return $results;
	}
}