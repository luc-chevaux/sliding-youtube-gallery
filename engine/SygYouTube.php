<?php

/**
 * @name SygYouTube
 * @category Sliding YouTube Gallery Plugin YouTube Interface
 * @since 1.0.1
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2.5
 */

class SygYouTube {
	private $yt;
	
	/**
	 * @name __construct
	 * @category construct SygYouTube object
	 * @since 1.0.1
	 */
	public function __construct() {
		Zend_Loader::loadClass('Zend_Gdata_YouTube');
		$this->yt = new Zend_Gdata_YouTube();
	}
	
	/**
	 * @name getUserProfile
	 * @category return youTube user profile object
	 * @since 1.0.1
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
	 * @name getUserUploads
	 * @category return youTube user uploads
	 * @since 1.0.1
	 * @param $username
	 * @return $videoFeed
	 */
	function getUserUploads($username) {
		$this->yt->setMajorProtocolVersion(2);
		$videoFeed = $this->yt->getuserUploads($username);
		return $videoFeed;
	}
	
	/**
	 * @name getVideoEntry
	 * @category return a YouTube Video
	 * @since 1.3.0
	 * @param $video_code
	 * @return $video
	 */
	function getVideoEntry($video_code) {
		$this->yt->setMajorProtocolVersion(2);
		$video = $this->yt->getVideoEntry($video_code);
		return $video;
	}
}
?>