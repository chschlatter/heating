<?php

include('../init.php');

if (!isset($_REQUEST['type'])) {
	$error_message = "No type provided.";
	include('../error.inc.php');
	exit();		
}
$type = $_REQUEST['type'];

$small_container = true;
include('../add-form.inc.php');

?>