<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	 Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link		  http://cakephp.org CakePHP(tm) Project
 * @package	   app.Controller
 * @since		 CakePHP(tm) v 0.2.9
 * @license	   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('FrontBaseController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package	   app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PaymentController extends FrontBaseController {

/**
 * Controller name
 *
 * @var string
 */

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = ['Offer', 'Stylist', 'CutModel'];
	public $components = ['Email'];

	public function beforeFilter() {
		$this->Auth->allow();
		parent::beforeFilter();
	}

	public function convini() {
		if ($this->request->is('post')) {
			
			// 入金済みフラグ
			$state = $this->request->data('paid');
			
			// オーダー番号
			$id = $this->request->data('order_number');
			
			// 暫定で記録
			$this->log($this->request->data, 'epsilon');
						
			if (empty($state) && empty($id)) {
				print "0 999 ERROR";
				throw NotFoundException('コードが不正です');
			}
			
			if ($state == 1) {
				$paid = 1;
			} else {
				$paid = 2;
				print "0 999 ERROR";
				throw NotFoundException('コードが不正です');
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
				if ($this->Offer->saveField('trans_code', $this->request->data('trans_code')) === false) {
					$this->raiseException($this->Offer);
				}

				$this->commit();
				print 1;

				$this->Email->sendmail([
					'to' => $offer['StylistUser']['email'],
					'template' => 'matching_to_stylist',
					'body' => ['data' => $offer],
					'subject' => 'CUTTALOCA（カッタロカ）：マッチングが成立しました',
				]);

				$this->Email->sendmail([
					'to' => $offer['CutModelUser']['email'],
					'template' => 'matching_to_cutmodel',
					'body' => ['data' => $offer],
					'subject' => 'CUTTALOCA（カッタロカ）：マッチングが成立しました',
				]);
			} catch (Exception $e) {
				$this->rollback($e);
				print "0 999 DB_ERROR";
			}
		}

		exit;
	}
}