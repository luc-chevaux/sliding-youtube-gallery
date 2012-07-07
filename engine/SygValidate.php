<?php

/**
 * Sliding Youtube Gallery Custom Exception Class
 *
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2.5
 */

class SygValidateException extends Exception {
	// Redefine the exception so message isn't optional
	public function __construct($message, $code = 0) {
		parent::__construct($message, $code);
	}
	
	/**
	 * @name validateStyle
	 * @category return string rap
	 * @since 1.2.6
	 * @throws Exception
	 * @return String representation of the object
	 */
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}

/**
 * Sliding Youtube Gallery Validation Class
 *
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
	 * @since 1.2.6
	 * @throws Exception
	 * @return $instance of SygValidate
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
	 * @since 1.2.6
	 * @param array $data
	 * @throws SygValidateException
	 */
	public static function validateStyle($data) {
		// validation code
		
		// throws exception
		throw SygValidateException(SygConstant::COD_EX_STYLE_NOT_VALID, SygConstant::MSG_EX_STYLE_NOT_VALID);
	}
	
	/**
	 * @name validateGallery
	 * @category style validation function
	 * @since 1.2.6
	 * @param array $data
	 * @throws SygValidateException
	 */
	public static function validateGallery($data) {
		// validation code
	
		// throws exception
		throw SygValidateException(SygConstant::COD_EX_GALLERY_NOT_VALID, SygConstant::MSG_EX_GALLERY_NOT_VALID);
	}
	
	/**
	 * @name getProblemFound
	 * @category getters and setters
	 * @since 1.2.6
	 * @return the $problemFound attribute array 
	 */
	public function getProblemFound() {
		return $this->problemFound;
	}
	
	/**
	 * @name setProblemFound
	 * @category getters and setters
	 * @since 1.2.6
	 * @param field_type $problemFound
	 */
	public function setProblemFound($problemFound) {
		$this->problemFound = $problemFound;
	}
}
?>