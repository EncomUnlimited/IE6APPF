<?php
require_once __DIR__ . '/fb-config.php';
$fb = new Facebook\Facebook($params);
$helper = $fb->getRedirectLoginHelper();
if($_POST['publish']=='me'){
	$data = [
  'message' => 'My awesome photo upload example.',
	  'source' => $fb->fileToUpload('20151224_223029.jpg'),
	];

	try {
	  // Returns a `Facebook\FacebookResponse` object
	  $response = $fb->post('/me/photos', $data, $_SESSION['fb_access_token']);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}

	$graphNode = $response->getGraphNode();

	echo 'Photo ID: ' . $graphNode['id'];
}
?>
<html>
<head>
	<title>Post from the past</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
<form action="" method="post">
	<input type="file" class="form-control" name="photo" />
	<input type="hidden" name="publish" value="me" />
	<input type="submit" class="btn btn-md btn-success" value="Publicar">
</form>
</body>
</html>