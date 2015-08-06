<?php

require("bootstrap.php");

$config = include("config_facebook.php");
$fb = new Facebook\Facebook($config);

$dashboardFb = new \DashboardSocial\DashboardFacebook();
$dashboardFb->setFacebook($fb);

try {
	$accessToken = $dashboardFb->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

if (isset($accessToken)) {
	$dashboardFb->setAccessToken((string) $accessToken);
	echo <<<SCRIPT
<script>
window.opener.hasLogin();
window.close();
</script>
SCRIPT;
}
else {
	$loginUrl = $dashboardFb->getLoginUrl(BASE_URL."login.php");
	header("Location: ".$loginUrl);
}