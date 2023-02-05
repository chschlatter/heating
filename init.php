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

// check cookie for authentication, otherwise redirect to login.php
preg_match('%/([^/]+)$%', $_SERVER['SCRIPT_NAME'], $matches);
if ($matches[1] != 'login.php') {
	if (isset($_COOKIE['token'])) {
		if ($_COOKIE['token'] != hash('sha256', $_ENV['APP_ADMIN_PWD'])) {
			error('Cannot validate cookie token.');
		}
	} else {
		header('Location: /login.php');
	}
}

// initialize sqlite db, create table(s) if they don't exist
$db = new SQLite3($_ENV['DB_FILE']);
$db->exec("CREATE TABLE IF NOT EXISTS meter_values(
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	type TEXT NOT NULL,
	value INTEGER NOT NULL,
	filename TEXT DEFAULT NULL,
	fileurl TEXT DEFAULT NULL)");

?>