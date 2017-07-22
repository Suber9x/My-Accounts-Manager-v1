<?php 
	require_once 'core/init.php';

	if(Input::exists()) {
		if(Token::check(Input::get('token'))) {
			$validate = new Validation();
			$validation = $validate->check($_POST, array(
				'username' => array(
					'name' => 'Ten dang nhap',
					'required' => true
				),
				'password' => array(
					'name' => 'Mat khau',
					'required' => true
				),
			));

			if($validation->passed()){
				$user = new User();
				$login = $user->login(Input::get('username'), Input::get('password'));
				if($login) {
					print_r($login);
					echo 'Success';
				} else {
					echo '<p>Nguoi dung khong ton tai</p>';
				}
			} else {
				print_r($validation->errors());
			}
		}
	}



?>






<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" value="<?php echo escape(Input::get('username')); ?>" placeholder="Nhap Username...">
	</div>
	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password"  placeholder="Nhap Password...">
	</div>

	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" name="" value="Dang Nhap">
</form>