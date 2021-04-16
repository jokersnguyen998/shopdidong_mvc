<?php
require_once "lib/session.php";
Session::init();
require_once "lib/config.php";
require_once "lib/database.php";

$db = new Database();
try {
	$accessToken = $handler->getAccessToken();
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
	echo "Response Exception: " . $e->getMessage();
	exit();
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
	echo "SDK Exception: " . $e->getMessage();
	exit();
}

if (!$accessToken) {
	header('Location: login.php');
	exit();
}

$oAuth2Client = $fb->getOAuth2Client();
if (!$accessToken->isLongLived())
	$accessToken = $oAuth2Client->getLongLivedAccesToken($accessToken);

	$response = $fb->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
	$userData = $response->getGraphNode()->asArray();
	Session::set('customer_login', true);
	Session::set('userData', $userData);
	Session::set('access_token', (string)$accessToken);

	$check = 1;
	$query = "SELECT * FROM tbl_customer";
	$result = $db->select($query);
	if ($result) {
		foreach ($result as $key => $value) {
			if (($userData['id'] == $value['id']) && ($userData['email'] == $value['email'])) {
				$check = 0;
				break;
			}
		}
	}
	$id = $userData['id'];
	$first_name = $userData['first_name'];
	$last_name = $userData['last_name'];
	$email = $userData['email'];
	$image = $userData['picture']['url'];
	$type = 1;
	if ($check == 1) {
		$query1 = "INSERT INTO tbl_customer(id,first_name,last_name,email,cus_image,type)
				VALUES('$id','$first_name','$last_name','$email','$image','$type')";
		$result1 = $db->insert($query1);
	}
	header('Location:checkout.php');
	exit();
?>