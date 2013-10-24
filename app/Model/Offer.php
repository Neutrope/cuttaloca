<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property Password $Password
 */
class Offer extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'status';

	public $belongsTo = [
		'CutModel' => [
			'type' => 'inner'
		],
		'Stylist' => [
			'type' => 'inner'
		]
	];

	public function beforeSave($options = []) {
		if (is_array($this->data['Offer']['content'])) {
			$this->data['Offer']['content'] = implode(',', $this->data['Offer']['content']);
		}
	}

	public function afterFind($results, $primary = false) {
		$this->OfferSchedule = ClassRegistry::init('OfferSchedule');

		foreach ($results as $key => $result) {
			if (!empty($result['Offer']['id'])) {
				if ($result['Offer']['status'] == STATUS_SUCCESS) {
					$results[$key]['Offer']['schedules'] = $this->OfferSchedule->findByOfferIdAndDetermine($result['Offer']['id'], 1);
				} else {
					$results[$key]['Offer']['schedules'] = $this->OfferSchedule->findAllByOfferId($result['Offer']['id']);
				}
			}
			if (!empty($result['Offer']['content'])) {
				$results[$key]['Offer']['content'] = explode(',', $result['Offer']['content']);
			}
		}

		return $results;
	}

	public function offerForCutModel($id) {
		$this->bindModel([
			'belongsTo' => [
				'User' => [
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => 'Stylist.user_id = User.id'
				]
			]
		]);
		$conditions = ['Offer.cut_model_id' => $id, 'NOT' => ['Offer.paid' => 1], 'AND' => ['(Offer.status != ? OR (Offer.status = ? AND Offer.modified > (current_timestamp + interval -1 day)))' => [STATUS_CANCEL, STATUS_CANCEL]]];
		$order = ['Offer.modified' => 'DESC'];
		return $this->find('all', compact('conditions', 'order'));
	}

	public function offerForStylist($id) {
		$this->bindModel([
			'belongsTo' => [
				'User' => [
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => 'CutModel.user_id = User.id'
				]
			]
		]);
		$conditions = ['Offer.stylist_id' => $id, 'NOT' => ['Offer.paid' => 1], 'AND' => ['(Offer.status != ? OR (Offer.status = ? AND Offer.modified > (current_timestamp + interval -1 day)))' => [STATUS_CANCEL, STATUS_CANCEL]]];
		$order = ['Offer.modified' => 'DESC'];
		return $this->find('all', compact('conditions', 'order'));
	}

	public function offerApproveForCutModel($id) {
		$this->bindModel([
			'belongsTo' => [
				'User' => [
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => 'Stylist.user_id = User.id'
				]
			]
		]);

		$conditions = ['Offer.cut_model_id' => $id, 'Offer.paid' => 1, 'Offer.status' => STATUS_SUCCESS];
		$order = ['Offer.modified' => 'DESC'];
		return $this->find('all', compact('conditions', 'order'));
	}

	public function offerApproveForStylist($id) {
		$this->bindModel([
			'belongsTo' => [
				'User' => [
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => 'CutModel.user_id = User.id'
				]
			]
		]);

		$conditions = ['Offer.stylist_id' => $id, 'Offer.paid' => 1];
		$order = ['Offer.modified' => 'DESC'];
		return $this->find('all', compact('conditions', 'order'));
	}

	public function getSettlement($id, $cut_model_id) {
		$this->bindModel([
			'belongsTo' => [
				'User' => [
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => 'Stylist.user_id = User.id'
				]
			]
		]);

		$conditions = ['Offer.id' => $id, 'Offer.cut_model_id' => $cut_model_id, 'Offer.status' => [STATUS_SUCCESS, STATUS_ADJUST, STATUS_OFFER], 'Offer.paid' => 0];
		return $this->find('first', compact('conditions'));
	}

	public function getInfo($id) {
		$this->bindModel([
			'belongsTo' => [
				'StylistUser' => [
					'type' => 'inner',
					'className' => 'User',
					'foreignKey' => false,
					'conditions' => 'Stylist.user_id = StylistUser.id'
				],
				'CutModelUser' => [
					'type' => 'inner',
					'className' => 'User',
					'foreignKey' => false,
					'conditions' => 'CutModel.user_id = CutModelUser.id'
				]
			]
		]);

		return $this->findById($id);
	}
}
