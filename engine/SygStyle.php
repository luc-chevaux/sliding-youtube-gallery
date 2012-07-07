<?php

/**
 * Sliding Youtube Gallery Plugin Style Data Bean
 *
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2.5
 */

class SygStyle {
	// object attributes
	private $styleName;
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
	private $thumbUrl;
	private $percOccW;
	private $percOccH;
	private $thumbTop;
	private $thumbLeft;
	private $descWidth;
	private $descFontSize;
	private $descFontColor;
	private $id;
	
	// recordset type
	public static $rsType = array('%s','%s','%d','%d','%d','%s','%d','%d','%s','%d','%d','%d','%d','%d','%s','%d','%d','%d');
	
	/**
	 * Constructor
	 * @param $key
	 * @return null
	 */
	public function __construct($key = null) {
		if (is_string($key)) $key = unserialize ($key);
		$this->mapThis($key);
	}

	/**
	 * Map object from resultset
	 * @param $result
	 * @return null
	 */
	private function mapThis($result = null) {
		$result = (object) $result;
		
		// box option values
		$this->setBoxBackground(($result->syg_box_background) ? $result->syg_box_background : SygConstant::SYG_BOX_DEFAULT_BACKGROUND_COLOR);
		$this->setBoxPadding($result->syg_box_padding);
		$this->setBoxRadius($result->syg_box_radius);
		$this->setBoxWidth($result->syg_box_width);
		
		// description option values
		$this->setDescFontColor(($result->syg_description_fontcolor) ? ($result->syg_description_fontcolor) : SygConstant::SYG_DESC_DEFAULT_FONT_COLOR);
		$this->setDescFontSize($result->syg_description_fontsize);
		$this->setDescWidth(($result->syg_thumbnail_width > 0) ? $result->syg_thumbnail_width : SygConstant::SYG_THUMB_DEFAULT_WIDTH);
		
		// thumbnail option values
		$this->setThumbBorderColor(($result->syg_thumbnail_bordercolor) ? $result->syg_thumbnail_bordercolor: SygConstant::SYG_THUMB_DEFAULT_BORDER_COLOR);
		$this->setThumbBorderRadius($result->syg_thumbnail_borderradius);
		$this->setThumbBorderSize($result->syg_thumbnail_bordersize);
		$this->setThumbButtonOpacity($result->syg_thumbnail_buttonopacity);
		$this->setThumbDistance($result->syg_thumbnail_distance);
		$this->setThumbHeight(($result->syg_thumbnail_height > 0) ? $result->syg_thumbnail_height : SygConstant::SYG_THUMB_DEFAULT_HEIGHT);
		$this->setThumbImage($result->syg_thumbnail_image);
		$this->setThumbWidth(($result->syg_thumbnail_width > 0) ? $result->syg_thumbnail_width : SygConstant::SYG_THUMB_DEFAULT_WIDTH);
		$this->setThumbOverlaySize($result->syg_thumbnail_overlaysize);
		
		// additional graphic option values
		$this->setPercOccH($this->getThumbOverlaySize() / ($this->getThumbHeight() + ($this->getThumbBorderSize()*2)));
		$this->setPercOccW($this->getThumbOverlaySize() / ($this->getThumbWidth() + ($this->getThumbBorderSize()*2)));
		$this->setThumbTop(50 - ($this->getPercOccH() / 2 * 100));
		$this->setThumbLeft(50 - ($this->getPercOccW() / 2 * 100));
		
		// id
		$this->setId($result->id);
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
	public function toDto($full = false) {
		$dto = array('syg_style_name'			=> $this->getStyleName(),
				'syg_box_background'			=> $this->getBoxBackground(),
				'syg_box_padding' 				=> $this->getBoxPadding(),
				'syg_box_radius'				=> $this->getBoxRadius(),
				'syg_box_width' 				=> $this->getBoxWidth(),
				'syg_description_fontcolor' 	=> $this->getDescFontColor(),
				'syg_description_fontsize'		=> $this->getDescFontSize(),
				'syg_description_width'			=> $this->getDescWidth(),
				'syg_thumbnail_bordercolor'		=> $this->getThumbBorderColor(),
				'syg_thumbnail_borderradius'	=> $this->getThumbBorderRadius(),
				'syg_thumbnail_bordersize'		=> $this->getThumbBorderSize(),
				'syg_thumbnail_buttonopacity'	=> $this->getThumbButtonOpacity(),
				'syg_thumbnail_distance'		=> $this->getThumbDistance(),
				'syg_thumbnail_height'			=> $this->getThumbHeight(),
				'syg_thumbnail_image'			=> $this->getThumbImage(),
				'syg_thumbnail_width'			=> $this->getThumbWidth(),
				'syg_thumbnail_overlaysize'		=> $this->getThumbOverlaySize(),
				'id'							=> $this->getId());
		
		if ($full) {
			$full_array = $dto;
			$full_array['syg_thumbnail_top'] = $this->getThumbTop();
			$full_array['syg_thumbnail_left'] = $this->getThumbLeft();
			$full_array['syg_thumbnail_url'] = $this->getThumbUrl();
			$dto = $full_array; 			
		}
		
		return $dto;
	}
	
	/**
	 * @return the $styleName
	 */
	public function getStyleName() {
		return $this->styleName;
	}

	/**
	 * @param field_type $styleName
	 */
	public function setStyleName($styleName) {
		$this->styleName = $styleName;
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
	 * @return the $thumbUrl
	 */
	public function getThumbUrl() {
		return $this->thumbUrl;
	}

	/**
	 * @param field_type $thumbUrl
	 */
	public function setThumbUrl($thumbUrl) {
		$this->thumbUrl = $thumbUrl;
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