<?php

define('APP_NAME', 'Heating Stats');

define('METER_TYPES', [
	'Haus_C_Verbrauch_Heizen',
	'Haus_C_Verbrauch_Warmwasser',
	'Haus_C_Produktion_Oel',
	'Haus_D_Verbrauch_Heizen',
	'Haus_D_Verbrauch_Warmwasser',
	'Haus_D_Produktion_Holz'
	]);

define('DB_NAME', __DIR__ . '/database.db');
define('VALUES_TABLE_NAME', 'meter_values');
define('LOGIN_TABLE_NAME', 'logins');

$small_container = false;

function error($error_message) 
{
    include(__DIR__ . '/error.inc.php');
    exit();
}

if (!isset($no_auth) or $no_auth === false) {
	if ($_COOKIE['login']) {
		list($c_username, $c_token) = explode(',', $_COOKIE['login']);

		$db = new SQLite3(DB_NAME);
		$hashed_password = $db->querySingle(
			"SELECT (password) FROM " . LOGIN_TABLE_NAME . "WHERE username = '$c_username';"");
		if ($hashed_password) {
			if ($c_token != hash('sha256', $c_username . $hashed_password)) {
				error('Cannot validate cookie token.');
			}
		} else {
			error('Unknown username.');
		}
		$db->close();
	} else {
		header('Location: /login.php');
	}
}

?>