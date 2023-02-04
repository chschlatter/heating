<?php

$no_auth = true;
include('../init.php');

if (isset($_REQUEST['username']) and isset($_REQUEST['password'])) {

	$db = new SQLite3($_ENV['DB_FILE']);
	$query = "SELECT (password) FROM " . $_ENV['DB_LOGINS_TABLE_NAME'] .
		" WHERE username = '" . $_REQUEST['username'] . "';";
	$password = $db->querySingle($query);
	if ($password === false) {
		die('Failed to read database.');
	} elseif ($password == NULL) {
		die('No user [' . $_REQUEST['username'] . '] found.');
	}

	if (hash('sha256', $_REQUEST['password']) == $password) {
		setcookie('login', $_REQUEST['username'] . ',' .
			hash('sha256', $_REQUEST['username'] . $password),
			strtotime('+300 days'));
		header('Location: /');
		exit();
	} else {
		die("Login failed.");
	}


} else {
	include('../login.inc.php');
}


?>