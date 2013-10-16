<?php
App::uses('StylistBaseController', 'Controller');
/**
 * Accounts Controller
 *
 * @property Account $Account
 */
class OfferController extends StylistBaseController {

	public $uses = ['Offer'];
	public $components = ['Email'];
	public $header = [
		'title' => 'オファー一覧',
		'css' => ['stylist', 'offer'],
		'js' => 'stylist'
	];

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->load_models(['Stylist']);

		$stylists = $this->Stylist->getlist(['Stylist.id' => $this->logindata['Stylist']['id']]);

		$this->set('apply_time', Configure::read('ApplyCutModel'));
		$this->set('weeks', $this->getWeeks());
		$this->set('my_schedule', $stylists[0]);
		$this->set('offers', $this->Offer->offerForStylist($this->logindata['Stylist']['id']));
	}

	public function approve() {
		// 現在から2週間前の日付（カット予定日を過ぎても、14日間は相手への連絡を可能にするための日付の比較対象）
		$this->set('two_weeks_before', date("Y-m-d",strtotime("-2 week")));
				
		$this->set('offers', $this->Offer->offerApproveForStylist($this->logindata['Stylist']['id']));
	}

	public function add() {
		if (!$this->request->is('post')) {
			$this->redirect($this->referer());
		}

		$this->load_models(['OfferSchedule', 'CutModel']);

		$data = $this->request->data;

		$data['Offer']['stylist_id'] = $this->logindata['Stylist']['id'];
		$data['Offer']['direction'] = DIRECTION_TO_CUTMODEL;

		$offer_schedules = [];
		$schedules = explode(',', $data['OfferSchedule']['time']);
		$mail_schedules = [];
		foreach ($schedules as $schedule) {
			list($date, $starttime, $day_of_week) = explode(' ', $schedule);
			$offer_schedules[] = [
				'date' => $date,
				'starttime' => $starttime,
				'day_of_week' => $day_of_week
			];
			$mail_schedules[] = date('Y/m/d', strtotime($date)).' '.$starttime;
		}

		$cutmodel = $this->CutModel->findById($data['Offer']['cut_model_id']);

		try {
			$this->begin(['Offer', 'OfferSchedule']);
			
			if ($this->Offer->save($data) === false) {
				$this->raiseException($this->Offer);
			}

			$data['OfferSchedule']['offer_id'] = $this->Offer->id;

			foreach ($offer_schedules as $value) {
				$this->OfferSchedule->create();
				$value['offer_id'] = $this->Offer->id;

				if ($this->OfferSchedule->save($value) === false) {
					$this->raiseException($this->OfferSchedule);
				}
			}

			$this->Email->sendmail([
				'to' => $cutmodel['User']['email'],
				'template' => 'offer_to_cutmodel',
				'subject' => 'CUTTALOCA（カッタロカ）：新着オファーが届きました',
				'body' => [
					'stylist' => $this->logindata,
					'cutmodel' => $cutmodel,
					'schedule' => implode(', ', $mail_schedules)
				]
			]);

			$this->commit();
		} catch (Exception $e) {
			$this->rollback($e);
		}

		$this->redirect(['action' => 'index']);
	}

	public function adjust() {
		if ($this->request->is('post')) {
			$this->load_models(['OfferSchedule', 'CutModel']);
			$data = $this->request->data;
			$offer = $this->Offer->findByIdAndStylistId($data['Offer']['id'], $this->logindata['Stylist']['id']);
			unset($offer['Offer']['created']);
			unset($offer['Offer']['modified']);

			$offer['Offer']['status'] = STATUS_ADJUST;
			$offer['Offer']['direction'] = DIRECTION_TO_CUTMODEL;

			$offer_schedules = [];
			$schedules = $data['OfferSchedule']['time'];
			foreach ($schedules as $schedule) {
				list($date, $starttime, $day_of_week) = explode(' ', $schedule);
				$offer_schedules[] = [
					'date' => $date,
					'starttime' => $starttime,
					'day_of_week' => $day_of_week
				];
				$mail_schedules[] = date('Y/m/d', strtotime($date)).' '.$starttime;
			}

			$cutmodel = $this->CutModel->findById($offer['Offer']['cut_model_id']);
			$content = Configure::read('CutModelStyle');
			//$content = $content[$offer['Offer']['style']];

			try {
				$this->begin(['Offer', 'OfferSchedule']);

				if ($this->OfferSchedule->deleteAll(['OfferSchedule.offer_id' => $data['Offer']['id']]) === false) {
					$this->raiseException($this->OfferSchedule);
				}

				if ($this->Offer->save($offer) === false) {
					$this->raiseException($this->Offer);
				}

				foreach ($offer_schedules as $value) {
					$this->OfferSchedule->create();
					$value['offer_id'] = $this->Offer->id;

					if ($this->OfferSchedule->save($value) === false) {
						$this->raiseException($this->OfferSchedule);
					}
				}

				$this->Email->sendmail([
					'to' => $cutmodel['User']['email'],
					'template' => 'adjust_to_cutmodel',
					'subject' => 'CUTTALOCA（カッタロカ）：別の日程が提案されました',
					'body' => [
						'stylist' => $this->logindata,
						'cutmodel' => $cutmodel,
						'schedule' => implode(', ', $mail_schedules)
					]
				]);

				$this->commit();
			} catch (Exception $e) {
				$this->rollback($e);
			}
		}
		$this->redirect('/stylist/offer/');
	}

	public function entry() {
		$this->load_models(['Calendar', 'Schedule']);
		$this->header['title'] = '掲載登録';
		$this->header['css'][] = 'register';
		$this->header['js'] = ['stylist', 'register'];

		if ($this->request->is('post')) {
			$this->load_models(['Stylist', 'User']);

			$data = $this->request->data;
			$temp = [];

			foreach ($data['Stylist']['apply_content'] as $value) {
				if ($value > 0) {
					$temp[] = $value;
				}
			}
			$data['Stylist']['apply_content'] = $temp;
			
			$temp = [];
			foreach ($data['Stylist']['apply_price'] as $value) {
				$temp[] = $value;
			}

			$data['Stylist']['id'] = $this->logindata['Stylist']['id'];
			$data['Stylist']['user_id'] = $this->logindata['User']['id'];
			$data['User']['id'] = $this->logindata['User']['id'];
			$data['Stylist']['apply_price'] = $temp;

			try {
				$this->begin(['Stylist', 'User']);

				if ($this->Stylist->save($data) === false) {
					$this->raiseException($this->Stylist);
				}

				if ($this->User->save($data) === false) {
					$this->raiseException($this->User);
				}

				$this->Schedule->saveFromCalendar($data);

				$this->commit();
				$this->Auth->login($this->User->getLogindata($this->logindata['User']['facebook_id']));
				$this->redirect('/stylist/search/');
			} catch (Exception $e) {
				$this->rollback($e);
			}
		}

		$schedule = $this->Stylist->getlist(['Stylist.user_id' => $this->logindata['User']['id']]);
		$this->logindata['Schedule'] = $schedule[0]['Schedule'];

		$this->set('calendars', $this->Calendar->getCalendar());
		$this->set('stylelist', Configure::read('StyleList'));
		$this->set('apply_gender', Configure::read('ApplyGender'));
		$this->set('apply_style', Configure::read('HairLengthList'));
		$this->set('apply_cutmodel', Configure::read('ApplyCutModel'));
		$this->set('prefecture', $this->Prefecture->getList());

	}

	public function accept($offer_id, $offer_schedule_id) {
		$this->load_models(['OfferSchedule', 'Schedule', 'CutModel']);

		$schedule = $this->OfferSchedule->findById($offer_schedule_id);
		if (!empty($schedule)) {
			$offer = $this->Offer->findById($offer_id);
			unset($offer['Offer']['created']);
			unset($offer['Offer']['modified']);

			$offer['Offer']['status'] = STATUS_SUCCESS;
			$offer['Offer']['direction'] = DIRECTION_TO_CUTMODEL;
			
			$this->OfferSchedule->id = $schedule['OfferSchedule']['id'];

			$data = $this->CutModel->findById($offer['Offer']['cut_model_id']);
			$data['OfferSchedule'] = $schedule['OfferSchedule'];

			try {
				$this->begin(['OfferSchedule', 'Offer']);

				if ($this->Offer->save($offer) === false) {
					$this->raiseException($this->Offer);
				}

				if ($this->OfferSchedule->saveField('determine', 1) === false) {
					$this->raiseException($this->OfferSchedule);
				}

				$date = strtotime($schedule['OfferSchedule']['date']);
				$year = date('Y', $date);
				$month = date('n', $date);
				$schedule = $this->Schedule->findByUserIdAndYearAndMonth($this->logindata['User']['id'], $year, $month);

				$schedule['Schedule']['recept'][date('j', $date)] = 0;

				if ($this->Schedule->save($schedule) === false) {
					$this->raiseException($this->Schedule);
				}

				$data['Stylist']['name'] = $this->logindata['User']['last_name'].' '.$this->logindata['User']['first_name'];

				$this->Email->sendmail([
					'to' => $data['User']['email'],
					'template' => 'accept_to_cutmodel',
					'subject' => 'CUTTALOCA（カッタロカ）： '.$data['Stylist']['name'].'さんからオファーが承認されました',
					'body' => ['data' => $data]
				]);

				$this->commit();
				$this->redirect('/stylist/offer/approve/');
			} catch (Exception $e) {
				$this->rollback($e);
				$this->redirect('/stylist/offer/');
			}
		}
	}

	public function cancel() {
		if ($this->request->is('post')) {
			$this->load_models(['CutModel']);
			$data = $this->request->data;
			$offer = $this->Offer->findByIdAndStylistId($data['Offer']['id'], $this->logindata['Stylist']['id']);
			unset($offer['Offer']['created']);
			unset($offer['Offer']['modified']);

			$offer['Offer']['status'] = STATUS_CANCEL;
			$offer['Offer']['direction'] = DIRECTION_TO_CUTMODEL;

			$data = $this->CutModel->findById($offer['Offer']['cut_model_id']);

			try {
				$this->begin(['Offer']);
				if ($this->Offer->save($offer) === false) {
					$this->raiseException($this->Offer);
				}
				
				$data['Stylist']['name'] = $this->logindata['User']['last_name'].' '.$this->logindata['User']['first_name'];

				$this->Email->sendmail([
					'to' => $data['User']['email'],
					'template' => 'cancel_to_cutmodel',
					'subject' => 'CUTTALOCA（カッタロカ）：オファーが不成立となりました',
					'body' => ['data' => $data]
				]);

				$this->commit();
			} catch (Exception $e) {
				$this->rollback($e);
			}
		}
		$this->redirect('/stylist/offer/');
	}

	public function message($id) {
		$offer = $this->Offer->getInfo($id);
		if (empty($offer) || $offer['Offer']['stylist_id'] != $this->logindata['Stylist']['id']) {
			$this->redirect('/stylist/search/');
		}

		$this->load_models(['OfferMessage']);

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$data['OfferMessage']['offer_id'] = $id;
			$data['OfferMessage']['direction'] = DIRECTION_TO_CUTMODEL;

			$offer['OfferMessage'] = $data['OfferMessage'];

			try {
				$this->begin(['OfferMessage']);
				if ($this->OfferMessage->save($data) === false) {
					$this->raiseException($this->OfferMessage);
				}
				$this->commit();

				$this->Email->sendmail([
					'to' => $offer['CutModelUser']['email'],
					'template' => 'message_to_cutmodel',
					'body' => ['data' => $offer],
					'subject' => 'CUTTALOCA（カッタロカ）：新着メッセージが届きました'
				]);

			} catch (Exception $e) {
				$this->rollback($e);
			}
		}

		$this->set('offer', $offer);
		$this->set('messages', $this->OfferMessage->getMessages($offer['Offer']['id']));
	}
}
