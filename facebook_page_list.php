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
$fb->setDefaultAccessToken($userToken);
$response = $fb->get('/me?fields=id,accounts{access_token,name,id}');
$graphEdge = $response->getGraphNode();
$data = $graphEdge->asArray();

$accounts = $data['accounts'];
$userId = $data['id'];

$pages = $dashboardSv->getPages($userId);

$pages_unsave = array_filter($accounts, function($item) use($pages){
	foreach($pages as $page){
		if($page['facebook_page_id'] == $item['id']) return false;
	}
	return true;
});
?>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<h1>click for page to database</h1>
		<?php foreach($pages_unsave as $item){?>
		<a href="facebook_page_add.php?access_token=<?php echo $item["access_token"];?>">
			<?php echo $item["name"];?>
		</a>
		<br>
		<?php }?>
	</div>
	<hr>
	<div>
		<h1>pages on database</h1>
		<?php foreach($pages as $item){?>
		<div style="margin-bottom: 10px;">
			<strong><?php echo $item["facebook_page_name"];?></strong> 
			<a target="_blank" href="https://developers.facebook.com/tools/debug/accesstoken?q=<?php echo $item["access_token"];?>">
				[debug token]
			</a>
			<?php echo $item["access_token"];?>
		</div>
		<?php }?>
	</div>
</body>
</html>