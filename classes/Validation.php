<?php

class Validation{
	private $__passed = false, 
			$__errors = array(),
			$__db = null;

	public function __construct(){
		$this->__db = DB::getInstance();
	}

	public function check($source, $items = array()) {
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				$value = $source[$item];
				$item = escape($item);
 
				if($rule === 'required' && empty($value)){
					$this->addError('Vui long nhap '.$items[$item]['name']);
				} elseif(!empty($value)) {
					switch($rule){
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$items[$item]['name']} yeu cau {$rule_value} ky tu tro len");
							}
							break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$items[$item]['name']} toi da {$rule_value} ky tu");
							}
							break;
						case 'unique':
							$check = $this->__db->get($rule_value, array($item, '=', $value));
							if($check->counts()) {
								$this->addError("{$item} da ton tai");
							}
							break;
						case 'matches':
							if($value != $source[$rule_value]) {
								$this->addError('Mat khau khong trung khop voi nhau');
							}
							break;
						default:
							break;
					}
				}	
			}
		}
		if(empty($this->__errors)) {
			$this->__passed = true;
		}

		return $this;
	}

	private function addError($error){
		$this->__errors[] = ucwords($error);
	}

	public function errors(){
		return $this->__errors;
	}

	public function passed(){
		return $this->__passed;
	}



}