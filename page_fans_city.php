<?php
require("bootstrap.php");

$config = include("config.php");
$baseUrl = "https://graph.facebook.com";

try {
	$fbRes = file_get_contents($baseUrl."/me/insights/page_fans_city?".http_build_query([
		"access_token"=> $_GET['access_token']
		]));
	$json = json_decode($fbRes, true);

	$res = [];
	foreach($json["data"][0]["values"][0]['value'] as $key => $value){
		$location = explode(', ', $key);
		if(count($location)==2){
			$res[$location[0]] = $value;
		}
	}

	header("Content-type: application/json");
	echo json_encode($res);
}
catch(Exception $e){
	echo $e->getMessage();
}
