<?php

/**
 * @name SygValidateException
 * @category Sliding Youtube Gallery Custom Exception Class
 * @since 1.2.5
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2.5
 */

class SygValidateException extends Exception {
	
	/**
	 * @name __construct
	 * @category construct SygValidateException object
	 * @since 1.3.0
	 * @param $message, $code
	 */
	public function __construct($message, $code = 0, Exception $previous = null) {
		if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
			parent::__construct($message, $code, $previous);
		} else {
			parent::__construct($message, $code);
		}
	}
	
	/**
	 * @name __toString
	 * @category return a string map which is representation of the object
	 * @since 1.3.0
	 * @throws Exception
	 * @return String representation of the object
	 */
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}

/**
 * @name SygValidate
 * @category Sliding Youtube Gallery Validate Class
 * @since 1.2.5
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2.5
 */

class SygValidate {	
	private $problemFound;
	private static $instance = null;
	
	/**
	 * @name getInstance
	 * @category style validation function
	 * @since 1.3.0
	 * @return self::$instance of SygValidate
	 */
	public static function getInstance() {
		if(self::$instance == null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	/**
	 * @name validateStyle
	 * @category style validation function
	 * @since 1.3.0
	 * @param $data array of style params to validate
	 * @throws SygValidateException
	 */
	public static function validateStyle($data) {
		// validation code
		
		// syg_thumbnail_height intero
		// syg_thumbnail_width intero
		// syg_thumbnail_bordersize intero <= 10
		// syg_thumbnail_borderradius intero <=20
		// syg_thumbnail_distance intero
		// syg_thumbnail_buttonopacity reale tra 0 e 1
		// syg_box_width intero
		// syg_box_radius intero <=20
		// syg_box_padding intero
		// syg_description_fontsize intero
			
		// throws exception
		throw new SygValidateException(SygConstant::MSG_EX_STYLE_NOT_VALID, SygConstant::COD_EX_STYLE_NOT_VALID);
	}
	
	/**
	 * @name validateGallery
	 * @category style validation function
	 * @since 1.3.0
	 * @param $data array of galleries to validate
	 * @throws SygValidateException
	 */
	public static function validateGallery($data) {
		// validation code
	
		// validazione congiunta syg_gallery_type e syg_gallery_type e syg_youtube_src
		// syg_youtube_maxvideocount intero 
		
		// throws exception
		throw new SygValidateException(SygConstant::MSG_EX_GALLERY_NOT_VALID, SygConstant::COD_EX_GALLERY_NOT_VALID);
	}
	
	/**
	 * @name validateGallery
	 * @category style validation function
	 * @since 1.3.0
	 * @param $data array of galleries to validate
	 * @throws SygValidateException
	 */
	public static function validateSettings($data) {
		// validation code
	
		// syg_option_numrec intero
		// syg_option_pagenumrec intero
		
		// throws exception
		throw new SygValidateException(SygConstant::MSG_EX_SETTING_NOT_VALID, SygConstant::COD_EX_SETTING_NOT_VALID);
	}
	
	/**
	 * @name getProblemFound
	 * @category getters and setters
	 * @since 1.3.0
	 * @return $problemFound attribute array 
	 */
	public function getProblemFound() {
		return $this->problemFound;
	}
	
	/**
	 * @name setProblemFound
	 * @category getters and setters
	 * @since 1.3.0
	 * @param $problemFound
	 */
	public function setProblemFound($problemFound) {
		$this->problemFound = $problemFound;
	}
}
?>