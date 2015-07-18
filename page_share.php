<?php
require("bootstrap.php");

$config = include("config_facebook.php");
$baseUrl = "https://graph.facebook.com";

$fb = new Facebook\Facebook($config);

$startDateTs = strtotime($_GET['date_start']." 00:00:00");
$endDateTs = strtotime($_GET['date_end']." 23:59:59");

try {
	$url = "/me/insights/page_positive_feedback_by_type?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs
		]);	
	$arr = $fb->get($url, $_GET['access_token'])->getGraphEdge()->asArray();

	$res = [
		"data"=> []
	];
	foreach($arr[0]["values"] as $key => $value){
		$totalCount = $value["value"]["link"];
		$obj = [
			"date"=> $value["end_time"]->format("Y-m-d"),
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
