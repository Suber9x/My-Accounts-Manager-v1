<?php

class User {
	private $__db, $__data, $__sessionName, $__loggedIn = false, $__cookieName;

	public function __construct($user = null){
		$this->__db = DB::getInstance();

		$this->__sessionName = Config::get('session/session_name');

		$this->__cookieName = Config::get('remember/cookie_name');
		
		if(!$user) {
			if(Session::exists($this->__sessionName)) {
				$user = Session::get($this->__sessionName);

				if($this->find($user)) {
					$this->__loggedIn = true;
				} else {
					//Logout
				}
			}
		} else {
			$this->find($user);
		}

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

	public function login($username = null, $password = null, $remember){
		if($user = $this->find($username))
		{
			if($this->data()->password === Hash::make($password, $this->data()->salt)) {
				Session::put($this->__sessionName, $this->data()->id);
				if($remember) {
					$hash = Hash::unique();
					$hashCheck = $this->__db->get('user_session', array('user_id', '=', $this->data()->id));
					if(!$hashCheck->counts()){
						$this->__db->insert('user_session',array(
							'user_id' => $this->data()->id,
							'hash' => $hash
						));
					} else {
						$hash = $hashCheck->first()->hash;
					}
				}
				
				Cookie::set($this->__cookieName, $hash, Config::get('remember/cookie_expiry'));
				return true;
			}

		}
		
		return false;
	}

	public function logout(){
		if(isset($_SESSION[$this->__sessionName]))
			Session::delete($this->__sessionName);
	}


	public function data(){
		return $this->__data;
	}

	public function isLoggedIn(){
		return $this->__loggedIn;
	}

}