<?php
require("bootstrap.php");

$config = include("config.php");
$baseUrl = "https://graph.facebook.com";
// $fb = new Facebook\Facebook($config);
// $fb->setDefaultAccessToken($_GET['access_token']);

$startDateTs = strtotime($_GET['date']." 00:00:00");
$endDateTs = strtotime($_GET['date']." 23:59:59");

try {
	$res = file_get_contents($baseUrl."/me/insights/page_fans?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs,
		"access_token"=> $_GET['access_token']
		]));
	$json = json_decode($res, true);
	$likeCount = $json['data'][0]['values'][0]['value'];

	$res = file_get_contents($baseUrl."/me/insights/page_fan_removes/day?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs,
		"access_token"=> $_GET['access_token']
		]));
	$json = json_decode($res, true);
	$unlikeDayCount = $json['data'][0]['values'][0]['value'];

	$data = [
		"total_like_daily"=> $likeCount,
		"unlike_daily"=> $unlikeDayCount,
		"attrition_rate"=> $unlikeDayCount/$likeCount,
	];

	header("Content-type: application/json");
	echo json_encode($data);
	//echo $likes;
}
catch(Exception $e){
	echo $e->getMessage();
}
