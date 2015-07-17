<?php
require("bootstrap.php");

$config = include("config.php");
$baseUrl = "https://graph.facebook.com";
// $fb = new Facebook\Facebook($config);
// $fb->setDefaultAccessToken($_GET['access_token']);

$startDateTs = strtotime($_GET['date_start']." 00:00:00");
$endDateTs = strtotime($_GET['date_end']." 23:59:59");

try {
	$fbRes = file_get_contents($baseUrl."/me/insights/page_engaged_users/day?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs,
		"access_token"=> $_GET['access_token']
		]));
	$jsonTotal = json_decode($fbRes, true);

	$fbRes = file_get_contents($baseUrl."/me/insights/page_impressions/day?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs,
		"access_token"=> $_GET['access_token']
		]));
	$jsonImpression = json_decode($fbRes, true);

	$res = [
		"data"=> []
	];
	foreach($jsonTotal["data"][0]["values"] as $key => $value){
		$totalCount = $value["value"];
		$totalImpressionCount = $jsonImpression["data"][0]["values"][$key]['value'];
		$rate = $totalCount/$totalImpressionCount;
		if($rate === false) $rate = 0;
		$obj = [
			"date"=> substr($value["end_time"],0,10),
			"engage_daily"=> $totalCount,
			"impression_daily"=> $totalImpressionCount,
			"engage_rate_daily"=> $rate
		];
		$res['data'][] = $obj;
	}

	header("Content-type: application/json");
	echo json_encode($res);
}
catch(Exception $e){
	echo $e->getMessage();
}
