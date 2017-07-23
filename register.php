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
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Ngoc Vo">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/config.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">

</head>
<body>
	<div class="login-box">
		<div class="heading bg-secondary-color" id="login-heading">
			<div class="float-left">
				<p class="leading">Đăng Nhập</p>
				<br/>
				<span class="small-text">Hãy cung cấp danh tính của bạn để có thể tiếp tục.</span>
			</div>
			<div class="float-right"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
		</div>
		<div class="form-section" id="login-section">
			<form action="" method="post" accept-charset="UTF-8">
				<p>Username</p>
				<div class="field">
					<input type="text" name="username" value="<?php echo escape(Input::get('username')); ?>" placeholder="Nhap Username...">
				</div>
				<p>Password</p>
				<div class="field">
					<input type="password" name="password"  placeholder="Nhap Password...">
				</div>
				<p>Nhập lại Password</p>
				<div class="field">
					<input type="password" name="password_confirm"  placeholder="Nhap Lai Password...">
				</div>
				<p>Họ tên</p>
				<div class="field">
					<input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" placeholder="Nhap Ho Ten...">
				</div>
				<br/>
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<input type="submit" class="btn btn-danger" name="" value="Đăng ký">
				<br/>
				<div class="text-center">
					<a href="#" >Quên mật khẩu ?</a> | <a href="login.php">Đăng nhập</a>
					<div class="clear-fix"></div>
				</div>
			</form>
		</div>
	</div>
</body>
</html>




