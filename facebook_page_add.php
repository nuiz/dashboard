<?php
require("bootstrap.php");

$fb_config = include("config_facebook.php");
$db_config = include("db_config.php");

$fb = new Facebook\Facebook($fb_config);
$dashboardFb = new DashboardSocial\DashboardFacebook();
$dashboardFb->setFacebook($fb);

$pdo = new PDO($db_config["dsn"], $db_config["username"], $db_config["password"], $db_config["option"]);
$dashboardSv = new DashboardSocial\DashBoardService();
$dashboardSv->setPDO($pdo);

$userToken = $dashboardFb->getUserLoginToken();
if($dashboardFb->getTokenExpire($userToken) >= time()){
	header("Location: index.php");
}
$response = $fb->get('/me?fields=id', $userToken);
$user = $response->getGraphNode()->asArray();

$longliveToken = $dashboardFb->extendLongliveAccessToken($_GET['access_token']);
$response = $fb->get('/me?fields=id,name', $longliveToken);
$page = $response->getGraphNode()->asArray();

$dashboardSv->addPage($page["id"], $longliveToken, $user["id"], $page["name"]);

header("Location: facebook_page_list.php?ts=".time());