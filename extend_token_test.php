<?php
require("bootstrap.php");

$config = include("config.php");
$fb = new Facebook\Facebook($config);

use DashboardSocial\DashboardFacebook;
$dashboardFacebook = new DashboardFacebook();
$dashboardFacebook->setFb($fb);
//$longliveToken = $dashboardFacebook->extendLongliveAccessToken($_GET['access_token']);
// echo $longliveToken;
$metaData = $dashboardFacebook->getTokenExpire($_GET['access_token']);
var_dump($metaData);