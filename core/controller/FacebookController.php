<?php

//require '../src/facebook.php';


class FacebookController {

	/*
	   * Holds the facebook object
	   *
	   * @var Object
	*/
	private $facebook;

	/**
	 * Facebook user id
	 *
	 * @var integer
	 */
	private $fbuser;

	/**
	 * Facebook API key
	 *
	 * @var string
	 */
	private $apiKey;

	/**
	 * Facebook secret key
	 *
	 * @var string
	 */
	private $secretKey;

	/**
	 * The constructor
	 *
	 * This function will initialize the class. You need to provide the API
	 * key and the secret as argument
	 *
	 * @param string api key
	 * @param string secret key
	 * @return void
	 *
	 */
	public function __construct()
	{
		require_once(PATH_ROOT . "plugins/Facebook/facebook.php");
		//FACEBOOK_API_ID
		//FACEBOOK_SECRET
		$this->apiKey	 = FACEBOOK_API_ID;
		$this->secretKey = FACEBOOK_SECRET;
		$this->facebook  = new Facebook(array(
							  'appId'  => $this->apiKey,
							  'secret' =>  $this->secretKey,
							));

	}


	public function login()
	{

		$userDetails = $this->getUserInfo();


		// && !defined("USER_ID")
		if ($userDetails && !defined("USER_ID")) {
			$uc = new UserController();

		//	print "tudy";
			$auth = G_Authentification::instance();

		//	print_r($userDetails);
		//	exit;
			return $auth->loginFromFacebook($userDetails);
			//return true;
		} else {
		//	return $this->getLogin();
			@header("Location: " . $this->getLogin(), true, 303);
			exit;
			return false;
		}
	}
	/**
	 * Vrací informace o uživateli z FB
	 * */
	public function getUserInfo()
	{
		//$this->fbuser = $fbuserId;


		//	print_r($this->facebook->api_client);
		//$user = $this->facebook->getUser($this->fbuser, $fields);
		$this->fbuser = $this->facebook->getUser();

	//	print_r($this->fbuser);
		if ($this->fbuser) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$userDetails = $this->facebook->api('/me');

			//	print_r($userDetails);

				return $userDetails;
			} catch (FacebookApiException $e) {
				error_log($e);
				$this->fbuser = null;
				return false;
			}
		}




	}

	public function getUserId()
	{
		return $this->fbuser;
	}
	private function getFblQuery($query)
	{
		print $query;
		return $this->facebook->api(array(
							'method' => 'fql.query',
							'query' => $query, )
		);

	}

	/**
	 * Get Friend List
	 *
	 * This function will retrieve the friend list of any given facebook
	 * user id. Optionally, it allows a few parameters to customize the
	 * list.
	 *
	 * @param int facebook user id
	 * @param bool whether the friends have installed this application
	 * @param int start limit
	 * @param int total limit
	 * @return array friend list
	 *
	 */
	public function getFriendList($fbuserId, $appUser = false, $start = 0, $limit = 20)
	{
		$this->fbuser = $fbuserId;

		// Does the friends need to add the app to be qualified ? ;)
		if ($appUser == false)
		{

			$usersArray = $this->getFblQuery("SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = {$this->fbuser})");

			print_r($usersArray);
		}
		else
		{
			$usersArray = $this->getFblQuery("SELECT uid FROM user WHERE has_added_app = 1 AND uid IN (SELECT uid2 FROM friend WHERE uid1 = {$this->fbuser})");

		}
		print_r($usersArray);

		if (empty($usersArray))
		{
			return array();
		}

		// Make an array of the friends
		foreach ($usersArray as $user)
		{
			$users[] = $user['uid'];
		}

		// Put a limit of the friends if specified
		if ($appUser && !empty($users) && $limit)
		{
			$users = array_slice($users, $start, $limit);
		}

		// Return the friend list
		return $users;
	}


	public function getLogin()
	{
		$url = "";
		if (!$this->fbuser || !defined("USER_ID") ) {
			$params=array();
			$params["display"] = "popup";
			$params["scope"] = "email";
			$params["redirect_uri"] = URL_HOME2 . "fblogin.php";
			$url = $this->facebook->getLoginUrl($params);
		}
		return $url;
	}


	/**
	 * FacebookController::getLogoutUrl()
	 *
	 * @return
	 */
	public function getLoginUrl()
	{
		return $this->facebook->getLoginUrl();
	}

	public function getLogoutUrl()
	{
		return $this->facebook->getLogoutUrl();
	}
}
?>