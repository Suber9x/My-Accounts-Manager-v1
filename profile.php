<?php require 'core/init.php' ?>
<?php 

	$user = new User();
	if(Input::exists()){
		if(Token::check(Input::get('token'))) {
			$validation = new Validation();
			$validate = $validation->check($_POST, array(
				'username' => array(
					'name' => 'Ten dang nhap',
					'required' => true,
					'min' => 2,
					'max' => 15,
					'unique' => 'users'
				),
	            'name' => array(
					'name' => 'Họ tên',
					'required' => true,
					'min' => 2,
					'max' => 50
				),   
			));

			if($validate->passed()){
				$user = new User();
				$date = new DateTime();
				$date = $date->format('d-m-Y H:i:s');

				$id = Session::get(Config::get('session/session_name'));

				if($user->changePassword(array('`username`','=', "'".Input::get('username')."'", ',', '`name`', '=', "'".Input::get('name')."'" , ',' ,'`updated`','=', "'".$date."'" , '/' ,'id', $id))){
					Session::flash('success', 'Thông tin tài khoản vừa được cập nhật.');
				} else {
					$err[] = 'Có lỗi xảy ra trong quá trình cập nhật.';
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
        if(Session::exists('success')) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>Lỗi!</strong> '.Session::flash('success').'</div>';
          }
	?>
</div>
<div class="jumbotron">
      <div class="container">
        <h1 class="display-3">TÀI KHOẢN</h1>
        <p>Đây là trang quản lý thông tin tài khoản dịch vụ.</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button" id="editbtn">Chỉnh Sửa Profile &raquo;</a></p>
      </div>
    </div>
<div class="container">
	<div id="profileinfo">
		<table class="table table-bordered table-responsive" style="display: inline-table !important;">
		  <thead>
		    <tr>
		      <th>Username</th>
		      <th>Họ Tên</th>
		      <th>Ngày Tạo</th>
		      <th>Cập Nhật Gần Đây</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <th scope="row"><?php echo $user->data()->username; ?></th>
		      <td><?php echo $user->data()->name; ?></td>
		      <td><?php echo $user->data()->joined; ?></td>
		      <td><?php echo $user->data()->updated; ?></td>
		    </tr>
		  </tbody>
		</table>
	</div>
	<div class="form" style="display: none;">
		<form action="" method="post" class="form-control" id="form-box">
	            <div>
	                <label for="username">Username</label>
	                <input type="text" class="form-control" value="<?php echo $user->data()->username ?>" name="username">
	            </div>
	            <div>
	                <label for="name">Họ Tên</label>
	                <input type="text" class="form-control" value="<?php echo $user->data()->name ?>" name="name">
	            </div>

	        <br>

	        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	        <input type="submit" name="" class="form-control btn btn-warning" value="Cập Nhật">
		</form>
	</div>


<?php View::include('blocks/footer.php') ?>
<script type="text/javascript"> 
	$('#editbtn').on('click', function(){
		$('#profileinfo').hide(5000);
		$('.form').show(5000);
	});
</script>