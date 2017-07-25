<?php
	require_once 'core/init.php';

	// $options = array(
	// 		'number' => 1,
	// 		'char'	=> 1,
	// 		'charUpper' => 1,
	// 		'charSpecial' => 1
	// );
	// $password = new Password();
	// $password = $password->make($options, 8);
	
	// echo $password;

 if(isset($_REQUEST['action'])) {
 	switch ($_REQUEST['action']) {
 		case 'genpassword':
 			$options = array(
					'number' => 1,
					'char'	=> 1,
					'charUpper' => 1,
					'charSpecial' => 1
			);
			$password = new Password();
			$password = $password->make($options, 8);
			
			echo $password;
 			break;
 		
 		default:
 			# code...
 			break;
 	}
 }