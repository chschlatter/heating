<?php

include('../init.php');

if (isset($_REQUEST['password'])) {
	if ($_REQUEST['password'] == $_ENV['APP_ADMIN_PWD']) {
		setcookie('token', hash('sha256', $_ENV['APP_ADMIN_PWD']), strtotime('+300 days'));
		header('Location: /');
		exit();
	} else {
		die("Wrong password.");
	}
} else {
	include('../login.inc.php');
}

?>