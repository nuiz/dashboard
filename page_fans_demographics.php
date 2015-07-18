<?php
require("bootstrap.php");

$config = include("config_facebook.php");
$baseUrl = "https://graph.facebook.com";
$fb = new Facebook\Facebook($config);

try {
	$url = "/me/insights/page_fans_gender_age";	
	$arr = $fb->get($url, $_GET['access_token'])->getGraphEdge()->asArray();

	$res = [
		"gender"=> [],
		"age"=> [],
		"gender_age"=> []
	];
	foreach($arr[0]["values"][0]['value'] as $key => $value){
		list($gender, $age) = explode(".", $key);
		if(!isset($res["gender"][$gender])){
			$res["gender"][$gender] = 0;
		}
		$res["gender"][$gender] += $value;
		if(!isset($res["age"][$age])){
			$res["age"][$age] = 0;
		}
		$res["age"][$age] += $value;
		$res["gender_age"][$key] = $value;
	}

	header("Content-type: application/json");
	echo json_encode($res);
}
catch(Exception $e){
	echo $e->getMessage();
}
