<?php

if(Session::exists('home')) {
	echo '<p>'.Session::flash('home').'</p>';
}

$user = new User();
if($user->isLoggedIn()) {
	$permission = $user->checkPermissionGroup($user->data()->groups);
	
} else {
	Redirect::to("login.php");
}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Ngoc Vo">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Trang chủ</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">		
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" type="text/css">
	
</head>
<body>
	<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
	      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="navbar-toggler-icon"></span>
	      </button>
	      <a class="navbar-brand" href="#">My Account v1.0</a>

	      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
	        <ul class="navbar-nav mr-auto">
	          <li class="nav-item active">
	            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
	          </li>
	          <li class="nav-item dropdown">
	            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</a>
	            <div class="dropdown-menu" aria-labelledby="dropdown01">
	              <a class="dropdown-item" href="#">Create New Account</a>
	              <a class="dropdown-item" href="#">Change Account Password</a>
	              <a class="dropdown-item" href="#">Delete Account</a>
	            </div>
	          </li>
	        </ul>
	        <form class="form-inline my-2 my-lg-0">
	          <p><?php 

	          	if($permission->first()->id == 2){
					?>
						<p style="color: rgba(255,255,255,.5)" class=" mr-sm-2 ">Hello <?php echo $permission->first()->name; ?>, <a href="#"><?php echo escape($user->data()->username) ?></a></p>
						<a style="color: rgba(255,255,255,.5)" class="btn btn-outline-success" href="logout.php">Đăng xuất</a>
						
						<?php
				}
				else {
					?>
						<p style="color: rgba(255,255,255,.5)" class=" mr-sm-2 ">Hello, <a href="#"><?php echo escape($user->data()->username) ?></a></p>
						<a style="color: rgba(255,255,255,.5)" class="btn btn-outline-success" href="logout.php">Đăng xuất</a>
					<?php
				}

	          ?></p>
	        </form>
	      </div>
	    </nav>