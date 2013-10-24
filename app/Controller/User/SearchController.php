<?php
App::uses('UserBaseController', 'Controller');
/**
 * Accounts Controller
 *
 * @property Account $Account
 */
class SearchController extends UserBaseController {

	public $uses = [];
	public $header = [
		'title' => 'スタイリスト一覧',
		'css' => ['stylist'],
		'js' => 'stylist'
	];

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->load_models(['Prefecture', 'Stylist']);

		$conditions = $this->makeConditions();

		$stylelist = Configure::read('HairLengthList');
		$stylelist_after = Configure::read('HairLengthAfterList');
		$this->set('cut_before', $stylelist);
		$this->set('cut_after', $stylelist_after);
		$this->set('color_before', Configure::read('ColorBefore'));
		$this->set('color_after', Configure::read('ColorAfter'));
		$this->set('perm_before', Configure::read('PermBefore'));
		$this->set('perm_after', Configure::read('PermAfter'));

		$this->set('search_prefecture', $this->Prefecture->getList());
		$this->set('stylelist', Configure::read('StyleList'));
		$this->set('stylists', $this->Stylist->getlist($conditions, $this->request->query['page']));
		$this->set('query', $this->getQuery());
		$this->set('search_results', $this->Stylist->find('count', compact('conditions')));
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
		
		// カットモデルからの美容師検索の場合、カットモデルの性別と美容師の募集対象(apply_gender)をデフォルトでマッチさせる
		$conditions['Stylist.apply_gender'] = [$this->logindata['User']['gender'], 9];
				
		if (!empty($data['prefecture'])) {
			$conditions['Stylist.prefecture'] = $data['prefecture'];
		}

		if (!empty($data['area'])) {
			$conditions['Stylist.city'] = $data['area'];
		}
		
		// カットモデルからの美容師検索の場合、「性別から絞り込み」の検索条件は美容師の性別とマッチさせる
		if (!empty($data['apply_gender'])) {
			if ($data['apply_gender'] == 9) {
				$conditions['User.gender'] = [1, 2];
			} else {
				$conditions['User.gender'] = $data['apply_gender'];
			}
		}		
		/*
		if (!empty($data['apply_gender'])) {
			if ($data['apply_gender'] == 9) {
				$conditions['Stylist.apply_gender'] = $data['apply_gender'];
			} else {
				$conditions['Stylist.apply_gender'] = [$data['apply_gender'], 9];
			}
		}*/

		if (!empty($data['apply_content'])) {
			$where = [];
			foreach ($data['apply_content'] as $value) {
				$where[] = "Stylist.apply_content like '%" . $value . "%'";
			}
			$conditions[] = '(' . implode(' AND ', $where) . ')';
		}

		return $conditions;
	}
}
