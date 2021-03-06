<?php
require("bootstrap.php");

$config = include("config_facebook.php");
$baseUrl = "https://graph.facebook.com";
$fb = new Facebook\Facebook($config);

$startDateTs = strtotime($_GET['date_start']." 00:00:00");
$endDateTs = strtotime($_GET['date_end']." 23:59:59");

try {
	$url = "/me/insights/page_fans?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs
		]);
	$arr = $fb->get($url, $_GET['access_token'])->getGraphEdge()->asArray();

	$url = "/me/insights/page_fan_adds/day?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs
		]);
	$arr_add = $fb->get($url, $_GET['access_token'])->getGraphEdge()->asArray();

	$res = [
		"data"=> []
	];
	foreach($arr[0]["values"] as $key => $value){
		$totalLikeCount = $arr[0]["values"][$key]["value"];
		$likeDayCount = $arr_add[0]["values"][$key]["value"];
		$obj = [
			"date"=> $value["end_time"]->format("Y-m-d"),
			"total_like_daily"=> $totalLikeCount,
			"like_daily"=> $likeDayCount,
			"growth_rate"=> $likeDayCount/$totalLikeCount,
		];
		$res['data'][] = $obj;
	}

	header("Content-type: application/json");
	echo json_encode($res);
}
catch(Exception $e){
	echo $e->getMessage();
}
