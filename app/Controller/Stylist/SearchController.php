<?php
App::uses('StylistBaseController', 'Controller');
/**
 * Accounts Controller
 *
 * @property Account $Account
 */
class SearchController extends StylistBaseController {

	public $uses = [];
	public $header = [
		'title' => 'カットモデル一覧',
		'css' => ['stylist'],
		'js' => 'stylist'
	];

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->load_models(['Prefecture', 'CutModel', 'Stylist']);

		$stylists = $this->Stylist->getlist(['Stylist.id' => $this->logindata['Stylist']['id']]);

		$conditions = $this->makeConditions();

		$this->set('search_prefecture', $this->Prefecture->getList());
		$this->set('stylelist', Configure::read('StyleList'));
		$this->set('stylists', $this->CutModel->getlist($conditions, $this->request->query['page']));
		$this->set('query', $this->getQuery());
		$this->set('search_results', $this->CutModel->find('count', compact('conditions')));
		$this->set('my_schedule', $stylists[0]);
		$this->set('weeks', $this->getWeeks());
		$this->set('apply_time', Configure::read('ApplyCutModel'));
	}

	private function getQuery() {
		$query = $this->request->query;
		if (empty($query['page'])) {
			$query['page'] = 1;
		}

		$this->set('page', $query['page']);

		$query['page']++;

		foreach ($query as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $val) {
					$result[] = $key.'[]='.$val;
				}
			} else {
				$result[] = $key.'='.$value;
			}
		}

		return implode('&amp;', $result);
	}

	private function makeConditions() {
		if (!$this->request->is('get')) {
			return null;
		} 

		$conditions = [];

		$data = $this->request->query;
		
		// USER_STATUSはACCEPTのもののみ検索対象
		$conditions['User.status'] = USER_STATUS_ACCEPT;

		if (!empty($data['prefecture'])) {
			$conditions['OR'] = [
				'CutModel.prefecture01' => $data['prefecture'],
				'CutModel.prefecture02' => $data['prefecture'],
				'CutModel.prefecture03' => $data['prefecture']
			];
		}

		if (!empty($data['area'])) {
			$conditions['OR'] = [
				'CutModel.city01' => $data['area'],
				'CutModel.city02' => $data['area'],
				'CutModel.city03' => $data['area']
			];
		}

		if (!empty($data['gender'])) {
			$conditions['User.gender'] = $data['gender'];
		}

		if (!empty($data['style'])) {
			$conditions['CutModel.style'] = $data['style'];
		}

		return $conditions;
	}
}
