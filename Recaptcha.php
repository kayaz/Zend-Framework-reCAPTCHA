<?php
abstract class kCMS_Recaptcha extends Zend_Controller_Action {

    public function init() {

		function getOptions()
		{
			$front = Zend_Controller_Front::getInstance();
			$bootstrap = $front->getParam('bootstrap');
			if (null === $bootstrap) {
				throw new Exception('Unable to find bootstrap');
			}

			return $bootstrap->getOptions();
		}
		
		function getRecaptchaBody(){
			$config = getOptions();
			$key = $config['google']['recaptcha']['pagekey'];
			if($key){
				$url = "<script src='https://www.google.com/recaptcha/api.js?render=".$key."'></script>";
				return $url;
			} else {
				throw new Exception('Unable to find pagekey in application.ini');
			}
		}
		
		function getRecaptchaForm($action){
			$config = getOptions();
			$key = $config['google']['recaptcha']['pagekey'];
			if($key){
				$script = "<script>grecaptcha.ready(function(){grecaptcha.execute(\"".$key."\",{action:\"".$action."\"}).then(function(a){document.getElementById(\"g-recaptcha-response\").value=a})});</script>";
				$script .= "<input type=\"hidden\" id=\"g-recaptcha-response\" name=\"g-recaptcha-response\">";
				return $script;
			} else {
				throw new Exception('Unable to find pagekey in application.ini');
			}
		}
				
		function getRecaptchaCheck($response){
			$config = getOptions();
			$key = $config['google']['recaptcha']['secret'];
			if($key){
				if($response){
					$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$key.'&response='.$response);
					$responseData = json_decode($verifyResponse);

					if($responseData->success) {
						return true;
					}
				} else {
					throw new Exception('Could not get recaptcha response');
				}
			} else {
				throw new Exception('Unable to find pagekey in application.ini');
			}
		}

	}
}
?>