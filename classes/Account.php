<?php 


class Account{
	private $__db;

	public function __construct($account = null){

		$this->__db = DB::getInstance();

	}

	public function create($field = array()) {
		if(!$this->__db->insert('service_account', $field)) {
			throw new Exception('Co loi xay ra khi tao tai khoan');
		}
	}


}