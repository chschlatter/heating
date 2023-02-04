#!/usr/bin/env php
<?php

$options = getopt('hp:');
if (isset($options['h']) or !isset($options['p'])) {
	echo "Usage: " . basename($argv[0]) . " [-h] -p <admin_password>\n";
	exit(1);
}

$db = new SQLite3('/data/database.db');

$db->exec("CREATE TABLE IF NOT EXISTS meter_values(
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	type TEXT NOT NULL,
	value INTEGER NOT NULL,
	filename TEXT DEFAULT NULL,
	fileurl TEXT DEFAULT NULL)");

$db->exec("CREATE TABLE IF NOT EXISTS logins(
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	username TEXT NOT NULL,
	password TEXT NOT NULL)");

$db->exec("INSERT INTO logins (username, password) VALUES (
	'admin', " .
	"'" . hash('sha256', $options['p']) . "')");



?>