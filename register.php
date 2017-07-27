<?php
	require_once 'core/init.php';
	$err = array();
	if(Input::exists()){
		if(Token::check(Input::get('token'))) {

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
					'name' => 'Mật khẩu',
					'required' => true,
					'min' => 6
				),
				'password_confirm' => array(
					'name' => 'Xác thực mật khẩu',
					'required' => true,
					'matches' => 'password'
				), 
				'name' => array(
					'name' => 'Họ tên',
					'required' => true,
					'min' => 2,
					'max' => 50
				), 
				'pincode' => array(
					'name' => 'Mã pin',
					'required' => true,
					'min' => 4,
					'max' => 8
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
						'pincode' => Input::get('pincode'),
						'joined' => $date,
						'groups' => 1
					));

					Session::flash('success', 'Bạn đã đăng ký thành công');
					Redirect::to('login.php');

				} catch(Exception $e) {
					die($e->getMessage());
				} 
				
			} else {
				foreach ($validation->errors() as $key => $value) {
					$err[] = $value;
				}
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
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">		
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

</head>
<body>
		<div class="error-display" style="display: fixed; left:0; bottom: 0; position: fixed">
						<?php 
							if(!empty($err)){
								foreach ($err as $key => $value) {
									echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
										  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										    <span aria-hidden="true">&times;</span>
										  </button>
										  <strong>Lỗi!</strong> '.$value.'</div>';
								}
							}
						?>
			</div>
	<div class="login-box">
		<div class="heading bg-secondary-color" id="login-heading">
			<div class="float-left">
				<span class="leading">Đăng Ký</span>
				<br/>
				<span class="small-text">Hãy cung cấp thông tin tài khoản của bạn.</span>
			</div>
			<div class="float-right"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
		</div>
		<div class="form-section" id="login-section">
			
			<form action="" method="post" accept-charset="UTF-8">
				<p>Username</p>
				<div class="field">
					<input type="text" name="username" value="<?php echo escape(Input::get('username')); ?>" placeholder="Nhập tên đăng nhập...">
				</div>
				<p>Password</p>
				<div class="field">
					<input type="password" name="password"  placeholder="Nhap mật khẩu...">
				</div>
				<p>Nhập lại Password</p>
				<div class="field">
					<input type="password" name="password_confirm"  placeholder="Nhập lại mật khẩu...">
				</div>
				<p>Họ tên</p>
				<div class="field">
					<input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" placeholder="Nhập họ tên...">
				</div>
				<p>Tạo mã pin</p>
				<div class="field">
					<input type="number" name="pincode"  placeholder="Nhập mã pin (4 số trở lên)...">
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

	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			 setTimeout(function(){
				$('.alert').hide(2000);
			}, 8000);
		});
	</script>
</body>
</html>




