<?php
require("bootstrap.php");

$config = include("config_facebook.php");
$baseUrl = "https://graph.facebook.com";
$fb = new Facebook\Facebook($config);

$startDateTs = strtotime($_GET['date_start']." 00:00:00");
$endDateTs = strtotime($_GET['date_end']." 23:59:59");

try {
	$url = "/me/insights/page_impressions_organic/day?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs
		]);
	$arr_organic = $fb->get($url, $_GET['access_token'])->getGraphEdge()->asArray();

	$url = "/me/insights/page_impressions_paid/day?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs
		]);
	$arr_paid = $fb->get($url, $_GET['access_token'])->getGraphEdge()->asArray();

	$res = [
		"data"=> []
	];
	foreach($arr_paid[0]["values"] as $key => $value){
		$totalImpressionPaidCount = $arr_paid[0]["values"][$key]['value'];
		$totalImpressionOrganicCount = $arr_organic[0]["values"][$key]['value'];
		$obj = [
			"date"=> $value["end_time"]->format("Y-m-d"),
			"impression_organic_daily"=> $totalImpressionOrganicCount,
			"impression_paid_daily"=> $totalImpressionPaidCount
		];
		$res['data'][] = $obj;
	}

	header("Content-type: application/json");
	echo json_encode($res);
}
catch(Exception $e){
	echo $e->getMessage();
}
