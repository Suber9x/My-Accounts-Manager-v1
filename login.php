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
				$remember = (Input::get('remember') === 'on') ? true : false;
				$login = $user->login(Input::get('username'), Input::get('password'), $remember);
				if($login) {
					Redirect::to('index.php');
				} else {
					echo '<p>Nguoi dung khong ton tai</p>';
				}
			} else {
				print_r($validation->errors());
			}
		}
	}

	$user = new User();
	if($user->isLoggedIn()) {
		Redirect::to("index.php");
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
		<div class="heading bg-primary-color" id="login-heading">
			<div class="float-left">
				<p class="leading">Đăng Nhập</p>
				<br/>
				<span class="small-text">Hãy cung cấp danh tính của bạn để có thể tiếp tục.</span>
			</div>
			<div class="float-right"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
		</div>
		<div class="form-section" id="login-section">
			<form action="" method="post" accept-charset="UTF-8">
				<div class="field">
					<label  for="username"><i class="fa fa-user" aria-hidden="true"></i></label>
					<input  type="text" name="username" value="<?php echo escape(Input::get('username')); ?>" placeholder="Nhập Username...">
				</div>
				<div class="clear-fix"></div>
				<div class="field">
					<label for="password"><i class="fa fa-key" aria-hidden="true"></i></label>
					<input type="password" name="password"  placeholder="Nhập Password...">
				</div>
				<div class="clear-fix"></div>
				<div>
					<labe for="remember">
						<input type="checkbox" name="remember" id="remember"> Ghi nhớ
					</label>
				</div>
				<br/>
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<input type="submit" class="btn btn-success " name="" value="Đăng nhập">
				<br/>
				<div class="text-center">
					<a href="#" >Quên mật khẩu ?</a> | <a href="register.php">Đăng ký</a>
					<div class="clear-fix"></div>
				</div>
			</form>
		</div>
	</div>
</body>
</html>





