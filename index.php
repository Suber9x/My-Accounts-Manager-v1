
  <?php include_once 'core/init.php' ?>

  <?php View::include('blocks/header.php') ?>

  <?php 

    if(Session::exists(Config::get('session/pincode_name'))){
      if(Session::get(Config::get('session/pincode_name')) != 'true') {
        Redirect::to('pincode_name.php');
      }
    }

    global $user;
    $id = Session::get(Config::get('session/session_name'));
    $accounts = DB::getInstance()->get('service_account', array('user_id', '=', $id))->results();
    
  
  ?>
    <div class="error-display" style="display: fixed; left:0; bottom: 0; position: fixed">
        <?php 
          if(Session::exists('success')) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>Thành Công!</strong> '.Session::flash('success').'</div>';
          } elseif(Session::exists('success_change')) {
             echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>Thành Công!</strong> '.Session::flash('success').'</div>';
          }
        ?>
      </div>
    
    <div class="jumbotron">
      <div class="container">
        <h1 class="display-3">TRANG QUẢN LÝ</h1>
        <p>Đây là trang quản lý các tài khoản dịch vụ.</p>
        <p><a class="btn btn-primary btn-lg" href="create.php" role="button">Ghi Nhớ Tài Khoản Mới &raquo;</a></p>
      </div>
    </div>
    
    <div class="container">
      
      <div class="row table-responsive">
        <table class="table table-hover" id="service-table">
          <thead class="thead-inverse">
            <tr>
              <th>#</th>
              <th>Tên Dịch Vụ</th>
              <th>Username/Email</th>
              <th>Mật Khẩu</th>
              <th>Ngày Tạo</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            $i = 1;
            foreach ($accounts as $account) {
                ?> 
                  <tr>
                    <th scope="row"><?php echo $i ?></th>
                    <td><?php echo $account->name ?></td>
                    <td><?php echo $account->username ?></td>
                    <td><?php echo $account->password ?></td>
                    <td><?php echo $account->date ?></td>
                    <td><a href="editaccount.php" id="edit_<?php echo $id; ?>" ><i class="fa fa-pencil"  aria-hidden="true"></i></a> | <a href="deleteaccount.php" id="delete_<?php echo $id; ?>" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                  </tr>             
                <?php
                $i++;
            } 
          ?>

            
           
          </tbody>
        </table>
      </div>

      <?php View::include('blocks/footer.php') ?>


