<?php

require_once(userpro_path . 'lib/twitterauth/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;


/**
 * Class TwitterAuth
 */

class TwitterAuth extends userpro_api
{

	protected $CONSUMER_KEY;
	protected $CONSUMER_SECRET;
	protected $access_token;
	protected $access_token_secret;


	/**
	 * TwitterAuth constructor.
	 *
	 * @param $consumer_key
	 * @param $consumer_secret
	 *
	 * @throws Exception
	 */
	public function __construct($consumer_key, $consumer_secret)
	{

//		Turn off Cookie function.
		if(empty($consumer_key))
			throw new Exception('Twitter consumer_key missing');

		$this->CONSUMER_KEY = $consumer_key;

		if(empty($consumer_secret))
			throw new Exception('Twitter consumer_secret missing');

		$this->CONSUMER_SECRET = $consumer_secret;

	}


	/**
	 * @return mixed
	 */
	public function twitterRedirect()
	{

		$redirectURL = userpro_get_option('twitter_signin_redirect');

		//Validate Redirect URL
		$redirectURL = up_valid_url($redirectURL);

		return $redirectURL;
	}


	/**
	 * @return string
	 */
	public function twitterUrl()
	{

		$twitteroauth = new TwitterOAuth($this->CONSUMER_KEY, $this->CONSUMER_SECRET);

		$callback_url = $this->twitterRedirect();

		//	Generate request tokens
		$request_token = $twitteroauth->oauth(
			'oauth/request_token', [
				'oauth_callback' => $callback_url,
			]
		);
		//	Save tokens to session turn off function
			$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

		//		Twitter auth URL
		$url = $twitteroauth->url(
			'oauth/authorize', [
				'oauth_token' => $request_token['oauth_token'],
			]
		);

		return $url;

	}


	/**
	 * @return array|object
	 * @throws Exception
	 */
	public function auth()
	{

		$oauth_token        =  $_GET['oauth_token'];
		$oauth_token_secret = isset($_SESSION['oauth_token_secret']) ? $_SESSION['oauth_token_secret'] : $_COOKIE['oauth_token_secret'];
		$oauth_verifier     = filter_input(INPUT_GET, 'oauth_verifier');
		// Throw Exception if session empty
		if(empty($oauth_verifier) ||
			empty($oauth_token) ||
			empty($oauth_token_secret)
		) {

			throw new Exception('Oauth_token or oauth_token_secret session/cookie empty. ');

		} else {

			//Twitter tokens

			$connection = new TwitterOAuth(
				$this->CONSUMER_KEY,
				$this->CONSUMER_SECRET,
				$oauth_token,
				$oauth_token_secret
			);

		}
		// request user token
		$token   = $connection->oauth(
			'oauth/access_token', [
				'oauth_verifier' => $oauth_verifier,
			]
		);
		$twitter = new TwitterOAuth(
			$this->CONSUMER_KEY,
			$this->CONSUMER_SECRET,
			$token['oauth_token'],
			$token['oauth_token_secret']
		);

		$user = $twitter->get("account/verify_credentials", ["include_email" => TRUE]);

		$user  = (array)$user;
		$users = get_users([
			'meta_key'     => 'twitter_oauth_id',
			'meta_value'   => $user['id'],
			'meta_compare' => '=',
		]);
		if(!empty($users)) {
			$returning_user_login = $users[0]->user_login;
			//   update user data if something change.
			parent::userpro_update_profile_via_twitter($users[0]->ID, $user);
			//	Login user
			userpro_auto_login($returning_user_login, TRUE, '', 'social');
		} else {
			$this->postMessage($twitter);
			$this->register($user);
		}
		return $user;

	}


	/**
	 * @param $user_data
	 */
	public function register($user_data)
	{

		$user_pass   = wp_generate_password($length = 12, $include_standard_special_chars = FALSE);
		$unique_user = parent::unique_user('twitter', $user_data);

		$email = isset($user_data['email']) ? $user_data['email'] : '';

		#return user id
		$user_id = parent::new_user($unique_user, $user_pass, $email, $user_data, $type = 'twitter');

		userpro_auto_login($unique_user, TRUE, '', 'social');

	}


	/**
	 * @param $user
	 */
	public function postMessage($user)
	{
		// Write post on twitter wall
		if(userpro_get_option('twitter_autopost') && userpro_get_option('twitter_autopost_msg')) {

			$message = $user->post('statuses/update', ['status' => userpro_get_option('twitter_autopost_msg')]);

		}
	}

}