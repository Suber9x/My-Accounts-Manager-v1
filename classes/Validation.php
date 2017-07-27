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
					$this->addError('Vui lòng nhập '.$items[$item]['name']);
				} elseif(!empty($value)) {
					switch($rule){
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$items[$item]['name']} yêu cầu {$rule_value} ký tự trở lên");
							}
							break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$items[$item]['name']} tối đa {$rule_value} ký tự");
							}
							break;
						case 'unique':
							$check = $this->__db->get($rule_value, array($item, '=', $value));
							if($check->counts()) {
								$this->addError("{$items['item']['name']} đã tồn tại");
							}
							break;
						case 'matches':
							if($value != $source[$rule_value]) {
								$this->addError("{$items[$item]['name']} và {$items[$rule_value]['name']} không trùng khớp");
							}
							break;
						case 'current_password':
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