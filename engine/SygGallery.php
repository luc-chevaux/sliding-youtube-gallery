<?php
class SygGallery {
	// object attributes
	private $ytVideoFormat;
	private $ytMaxVideoCount;
	private $ytUsername;
	private $boxWidth;
	private $boxBackground;
	private $boxRadius;
	private $boxPadding;
	private $thumbHeight;
	private $thumbWidth;
	private $thumbBorderSize;
	private $thumbBorderColor;
	private $thumbBorderRadius;
	private $thumbOverlaySize;
	private $thumbImage;
	private $thumbDistance;
	private $thumbButtonOpacity;
	private $percOccW;
	private $percOccH;
	private $thumbTop;
	private $thumbLeft;
	private $descWidth;
	private $descFontSize;
	private $descFontColor;
	private $descShow;
	private $descShowDuration;
	private $descShowTags;
	private $descShowRatings;
	private $descShowCategories;
	private $id;
	
	private $userProfile;
	
	// default constructor
	public function __construct($result = null) {
		$this->mapThis($result);
	}

	private function mapThis($result = null) {
		
		
		// box option values
		$this->setBoxBackground($result->syg_box_background);
		$this->setBoxPadding($result->syg_box_padding);
		$this->setBoxRadius($result->syg_box_radius);
		$this->setBoxWidth($result->syg_box_width);
		
		// description option values
		$this->setDescFontColor($result->syg_description_fontcolor);
		$this->setDescFontSize($result->syg_description_fontsize);
		$this->setDescShow($result->syg_description_show);
		$this->setDescShowCategories($result->syg_description_showcategories);
		$this->setDescShowDuration($result->syg_description_showduration);
		$this->setDescShowRatings($result->syg_description_showratings);
		$this->setDescShowTags($result->syg_description_showtags);
		$this->setDescWidth($result->syg_description_width);
		
		// thumbnail option values
		$this->setThumbBorderColor($result->syg_thumbnail_bordercolor);
		$this->setThumbBorderRadius($result->syg_thumbnail_borderradius);
		$this->setThumbBorderSize($result->syg_thumbnail_bordersize);
		$this->setThumbButtonOpacity($result->syg_thumbnail_buttonopacity);
		$this->setThumbDistance($result->syg_thumbnail_distance);
		$this->setThumbHeight($result->syg_thumbnail_height);
		$this->setThumbImage($result->syg_thumbnail_image);
		$this->setThumbWidth($result->syg_thumbnail_width);
		$this->setThumbOverlaySize($result->syg_thumbnail_overlaysize);
		// additional graphic option values
		$this->setPercOccH($this->getThumbOverlaySize() / ($this->getThumbHeight() + ($this->getThumbBorderSize()*2)));
		$this->setPercOccW($this->getThumbOverlaySize() / ($this->getThumbWidth() + ($this->getThumbBorderSize()*2)));
		$this->setThumbTop(50 - ($this->getPercOccH() / 2 * 100));
		$this->setThumbLeft(50 - ($this->getPercOccW() / 2 * 100));
		
		// youtube option values
		$this->setYtMaxVideoCount($result->syg_youtube_maxvideocount);
		$this->setYtVideoFormat($result->syg_youtube_videoformat);
		$this->setYtUsername($result->syg_youtube_username);
		
		// id
		$this->setId($result->id);
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
	 * @return the $boxWidth
	 */
	public function getBoxWidth() {
		return $this->boxWidth;
	}

	/**
	 * @param field_type $boxWidth
	 */
	public function setBoxWidth($boxWidth) {
		$this->boxWidth = $boxWidth;
	}

	/**
	 * @return the $boxBackground
	 */
	public function getBoxBackground() {
		return $this->boxBackground;
	}

	/**
	 * @param field_type $boxBackground
	 */
	public function setBoxBackground($boxBackground) {
		$this->boxBackground = $boxBackground;
	}

	/**
	 * @return the $boxRadius
	 */
	public function getBoxRadius() {
		return $this->boxRadius;
	}

	/**
	 * @param field_type $boxRadius
	 */
	public function setBoxRadius($boxRadius) {
		$this->boxRadius = $boxRadius;
	}

	/**
	 * @return the $boxPadding
	 */
	public function getBoxPadding() {
		return $this->boxPadding;
	}

	/**
	 * @param field_type $boxPadding
	 */
	public function setBoxPadding($boxPadding) {
		$this->boxPadding = $boxPadding;
	}

	/**
	 * @return the $thumbHeight
	 */
	public function getThumbHeight() {
		return $this->thumbHeight;
	}

	/**
	 * @param field_type $thumbHeight
	 */
	public function setThumbHeight($thumbHeight) {
		$this->thumbHeight = $thumbHeight;
	}

	/**
	 * @return the $thumbWidth
	 */
	public function getThumbWidth() {
		return $this->thumbWidth;
	}

	/**
	 * @param field_type $thumbWidth
	 */
	public function setThumbWidth($thumbWidth) {
		$this->thumbWidth = $thumbWidth;
	}

	/**
	 * @return the $thumbBorderSize
	 */
	public function getThumbBorderSize() {
		return $this->thumbBorderSize;
	}

	/**
	 * @param field_type $thumbBorderSize
	 */
	public function setThumbBorderSize($thumbBorderSize) {
		$this->thumbBorderSize = $thumbBorderSize;
	}

	/**
	 * @return the $thumbBorderColor
	 */
	public function getThumbBorderColor() {
		return $this->thumbBorderColor;
	}

	/**
	 * @param field_type $thumbBorderColor
	 */
	public function setThumbBorderColor($thumbBorderColor) {
		$this->thumbBorderColor = $thumbBorderColor;
	}

	/**
	 * @return the $thumbBorderRadius
	 */
	public function getThumbBorderRadius() {
		return $this->thumbBorderRadius;
	}

	/**
	 * @param field_type $thumbBorderRadius
	 */
	public function setThumbBorderRadius($thumbBorderRadius) {
		$this->thumbBorderRadius = $thumbBorderRadius;
	}

	/**
	 * @return the $thumbOverlaySize
	 */
	public function getThumbOverlaySize() {
		return $this->thumbOverlaySize;
	}

	/**
	 * @param field_type $thumbOverlaySize
	 */
	public function setThumbOverlaySize($thumbOverlaySize) {
		$this->thumbOverlaySize = $thumbOverlaySize;
	}

	/**
	 * @return the $thumbImage
	 */
	public function getThumbImage() {
		return $this->thumbImage;
	}

	/**
	 * @param field_type $thumbImage
	 */
	public function setThumbImage($thumbImage) {
		$this->thumbImage = $thumbImage;
	}

	/**
	 * @return the $thumbDistance
	 */
	public function getThumbDistance() {
		return $this->thumbDistance;
	}

	/**
	 * @param field_type $thumbDistance
	 */
	public function setThumbDistance($thumbDistance) {
		$this->thumbDistance = $thumbDistance;
	}

	/**
	 * @return the $thumbButtonOpacity
	 */
	public function getThumbButtonOpacity() {
		return $this->thumbButtonOpacity;
	}

	/**
	 * @param field_type $thumbButtonOpacity
	 */
	public function setThumbButtonOpacity($thumbButtonOpacity) {
		$this->thumbButtonOpacity = $thumbButtonOpacity;
	}

	/**
	 * @return the $percOccW
	 */
	public function getPercOccW() {
		return $this->percOccW;
	}

	/**
	 * @param field_type $percOccW
	 */
	public function setPercOccW($percOccW) {
		$this->percOccW = $percOccW;
	}

	/**
	 * @return the $percOccH
	 */
	public function getPercOccH() {
		return $this->percOccH;
	}

	/**
	 * @param field_type $percOccH
	 */
	public function setPercOccH($percOccH) {
		$this->percOccH = $percOccH;
	}

	/**
	 * @return the $thumbTop
	 */
	public function getThumbTop() {
		return $this->thumbTop;
	}

	/**
	 * @param field_type $thumbTop
	 */
	public function setThumbTop($thumbTop) {
		$this->thumbTop = $thumbTop;
	}

	/**
	 * @return the $thumbLeft
	 */
	public function getThumbLeft() {
		return $this->thumbLeft;
	}

	/**
	 * @param field_type $thumbLeft
	 */
	public function setThumbLeft($thumbLeft) {
		$this->thumbLeft = $thumbLeft;
	}

	/**
	 * @return the $descWidth
	 */
	public function getDescWidth() {
		return $this->descWidth;
	}

	/**
	 * @param field_type $descWidth
	 */
	public function setDescWidth($descWidth) {
		$this->descWidth = $descWidth;
	}

	/**
	 * @return the $descFontSize
	 */
	public function getDescFontSize() {
		return $this->descFontSize;
	}

	/**
	 * @param field_type $descFontSize
	 */
	public function setDescFontSize($descFontSize) {
		$this->descFontSize = $descFontSize;
	}

	/**
	 * @return the $descFontColor
	 */
	public function getDescFontColor() {
		return $this->descFontColor;
	}

	/**
	 * @param field_type $descFontColor
	 */
	public function setDescFontColor($descFontColor) {
		$this->descFontColor = $descFontColor;
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
}
?>