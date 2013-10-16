<?php
App::uses('UserBaseController', 'Controller');
/**
 * Accounts Controller
 *
 * @property Account $Account
 */
class StylistController extends UserBaseController {

	public $uses = [];
	public $header = [
		'title' => 'スタイリスト詳細',
		'css' => ['stylist'],
		'js' => 'stylist'
	];

/**
 * index method
 *
 * @return void
 */
	public function index($id) {
		$this->load_models(['Stylist', 'Schedule', 'Review', 'Portfolio', 'Offer']);

		$stylist = $this->Stylist->getlist(['Stylist.id' => $id]);
		$stylist = $stylist[0];

		$this->header['title'] = 'スタイリスト【'.$stylist['User']['last_name'].' '.$stylist['User']['first_name'].'】さんの詳細';

		$conditions = [
			'Offer.stylist_id' => $id,
			'Offer.cut_model_id' => $this->logindata['CutModel']['id']
		];
		$offers = $this->Offer->find('all', compact('conditions'));

		$message = 0;
		$time = false;
		if (!empty($offers)) {

			foreach ($offers as $offer) {
				if ($offer['Offer']['paid'] == 1 && $offer['Offer']['schedules']['OfferSchedule']['date'] > date('Y-m-d')) {
					$message = $offer['Offer']['id'];
				}
				if ($offer['Offer']['status'] < STATUS_SUCCESS || ($offer['Offer']['status'] == STATUS_SUCCESS && $offer['Offer']['paid'] == 0)) {
					$time = true;
				}
			}
		}

		$this->set('message', $message);
		$this->set('time', $time);
		$this->set('weeks', $this->getWeeks());

		$stylelist = Configure::read('HairLengthList');
		$stylelist_after = Configure::read('HairLengthAfterList');
		$this->set('cut_before', $stylelist);
		$this->set('cut_after', $stylelist_after);
		$this->set('color_before', Configure::read('ColorBefore'));
		$this->set('color_after', Configure::read('ColorAfter'));
		$this->set('perm_before', Configure::read('PermBefore'));
		$this->set('perm_after', Configure::read('PermAfter'));

		$this->set('stylist', $stylist);
		$this->set('reviews', $this->Review->findAllByStylistUserId($stylist['User']['id']));
		$this->set('stylists', $this->Stylist->getlist());
		$this->set('apply_time', Configure::read('ApplyCutModel'));
		$this->set('portfolios', $this->Portfolio->findAllByStylistId($id));
	}
}