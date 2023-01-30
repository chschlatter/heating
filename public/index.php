<?php

include('../init.php');

$db = new SQLite3(DB_NAME);

$results = $db->query("SELECT * FROM " . VALUES_TABLE_NAME . " ORDER BY created_at ASC;");
$values_per_date = [];
while ($row = $results->fetchArray()) {
	preg_match('/^\d{4}-\d{2}-\d{2}/', $row['created_at'], $matches);
	$created_date = $matches[0];
	if (preg_match('/^Haus_(C|D)/', $row['type'], $matches)) {
		$house = $matches[1];

		if (!isset($values_per_date[$created_date])) {
			$values_per_date[$created_date]['C'] = [];
			$values_per_date[$created_date]['D'] = [];
		}		
		$values_per_date[$created_date][$house][] = $row;
	}
}

include('../index.inc.php');


?>