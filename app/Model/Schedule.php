<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property Password $Password
 */
class Schedule extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'day';

	public function beforeSave($options = []) {
		if (is_array($this->data['Schedule']['recept'])) {
			$this->data['Schedule']['recept'] = json_encode($this->data['Schedule']['recept']);
		}
	}

	public function afterFind($results, $primary = false) {
		foreach ($results as $key => $result) {
			$schedule = $result['Schedule'];
			$results[$key]['Schedule']['recept'] = json_decode($result['Schedule']['recept'], true);
			$results[$key]['Schedule'][$schedule['year']][$schedule['month']] = $results[$key]['Schedule']['recept'];
		}

		return $results;
	}

	public function saveFromCalendar($data) {
		$recept = $data['Schedule']['recept'];
		foreach ($recept as $year => $ary) {
			foreach ($recept[$year] as $month => $value) {
				$this->create();
				$data['Schedule'] = [
					'user_id' => $data['Stylist']['user_id'],
					'year' => $year,
					'month' => $month,
					'recept' => $recept[$year][$month]
				];
				if ($this->save($data) === false) {
					$this->raiseException();
				}
			}
		}
	}

	public function getSchedule($user_id, $date) {
		$or = [];
		foreach ($date as $value) {
			$or[] = ['Schedule.year' => $value[0], 'Schedule.month' => $value[1]];
		}

		$conditions = [
			'Schedule.user_id' => $user_id,
			'OR' => $or
		];
		$data = $this->find('all', compact('conditions'));

		return $data;
	}
}
