<?php

require_once 'core/init.php';
if(Session::exists('home')) {
	echo '<p>'.Session::flash('home').'</p>';
}

$user = new User();
if($user->isLoggedIn()) {
	?>
		<p>Hello <a href="#"><?php echo escape($user->data()->username) ?></a></p>

		<ul>
			<li><a href="logout.php">Dang xuat</a></li>
		</ul>
	<?php
} else {
	echo 'Ban can <a href="login.php">dang nhap</a> hoac <a href="register.php">dang ky</a>.';
}
