<?php
require("bootstrap.php");

$config = include("config.php");
$baseUrl = "https://graph.facebook.com";

try {
	$fbRes = file_get_contents($baseUrl."/me/insights/page_fans_gender_age?".http_build_query([
		"access_token"=> $_GET['access_token']
		]));
	$json = json_decode($fbRes, true);

	$res = [
		"gender"=> [
		],
		"age"=> [
		]
	];
	foreach($json["data"][0]["values"][0]['value'] as $key => $value){
		list($gender, $age) = explode(".", $key);
		if(!isset($res["gender"][$gender])){
			$res["gender"][$gender] = 0;
		}
		$res["gender"][$gender] += $value;
		if(!isset($res["age"][$age])){
			$res["age"][$age] = 0;
		}
		$res["age"][$age] += $value;
	}

	header("Content-type: application/json");
	echo json_encode($res);
}
catch(Exception $e){
	echo $e->getMessage();
}
