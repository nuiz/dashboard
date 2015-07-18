<?php
require("bootstrap.php");

$config = include("config_facebook.php");
$baseUrl = "https://graph.facebook.com";
$fb = new Facebook\Facebook($config);

try {
	$url = "/me/insights/page_fans_city?";
	$arr = $fb->get($url, $_GET['access_token'])->getGraphEdge()->asArray();

	$res = [];
	foreach($arr[0]["values"][0]['value'] as $key => $value){
		$location = explode(', ', $key);
		if(count($location)==2){
			$res[$location[0]] = $value;
		}
	}

	header("Content-type: application/json");
	echo json_encode($res);
}
catch(Exception $e){
	echo $e->getMessage();
}
