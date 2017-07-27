<?php require_once 'core/init.php' ?>
<?php 

$err = array();
	
	if(Input::exists()){
		if(Token::check(Input::get('token'))) {
			$validation = new Validation();
			$validate = $validation->check($_POST, array(
				'old_pincode' => array(
	                'name' => 'Mã Pin Cũ',
	                'required' => true,
	                'min' => 4,
	            ),
	            'new_pincode' => array(
	                'name' => 'Mã Pin Mới',
	                'required' => true,
	                'min' => 4,
	                'matches' => 'confirm_pincode',
	            ),
	            'confirm_pincode' => array(
	                'name' => 'xác nhận mã pin',
	                'required' => true,
	                'min' => 4,
	                
	            )
			));

			if($validate->passed()){
				$user = new User();
				$user->find(Session::get(Config::get('session/session_name')));
			
				
				$original_pincode = $user->data()->pincode;
				$id = Session::get(Config::get('session/session_name'));

				if(Input::get('old_pincode') == $original_pincode){
					//var_dump($user->changePassword(array('password','=', Hash::make(Input::get('new_password'), $new_salt), ',', 'salt', '=', $new_salt , '/' ,'id', $id)));
					if($user->changePassword(array('`pincode`','=', Input::get('new_pincode'), '/' ,'id', $id))){
						Session::flash('success', 'Mã pin vừa được cập nhật.');
						Redirect::to('index.php');
					} else {
						$err[] = 'Có lỗi xảy ra trong quá trình cập nhật.';
					}
				} else {
					$err[] = 'Mã Pin Cũ Không Đúng.';
				}
				
			} else {
            	foreach ($validation->errors() as $key => $value) {
					$err[] = $value;
				}
			}
 



		}
	}





 ?>








<?php View::include('blocks/header.php') ?>
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
		if(Session::exists('error')) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>Lỗi!</strong> '.Session::flash('error').'</div>';
          }
	?>
</div>
<div class="jumbotron">
  <div class="container">
    <h1 class="display-3">THAY ĐỔI MẬT KHẨU</h1>
    <p>Để thay đổi mã pin vui lòng điền thông tin thích hợp vào form bên dưới.</p>
    <p><a class="btn btn-primary btn-lg" href="create.php" role="button">Đổi Mã Pin &raquo;</a></p>
  </div>
</div>

<div class="container">
	<form class="form-control" action="" method="post">
		<div>
			<label  for="old_pincode">Mã Pin Hiện Tại</label>
			<input type="number" name="old_pincode" class="form-control">
		</div>
		<div>
			<label  for="new_pincode">Mã Pin Mới</label>
			<input type="number" name="new_pincode" class="form-control">
		</div>
		<div>
			<label  for="confirm_pincode">Xác Nhận Mã Pin</label>
			<input type="number" name="confirm_pincode" class="form-control">
		</div>

		<br>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="submit" name="" class="form-control btn btn-success" value="Thay Đổi">
	</form>

<?php View::include('blocks/footer.php') ?>