<?php
require("bootstrap.php");

$config = include("config.php");
$baseUrl = "https://graph.facebook.com";
// $fb = new Facebook\Facebook($config);
// $fb->setDefaultAccessToken($_GET['access_token']);

$startDateTs = strtotime($_GET['date_start']." 00:00:00");
$endDateTs = strtotime($_GET['date_end']." 23:59:59");

try {
	$fbRes = file_get_contents($baseUrl."/me/insights/page_positive_feedback_by_type?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs,
		"access_token"=> $_GET['access_token']
		]));
	$jsonTotal = json_decode($fbRes, true);

	$res = [
		"data"=> []
	];
	foreach($jsonTotal["data"][0]["values"] as $key => $value){
		$totalCount = $jsonTotal["data"][0]["values"][$key]["value"]["like"];
		$obj = [
			"date"=> substr($jsonTotal["data"][0]["values"][$key]["end_time"],0,10),
			"share_daily"=> $totalCount
		];
		$res['data'][] = $obj;
	}

	header("Content-type: application/json");
	echo json_encode($res);
}
catch(Exception $e){
	echo $e->getMessage();
}
