<?php

$no_auth = true;
include('../init.php');

if (isset($_REQUEST['username'])) {

	$db = new SQLite3(DB_NAME);
	$results = $db->query("SELECT * FROM logins 
		WHERE username = '" . $_REQUEST['username'] . "';");
	if (!$row = $results->fetchArray()) {
		die("Login failed.");
	}

	if (hash('sha256', $_REQUEST['password']) == $row['password']) {
		setcookie('login', $_REQUEST['username'] . ',' .
			hash('sha256', $_REQUEST['username'] . $row['password']),
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