<?php
App::uses('BatchBaseShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');

class ScheduleShell extends BatchBaseShell {
	public $uses = ['Stylist', 'Schedule', 'Calendar'];

	public function startup() {
		$collection = new ComponentCollection();
		parent::startup();
	}

	public function main() {
//ログを取る
		$this->log('-------スケジュールの作成を開始しました------');
		$current = [
			'year' => date('Y'),
			'month' => date('m')
		];

		$nextmonth = mktime(0, 0, 0, $current['month']+1, 1, $current['year']);

		$next = [
			'year' => date('Y', $nextmonth),
			'month' => date('m', $nextmonth)
		];

		$stylists = $this->Stylist->find('all');
		$days = $this->Calendar->find('all', ['conditions' => ['Calendar.year' => $next['year'], 'Calendar.month' => $next['month']], 'order' => ['Calendar.day' => 'ASC']]);

		foreach ($stylists as $stylist) {
			$this->log($stylist['User']['last_name'].'さん(スタイリストID：'.$stylist['Stylist']['id'].')のスケジュール登録を開始します。');
			$recept = [];
			$this->Schedule->create();
			foreach ($days as $calendar) {
				if ($calendar['Calendar']['holiday'] == 1) { // 休日
					$key = 'holiday';
				} else if ($calendar['Calendar']['day_of_week'] == 6) { // 土曜日
					$key = 'saturday';
				} else {
					$key = 'ordinary';
				}
				if ($stylist['Stylist'][$key.'_start'] > 0 && $stylist['Stylist'][$key.'_end'] > 0) {
					$recept[$calendar['Calendar']['day']] = 1;
				} else {
					$recept[$calendar['Calendar']['day']] = 0;
				}
			}

			$data = [
				'user_id' => $stylist['User']['id'],
				'year' => $next['year'],
				'month' => $next['month'],
				'recept' => $recept
			];
			if ($this->Schedule->save($data) === false) {
				$this->log('スケジュールの登録に失敗しました。');
			}
		}

		$this->log('-------スケジュールの作成が終了しました------');
	}
}
