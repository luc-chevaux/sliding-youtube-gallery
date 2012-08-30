<?php

/**
 * @name Sliding Youtube Gallery Plugin Gallery Data Bean
 * @category Sliding Youtube Gallery Object
 * @since 1.0.1
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.3.2
 */

class SygGallery {
	// plugin objects
	private $sygYouTube;
	private $sygDao;
	private $sygStyle;
	private $userProfile;

	// this object attributes
	private $galleryName;
	private $galleryDetails;
	private $galleryType;
	private $ytVideoFormat;
	private $ytMaxVideoCount;
	private $ytDisableRelatedVideo;
	private $ytSrc;
	private $styleId;
	private $descShow;
	private $descShowDuration;
	private $descShowTags;
	private $descShowRatings;
	private $descShowCategories;
	private $id;
	
	// other attributes
	private $thumbUrl;
	
	// recordset type
	public static $rsType = array('%s','%s','%s','%d','%d','%d','%d','%d','%d','%s','%s','%d','%d','%d');
	
	/**
	 * @name __construct
	 * @category construct SygGallery object
	 * @since 1.0.1
	 * @param $key
	 */
	public function __construct($key = null) {
		if (is_string($key)) $key = unserialize ($key);
		$this->sygYouTube = new SygYouTube();
		$this->sygDao = new SygDao();		
		$this->mapThis($key);
	}

	/**
	 * @name mapThis
	 * @category data object mapping from resultset 
	 * @since 1.0.1
	 * @param $result
	 */
	private function mapThis($result = null) {
		$result = (object) $result;
		
		// id
		$this->setId($result->id);
		
		$this->setGalleryName($result->syg_gallery_name);
		$this->setGalleryDetails($result->syg_gallery_details);
		
		// youtube option values
		$this->setYtMaxVideoCount($result->syg_youtube_maxvideocount);
		$this->setYtVideoFormat($result->syg_youtube_videoformat);
		$this->setYtDisableRelatedVideo($result->syg_youtube_disablerel);
		$this->setYtSrc($result->syg_youtube_src);
		
		// set youtube user profile
		($result->syg_gallery_type) ? $this->setGalleryType($result->syg_gallery_type) : $this->setGalleryType('feed');
		
		if ((($this->getGalleryType() == 'feed') && (!$this->getId())) || ($this->getGalleryType() != 'feed')) {
			$this->setUserProfile(null);
		} else {
			$this->setUserProfile($this->sygYouTube->getUserProfile($this->getYtSrc()));
		}
		
		// description option values
		$this->setDescShow($result->syg_description_show);
		$this->setDescShowCategories($result->syg_description_showcategories);
		$this->setDescShowDuration($result->syg_description_showduration);
		$this->setDescShowRatings($result->syg_description_showratings);
		$this->setDescShowTags($result->syg_description_showtags);
		
		// set style id
		$this->setStyleId($result->syg_style_id);
		
		// load style setting
		$this->sygStyle = $this->sygDao->getSygStyleById($this->getStyleId());
	}
	
	/**
	 * @name countGalleryEntry
	 * @category count feed element for this gallery
	 * @since 1.3.0
	 * @return int $count
	 */
	public function countGalleryEntry() {
		return $this->sygYouTube->countGalleryEntry ($this);
	}
	
	/**
	 * @name getJsonData 
	 * @category object data parser
	 * @since 1.0.1
	 * @return string $json
	 */
	function getJsonData(){
		$var = get_object_vars($this);
		foreach($var as &$value){
			if(is_object($value) && method_exists($value,'getJsonData')){
				$value = $value->getJsonData();
			}
		}
		$json = $var;
		return $json;
	}
	
	/**
	 * @name 
	 * @category object data parser
	 * @since 1.0.1
	 * @param $full, if true export gallery with its owned style
	 * @return array $dto
	 */
	public function toDto($full = false) {
		$dto = array(
				'syg_gallery_name'					=> $this->getGalleryName(),
				'syg_gallery_details'				=> $this->getGalleryDetails(),
				'syg_gallery_type'					=> $this->getGalleryType(),
				'syg_description_show'				=> $this->getDescShow(),
				'syg_description_showcategories'	=> $this->getDescShowCategories(),
				'syg_description_showduration'		=> $this->getDescShowDuration(),
				'syg_description_showratings'		=> $this->getDescShowRatings(),
				'syg_description_showtags' 			=> $this->getDescShowTags(),
				'syg_youtube_maxvideocount'			=> $this->getYtMaxVideoCount(),
				'syg_youtube_videoformat'			=> $this->getYtVideoFormat(),
				'syg_youtube_src'					=> $this->getYtSrc(),
				'syg_style_id'						=> $this->getStyleId(),
				'syg_youtube_disablerel'			=> $this->getYtDisableRelatedVideo(),
				'id'								=> $this->getId());
		
		if ($full) {
			$full_array = $dto;
			
			$full_array['syg_box_background'] = $this->getSygStyle()->getBoxBackground();
			$full_array['syg_box_padding'] = $this->getSygStyle()->getBoxPadding();
			$full_array['syg_box_radius'] = $this->getSygStyle()->getBoxRadius();
			$full_array['syg_box_width'] = $this->getSygStyle()->getBoxWidth();
			$full_array['syg_description_fontcolor'] = $this->getSygStyle()->getDescFontColor();
			$full_array['syg_description_fontsize']	= $this->getSygStyle()->getDescFontSize();
			$full_array['syg_description_width'] = $this->getSygStyle()->getDescWidth();
			$full_array['syg_thumbnail_bordercolor'] = $this->getSygStyle()->getThumbBorderColor();
			$full_array['syg_thumbnail_borderradius'] = $this->getSygStyle()->getThumbBorderRadius();
			$full_array['syg_thumbnail_bordersize']	= $this->getSygStyle()->getThumbBorderSize();
			$full_array['syg_thumbnail_buttonopacity'] = $this->getSygStyle()->getThumbButtonOpacity();
			$full_array['syg_thumbnail_distance'] = $this->getSygStyle()->getThumbDistance();
			$full_array['syg_thumbnail_height']	= $this->getSygStyle()->getThumbHeight();
			$full_array['syg_thumbnail_image'] = $this->getSygStyle()->getThumbImage();
			$full_array['syg_thumbnail_width'] = $this->getSygStyle()->getThumbWidth();
			$full_array['syg_thumbnail_overlaysize'] = $this->getSygStyle()->getThumbOverlaySize();
			$full_array['syg_thumbnail_top'] = $this->getSygStyle()->getThumbTop();
			$full_array['syg_thumbnail_left'] = $this->getSygStyle()->getThumbLeft();
			$full_array['syg_thumbnail_url'] = $this->getSygStyle()->getThumbUrl();
			
			$dto = $full_array;
		}
		return $dto;
	}
	
	/**
	 * @name getRsType
	 * @category getters and setters
	 * @since 1.0.1
	 * @return array $rsType
	 */
	public static function getRsType() {
		return SygGallery::$rsType;
	}
	
	/**
	 * @name getSygStyle
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $sygStyle
	 */
	public function getSygStyle() {
		return $this->sygStyle;
	}

	/**
	 * @name setSygStyle
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $sygStyle
	 */
	public function setSygStyle($sygStyle) {
		$this->sygStyle = $sygStyle;
	}

	/**
	 * @name getUserProfile
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $userProfile
	 */
	public function getUserProfile() {
		return $this->userProfile;
	}

	/**
	 * @name setUserProfile
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $userProfile
	 */
	public function setUserProfile($userProfile) {
		$this->userProfile = $userProfile;
		if ($this->userProfile) { 
			$this->thumbUrl = $userProfile->getThumbnail()->getUrl();
		} else {
			$this->thumbUrl = SygConstant::BE_ICON_VIDEO_GALLERY;
		}
	}

	/**
	 * @name getYtVideoFormat
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $ytVideoFormat
	 */
	public function getYtVideoFormat() {
		return $this->ytVideoFormat;
	}

	/**
	 * @name setYtVideoFormat
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $ytVideoFormat
	 */
	public function setYtVideoFormat($ytVideoFormat) {
		$this->ytVideoFormat = $ytVideoFormat;
	}

	/**
	 * @name getYtMaxVideoCount
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $ytMaxVideoCount
	 */
	public function getYtMaxVideoCount() {
		return $this->ytMaxVideoCount;
	}

	/**
	 * @name setYtMaxVideoCount
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $ytMaxVideoCount
	 */
	public function setYtMaxVideoCount($ytMaxVideoCount) {
		$this->ytMaxVideoCount = $ytMaxVideoCount;
	}

	/**
	 * @name getYtSrc
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $ytSrc
	 */
	public function getYtSrc() {
		return $this->ytSrc;
	}

	/**
	 * @name setYtSrc
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $ytSrc
	 */
	public function setYtSrc($ytSrc) {
		$this->ytSrc = $ytSrc;
	}

	/**
	 * @name getStyleId
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $styleId
	 */
	public function getStyleId() {
		return $this->styleId;
	}

	/**
	 * @name setStyleId
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $styleId
	 */
	public function setStyleId($styleId) {
		$this->styleId = $styleId;
	}

	/**
	 * @name getYtSrc
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $ytSrc
	 */
	public function getDescShow() {
		return $this->descShow;
	}

	/**
	 * @name setDescShow
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $descShow
	 */
	public function setDescShow($descShow) {
		$this->descShow = $descShow;
	}

	/**
	 * @name getDescShowDuration
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $descShowDuration
	 */
	public function getDescShowDuration() {
		return $this->descShowDuration;
	}

	/**
	 * @name setDescShowDuration
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $descShowDuration
	 */
	public function setDescShowDuration($descShowDuration) {
		$this->descShowDuration = $descShowDuration;
	}

	/**
	 * @name getDescShowTags
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $descShowTags
	 */
	public function getDescShowTags() {
		return $this->descShowTags;
	}

	/**
	 * @name setDescShowTags
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $descShowTags
	 */
	public function setDescShowTags($descShowTags) {
		$this->descShowTags = $descShowTags;
	}

	/**
	 * @name getDescShowRatings
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $descShowRatings
	 */
	public function getDescShowRatings() {
		return $this->descShowRatings;
	}

	/**
	 * @name setDescShowRatings
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $descShowRatings
	 */
	public function setDescShowRatings($descShowRatings) {
		$this->descShowRatings = $descShowRatings;
	}

	/**
	 * @name getDescShowCategories
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $descShowCategories
	 */
	public function getDescShowCategories() {
		return $this->descShowCategories;
	}

	/**
	 * @name setDescShowCategories
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $descShowCategories
	 */
	public function setDescShowCategories($descShowCategories) {
		$this->descShowCategories = $descShowCategories;
	}

	/**
	 * @name getGalleryType
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $galleryType
	 */
	public function getGalleryType() {
		return $this->galleryType;
	}

	/**
	 * @name setGalleryType
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $galleryType
	 */
	public function setGalleryType($galleryType) {
		$this->galleryType = $galleryType;
	}

	/**
	 * @name getId
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @name setId
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @name getGalleryName
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $galleryName
	 */
	public function getGalleryName() {
		return $this->galleryName;
	}

	/**
	 * @name setGalleryName
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $galleryName
	 */
	public function setGalleryName($galleryName) {
		$this->galleryName = $galleryName;
	}

	/**
	 * @name getGalleryDetails
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $galleryDetails
	 */
	public function getGalleryDetails() {
		return $this->galleryDetails;
	}

	/**
	 * @name setGalleryDetails
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $galleryDetails
	 */
	public function setGalleryDetails($galleryDetails) {
		$this->galleryDetails = $galleryDetails;
	}
	
	/**
	 * @name getThumbUrl
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $thumbUrl
	 */
	public function getThumbUrl() {
		return $this->thumbUrl;
	}

	/**
	 * @name setThumbUrl
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $thumbUrl
	 */
	public function setThumbUrl($thumbUrl) {
		$this->thumbUrl = $thumbUrl;
	}
	
	/**
	 * @name getYtDisableRelatedVideo
	 * @category getters and setters
	 * @since 1.3.0
	 * @return $ytDisableRelatedVideo
	 */
	public function getYtDisableRelatedVideo() {
		return $this->ytDisableRelatedVideo;
	}

	/**
	 * @name setYtDisableRelatedVideo
	 * @category getters and setters
	 * @since 1.3.0
	 * @param $ytDisableRelatedVideo
	 */
	public function setYtDisableRelatedVideo($ytDisableRelatedVideo) {
		$this->ytDisableRelatedVideo = $ytDisableRelatedVideo;
	}
}
?>