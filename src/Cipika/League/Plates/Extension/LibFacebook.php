<?php
namespace Cipika\League\Plates\Extension;

require_once 'facebook_sdk/facebook.php';

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class LibFacebook implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('FacebookConnect', [$this, 'FacebookConnect']);
        $engine->registerFunction('FacebookDestroy', [$this, 'FacebookDestroy']);
    }
    
	function FacebookConnect($redirect='')
	{
		$facebook = new \Facebook(array(
		  'appId'  => APPID_FB,
		  'secret' => SECRETID_FB,
		  'cookie' => true,
          'trustForwarded' => true,
		));
	
		// Get User ID
		$user = $facebook->getUser();
		
		$result['user']  = $user;
		$result['token'] = $facebook->getAccessToken();
		
		if ($user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $facebook->api('/me');
				$result['user_profile'] = $user_profile;
			} catch (FacebookApiException $e) {
				error_log($e);
				$user = null;
			}
		}
		
		// Login or logout url will be needed depending on current user state.
		
			$result['loginUrl'] = $facebook->getLoginUrl(array("scope" => "user_about_me,email,publish_actions,read_stream,read_friendlists", 'redirect_uri' => base_url().'/auth/login_fb?c_redirect='.$redirect));
		
		
		return $result;
	}
        function FacebookDestroy(){
            $facebook = new Facebook(array(
		  'appId'  => '234905216704515',
		  'secret' => 'c8b43df6d650dcf7d349f4dea34712e9',
		  'cookie' => true
		));
            $facebook->destroySession();
        }
}
