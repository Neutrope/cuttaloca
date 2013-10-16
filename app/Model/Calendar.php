<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property Password $Password
 */
class Calendar extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'day';

	public function getCutWeek() {
		$year = date('Y');
		$month = date('n');
		$w = date('w');
		$day = date('j') - $w;

		$weeks = ['今週', '来週', '２週間後', '３週間後', '４週間後', '１ヶ月後'];
		$result = [];
		
		// 「後で決める」を追加（とりあえず、 cut_week に入る値は 22230706 で固定）
		$result[date('Ymd', '8000000000')] = "後で決める";
		
		foreach ($weeks as $key => $value) {
			$start = mktime(0, 0, 0, $month, $day + 7*$key, $year);
			$end = mktime(0, 0, 0, $month, $day + 7*($key + 1) -1, $year);
			$result[date('Ymd', $start)] = sprintf('%s|　%s - %s', mb_substr($value.'　　　　　　', 0, 5), date('n/j', $start), date('n/j', $end));
		}

		return $result;
	}

	public function getCalendar($year = null, $month = null) {
		if (is_null($year)) {
			$year = date('Y');
		}
		if (is_null($month)) {
			$month = date('n');
		}
		$conditions = [
			'Calendar.year' => $year,
			'Calendar.month' => $month
		];

		$order = [
			'Calendar.day_of_week' => 'ASC',
			'Calendar.day' => 'ASC'
		];

		$temp = $this->find('all', compact('conditions', 'order'));

		$data = [];

		if ($temp[0]['Calendar']['day'] != 1) {
			for ($i = 0; $i < 8 - $temp[0]['Calendar']['day']; $i++) {
				$data[$i][] = '';
			}
		}

		foreach ($temp as $value) {
			$data[$value['Calendar']['day_of_week']][] = $value['Calendar'];
		}
		$result[] = $data;

		$next = mktime(0, 0, 0, $month+1, 1, $year);
		$year = date('Y', $next);
		$month = date('n', $next);

		$conditions = [
			'Calendar.year' => $year,
			'Calendar.month' => $month
		];

		$temp = $this->find('all', compact('conditions', 'order'));

		$data = [];
		if ($temp[0]['Calendar']['day'] != 1) {
			for ($i = 0; $i < 8 - $temp[0]['Calendar']['day']; $i++) {
				$data[$i][] = '';
			}
		}

		foreach ($temp as $value) {
			$data[$value['Calendar']['day_of_week']][] = $value['Calendar'];
		}
		$result[] = $data;

		return $result;
	}
}
