<?php
class SygGallery {
	// object attributes
	private $ytVideoFormat;
	private $ytMaxVideoCount;
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
	private $defaultLeft;
	private $percOccH;
	private $defaultTop;
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
	
	// default constructor
	public function __construct() {
		/* YouTube default values */
		// default video format
		$this->setYtVideoFormat(get_option('syg_youtube_videoformat') != '' ? get_option('syg_youtube_videoformat') : "480n");
		$this->setYtMaxVideoCount(get_option('syg_youtube_maxvideocount') != '' ? get_option('syg_youtube_maxvideocount') : "15");
		
		/* box default values*/
		// default main box width
		$this->setBoxWidth(get_option('syg_box_width') != '' ? get_option('syg_box_width') : "550");
		
		// default main box background color
		$this->setBoxBackground(get_option('syg_box_background') != '' ? get_option('syg_box_background') : "#efefef");
		// default box radius pixel
		$this->setBoxRadius(get_option('syg_box_radius') != '' ? get_option('syg_box_radius') : "10");
		// default box padding pixel
		$this->setBoxPadding(get_option('syg_box_padding') != '' ? get_option('syg_box_padding') : "10");
		
		/* thumbnail default values*/
		// default thumbnail height
		$this->setThumbHeight(get_option('syg_thumbnail_height') != '' ? get_option('syg_thumbnail_height') : "100");
		// default thumbnail width
		$this->setThumbWidth(get_option('syg_thumbnail_width') != '' ? get_option('syg_thumbnail_width') : "133");
		// default thumbnail border size
		$this->setThumbBorderSize(get_option('syg_thumbnail_bordersize') != '' ? get_option('syg_thumbnail_bordersize') : "3");
		// default thumbnail border color
		$this->setThumbBorderColor(get_option('syg_thumbnail_bordercolor') != '' ? get_option('syg_thumbnail_bordercolor') : "#333333");
		// default thumbnail border radius
		$this->setThumbBorderRadius(get_option('syg_thumbnail_borderradius') != '' ? get_option('syg_thumbnail_borderradius') : "10");
		// default thumbnail overlay size
		$this->setThumbOverlaySize(get_option('syg_thumbnail_overlaysize') != '' ? get_option('syg_thumbnail_overlaysize') : "32");
		// default overlay button
		$this->setThumbImage(get_option('syg_thumbnail_image') != '' ? get_option('syg_thumbnail_image') : "1");
		// default thumbnail border size
		$this->setThumbBorderSize(get_option('syg_thumbnail_bordersize') != '' ? get_option('syg_thumbnail_bordersize') : "3");
		// default thumbnail distance
		$this->setThumbDistance(get_option('syg_thumbnail_distance') != '' ? get_option('syg_thumbnail_distance') : "10");
		// default thumbnail button opacity
		$this->setThumbButtonOpacity(get_option('syg_thumbnail_buttonopacity') != '' ? get_option('syg_thumbnail_buttonopacity') : "0.50");

		// update calculated option
		$this->setPercOccW($syg_thumbnail_overlaysize / ($this->thumbWidth + ($this->thumbBorderSize*2)));
		$this->setDefaultLeft(50 - ($this->percOccW / 2 * 100));
		$this->setPercOccH($syg_thumbnail_overlaysize / ($this->thumbHeight + ($this->thumbBorderSize*2)));
		$this->setDefaultTop(50 - ($this->percOccH / 2 * 100));
		
		// default thumbnail top position
		$this->setThumbTop(get_option('syg_thumbnail_top') != '' ? get_option('syg_thumbnail_top') : $this->defaultTop);
		// default thumbnail left position
		$this->setThumbLeft(get_option('syg_thumbnail_left') != '' ? get_option('syg_thumbnail_left') : $this->defaultLeft);
		
		/* thumbnail description */
		// default description width
		$this->setDescWidth(get_option('syg_description_width') != '' ? get_option('syg_description_width') : $this->thumbWidth);
		// default description font size
		$this->setDescFontSize(get_option('syg_description_fontsize') != '' ? get_option('syg_description_fontsize') : "12");
		// default description font color
		$this->setDescFontColor(get_option('syg_description_fontcolor') != '' ? get_option('syg_description_fontcolor') : "#333333");
		// default show video description
		$this->setDescShow(get_option('syg_description_show') != '' ? get_option('syg_description_show') : "false");
		// default show video duration
		$this->setDescShowDuration(get_option('syg_description_showduration') != '' ? get_option('syg_description_showduration') : "false");
		// default show video tags
		$this->setDescShowTags(get_option('syg_description_showtags') != '' ? get_option('syg_description_showtags') : "false");
		// default show video ratings
		$this->setDescShowRatings(get_option('syg_description_showratings') != '' ? get_option('syg_description_showratings') : "false");
		// default show video categories
		$this->setDescShowRatings(get_option('syg_description_showcategories') != '' ? get_option('syg_description_showcategories') : "false");
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
	public function getThumbHeight() {
		return $this->thumbHeight;
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
	public function getThumbButtonOpacity() {
		return $this->thumbButtonOpacity;
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
	public function setThumbHeight($thumbHeight) {
		$this->thumbHeight = $thumbHeight;
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
	public function setThumbButtonOpacity($thumbButtonOpacity) {
		$this->thumbButtonOpacity = $thumbButtonOpacity;
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