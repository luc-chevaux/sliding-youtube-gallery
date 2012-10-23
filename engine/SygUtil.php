<?php

/**
 * @name SygUtil
 * @category Sliding Youtube Gallery Plugin Utility Class
 * @since 1.0.1
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.3.5
 */

class SygUtil {
	private static $nAspectRatio = 0.75;
	private static $wAspectRatio = 0.5625;
	
	/**
	 * @name getNormalHeight
	 * @category Get height from width (w/normal aspect ratio)
	 * @since 1.2.5
	 * @param $width
	 * @return int $height
	 */
	public static function getNormalHeight($width) {
		$height = round($width * self::$nAspectRatio);
		return $height;
	}
	
	/**
	 * @name getWideHeight
	 * @category Get height from width (w/wide aspect ratio)
	 * @since 1.2.5
	 * @param $width
	 * @return int $height
	 */
	public static function getWideHeight($width) {
		$height = round($width * self::$wAspectRatio);
		return $height;
	}
	
	/**
	 * @name extractType
	 * @category Extract type from videoformat
	 * @since 1.0.1
	 * @param $videoFormat
	 * @return string $type
	 */
	public static function extractType($videoFormat) {
		$start = strlen($videoFormat)-1;
		$type = substr($videoFormat, $start, 1);
		return $type;
	}
	
	/**
	 * @name extractWidth
	 * @category Extract width from videoformat
	 * @since 1.0.1
	 * @param $videoFormat
	 * @return int $width
	 */
	public static function extractWidth($videoFormat) {
		$start = 0;
		$stop = strlen($videoFormat)-1;
		$width = substr($videoFormat, $start, $stop);
		return $width;
	}
	
	/**
	 * @name Sec2Time
	 * @category Return an array with time elements
	 * @since 1.2.5
	 * @param $seconds
	 * @return array $time
	 */
	private static function Sec2Time($seconds) {
		if(is_numeric($seconds)) {
			$value = array(
					"years" => 0, "days" => 0, "hours" => 0,
					"minutes" => 0, "seconds" => 0,
			);
			if($seconds >= 31556926){
				$value["years"] = floor($seconds/31556926);
				$seconds = ($seconds%31556926);
			}
			if($seconds >= 86400){
				$value["days"] = floor($seconds/86400);
				$seconds = ($seconds%86400);
			}
			if($seconds >= 3600){
				$value["hours"] = floor($seconds/3600);
				$seconds = ($seconds%3600);
			}
			if($seconds >= 60){
				$value["minutes"] = floor($seconds/60);
				$seconds = ($seconds%60);
			}
			$value["seconds"] = floor($seconds);
			return (array) $value;
		}else{
			return (bool) FALSE;
		}
	}

	/**
	 * @name formatDuration
	 * @category Format a video duration in hh:mi:ss
	 * @since 1.2.5
	 * @param $duration
	 * @return string $videoDuration
	 */
	public static function formatDuration ($duration = null) {
		$duration = self::Sec2Time($duration);
		$videoDuration = ($duration['hours'] > 0) ? $duration['hours'].':' : '';
		$videoDuration .= ($duration['minutes'] > 0) ? $duration['minutes'].':' : '0:';
		$videoDuration .= str_pad($duration['seconds'], 2, '0', STR_PAD_LEFT);
		return $videoDuration;
	}
	
	/**
	 * @name isCurlInstalled
	 * @category Check if curl is installed
	 * @since 1.2.5
	 * @param $videoFormat
	 * @return boolean
	 */
	public static function isCurlInstalled() {
		$installed = (in_array ('curl', get_loaded_extensions())) ? true : false;
	}
	
	/**
	 * @name getJsonData
	 * @category object data parser
	 * @since 1.2.5
	 * @return string $json
	 */
	public static function getJsonData($needle){
		$var = get_object_vars($needle);
		foreach($var as &$value){
			if(is_object($value) && method_exists($value,'getJsonData')){
				$value = $value->getJsonData();
			}
		}
		$json = $var;
		return $json;
	}
	
	/**
	 * @name injectValues
	 * @category placeholder values injection
	 * @since 1.2.5
	 * @return string $json
	 */
	public static function injectValues() {
		$args = func_get_args();
		$toParse = array_shift ($args);
		return vsprintf ($toParse, $args);
	}
	
	/**
	 * @name getLabel
	 * @category get a label from SygConstant by input name
	 * @since 1.3.3
	 * @return string $label
	 */
	public static function getLabel($label) {
		return constant('SygConstant::'.$label);
	}
}
?>