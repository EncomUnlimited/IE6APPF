<?php
if (!session_id()) {
	session_start();		
}
use Facebook\Facebook as Facebook;
use Facebook\Exceptions\FacebookResponseException as FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException as FacebookSDKException;
use Facebook\FacebookRedirectLoginHelper;
class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showHome()
	{
		if(!Session::has('fb_access_token')){
			$fb = new Facebook([
				'app_id' => Config::get('facebook.app_id'),
			  	'app_secret' => Config::get('facebook.app_secret'),
			  	'default_graph_version' => Config::get('facebook.default_graph_version')
				]);
			$helper = $fb->getRedirectLoginHelper();
			$loginUrl = $helper->getLoginUrl(Config::get('facebook.callback'),  Config::get('facebook.permissions'));
			return View::make('home')->with('loginUrl',$loginUrl);
		}
		return View::make('home');
	}
	public function upload()
	{
		ini_set('max_execution_time', 0);
		set_time_limit(0);
		if(Input::hasFile('0')){
			$destinationPath = public_path() . '/img/';
			$file            = Input::file('0');
        	$filename        = str_random(6) . '_' . $file->getClientOriginalName();
       	 	$uploadSuccess   = $file->move($destinationPath, $filename);
       	 	Session::put('photo',$destinationPath . $filename);
			return Response::json(['photo'=>"http://ie6.encom.uy/img/$filename"]);
		}else{
			return Response::json(['message'=>"No se cargo"]);
		}
		
	}
	public function publish()
	{
		$fb = new Facebook([
				'app_id' => Config::get('facebook.app_id'),
			  	'app_secret' => Config::get('facebook.app_secret'),
			  	'default_graph_version' => Config::get('facebook.default_graph_version'),
			  	'persistent_data_handler' => Config::get('facebook.persistent_data_handler')
				]);
		$helper = $fb->getRedirectLoginHelper();
		if(Session::has('photo')){
			if(Input::has('quePiensas')){
				$data = [
			  	'message' => Input::get('quePiensas'),
				 'source' => $fb->fileToUpload(Session::get('photo')),
				];

				try {
				  // Returns a `Facebook\FacebookResponse` object
				  $response = $fb->post('/me/photos', $data, Session::get('fb_access_token'));
				} catch(Facebook\Exceptions\FacebookResponseException $e) {
				  echo 'Graph returned an error: ' . $e->getMessage();
				  exit;
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
				  echo 'Facebook SDK returned an error: ' . $e->getMessage();
				  exit;
				}

				$graphNode = $response->getGraphNode();

				return Redirect::to('/')->with('mensaje','Publicado con exito!');
			}else{
				return Redirect::to('/')->with('mensaje','Sin mensaje no hay amor');
			}
		}else{
			return Redirect::to('/')->with('mensaje','Sin foto no hay amor') ;
		}
	}
	public function callback(){
		$fb = new Facebook([
				'app_id' => Config::get('facebook.app_id'),
			  	'app_secret' => Config::get('facebook.app_secret'),
			  	'default_graph_version' => Config::get('facebook.default_graph_version'),
			  	'persistent_data_handler' => Config::get('facebook.persistent_data_handler')
				]);
		$helper = $fb->getRedirectLoginHelper();

		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
			return Redirect::to('/')->with('mensaje', 'Graph returned an error: ' . $e->getMessage()) ;
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
			return Redirect::to('/')->with('mensaje','Facebook SDK returned an error: ' . $e->getMessage());
		  exit;
		}

		if (! isset($accessToken)) {
		  if ($helper->getError()) {
		    header('HTTP/1.0 401 Unauthorized');
		    echo "Error: " . $helper->getError() . "\n";
		    echo "Error Code: " . $helper->getErrorCode() . "\n";
		    echo "Error Reason: " . $helper->getErrorReason() . "\n";
		    echo "Error Description: " . $helper->getErrorDescription() . "\n";
		  } else {
		    header('HTTP/1.0 400 Bad Request');
		    echo 'Bad request';
		  }
		  exit;
		}

		// Logged in
		//echo '<h3>Access Token</h3>';
		//var_dump($accessToken->getValue());

		// The OAuth 2.0 client handler helps us manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();

		// Get the access token metadata from /debug_token
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);
		//echo '<h3>Metadata</h3>';
		//var_dump($tokenMetadata);

		// Validation (these will throw FacebookSDKException's when they fail)
		$tokenMetadata->validateAppId(Config::get('facebook.app_id'));
		// If you know the user ID this access token belongs to, you can validate it here
		//$tokenMetadata->validateUserId('123');
		$tokenMetadata->validateExpiration();

		if (! $accessToken->isLongLived()) {
		  // Exchanges a short-lived access token for a long-lived one
		  try {
		    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		  } catch (Facebook\Exceptions\FacebookSDKException $e) {
		  	return Redirect::to('/')->with('mensaje',"<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n");
		    exit;
		  }

		  //echo '<h3>Long-lived</h3>';
		  //var_dump($accessToken->getValue());
		}

		Session::put('fb_access_token',(string) $accessToken);
		// User is logged in with a long-lived access token.
		// You can redirect them to a members-only page.
		return Redirect::to('/')->with('mensaje','Ya puede publicar');
	}
}