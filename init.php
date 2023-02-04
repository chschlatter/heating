<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('METER_TYPES', [
	'Haus_C_Verbrauch_Heizen',
	'Haus_C_Verbrauch_Warmwasser',
	'Haus_C_Produktion_Oel',
	'Haus_D_Verbrauch_Heizen',
	'Haus_D_Verbrauch_Warmwasser',
	'Haus_D_Produktion_Holz'
	]);

$small_container = false;

function error($error_message) 
{
    include(__DIR__ . '/error.inc.php');
    exit();
}

// redirect to /login.php if no cookie for authentication available
// hint: $no_auth is set by login.php
if (!isset($no_auth) or $no_auth === false) {
	if (isset($_COOKIE['login'])) {
		list($c_username, $c_token) = explode(',', $_COOKIE['login']);

		$db = new SQLite3($_ENV['DB_FILE']);
		$hashed_password = $db->querySingle(
			"SELECT (password) FROM " . $_ENV['DB_LOGINS_TABLE_NAME'] . " WHERE username = '$c_username';");
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