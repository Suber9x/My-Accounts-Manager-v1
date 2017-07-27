<?php 
	require_once 'core/init.php';

	$err = array();

	if(Input::exists()) {
		if(Token::check(Input::get('token'))) {
			$validate = new Validation();
			$validation = $validate->check($_POST, array(
				'username' => array(
					'name' => 'Tên Đăng Nhập',
					'required' => true
				),
				'password' => array(
					'name' => 'Mật khẩu',
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
					$err[] = 'Người Dùng Không Tồn Tại!';
				}
			} else {
				foreach ($validation->errors() as $key => $value) {
					$err[] = $value;
				}
				
			}

		}
	}

	$user = new User();
	if($user->isLoggedIn()) {
		Redirect::to("pincode.php");
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
					} elseif (Session::exists('success')) {
						echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
								  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
								    <span aria-hidden="true">&times;</span>
								  </button>
								  <strong>Thành Công!</strong> '.Session::flash('success').'</div>';
					}
				?>
			</div>
	<div class="login-box">
		<div class="heading bg-primary-color" id="login-heading">
			<div class="float-left">
				<span class="leading">Đăng Nhập</span>
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





