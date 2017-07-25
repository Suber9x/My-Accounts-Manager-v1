<?php
require_once 'functions/sanitize.php';
session_start();



$GLOBALS['config'] = array(
	'server' => array(
		'path' => 'http://127.0.0.1/NV-s-Porfolio/',
	),
	'mysql'	=> array(
		'host'	=> '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'db' => 'ngocvo',
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token',
		'pincode_name'	=> 'pincode',
	)


);


spl_autoload_register(function($class){
	require_once 'classes/'.$class.'.php';
});





if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('user_session', array('hash', '=', $hash));

	if($hashCheck->counts()){
		$user = new User($hashCheck->first()->user_id);
		$user->login();
		
		
	}
}

