<?php

require_once("PluploadHandler.php");

PluploadHandler::no_cache_headers();
PluploadHandler::cors_headers();

if (isset($_REQUEST["name"])) {
	$fileName = $_REQUEST["name"];
} elseif (!empty($_FILES)) {
	$fileName = $_FILES["file"]["name"];
} else {
	$fileName = uniqid("file_");
}

if (!PluploadHandler::handle(array(
	'target_dir' => 'uploads/',
	'allow_extensions' => 'jpg,jpeg,png'
))) {
	die(json_encode(array(
		'status' => 0, 
		'error' => array(
			'code' => PluploadHandler::get_error_code(),
			'message' => PluploadHandler::get_error_message()
		)
	)));
} else {
	die(json_encode(array('status' => 1, 'msg'=> 'success', 'res'=>array('src'=> 'http://localhost/git/cipika/asset/uploads/'.$fileName))));
}