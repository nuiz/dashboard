<?php

require("bootstrap.php");

$config = include("config.php");
$fb = new Facebook\Facebook($config);	

$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;
  header("Location: ".BASE_URL);

  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
}
else if(isset($_SESSION['facebook_access_token'])){
	$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	try {
	  $response = $fb->get('/me/accounts?fields=likes,name,access_token');
	  $graphEdge = $response->getGraphEdge();
	  $data = [
	  	"data"=> []
	  ];

	  foreach($graphEdge as $graphNode){
	  	$data["data"][] = [
	  		"id"=> $graphNode->getField("id"),
	  		"name"=> $graphNode->getField("name"),
	  		"likes"=> $graphNode->getField("likes"),
	  		"access_token"=> $graphNode->getField("access_token")
	  	];
	  }
	  
	  header("Content-type: application/json");
	  echo json_encode($data);
	  exit();

	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  // When Graph returns an error
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  // When validation fails or other local issues
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}
}
else {
	$permissions = ['manage_pages', 'publish_pages']; // optional
	$loginUrl = $helper->getLoginUrl(BASE_URL, $permissions);

	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}