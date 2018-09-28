<?php

if(session_status() == PHP_SESSION_NONE) {
	session_start();
}

require_once(userpro_path . 'lib/linkedin/vendor/autoload.php');

use LinkedIn\Client;
use LinkedIn\Scope;
use LinkedIn\AccessToken;


class LinkedinAuth
{

	var $client;


	public function __construct()
	{

		if(isset($_GET['code']) && isset($_GET['upslug']) && $_GET['upslug'] == 'linkedin')
			add_action('init', [&$this, 'getUser']);

		$cliendId = userpro_get_option('linkedin_app_key');
		$clientSecret =  userpro_get_option('linkedin_Secret_Key');
		$redirect_url = userpro_get_option('linkedin_redirect_url');
//		Validate redirect url from WP backend.
		$redirect_url = up_valid_url($redirect_url);

		$this->client = new Client($cliendId,$clientSecret);
			$this->client->setRedirectUrl($redirect_url);
	}


	public function auth()
	{

		$scopes   = [
			Scope::READ_BASIC_PROFILE,
			Scope::READ_EMAIL_ADDRESS,
		];
		$loginUrl = $this->client->getLoginUrl($scopes); // get url on LinkedIn to start linking

		if(isset($loginUrl)) {
			return $loginUrl;
		} else {
			throw new Exception('Linkedin auth url is empty, please check your api');
		}

	}


	public function getUser()
	{

		$acces_token = $this->client->getAccessToken($_GET['code']);

		$user_info = $this->client->get(
			'people/~:(id,email-address,picture-urls::(original),first-name,last-name,location)'
		);

		$profile_exist = social_profile_check($user_info['emailAddress'], $user_info['id'], 'linkedin');

		if($profile_exist == FALSE) {

				$api        = new userpro_api();
				$user_login = $user_info['firstName'] . '_' . $user_info['lastName'];
				$user_pass  = wp_generate_password($length = 12, $include_standard_special_chars = FALSE);
				$user_email = isset($user_info['emailAddress']) ? $user_info['emailAddress'] : '';

				if($api->display_name_exists($user_login)) {
					$user_login = $api->unique_display_name($user_login);
				}
				$user = $api->new_user($user_login, $user_pass, $user_email, $user_info, $type = 'linkedin');

				userpro_auto_login($user_login, TRUE, '', 'social');


		}else{

			if(!is_user_logged_in()) {

				userpro_auto_login($profile_exist, TRUE, '', 'social');

			}

		}
	}


}