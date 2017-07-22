<?php
	require_once 'core/init.php';

	if(Input::exists()){
		if(Token::check(Input::get('token'))) {
			echo "Dang chay <br>";

			$validate = new Validation();
			$validation = $validate->check($_POST, array(
				'username' => array(
					'name' => 'Ten dang nhap',
					'required' => true,
					'min' => 2,
					'max' => 15,
					'unique' => 'users'
				),
				'password' => array(
					'name' => 'Mat khau',
					'required' => true,
					'min' => 6
				),
				'password_confirm' => array(
					'name' => 'Xac thuc mat khau',
					'required' => true,
					'matches' => 'password'
				), 
				'name' => array(
					'name' => 'Ho va ten',
					'required' => true,
					'min' => 2,
					'max' => 20
				)

			));

			if($validation->passed()){
				$user = new User();

				$salt = Hash::salt(32);

				$date = new DateTime();
				$date = $date->format('d-m-Y H:i:s');

				try{
					$user->create(array(
						'username' => Input::get('username'),
						'password' => Hash::make(Input::get('password'), $salt),
						'salt' => $salt,
						'name' => Input::get('name'),
						'joined' => $date,
						'groups' => 1
					));

					Session::flash('home', 'Ban da dang ky thanh cong');
					Redirect::to('index.php');

				} catch(Exception $e) {
					die($e->getMessage());
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

	<div class="field">
		<label for="password_confirm">Nhap Lai Mat Khau</label>
		<input type="password" name="password_confirm"  placeholder="Nhap Lai Password...">
	</div>

	<div class="field">
		<label for="name">Ho Va Ten</label>
		<input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" placeholder="Nhap Ho Ten...">
	</div>

	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" value="Register">
</form>