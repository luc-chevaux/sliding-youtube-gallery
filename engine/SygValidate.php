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
	
	private $problems;
	
	/**
	 * @name __construct
	 * @category construct SygValidateException object
	 * @since 1.3.0
	 * @param $message, $code
	 */
	public function __construct($problems, $message, $code = 0, Exception $previous = null) {
		$this->problems = $problems;
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
	
	/**
	 * @name getProblems
	 * @category getters and setters
	 * @since 1.3.0
	 * @return $problemFound attribute array 
	 */
	public function getProblems() {
		return $this->problems;
	}

	/**
	 * @name setProblems
	 * @category getters and setters
	 * @since 1.3.0
	 * @param $problemFound
	 */
	public function setProblems($problems) {
		$this->problems = $problems;
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
		$data = unserialize($data);
		// validation code
		$problemFound = array();
		
		// syg_thumbnail_height intero
		
		if (!(is_int($data['syg_thumbnail_height']))) {
			array_push($problemFound, array('field' => 'syg_thumbnail_height', 'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}
		 
		// syg_thumbnail_width intero
		if (!(is_int($data['syg_thumbnail_width']))) {
			array_push($problemFound, array('field' => 'syg_thumbnail_width', 'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}
		
		// syg_thumbnail_bordersize intero <= 10		
		if (!(is_int($data['syg_thumbnail_bordersize']) && $data['syg_thumbnail_bordersize'] <= 10 )) {
			if (!(is_int($data['syg_thumbnail_bordersize']))) { 
				array_push($problemFound, array('field' => 'syg_thumbnail_bordersize', 'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
			} else {
				if (!($data['syg_thumbnail_bordersize'] <= 10)) {
					array_push($problemFound, array('field' => 'syg_thumbnail_bordersize', 'msg' => SygConstant::BE_VALIDATE_NOT_LESS_VALUE));
				}
			}
		}
		
		// syg_thumbnail_borderradius intero <=20
		if (!(is_int($data['syg_thumbnail_borderradius']) && $data['syg_thumbnail_borderradius'] <= 20)) {
			if (!(is_int($data['syg_thumbnail_bordersize']))) {
				array_push($problemFound, array('field' => 'syg_thumbnail_borderradius', 'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
			} else {
				if (!($data['syg_thumbnail_bordersize'] <= 20)) {
					array_push($problemFound, array('field' => 'syg_thumbnail_borderradius', 'msg' => SygConstant::BE_VALIDATE_NOT_LESS_VALUE));
				}
			}
		}
		
		// syg_thumbnail_distance intero
		if (!(is_int($data['syg_thumbnail_distance']))) {
			array_push($problemFound, array('field' => 'syg_thumbnail_distance', 'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}
		
		// syg_thumbnail_buttonopacity reale tra 0 e 1
		if (!(is_float($data['syg_thumbnail_buttonopacity']) && $data['syg_thumbnail_buttonopacity'] >= 0 && $data['syg_thumbnail_buttonopacity'] <= 1)) {
			if (!(is_float($data['syg_thumbnail_buttonopacity']))) {
				array_push($problemFound, array('field' => 'syg_thumbnail_buttonopacity', 'msg' => SygConstant::BE_VALIDATE_NOT_A_FLOAT));
			} else {
				if (!($data['syg_thumbnail_buttonopacity'] >= 0 && $data['syg_thumbnail_buttonopacity'] <= 1)) {
					array_push($problemFound, array('field' => 'syg_thumbnail_buttonopacity', 'msg' => SygConstant::BE_VALIDATE_NOT_IN_RANGE));
				}
			}
		}
		
		// syg_box_width intero
		if (!(is_int($data['syg_box_width']))) {
			array_push($problemFound, array('field' => 'syg_box_width', 'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}
		
		// syg_box_radius intero <=20
		if (!(is_int($data['syg_box_radius']) && ($data['syg_box_radius'] <= 20))) {
			if (!(is_int($data['syg_box_radius']))) {
				array_push($problemFound, array('field' => 'syg_box_radius', 'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
			} else {
				if (!($data['syg_box_radius'] <= 20)) {
					array_push($problemFound, array('field' => 'syg_box_radius', 'msg' => SygConstant::BE_VALIDATE_NOT_LESS_VALUE));
				}
			}
		}
		
		// syg_box_padding intero
		if (!(is_int($data['syg_box_padding']))) {
			array_push($problemFound, array('field' => 'syg_box_padding', 'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}
		
		// syg_description_fontsize intero
		if (!(is_int($data['syg_description_fontsize']))) {
			array_push($problemFound, array('field' => 'syg_description_fontsize', 'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}
		
		if (count($problemFound) > 0) {
			// throws exception
			 throw new SygValidateException($problemFound, SygConstant::MSG_EX_STYLE_NOT_VALID, SygConstant::COD_EX_STYLE_NOT_VALID);
		} else {
			return true;
		}
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
	 * @name validateSettings
	 * @category settings validation function
	 * @since 1.3.0
	 * @param $data array of settings to validate
	 * @throws SygValidateException
	 */
	public static function validateSettings($data) {
		// validation code
	
		// syg_option_numrec intero
		// syg_option_pagenumrec intero
		
		// throws exception
		throw new SygValidateException(SygConstant::MSG_EX_SETTING_NOT_VALID, SygConstant::COD_EX_SETTING_NOT_VALID);
	}
}
?>