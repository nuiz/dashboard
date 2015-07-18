<?php
namespace DashboardSocial;
use Facebook\Facebook;

class DashboardFacebook {
	private $fb, $redirectLoginHelper;

	public function setFacebook(Facebook $fb){
		$this->fb = $fb;
	}
	
	public function getRedirectLoginHelper(){
		if(is_null($this->redirectLoginHelper)){
			$this->redirectLoginHelper = $this->fb->getRedirectLoginHelper();
		}
		return $this->redirectLoginHelper;
	}

	public function getAccessToken(){
		return $this->getRedirectLoginHelper()->getAccessToken();
	}

	public function getLoginUrl(){
		$permissions = ['manage_pages', 'publish_pages', 'read_insights'];
		return $this->getRedirectLoginHelper()->getLoginUrl(BASE_URL, $permissions);
	}

	public function setAccessToken($accessToken){
		$_SESSION['facebook_access_token'] = (string)$accessToken;
	}

	public function getUserLoginToken(){
		return empty($_SESSION['facebook_access_token'])? null: $_SESSION['facebook_access_token'];
	}

	// if use page token > return never expire
	public function extendLongliveAccessToken($accessToken){
		$oAuth2Client = $this->fb->getOAuth2Client();
		return $oAuth2Client->getLongLivedAccessToken($accessToken);
	}

	public function getTokenExpire($accessToken){
		$oAuth2Client = $this->fb->getOAuth2Client();
		return $oAuth2Client->debugToken($accessToken)->getExpiresAt()->getTimeStamp();
	}
}