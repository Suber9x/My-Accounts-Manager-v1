<?php 

class Password {

	private $__number = array('0','1','2','3','4','5','6','7','8','9'), 
			$__char = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'),
			$__charUpper = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'),
			$__charSpecial = array('!','@','#','$','^','*','/','~');

	public function make($options = array(), $length) {
		$password_option = array();
		foreach ($options as $key => $value) {
			if($value == 1) {
				switch($key){
					case 'number':
						$password_option = array_merge($password_option, $this->__number);
						break;
					case 'char':
						$password_option = array_merge($password_option, $this->__char);
						break;
					case 'charUpper':
						$password_option = array_merge($password_option, $this->__charUpper);
						break;
					case 'charSpecial':
						$password_option = array_merge($password_option, $this->__charSpecial);
						break;
				}
			}
		}

		
		$password = array();
		$randVal = array_rand($password_option, $length);
		for($i=0; $i <= $length; $i++) {
			array_push($password, $password_option[array_rand($password_option)]);
		}
		shuffle($password);
		//var_dump($password);
		$password = implode("", $password);
		return $password;

	}

}






