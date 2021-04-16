<?php 
require_once "Facebook/autoload.php";

$fb = new \Facebook\Facebook([
	'app_id' => '719778918697609',
	'app_secret' => 'af55315eb455c20f494f54252c24eefc',
	'default_graph_version' => 'v2.10' 
]);
$handler = $fb->getRedirectLoginHelper();
?>