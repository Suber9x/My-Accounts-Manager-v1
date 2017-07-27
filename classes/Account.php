<?php 


class Account{
	private $__db, $__data;

	public function __construct($account = null){

		$this->__db = DB::getInstance();

	}

	public function create($field = array()) {
		if(!$this->__db->insert('service_account', $field)) {
			throw new Exception('Co loi xay ra khi tao tai khoan');
		}
	}

	public function find($user = null) {
		if($user) {
			$findcase = (is_numeric($user)) ? 'id' : 'name';
			switch ($findcase) {
				case 'id':
					$data = $this->__db->get('service_account', array('user_id', '=', $user));
					//var_dump($data);
					if($data->counts()) {
						$this->__data = $data->first();
						
						return true;
					}
					break;
				case 'name':
					$data = $this->__db->get('service_account', array('name', '=', $user));
					if($data->counts() && $data->counts() == 1) {
						$this->__data = $data->first();
						return true;
					} return false;
					break;
			}
			return false;

		}
	}

	public function update($fields){
		return $this->__db->update('service_account', $fields);
	}

	public function data(){
		return $this->__data;
	}


}