<?php

class User {
	private $__db, $__data;

	public function __construct($user = null){
		$this->__db = DB::getInstance();
	}

	public function create($fields = array()){
		if(!$this->__db->insert('users', $fields)) {
			throw new Exception('Co loi xay ra khi tao tai khoan');
		}
	}

	public function find($user = null) {
		if($user) {
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->__db->get('users', array($field, '=', $user));

			if($data->counts()){
				$this->__data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function login($username = null, $password = null){
		if($user = $this->find($username))
			return $this->__data;
		
		return false;
	}

}