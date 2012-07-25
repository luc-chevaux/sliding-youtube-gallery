<?php

/**
 * Sliding Youtube Gallery Plugin Gallery Data Bean
 *
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2.5
 */

class SygGallery {
	private $sygStyle;
	private $userProfile;
	
	// object attributes
	private $ytVideoFormat;
	private $ytMaxVideoCount;
	private $ytUsername;
	private $styleId;
	private $descShow;
	private $descShowDuration;
	private $descShowTags;
	private $descShowRatings;
	private $descShowCategories;
	private $id;
	
	// recordset type
	public static $rsType = array('%d','%d','%d','%d','%d','%d','%s','%s','%d','%d');
	
	/**
	 * Constructor
	 * @param $key
	 * @return null
	 */
	public function __construct($key = null) {
		if (is_string($key)) $key = unserialize ($key);
		$this->sygYouTube = new SygYouTube();
		$this->mapThis($key);
	}

	/**
	 * Map object from resultset
	 * @param $result
	 * @return null
	 */
	private function mapThis($result = null) {
		$result = (object) $result;
		
		// description option values
		$this->setDescShow($result->syg_description_show);
		$this->setDescShowCategories($result->syg_description_showcategories);
		$this->setDescShowDuration($result->syg_description_showduration);
		$this->setDescShowRatings($result->syg_description_showratings);
		$this->setDescShowTags($result->syg_description_showtags);
		
		// youtube option values
		$this->setYtMaxVideoCount($result->syg_youtube_maxvideocount);
		$this->setYtVideoFormat($result->syg_youtube_videoformat);
		$this->setYtUsername($result->syg_youtube_username);
		
		// set style id
		$this->setStyleId($result->syg_style_id);
		
		// set youtube user profile
		($this->getYtUsername()) ? $this->setUserProfile($this->sygYouTube->getUserProfile($this->getYtUsername())) : $this->setUserProfile(null);
		
		// id
		$this->setId($result->id);
		
		// instantiate local dao
		$sygDao = new SygDao();
		
		// load style setting
		$this->sygStyle = $sygDao->getSygStyleById($this->getStyleId());
	}
	
	/**
	 * Return Json data string
	 * @return $json
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
	 * Populate and return a dto with values
	 * @param $full 
	 * @return array
	 */
	public function toDto() {
		$dto = array(
				'syg_description_show'				=> $this->getDescShow(),
				'syg_description_showcategories'	=> $this->getDescShowCategories(),
				'syg_description_showduration'		=> $this->getDescShowDuration(),
				'syg_description_showratings'		=> $this->getDescShowRatings(),
				'syg_description_showtags' 			=> $this->getDescShowTags(),
				'syg_youtube_maxvideocount'			=> $this->getYtMaxVideoCount(),
				'syg_youtube_videoformat'			=> $this->getYtVideoFormat(),
				'syg_youtube_username'				=> $this->getYtUsername(),
				'syg_style_id'						=> $this->getStyleId(),
				'id'								=> $this->getId());
		return $dto;
	}
	
	/**
	 * @return the $rsType
	 */
	public static function getRsType() {
		return SygGallery::$rsType;
	}
	/**
	 * @return the $sygStyle
	 */
	public function getSygStyle() {
		return $this->sygStyle;
	}

	/**
	 * @param field_type $sygStyle
	 */
	public function setSygStyle($sygStyle) {
		$this->sygStyle = $sygStyle;
	}

	/**
	 * @return the $userProfile
	 */
	public function getUserProfile() {
		return $this->userProfile;
	}

	/**
	 * @param field_type $userProfile
	 */
	public function setUserProfile($userProfile) {
		$this->userProfile = $userProfile;
	}

	/**
	 * @return the $ytVideoFormat
	 */
	public function getYtVideoFormat() {
		return $this->ytVideoFormat;
	}

	/**
	 * @param field_type $ytVideoFormat
	 */
	public function setYtVideoFormat($ytVideoFormat) {
		$this->ytVideoFormat = $ytVideoFormat;
	}

	/**
	 * @return the $ytMaxVideoCount
	 */
	public function getYtMaxVideoCount() {
		return $this->ytMaxVideoCount;
	}

	/**
	 * @param field_type $ytMaxVideoCount
	 */
	public function setYtMaxVideoCount($ytMaxVideoCount) {
		$this->ytMaxVideoCount = $ytMaxVideoCount;
	}

	/**
	 * @return the $ytUsername
	 */
	public function getYtUsername() {
		return $this->ytUsername;
	}

	/**
	 * @param field_type $ytUsername
	 */
	public function setYtUsername($ytUsername) {
		$this->ytUsername = $ytUsername;
	}

	/**
	 * @return the $styleId
	 */
	public function getStyleId() {
		return $this->styleId;
	}

	/**
	 * @param field_type $styleId
	 */
	public function setStyleId($styleId) {
		$this->styleId = $styleId;
	}

	/**
	 * @return the $descShow
	 */
	public function getDescShow() {
		return $this->descShow;
	}

	/**
	 * @param field_type $descShow
	 */
	public function setDescShow($descShow) {
		$this->descShow = $descShow;
	}

	/**
	 * @return the $descShowDuration
	 */
	public function getDescShowDuration() {
		return $this->descShowDuration;
	}

	/**
	 * @param field_type $descShowDuration
	 */
	public function setDescShowDuration($descShowDuration) {
		$this->descShowDuration = $descShowDuration;
	}

	/**
	 * @return the $descShowTags
	 */
	public function getDescShowTags() {
		return $this->descShowTags;
	}

	/**
	 * @param field_type $descShowTags
	 */
	public function setDescShowTags($descShowTags) {
		$this->descShowTags = $descShowTags;
	}

	/**
	 * @return the $descShowRatings
	 */
	public function getDescShowRatings() {
		return $this->descShowRatings;
	}

	/**
	 * @param field_type $descShowRatings
	 */
	public function setDescShowRatings($descShowRatings) {
		$this->descShowRatings = $descShowRatings;
	}

	/**
	 * @return the $descShowCategories
	 */
	public function getDescShowCategories() {
		return $this->descShowCategories;
	}

	/**
	 * @param field_type $descShowCategories
	 */
	public function setDescShowCategories($descShowCategories) {
		$this->descShowCategories = $descShowCategories;
	}

	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
}
?>