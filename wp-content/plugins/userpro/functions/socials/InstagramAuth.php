<?php


if(session_status() == PHP_SESSION_NONE) {
	session_start();
}
require_once(userpro_path . 'lib/instagram/vendor/autoload.php');

use MetzWeb\Instagram\Instagram;

class InstagramAuth
{
	var $instagram;

	public function __construct($code = null)
	{

		$redirectURL = userpro_get_option('instagram_redirect_url');
		//Validate Redirect URL
		$redirectURL = up_valid_url($redirectURL);

		$this->instagram = new Instagram(array(
			'apiKey'      => userpro_get_option('instagram_app_key'),
			'apiSecret'   => userpro_get_option('instagram_Secret_Key'),
			'apiCallback' => $redirectURL
		));

		if(isset($code))
			add_action('init', [&$this, 'instagramUser']);

	}


	public function instagramUrl(){




//	die(print_r($this->instagram,1));

	$url = $this->instagram->getLoginUrl();

	$url = urldecode($url);

	return $url;

}
public function instagramUser($code){



	try {

		$user_info = $this->instagram->getOAuthToken($code);

	}
	catch(Exception $e){
		up_error('UserPro error instagramAuth ( instagramUser function )' . $e);
		die();
	}


	$user['id'] = $user_info->user->id;
	$user['full_name'] = $user_info->user->full_name;
	$user['username'] = $user_info->user->username;
	$user['profile_picture'] = $user_info->user->profile_picture;


	#login , check if user exist with same email

	$users = get_users([
		'meta_key'     => 'userpro_instagram_id',
		'meta_value'   => $user['id'],
		'meta_compare' => '=',
	]);

	if(!empty($users)){

		userpro_auto_login($users[0]->user_login, TRUE, '', 'social');

	}else{

		$api = new userpro_api();

		$user_pass = wp_generate_password($length = 12, $include_standard_special_chars = FALSE);

//				Check if user login exist
		if($api->display_name_exists($user['username'])) {
			$user['username'] = $api->unique_display_name($user['username']);
		}

		$user_id = $api->new_user($user['username'], $user_pass, '', $user, $type = 'instagram');

		userpro_auto_login($user['username'], TRUE, '', 'social');

	}

	#register


}
}