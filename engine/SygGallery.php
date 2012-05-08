<?php
class SygGallery {
	// object attributes
	private $ytVideoFormat;
	private $ytMaxVideoCount;
	private $boxWidth;
	private $boxBackground;
	private $boxRadius;
	private $boxPadding;
	private $thumbheight;
	private $thumbWidth;
	private $thumbBorderSize;
	private $thumbBorderColor;
	private $thumbBorderRadius;
	private $thumbOverlaySize;
	private $thumbImage;
	private $thumbDistance;
	private $thumbButtonopacity;
	private $percOccW;
	private $defaultLeft; // = 50 - ($percOcc_w / 2 * 100);
	private $percOccH; // = $thumbOverlaySize / ($thumbHeight + ($thumbBorderSize*2));
	private $defaultTop; // = 50 - ($percOccH / 2 * 100);
	private $thumbTop; // = get_option('syg_thumbnail_top') != '' ? get_option('syg_thumbnail_top') : $default_top;
	private $thumbLeft; // = get_option('syg_thumbnail_left') != '' ? get_option('syg_thumbnail_left') : $default_left;
	private $descWidth; // = get_option('syg_description_width') != '' ? get_option('syg_description_width') : $syg_thumbnail_width;
	private $descFontSize; // = get_option('syg_description_fontsize') != '' ? get_option('syg_description_fontsize') : "12";
	private $descFontColor; // = get_option('syg_description_fontcolor') != '' ? get_option('syg_description_fontcolor') : "#333333";
	private $descShow; // = get_option('syg_description_show') != '' ? get_option('syg_description_show') : "false";
	private $descShowDuration; // = get_option('syg_description_showduration') != '' ? get_option('syg_description_showduration') : "false";
	private $descShowTags; // = get_option('syg_description_showtags') != '' ? get_option('syg_description_showtags') : "false";
	private $descShowRatings; // = get_option('syg_description_showratings') != '' ? get_option('syg_description_showratings') : "false";
	private $descShowCategories; // = get_option('syg_description_showcategories') != '' ? get_option('syg_description_showcategories') : "false";
	
	// default constructor
	public function __construct() {

	}
	
	/**
	 * @return the $ytVideoFormat
	 */
	public function getYtVideoFormat() {
		return $this->ytVideoFormat;
	}

	/**
	 * @return the $ytMaxVideoCount
	 */
	public function getYtMaxVideoCount() {
		return $this->ytMaxVideoCount;
	}

	/**
	 * @return the $boxWidth
	 */
	public function getBoxWidth() {
		return $this->boxWidth;
	}

	/**
	 * @return the $boxBackground
	 */
	public function getBoxBackground() {
		return $this->boxBackground;
	}

	/**
	 * @return the $boxRadius
	 */
	public function getBoxRadius() {
		return $this->boxRadius;
	}

	/**
	 * @return the $boxPadding
	 */
	public function getBoxPadding() {
		return $this->boxPadding;
	}

	/**
	 * @return the $thumbheight
	 */
	public function getThumbheight() {
		return $this->thumbheight;
	}

	/**
	 * @return the $thumbWidth
	 */
	public function getThumbWidth() {
		return $this->thumbWidth;
	}

	/**
	 * @return the $thumbBorderSize
	 */
	public function getThumbBorderSize() {
		return $this->thumbBorderSize;
	}

	/**
	 * @return the $thumbBorderColor
	 */
	public function getThumbBorderColor() {
		return $this->thumbBorderColor;
	}

	/**
	 * @return the $thumbBorderRadius
	 */
	public function getThumbBorderRadius() {
		return $this->thumbBorderRadius;
	}

	/**
	 * @return the $thumbOverlaySize
	 */
	public function getThumbOverlaySize() {
		return $this->thumbOverlaySize;
	}

	/**
	 * @return the $thumbImage
	 */
	public function getThumbImage() {
		return $this->thumbImage;
	}

	/**
	 * @return the $thumbDistance
	 */
	public function getThumbDistance() {
		return $this->thumbDistance;
	}

	/**
	 * @return the $thumbButtonopacity
	 */
	public function getThumbButtonopacity() {
		return $this->thumbButtonopacity;
	}

	/**
	 * @return the $percOccW
	 */
	public function getPercOccW() {
		return $this->percOccW;
	}

	/**
	 * @return the $defaultLeft
	 */
	public function getDefaultLeft() {
		return $this->defaultLeft;
	}

	/**
	 * @return the $percOccH
	 */
	public function getPercOccH() {
		return $this->percOccH;
	}

	/**
	 * @return the $defaultTop
	 */
	public function getDefaultTop() {
		return $this->defaultTop;
	}

	/**
	 * @return the $thumbTop
	 */
	public function getThumbTop() {
		return $this->thumbTop;
	}

	/**
	 * @return the $thumbLeft
	 */
	public function getThumbLeft() {
		return $this->thumbLeft;
	}

	/**
	 * @return the $descWidth
	 */
	public function getDescWidth() {
		return $this->descWidth;
	}

	/**
	 * @return the $descFontSize
	 */
	public function getDescFontSize() {
		return $this->descFontSize;
	}

	/**
	 * @return the $descFontColor
	 */
	public function getDescFontColor() {
		return $this->descFontColor;
	}

	/**
	 * @return the $descShow
	 */
	public function getDescShow() {
		return $this->descShow;
	}

	/**
	 * @return the $descShowDuration
	 */
	public function getDescShowDuration() {
		return $this->descShowDuration;
	}

	/**
	 * @return the $descShowTags
	 */
	public function getDescShowTags() {
		return $this->descShowTags;
	}

	/**
	 * @return the $descShowRatings
	 */
	public function getDescShowRatings() {
		return $this->descShowRatings;
	}

	/**
	 * @return the $descShowCategories
	 */
	public function getDescShowCategories() {
		return $this->descShowCategories;
	}

	/**
	 * @param field_type $ytVideoFormat
	 */
	public function setYtVideoFormat($ytVideoFormat) {
		$this->ytVideoFormat = $ytVideoFormat;
	}

	/**
	 * @param field_type $ytMaxVideoCount
	 */
	public function setYtMaxVideoCount($ytMaxVideoCount) {
		$this->ytMaxVideoCount = $ytMaxVideoCount;
	}

	/**
	 * @param field_type $boxWidth
	 */
	public function setBoxWidth($boxWidth) {
		$this->boxWidth = $boxWidth;
	}

	/**
	 * @param field_type $boxBackground
	 */
	public function setBoxBackground($boxBackground) {
		$this->boxBackground = $boxBackground;
	}

	/**
	 * @param field_type $boxRadius
	 */
	public function setBoxRadius($boxRadius) {
		$this->boxRadius = $boxRadius;
	}

	/**
	 * @param field_type $boxPadding
	 */
	public function setBoxPadding($boxPadding) {
		$this->boxPadding = $boxPadding;
	}

	/**
	 * @param field_type $thumbheight
	 */
	public function setThumbheight($thumbheight) {
		$this->thumbheight = $thumbheight;
	}

	/**
	 * @param field_type $thumbWidth
	 */
	public function setThumbWidth($thumbWidth) {
		$this->thumbWidth = $thumbWidth;
	}

	/**
	 * @param field_type $thumbBorderSize
	 */
	public function setThumbBorderSize($thumbBorderSize) {
		$this->thumbBorderSize = $thumbBorderSize;
	}

	/**
	 * @param field_type $thumbBorderColor
	 */
	public function setThumbBorderColor($thumbBorderColor) {
		$this->thumbBorderColor = $thumbBorderColor;
	}

	/**
	 * @param field_type $thumbBorderRadius
	 */
	public function setThumbBorderRadius($thumbBorderRadius) {
		$this->thumbBorderRadius = $thumbBorderRadius;
	}

	/**
	 * @param field_type $thumbOverlaySize
	 */
	public function setThumbOverlaySize($thumbOverlaySize) {
		$this->thumbOverlaySize = $thumbOverlaySize;
	}

	/**
	 * @param field_type $thumbImage
	 */
	public function setThumbImage($thumbImage) {
		$this->thumbImage = $thumbImage;
	}

	/**
	 * @param field_type $thumbDistance
	 */
	public function setThumbDistance($thumbDistance) {
		$this->thumbDistance = $thumbDistance;
	}

	/**
	 * @param field_type $thumbButtonopacity
	 */
	public function setThumbButtonopacity($thumbButtonopacity) {
		$this->thumbButtonopacity = $thumbButtonopacity;
	}

	/**
	 * @param field_type $percOccW
	 */
	public function setPercOccW($percOccW) {
		$this->percOccW = $percOccW;
	}

	/**
	 * @param field_type $defaultLeft
	 */
	public function setDefaultLeft($defaultLeft) {
		$this->defaultLeft = $defaultLeft;
	}

	/**
	 * @param field_type $percOccH
	 */
	public function setPercOccH($percOccH) {
		$this->percOccH = $percOccH;
	}

	/**
	 * @param field_type $defaultTop
	 */
	public function setDefaultTop($defaultTop) {
		$this->defaultTop = $defaultTop;
	}

	/**
	 * @param field_type $thumbTop
	 */
	public function setThumbTop($thumbTop) {
		$this->thumbTop = $thumbTop;
	}

	/**
	 * @param field_type $thumbLeft
	 */
	public function setThumbLeft($thumbLeft) {
		$this->thumbLeft = $thumbLeft;
	}

	/**
	 * @param field_type $descWidth
	 */
	public function setDescWidth($descWidth) {
		$this->descWidth = $descWidth;
	}

	/**
	 * @param field_type $descFontSize
	 */
	public function setDescFontSize($descFontSize) {
		$this->descFontSize = $descFontSize;
	}

	/**
	 * @param field_type $descFontColor
	 */
	public function setDescFontColor($descFontColor) {
		$this->descFontColor = $descFontColor;
	}

	/**
	 * @param field_type $descShow
	 */
	public function setDescShow($descShow) {
		$this->descShow = $descShow;
	}

	/**
	 * @param field_type $descShowDuration
	 */
	public function setDescShowDuration($descShowDuration) {
		$this->descShowDuration = $descShowDuration;
	}

	/**
	 * @param field_type $descShowTags
	 */
	public function setDescShowTags($descShowTags) {
		$this->descShowTags = $descShowTags;
	}

	/**
	 * @param field_type $descShowRatings
	 */
	public function setDescShowRatings($descShowRatings) {
		$this->descShowRatings = $descShowRatings;
	}

	/**
	 * @param field_type $descShowCategories
	 */
	public function setDescShowCategories($descShowCategories) {
		$this->descShowCategories = $descShowCategories;
	}

	
}
?>