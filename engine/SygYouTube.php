<?php

/**
 * Sliding Youtube Gallery Plugin YouTube Interface
 *
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2
 */

class SygYouTube {
	private $yt;
	
	/**
	 * Constructor
	 * @return null
	 */
	public function __construct() {
		Zend_Loader::loadClass('Zend_Gdata_YouTube');
		$this->yt = new Zend_Gdata_YouTube();
	}
	
	/**
	 * Return YouTube User Profile Object
	 * @param $username 
	 * @return $userProfile
	 */
	function getUserProfile($username) {
		try {
			$this->yt->setMajorProtocolVersion(2);
			$userProfile = $this->yt->getUserProfile($username);
		} catch (Zend_Gdata_App_HttpException $exception) {
			$userprofile = null;
		}
		return $userProfile;
	}
	
	/**
	 * Return YouTube User Uploads
	 * @param $username
	 * @return $videoFeed
	 */
	function getUserUploads($username) {
		$this->yt->setMajorProtocolVersion(2);
		$videoFeed = $this->yt->getuserUploads($username);
		return $videoFeed;
	}
}
?>