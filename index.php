<?php
require_once __DIR__ . '/fb-config.php';
$fb = new Facebook\Facebook($params);
$helper = $fb->getRedirectLoginHelper();

$permissions = ['email','publish_actions']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://ie6.encom.uy/fb-callback.php', $permissions);
if(empty($_SESSION['fb_access_token'])){
	echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
}else{
	try {
	  // Get the Facebook\GraphNodes\GraphUser object for the current user.
	  // If you provided a 'default_access_token', the '{access-token}' is optional.
	  $response = $fb->get('/me?fields=id,name,picture', $_SESSION['fb_access_token']);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  // When Graph returns an error
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  // When validation fails or other local issues
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}

	$me = $response->getGraphUser();
	$_SESSION['me'] = $me;
	echo 'Logged in as ' . $me->getName();
	echo '<a href="http://ie6.encom.uy/post.php">Post on Facebook from the past!</a>';
}


