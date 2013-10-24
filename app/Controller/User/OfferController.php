<?php
App::uses('UserBaseController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Accounts Controller
 *
 * @property Account $Account
 */
class OfferController extends UserBaseController {

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
		$offers = $this->Offer->offerForCutModel($this->logindata['CutModel']['id']);

		$stylist_id = [];
		foreach ($offers as $offer) {
			if ($offer['Offer']['direction'] == DIRECTION_TO_CUTMODEL && $offer['Offer']['status'] <= STATUS_ADJUST)
			$stylist_id[] = $offer['Offer']['stylist_id'];
		}

		if (!empty($stylist_id)) {
			$this->set('weeks', $this->getWeeks());
			$this->set('apply_time', Configure::read('ApplyCutModel'));
		}

		$this->set('stylists', $this->Stylist->getlist(['Stylist.id' => $stylist_id]));
		$this->set('offers', $this->Offer->offerForCutModel($this->logindata['CutModel']['id']));
	}

	public function approve() {
		$this->header['css'][] = 'accept_offer';

		// カット日から1日過ぎたらレビューページ
		$this->set('review_date', date("Y-m-d", strtotime("-1 days")));

		$this->set('offers', $this->Offer->offerApproveForCutModel($this->logindata['CutModel']['id']));
	}

	public function add() {
		if (!$this->request->is('post')) {
			$this->redirect($this->referer());
		}

		$this->load_models(['OfferSchedule', 'User', 'CutModel', 'Stylist']);

		$data = $this->request->data;

		$data['CutModel']['id'] = $this->logindata['CutModel']['id'];
		$data['Offer']['cut_model_id'] = $this->logindata['CutModel']['id'];
		$data['Offer']['direction'] = DIRECTION_TO_STYLIST;

		$offer_schedules = [];
		$schedules = explode(',', $data['OfferSchedule']['time']);
		foreach ($schedules as $schedule) {
			list($date, $starttime, $day_of_week) = explode(' ', $schedule);
			$offer_schedules[] = [
				'date' => $date,
				'starttime' => $starttime,
				'day_of_week' => $day_of_week
			];
			$mail_schedules[] = date('Y/m/d', strtotime($date)).' '.$starttime;
		}

		$stylist = $this->Stylist->findById($data['Offer']['stylist_id']);
		$content = Configure::read('CutModelStyle');
		$content = $content[$data['Offer']['style']];

		try {
			$this->begin(['Offer', 'OfferSchedule']);
			
			if ($this->Offer->save($data) === false) {
				$this->raiseException($this->Offer);
			}

			$schedule = [];
			foreach ($offer_schedules as $value) {
				$this->OfferSchedule->create();
				$value['offer_id'] = $this->Offer->id;
				if ($this->OfferSchedule->save($value) === false) {
					$this->raiseException($this->OfferSchedule);
				}
			}

			$this->Email->sendmail([
				'to' => $stylist['User']['email'],
				'template' => 'offer_to_stylist',
				'subject' => 'CUTTALOCA（カッタロカ）：新着オファーが届きました',
				'body' => [
					'stylist' => $stylist,
					'cutmodel' => $this->logindata,
					'schedule' => implode(', ', $mail_schedules),
					'content' => $content
				]
			]);
			$this->commit();
			$this->Auth->login($this->User->getLoginData($this->logindata['User']['facebook_id']));
		} catch (Exception $e) {
			$this->rollback($e);
		}

		$this->redirect(['action' => 'index']);
	}

	public function adjust() {
		if ($this->request->is('post')) {
			$this->load_models(['OfferSchedule', 'Stylist']);
			$data = $this->request->data;
			$offer = $this->Offer->findByIdAndCutModelId($data['Offer']['id'], $this->logindata['CutModel']['id']);
			unset($offer['Offer']['created']);
			unset($offer['Offer']['modified']);

			$offer['Offer']['status'] = STATUS_ADJUST;
			$offer['Offer']['direction'] = DIRECTION_TO_STYLIST;

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

			$stylist = $this->Stylist->findById($offer['Offer']['stylist_id']);
			$content = Configure::read('CutModelStyle');
			$content = $content[$offer['Offer']['style']];

			try {
				$this->begin(['Offer']);

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

				$this->commit();

				$this->Email->sendmail([
					'to' => $stylist['User']['email'],
					'template' => 'adjust_to_stylist',
					'subject' => 'CUTTALOCA（カッタロカ）：別の日程が提案されました',
					'body' => [
						'stylist' => $stylist,
						'cutmodel' => $this->logindata,
						'schedule' => implode(', ', $mail_schedules),
						'content' => $content
					]
				]);
			} catch (Exception $e) {
				$this->rollback($e);
			}
		}
		$this->redirect('/user/offer/');
	}

	public function settlement($id = null, $offer_schedule_id = null) {
		$this->layout = 'settlement';
		if ($this->request->is('post')) {
			$offer = $this->Offer->findById($id);
			if($offer['Offer']['status'] != STATUS_SUCCESS){
				// オファー日程が確定していない場合はここで日程確定の処理

				$this->load_models(['OfferSchedule', 'Schedule']);			
				$schedule = $this->OfferSchedule->findById($offer_schedule_id);
				if (!empty($schedule)) {
					unset($offer['Offer']['created']);
					unset($offer['Offer']['modified']);

					$offer['Offer']['status'] = STATUS_SUCCESS;
					$offer['Offer']['direction'] = DIRECTION_TO_STYLIST;

					$this->OfferSchedule->id = $schedule['OfferSchedule']['id'];

					try {
						$this->begin(['OfferSchedule', 'Offer', 'Schedule']);

						if ($this->Offer->save($offer) === false) {
							$this->raiseException($this->Offer);
						}

						if ($this->OfferSchedule->saveField('determine', 1) === false) {
							$this->raiseException($this->OfferSchedule);
						}

						$date = strtotime($schedule['OfferSchedule']['date']);
						$year = date('Y', $date);
						$month = date('n', $date);
						$schedule = $this->Schedule->findByUserIdAndYearAndMonth($offer['Stylist']['user_id'], $year, $month);

						$schedule['Schedule']['recept'][date('j', $date)] = 0;

						if ($this->Schedule->save($schedule) === false) {
							$this->raiseException($this->Schedule);
						}

						$this->commit();
					} catch (Exception $e) {
						$this->rollback($e);
						$this->redirect('/user/offer/settlement/'.$id.'/'.$offer_schedule_id.'/');
					}
				}else{
					$this->redirect('/user/offer/settlement/'.$id.'/'.$offer_schedule_id.'/');
				}
			}
			
			$post = [
				'contract_code' => '53157400',
				'xml' => 1,
				'user_id' => $this->logindata['User']['id'],
				'user_name' => $this->logindata['User']['last_name'].' '.$this->logindata['User']['first_name'],
				'user_mail_add' => $this->logindata['User']['email'],
				'item_code' => 1,
				'item_name' => 'cuttaloca',
				'order_number' => $id,
				'st_code' => '10100-0000-00000',
				'mission_code' => 1,
				'item_price' => '500',
				'process_code' => 1,
				'memo1' => '',
				'memo2' => ''
			];

			$socket = new HttpSocket();
			if (TEST_MODE) {
				$xml = $socket->post('https://beta.epsilon.jp/cgi-bin/order/receive_order3.cgi', $post);
			} else {
				$xml = $socket->post('https://secure.epsilon.jp/cgi-bin/order/receive_order3.cgi', $post);
			}

			// 結果を取り出すための正規表現
			$p_result = '!<result result="(0|1)" \/>!i';
			$p_redirect = '!<result redirect="([^"]*)" \/>!i';
			$p_error_code = '!<result err_code="([0-9]+)" \/>!i';
			$p_error_detail = '!<result err_detail="([^"]*)" \/>!i';
			$result = preg_match($p_result, $xml, $m1) ? $m1[1] : NULL;

			if ($result == 1) {
				$this->Offer->id = $id;
				$this->Session->write('offer_id', $id);
				$redirect = preg_match($p_redirect, $xml, $m1) ? $m1[1] : NULL;

				$this->redirect(urldecode($redirect));
			}
			$code = preg_match($p_error_code, $xml, $m1) ? $m1[1] : NULL;
			$detail = preg_match($p_error_detail, $xml, $m1) ? $m1[1] : NULL;
			$detail = urldecode($detail);
			$encode = mb_detect_encoding($detail);
			var_dump($code);
			var_dump(mb_convert_encoding($detail, 'UTF-8', $encode));
			exit;
		}
		$offer = $this->Offer->getSettlement($id, $this->logindata['CutModel']['id']);

		if (empty($offer)) {
			$this->redirect('/user/offer/');
		}
		$this->load_models(['Prefecture']);

		$this->set('prefecture', $this->Prefecture->getProfList());
		$this->set('offer', $offer);
		$this->set('offer_schedule_id', $offer_schedule_id);
	}

	public function paid() {
		$post = [
			'contract_code' => '53157400',
			'trans_code' => $this->request->query['trans_code']
		];

		$socket = new HttpSocket();
		if (TEST_MODE) {
			$xml = $socket->post('https://beta.epsilon.jp/cgi-bin/order/getsales2.cgi', $post);
		} else {
			$xml = $socket->post('https://secure.epsilon.jp/cgi-bin/order/getsales2.cgi', $post);
		}

		$p_payment = '!<result payment_code="(\d)" \/>!i';
		$p_state = '!<result state="([^"]*)" \/>!i';
		$p_id = '!<result order_number="([^"]*)" \/>!i';
		$payment = preg_match($p_payment, $xml, $m1) ? $m1[1] : NULL;
		$state = preg_match($p_state, $xml, $m1) ? $m1[1] : NULL;
		$id = preg_match($p_id, $xml, $m1) ? $m1[1] : NULL;

		if ($state == 0) {
			$paid = 2;
			$redirect = '/user/offer';
		} else if ($state == 1) {
			$paid = 1;
			$redirect = '/user/offer/approve/';
		}

		$offer = $this->Offer->getInfo($id);
		$style = Configure::read('CutModelStyle');
		$offer['Offer']['style'] = $style[$offer['Offer']['style']];
		$offer['OfferSchedule'] = $offer['Offer']['schedules']['OfferSchedule'];
		unset($offer['Offer']['schedules']);

		try {
			$this->begin(['Offer']);
			$this->Offer->id = $id;
			if ($this->Offer->saveField('paid', $paid) === false) {
				$this->raiseException($this->Offer);
			}
			if ($this->Offer->saveField('trans_code', $post['trans_code']) === false) {
				$this->raiseException($this->Offer);
			}
			$this->commit();

			if ($paid == 1) {
				$this->Email->sendmail([
					'to' => $offer['StylistUser']['email'],
					'template' => 'matching_to_stylist',
					'subject' => 'CUTTALOCA（カッタロカ）：マッチングが成立しました',
					'body' => ['data' => $offer]
				]);

				$this->Email->sendmail([
					'to' => $offer['CutModelUser']['email'],
					'template' => 'matching_to_cutmodel',
					'subject' => 'CUTTALOCA（カッタロカ）：マッチングが成立しました',
					'body' => ['data' => $offer]
				]);

			}
		} catch (Exception $e) {
			$this->rollback($e);
		}

		$this->redirect($redirect);
	}

	public function error() {
		$this->redirect('/user/offer/');
	}

	public function cancel() {
		if ($this->request->is('post')) {
			$this->load_models(['Stylist']);
			$data = $this->request->data;
			$offer = $this->Offer->findByIdAndCutModelId($data['Offer']['id'], $this->logindata['CutModel']['id']);
			unset($offer['Offer']['created']);
			unset($offer['Offer']['modified']);

			$offer['Offer']['status'] = STATUS_CANCEL;
			$offer['Offer']['direction'] = DIRECTION_TO_STYLIST;

			$data = $this->Stylist->findById($offer['Offer']['stylist_id']);

			try {
				$this->begin(['Offer']);
				if ($this->Offer->save($offer) === false) {
					$this->raiseException($this->Offer);
				}

				$this->commit();
				
				$data['CutModel']['name'] = $this->logindata['User']['last_name'].' '.$this->logindata['User']['first_name'];
				
				$this->Email->sendmail([
					'to' => $data['User']['email'],
					'template' => 'cancel_to_stylist',
					'subject' => 'CUTTALOCA（カッタロカ）：オファーが不成立となりました',
					'body' => ['data' => $data]
				]);

			} catch (Exception $e) {
				$this->rollback($e);
			}
		}
		$this->redirect('/user/offer/');
	}

	public function message($id) {
		$offer = $this->Offer->getInfo($id);
		if (empty($offer) || $offer['Offer']['cut_model_id'] != $this->logindata['CutModel']['id']) {
			$this->redirect('/user/search/');
		}

		$this->load_models(['OfferMessage']);

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$data['OfferMessage']['offer_id'] = $id;
			$data['OfferMessage']['direction'] = DIRECTION_TO_STYLIST;

			$offer['OfferMessage'] = $data['OfferMessage'];

			try {
				$this->begin(['OfferMessage']);
				if ($this->OfferMessage->save($data) === false) {
					$this->raiseException($this->OfferMessage);
				}
				$this->commit();

				$this->Email->sendmail([
					'to' => $offer['StylistUser']['email'],
					'template' => 'message_to_stylist',
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

	public function entry() {
		$this->header['title'] = '掲載内容 確認＆更新';
		$this->header['css'] = ['stylist', 'register'];
		$this->header['js'] = 'register';

		if ($this->request->is('post')) {
			$this->load_models(['User', 'CutModel']);

			$data = $this->request->data;

			$data['User']['id'] = $this->logindata['User']['id'];
			$data['User']['accept_offer'] = 1;
			$data['CutModel']['id'] = $this->logindata['CutModel']['id'];
			try {
				$this->begin(['User', 'CutModel']);
				
				if ($this->User->save($data['User']) === false) {
					$this->raiseException($this->User);
				}
				if ($this->CutModel->save($data['CutModel']) === false) {
					$this->raiseException($this->CutModel);
				}
				$this->commit();
				$this->logindata = $this->User->getLoginData($this->logindata['User']['facebook_id']);
				$this->Auth->login($this->logindata);
			} catch (Exception $e) {
				$this->rollback($e);
			}
		}

		$this->load_models(['Calendar', 'City']);

		$this->set('city01', $this->City->getCity($this->logindata['CutModel']['prefecture01']));
		if ($this->loindata['CutModel']['prefecture02']) {
			$this->set('city02', $this->City->getCity($this->logindata['CutModel']['prefecture02']));
		}
		if ($this->loindata['CutModel']['prefecture03']) {
			$this->set('city03', $this->City->getCity($this->logindata['CutModel']['prefecture03']));
		}

		$stylelist = Configure::read('HairLengthList');
		$stylelist_after = Configure::read('HairLengthAfterList');
		$this->set('cut_before', $stylelist);
		$this->set('cut_after', $stylelist_after);
		$this->set('color_before', Configure::read('ColorBefore'));
		$this->set('color_after', Configure::read('ColorAfter'));
		$this->set('perm_before', Configure::read('PermBefore'));
		$this->set('perm_after', Configure::read('PermAfter'));

		$this->set('cut_week', $this->Calendar->getCutWeek());
		$this->set('cutmodelstyle', Configure::read('CutModelStyle'));
	}
}
