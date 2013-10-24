<?php
App::uses('UserBaseController', 'Controller');
/**
 * Accounts Controller
 *
 * @property Account $Account
 */
class ReviewController extends UserBaseController {

	public $uses = ['Stylist', 'Review'];
	public $components = ['Email'];
	public $header = [
		'title' => 'レビューを書く',
		'css' => ['stylist', 'cutmodel', 'review']
	];

/**
 * index method
 *
 * @return void
 */
	public function offer($id) {
		$this->load_models(['Offer']);
		$offer = $this->Offer->getInfo($id);

		if ($this->request->is('post')) {
			$data = $this->request->data;

			$data['Review']['stylist_user_id'] = $offer['StylistUser']['id'];
			$data['Review']['cut_model_user_id'] = $this->logindata['User']['id'];

			try {
				$this->begin(['Review', 'Offer']);
				if ($this->Review->save($data) === false) {
					$this->raiseException($this->Review);
				}

				$this->Offer->id = $offer['Offer']['id'];
				if ($this->Offer->saveField('status', STATUS_END) === false) {
					$this->raiseException($this->Offer);
				}
				$this->commit();

				$offer['Review'] = $data['Review'];
				$this->Email->sendmail([
					'to' => $offer['StylistUser']['email'],
					'template' => 'review_to_stylist',
					'subject' => 'CUTTALOCA（カッタロカ）:レビューがありました',
					'body' => ['data' => $offer]
				]);

				$this->redirect('/user/offer/approve/');
			} catch(Exception $e) {
				$this->rollback($e);
			}
		}

		$this->set('offer', $offer);
		$this->set('stylist', $this->Stylist->findById($offer['Offer']['stylist_id']));
	}

	public function stylist($id) {
		$this->header['js'] = 'blocksit';
		$stylist = $this->Stylist->findById($id);
		$this->set('reviews', $this->Review->findAllByStylistUserId($stylist['User']['id']));
	}
}
