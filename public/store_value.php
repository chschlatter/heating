<?php
include('../init.php');

use AsyncAws\SimpleS3\SimpleS3Client;


$php_file_upload_errors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
);

$image_file = $_FILES['image'];

if (!$image_file or ($image_file['error'] != UPLOAD_ERR_OK)) {
    error("Could not upload file: " . $php_file_upload_errors[$image_file['error']]);
}

$value = filter_input(INPUT_POST, 'value', FILTER_VALIDATE_INT);
if ($value == false or $value == NULL) error("Could not store value.");

if (!isset($_REQUEST['type'])) error("No type provided.");
$type = $_REQUEST['type'];


/*
$upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
$date = new DateTimeImmutable();
$upload_filename = $date->format('Y-m-d_H-i-s') . '.' . 
    pathinfo($image_file['name'], PATHINFO_EXTENSION);
$upload_file = $upload_dir . $upload_filename; 

// $uploadfile = $uploaddir . basename($image_file['name']);

if (!move_uploaded_file($image_file['tmp_name'], $upload_file)) {
    error("Could not upload file: " . $php_file_upload_errors[$image_file['error']]);
}
*/

$s3 = new SimpleS3Client([
    'region' => $_ENV['S3_REGION'],
    'accessKeyId' => $_ENV['S3_ACCESS_KEY_ID'],
    'accessKeySecret' => $_ENV['S3_KEY_SECRET']
    ]);

$date = new DateTimeImmutable();
$upload_filename = $date->format('Y-m-d_H-i-s') . '.' . 
    pathinfo($image_file['name'], PATHINFO_EXTENSION);
$resource = fopen($image_file['tmp_name'], 'r');
$s3->upload($_ENV['S3_BUCKET'], $upload_filename, $resource, ['ContentType' => 'image/jpeg']);
$url = $s3->getUrl($_ENV['S3_BUCKET'], $upload_filename);

$db = new SQLite3($_ENV['DB_FILE']);
$db->exec("INSERT INTO " . $_ENV['DB_VALUES_TABLE_NAME'] . " (type, value, filename, fileurl) VALUES (
	'$type',
	$value,
	'$upload_filename',
    '$url')");
$db->close();

include('../store_value_success.inc.php');


?>