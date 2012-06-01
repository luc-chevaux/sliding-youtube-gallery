<?php

class SygUtil {
	private static $nAspectRatio = 0.75;
	private static $wAspectRatio = 0.5625;
	
	/* function to mantain the aspect ratio normal
	 * when width has been changed
	*/
	public static function getNormalHeight($width) {
		$new_height = round($width * self::$nAspectRatio);
		return $new_height;
	}
	
	/* function to mantain the aspect ratio wide
	 * when width has been changed
	*/
	public static function getWideHeight($width) {
		$new_height = round($width * self::$wAspectRatio);
		return $new_height;
	}
	
	/*
	 * function to extract type
	*/
	public static function extractType($width) {
		$start = 0;
		$stop = strlen($width)-1;
		$type = substr($width, $stop, 1);
		return $type;
	}
	
	/*
	 * function to extract width
	*/
	public static function extractWidth($width) {
		$start = 0;
		$stop = strlen($width)-1;
		$width = substr($width, $start, $stop);
		return $width;
	}
	
	/*
	 * convert second to time
	*/
	private static function Sec2Time($time) {
		if(is_numeric($time)) {
			$value = array(
					"years" => 0, "days" => 0, "hours" => 0,
					"minutes" => 0, "seconds" => 0,
			);
			if($time >= 31556926){
				$value["years"] = floor($time/31556926);
				$time = ($time%31556926);
			}
			if($time >= 86400){
				$value["days"] = floor($time/86400);
				$time = ($time%86400);
			}
			if($time >= 3600){
				$value["hours"] = floor($time/3600);
				$time = ($time%3600);
			}
			if($time >= 60){
				$value["minutes"] = floor($time/60);
				$time = ($time%60);
			}
			$value["seconds"] = floor($time);
			return (array) $value;
		}else{
			return (bool) FALSE;
		}
	}
	
	public static function formatDuration ($duration = null) {
		$duration = self::Sec2Time($duration);
		$videoDuration .= ($duration['hours'] > 0) ? $duration['hours'].':' : '';
		$videoDuration .= ($duration['minutes'] > 0) ? $duration['minutes'].':' : '0:';
		$videoDuration .= str_pad($duration['seconds'], 2, '0', STR_PAD_LEFT);
		return $videoDuration;
	}
}
?>