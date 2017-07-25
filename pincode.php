<?php 
	require_once 'core/init.php';

	$user = new User();

	if(Input::exists()){
		if(User::checkPincode(escape(Input::get('pincode')), $user->data()->pincode)){
			$user->successPincode();
			Session::put(Config::get('session/pincode_name'), 'true');
			Redirect::to('index.php');
		}
		else {
			Redirect::to('logout.php');
		}
	}

	if(Session::exists(Config::get('session/pincode_name')) && Session::get(Config::get('session/pincode_name')) == 'true') {
		Redirect::to('index.php');
	}

?>

<?php View::include('blocks/header.php'); ?>

	<div class="jumbotron">
      <div class="container">
        <h1 class="display-3">PINCODE </h1>
        <p>Xác minh bước 2. Vui lòng cung cấp mã pin của bạn.</p>
        <p><a class="btn btn-primary btn-lg" href="create.php" role="button">Thay Đổi Mã Pin &raquo;</a></p>
      </div>
    </div>
	
	<div class="container">
		<form class="form-control" action="" method="post">
			<label for="pincode">Nhập mã pin</label>
			<input type="number" class="form-control" name="pincode">

			<br/>

			<input type="submit" class="btn btn-success form-control">
		</form>
	


<?php View::include('blocks/footer.php'); ?>