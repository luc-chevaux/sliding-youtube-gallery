<?php

/**
 * Sliding Youtube Gallery Plugin Utility Class
 *
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2.3
 */

class SygUtil {
	private static $nAspectRatio = 0.75;
	private static $wAspectRatio = 0.5625;
	
	/**
	 * Get height from width (w/normal aspect ratio)
	 * @param $width
	 * @return $height
	 */
	public static function getNormalHeight($width) {
		$height = round($width * self::$nAspectRatio);
		return $height;
	}
	
	/**
	 * Get height from width (w/wide aspect ratio)
	 * @param $width
	 * @return $height
	 */
	public static function getWideHeight($width) {
		$height = round($width * self::$wAspectRatio);
		return $height;
	}
	
	/**
	 * Extract type from video format
	 * @param $videoFormat
	 * @return $type
	 */
	public static function extractType($videoFormat) {
		$start = strlen($videoFormat)-1;
		$type = substr($videoFormat, $start, 1);
		return $type;
	}
	
	/**
	 * Extract width from video format
	 * @param $videoFormat
	 * @return array
	 */
	public static function extractWidth($videoFormat) {
		$start = 0;
		$stop = strlen($videoFormat)-1;
		$width = substr($videoFormat, $start, $stop);
		return $width;
	}
	
	/**
	 * Convert seconds to a time period
	 * @param $seconds
	 * @return array
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
	 * Datetime Formatter for video duration
	 * @param $duration
	 * @return $videoDuration;
	 */
	public static function formatDuration ($duration = null) {
		$duration = self::Sec2Time($duration);
		$videoDuration = ($duration['hours'] > 0) ? $duration['hours'].':' : '';
		$videoDuration .= ($duration['minutes'] > 0) ? $duration['minutes'].':' : '0:';
		$videoDuration .= str_pad($duration['seconds'], 2, '0', STR_PAD_LEFT);
		return $videoDuration;
	}
	
	/**
	 * Check if curl is installed
	 * @param $duration
	 * @return $videoDuration;
	 */
	public static function isCurlInstalled() {
		$installed = (in_array ('curl', get_loaded_extensions())) ? true : false;
	}
}
?>