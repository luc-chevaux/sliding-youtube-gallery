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
	 * @category return youTube user uploads Feed
	 * @since 1.0.1
	 * @param SygGallery $gallery
	 * @param $start = null
	 * @param $per_page = null
	 * @return $feed
	 */
	public function getUserUploads(SygGallery $gallery, $start = null, $per_page = null) {
		$username = $gallery->getYtSrc();
		$maxVideoCount = $gallery->getYtMaxVideoCount(); 
		
		// truncate feed
		
		// paginate feed 
		
		$this->yt->setMajorProtocolVersion(2);
		if (($start !== null) && ($per_page !== null)) {
			// return a video subset			
			
			$feed = new Zend_Gdata_YouTube_VideoFeed();
			
		} else {
			// return all videos (warning)
			$feed = $this->yt->retrieveAllEntriesForFeed($this->yt->getuserUploads($username));
		}
		
		return $feed;
	}
	
	/**
	 * @name getUserList
	 * @category return youTube user list Feed
	 * @since 1.0.1
	 * @param SygGallery $gallery
	 * @param $start = null
	 * @param $per_page = null
	 * @return $feed
	 */
	public function getUserList(SygGallery $gallery, $start = null, $per_page = null) {
		$list_of_videos = preg_split('/\r\n|\r|\n/', $gallery->getYtSrc());
		foreach ($list_of_videos as $key => $value) {
			$list_of_videos[$key] = str_replace('v=', '', parse_url($value, PHP_URL_QUERY));
			$videoEntry = $this->getVideoEntry($list_of_videos[$key]);
			$feed->addEntry($videoEntry);
		}
		$feed = $this->adjustFeed($feed, $gallery, $start, $per_page);
		return $feed;
	}
	
	/**
	 * @name getUserPlaylist
	 * @category return youTube user uploads
	 * @since 1.0.1
	 * @param SygGallery $gallery
	 * @param $start = null
	 * @param $per_page = null
	 * @return $feed
	 */
	public function getUserPlaylist(SygGallery $gallery, $start = null, $per_page = null) {
		$playlist_id = str_replace('list=PL', '', parse_url($gallery->getYtSrc(), PHP_URL_QUERY));
		$content = json_decode(
				file_get_contents(
						'http://gdata.youtube.com/feeds/api/playlists/'
						. $playlist_id
						. '/?v=2&alt=json&feature=plcp'));
		$feed_to_object = $content->feed->entry;
		if (count($feed_to_object)) {
			foreach ($feed_to_object as $item) {
				$videoId = $item->{'media$group'}->{'yt$videoid'}->{'$t'};
				$videoEntry = $this->sygYouTube->getVideoEntry($videoId);
				$feed->addEntry($videoEntry);
			}
		}
		$feed = $this->sygYouTube->adjustFeed($feed, $gallery, $start, $per_page);
		return $feed;
	}
	
	/**
	 * @name adjustFeed
	 * @category return youTube user uploads
	 * @since 1.0.1
	 * @param $username
	 * @return $videoFeed
	 */
	private function adjustFeed(Zend_Gdata_YouTube_VideoFeed $feed, SygGallery $gallery, $start = null, $per_page = null) {
		// truncate feed
		$feed_count = $feed->count();
		if ($gallery->getYtMaxVideoCount() < $feed_count) {
			$feed_count--;
			for ($i = $gallery->getYtMaxVideoCount(); $i <= $feed_count; $i++) {
				$feed->offsetUnset($i);
			}
		}
	
		// feed pagination
		if (($start !== null) && ($per_page !== null) && ($feed->count() > $per_page)) {
			$feed_page = new Zend_Gdata_YouTube_VideoFeed();
			$end = intval($start + $per_page) - 1;
			for ($i = $start; $i <= $end; $i++) {
				if ($feed->offsetGet($i)) $feed_page->addEntry($feed->offsetGet($i));
			}
			$feed = $feed_page;
		}
	
		return $feed;
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
	
	/**
	 * @name countGalleryEntry
	 * @category return displayed video count
	 * @since 1.3.0
	 * @param $username
	 * @return $videoFeed
	 */
	public function countGalleryEntry($src = null, $gallery_type = null, $max_video_count = null) {
		$count = 0;
		if ($src && $gallery_type && $max_video_count) {
			$feed = new Zend_Gdata_YouTube_VideoFeed();
			if ($gallery_type == 'feed') {
				$feed = $this->yt->getuserUploads($src);
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
				$count = $max_video_count;
			}
		} 
		return $count;
	}
}
?>