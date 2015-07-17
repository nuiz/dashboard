<?php
require("bootstrap.php");

$config = include("config.php");
$baseUrl = "https://graph.facebook.com";
// $fb = new Facebook\Facebook($config);
// $fb->setDefaultAccessToken($_GET['access_token']);

$startDateTs = strtotime($_GET['date_start']." 00:00:00");
$endDateTs = strtotime($_GET['date_end']." 23:59:59");

try {
	$fbRes = file_get_contents($baseUrl."/me/insights/page_impressions_organic/day?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs,
		"access_token"=> $_GET['access_token']
		]));
	$jsonImpressionOrganic = json_decode($fbRes, true);

	$fbRes = file_get_contents($baseUrl."/me/insights/page_impressions_paid/day?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs,
		"access_token"=> $_GET['access_token']
		]));
	$jsonImpressionPaid = json_decode($fbRes, true);

	$fbRes = file_get_contents($baseUrl."/me/insights/page_impressions/day?".http_build_query([
		"since"=> $startDateTs,
		"until"=> $endDateTs,
		"access_token"=> $_GET['access_token']
		]));
	$jsonImpression = json_decode($fbRes, true);

	$res = [
		"data"=> []
	];
	foreach($jsonImpressionOrganic["data"][0]["values"] as $key => $value){
		$totalImpressionOrganicCount = $value["value"];
		$totalImpressionPaidCount = $jsonImpressionPaid["data"][0]["values"][$key]['value'];
		$totalImpressionCount = $jsonImpression["data"][0]["values"][$key]['value'];
		$obj = [
			"date"=> substr($value["end_time"],0,10),
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
