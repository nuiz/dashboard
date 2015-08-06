<?php

require("bootstrap.php");

$config = include("config_facebook.php");
$fb = new Facebook\Facebook($config);

$dashboardFb = new \DashboardSocial\DashboardFacebook();
$dashboardFb->setFacebook($fb);

try {
	$accessToken = $dashboardFb->getUserLoginToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}
?>
<html>
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="public/jquery/jquery-1.11.3.min.js"></script>
</head>
<body>
<div id="body"></div>
<script type="text/javascript">
$(function(){
	window.hasLogin = function(){
		var $a = $('<a href="facebook_page_list.php">goto page</a>');
		$('#body').html($a);
	};
	var isLogin = <?php echo json_encode(!is_null($accessToken));?>;
	if(isLogin){
		window.hasLogin();
	}
	else {
		var $aLogin = $('<a href="">login</a>');
		$('#body').html($aLogin);
		$aLogin.click(function(e){
			e.preventDefault();
			window.open("login.php", "", "width=780,height=410");
		});
	}
});
</script>
</body>
</html>