<?php
App::uses('BatchBaseShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');

class CalendarShell extends BatchBaseShell {
	public $uses = ['Calendar'];

	public function startup() {
		$collection = new ComponentCollection();
		parent::startup();
	}

	public function main() {
//ログを取る
		$this->log('-------カレンダーの取得を開始しました------');
		$year = date('Y');
		$start_year = $year;
		$month = 1;
		$day = 1;

		if (date('Ymd') > date('Y1101')) {
			$year++;
			$start_year++;
		}

		$holidays_url = sprintf(
			'http://www.google.com/calendar/feeds/%s/public/full-noattendees?start-min=%s&start-max=%s&max-results=%d&alt=json',
			'outid3el0qkcrsuf89fltf7a4qbacgt9@import.calendar.google.com',
			date('Y-01-01'), // 取得開始日
			date('Y-12-31'), // 取得終了日
			50 // 最大取得数
		);

		if($results = file_get_contents($holidays_url)) {
			$results = json_decode($results, true);
			$holidays = [];
			foreach($results['feed']['entry'] as $val) {
				$date = $val['gd$when'][0]['startTime']; // 日付を取得
				$holidays[$date] = true;
			}
		}


		$time = mktime(0, 0, 0, 1, 1, $year);
		do {
			$this->Calendar->create();
			$today = date('Y-m-d', $time);
			$w = date('w', $time);
			$data = [
				'year' => $year,
				'month' => $month,
				'day' => $day,
				'day_of_week' => $w,
				'holiday' => isset($holidays[$today]) ? 1 : ($w == 0 ? 1 : 0)
			];

			$this->Calendar->save($data);

			$time = mktime(0, 0, 0, $month, $day+1, $year);
			$year = date('Y', $time);
			$month = date('n', $time);
			$day = date('j', $time);
		} while($year == $start_year);

		$this->log(print_r($data, true));
		$this->log('-------カレンダーの取得が終了しました------');
	}
}
