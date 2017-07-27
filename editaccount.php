<?php require_once 'core/init.php' ?>

<?php 
$err = array();

$service = new Account();
$additionVal = array();
if($service->find(Session::get(Config::get('session/session_name')))){
	$additionVal = json_decode($service->data()->addition_info, true);
}

$currentServiceName = $service->data()->name;	


if(Input::exists()) {
    if(Token::check(Input::get('token'))){
    	
    	if(!$service->find(Input::get('name'))){
    		$validation = new Validation();
	        $validateArr = array(
	            'name' => array(
	                'name' => 'Tên Dịch Vụ',
	                'required' => true,
	                'min' => 2,
	                'max' => 20,
	            ),
	            'service_username' => array(
	                'name' => 'Tên Đăng Nhập',
	                'required' => true,
	                'min' => 6,
	                'max' => 20
	            ),
	            'service_password' => array(
	                'name' => 'Mật Khẩu Dịch Vụ',
	                'required' => true,
	                'min' => 8,
	                'max' => 20
	            ),
	        );

	        if(Input::get('new_password')){
	        	$validateArr = array_merge($validateArr, array(
	        		'old_password' => array(
		                'name' => 'Mật Khẩu Cũ',
		                'required' => true,
		                'min' => 6,
		            ),
		            'new_password' => array(
		                'name' => 'Mật Khẩu Mới',
		                'required' => true,
		                'min' => 6,
		                'matches' => 'password_confirm',
		            ),
		            'password_confirm' => array(
		                'name' => 'xác nhận mật khẩu',
		                'required' => true,
		                'min' => 6,
		                
		            )
	        	));
	        }
	        $validate = $validation->check($validateArr);


	        if($validate->passed()){
	            $account = new Account();
	            $date = new DateTime();
	            $date = $date->format('d-m-Y H:i:s');
	            $addition = Input::get('addition');
	            $additionVal = Input::get('additionVal');
	            $obj = array();
	            for($i=0; $i<sizeof($addition); $i++)
	                for($j=0; $j<sizeof($additionVal); $j++){
	                    $obj[$addition[$i]] = $additionVal[$j]; 
	                }
	            $obj = json_encode($obj);

	            $updatefields = array();

	            if(Input::get('new_password')) {
	            	$updatefields = array(
	            		'`name`','=',"'".Input::get('name')."'", ',',
	            		'`username`','=',"'".Input::get('service_username')."'", ',',
	            		'`password`','=',"'".Input::get('new_password')."'", ',',
	            		'`addition_info`','=',"'".$obj."'", ',',
	            		'`updated`','=',"'".$date."'", ',',
	            		'`id`',$service->data()->id, 
	            	);
	            } else {
	            	$updatefields = array(
	            		'`name`','=',"'".Input::get('name')."'", ',',
	            		'`username`','=',"'".Input::get('service_username')."'", ',',
	            		'`password`','=',"'".$service->data()->password."'", ',',
	            		'`addition_info`','=',"'".$obj."'", ',',
	            		'`updated`','=',"'".$date."'", ',',
	            		'`id`',$service->data()->id, 
	            	);
	            }

	            if($account->update($updatefields)){
	            	Session::flash('success', 'Thông Tin Tài Khoản Vừa Được Cập Nhật.');
	            	Redirect::to('index.php');
	            }
	            else {
	            	$err[] = 'Có lỗi trong quá trình cập nhật';
	            }
	 
	        }
	        else {
	            foreach ($validate->errors() as $key => $value) {
	                    $err[] = $value;
	                }
	        }
	    		
	    	} else{
	    		$err[] = 'Tên Dịch Vụ Đã Tồn Tại';

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
	?>
</div>

<div class="jumbotron">
  <div class="container">
    <h1 class="display-3">CẬP NHẬT THÔNG TIN TÀI KHOẢN DỊCH VỤ</h1>
    <p>Để thay đổi thông tin tài khoản dịch vụ vui lòng điền thông tin thích hợp vào form bên dưới.</p>
    <p><a class="btn btn-success btn-lg" href="create.php" role="button">Đổi Mã Pin &raquo;</a></p>
  </div>
</div>
<div class="container">
    	<form action="" method="post" class="form-control" id="form-box">
    		<div id="appendbox">
                <div>
                    <label for="name">Tên Dịch Vụ</label>
                    <input type="text" class="form-control" value="<?php echo $service->data()->name ?>" name="name">
                </div>
                <div>
                    <label for="service_username">Username/Email</label>
                    <input type="text" class="form-control" value="<?php echo $service->data()->username ?>" name="service_username">
                </div>
                <br>
                <p><div style="cursor: pointer" onclick="loadChangePasswordForm();" class="btn btn-warning">Cập nhật mật khẩu (+)</div></p>
                <br>
                <div id="updateform_wrapper">
                	
                </div>
                <br>
                <div class="float-right" id="genPasswrapper">
                    <div class="btn btn-success" onclick="makePassword('action');" style="color:#fff; cursor: pointer;" class="form-control">Sinh mật khẩu? (+)</div>
                    <div id="gen"></div>
                </div>
                <div class="float-left">
                    <div href="#" class="btn btn-primary" onclick="loadMore();" style="color:#fff; cursor: pointer;" class="form-control">Thêm trường thông tin? (+)</div>
                </div>
                <div class="clearfix"></div>
                <br>
				<?php 
					foreach ($additionVal as $key => $value) {
						echo '<div style="display: flex;"><div class="col-md-6"><label for="pincode">Tên Trường Thông Tin</label><input type="text" value='.$key.' class="form-control" name="addition[]" placeholder="vd: Câu hỏi bí mật..."></div><div class="col-md-6"><label for="pincode">Giá Trị</label><textarea class="form-control" name="additionVal[]" placeholder="vd: Con mèo...">'.$value.'</textarea></div> </div><div class="clearfix"></div>';
					}

				?>
                <div class="clearfix"></div>      
            </div>

            <br>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            <input type="submit" name="" class="form-control btn btn-warning" value="Cập Nhật">
    	</form>

    <script type="text/javascript">


        function makePassword(){

            var req = new XMLHttpRequest();
            var url = 'genpass.php';
            var params = "genpassword";

            req.open("POST", url, true);
            req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            req.send("action=" + params);
            req.onreadystatechange = function() {
                if(req.readyState == 400 || req.status == 200) {
                    var passbox = '';
                    passbox += '<br><div id="copyTxt" style="border: 1px solid rgba(0,0,0,.15); height: 30px; border-radius: 5px; box-sizing: border-box; padding: 3px; display: flex"><span class="float-left">';
                    passbox += req.responseText;
                    passbox += '</span> <i onclick="copyText();" style="cursor: pointer;" class="fa fa-clipboard" aria-hidden="true"></i></div>';

                    $('#gen').html(passbox);
                }
            }
            
        }



        function loadMore(){
            input = '<div style="display: flex;"><div class="col-md-6"><label for="pincode">Tên Trường Thông Tin</label><input type="text" class="form-control" name="addition[]" placeholder="vd: Câu hỏi bí mật..."></div><div class="col-md-6"><label for="pincode">Giá Trị</label><textarea class="form-control" name="additionVal[]" placeholder="vd: Con mèo..."></textarea></div> </div><div class="clearfix"></div>';

            $('#appendbox').append(input);
        }

        function loadChangePasswordForm(){
        	form = '<div><label for="old_password">Mật Khẩu Hiện Tại</label><input type="text" name="old_password" class="form-control"></div><div><label  for="new_password">Mật Khẩu Mới</label><input type="password" name="new_password" class="form-control"></div><div><label  for="password_confirm">Xác Nhận Mật Khẩu</label><input type="password" name="password_confirm" class="form-control"></div>';
        	$('#updateform_wrapper').html(form);
        };


        function copyText(){
            var password = $('#copyTxt').text();
            var temp = $('<input>');
            $('body').append(temp);
            temp.val(password).select();
            document.execCommand('copy');
            temp.remove();
            alert("Copied");
        }

    </script>

<?php View::include('blocks/footer.php') ?>