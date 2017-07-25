
  <?php include_once 'core/init.php' ?>

  <?php View::include('blocks/header.php') ?>

  <?php 
    // var_dump());
    // die();
    if(Session::exists(Config::get('session/pincode_name'))){
      if(Session::get(Config::get('session/pincode_name')) != 'true') {
        Redirect::to('pincode_name.php');
      }
    }

    global $user;
    $id = Session::get(Config::get('session/session_name'));
    $accounts = DB::getInstance()->get('service_account', array('user_id', '=', $id))->results();
    
  
  ?>
    
    <div class="jumbotron">
      <div class="container">
        <h1 class="display-3">TRANG QUẢN LÝ</h1>
        <p>Đây là trang quản lý các tài khoản.</p>
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
            foreach ($accounts as $account) {
                ?> 
                  <tr>
                    <th scope="row"><?php echo $account->id ?></th>
                    <td><?php echo $account->name ?></td>
                    <td><?php echo $account->username ?></td>
                    <td>@<?php echo $account->password ?></td>
                    <td>@<?php echo $account->date ?></td>
                    <td><a href="edit.php"><i class="fa fa-pencil" aria-hidden="true"></i></a> | <a href="delete.php"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                  </tr>             
                <?php
            } 
          ?>
          <!--   <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
              <td><a href="edit.php"><i class="fa fa-pencil" aria-hidden="true"></i></a> | <a href="delete.php"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Jacob</td>
              <td>Thornton</td>
              <td>@fat</td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>Larry</td>
              <td>the Bird</td>
              <td>@twitter</td>
            </tr> -->
            
           
          </tbody>
        </table>
      </div>

      <?php View::include('blocks/footer.php') ?>


