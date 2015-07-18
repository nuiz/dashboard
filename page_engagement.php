<?php
require("bootstrap.php");

$config = include("config_facebook.php");
$baseUrl = "https://graph.facebook.com";
$fb = new Facebook\Facebook($config);

$startDateTs = strtotime($_GET['date_start']." 00:00:00");
$endDateTs = strtotime($_GET['date_end']." 23:59:59");

try {
	$url = "/me/insights/page_engaged_users/day?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs
		]);	
	$arr = $fb->get($url, $_GET['access_token'])->getGraphEdge()->asArray();

	$url = "/me/insights/page_impressions/day?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs
		]);	
	$arr_impression = $fb->get($url, $_GET['access_token'])->getGraphEdge()->asArray();

	$res = [
		"data"=> []
	];
	foreach($arr[0]["values"] as $key => $value){
		$totalCount = $arr[0]["values"][$key]['value'];
		$totalImpressionCount = $arr_impression[0]["values"][$key]['value'];
		$rate = $totalCount/$totalImpressionCount;
		if($rate === false) $rate = 0;
		$obj = [
			"date"=> $value["end_time"]->format("Y-m-d"),
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
