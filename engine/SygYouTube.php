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
	public function getUserProfile($username) {
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
	public function getUserUploads($username) {
		$this->yt->setMajorProtocolVersion(2);
		$videoFeed = $this->yt->getuserUploads($username);
		return $videoFeed;
	}
	
	/**
	 * @name getVideoEntry
	 * @category return a YouTube Video
	 * @since 1.3.0
	 * @param $video_code
	 * @return Zend_Gdata_YouTube_VideoEntry $video
	 */
	public function getVideoEntry($video_code = null) {
		$this->yt->setMajorProtocolVersion(2);
		$video = $this->yt->getVideoEntry($video_code);
		return $video;
	}
	
	public function countGalleryEntry($src = null, $gallery_type = null, $max_video_count = null) {
		$count = 0;
		if ($src && $gallery_type && $max_video_count) {
			$feed = new Zend_Gdata_YouTube_VideoFeed();
			if ($gallery_type == 'feed') {
				$feed = $this->sygYouTube->getuserUploads($src);
				$count = $feed->count();
			} else if ($gallery_type == 'list') {
				$list_of_videos = preg_split( '/\r\n|\r|\n/', $src);
				$count = count($list_of_videos);
			} else if ($gallery_type == 'playlist') {
				$playlist_id = str_replace ('list=PL', '', parse_url($src, PHP_URL_QUERY));
				$content = json_decode(file_get_contents('http://gdata.youtube.com/feeds/api/playlists/'.$playlist_id.'/?v=2&alt=json&feature=plcp'));
				$feed_to_object = $content->feed->entry;
				$count = count($feed_to_object);
			}
			
			// truncate feed
			if ($max_video_count < $count) {
				$count = $gallery->getYtMaxVideoCount();
			}
		} 
		return $count;
	}
}
?>