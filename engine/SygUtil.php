<?php

/**
 * @name SygUtil
 * @category Sliding Youtube Gallery Plugin Utility Class
 * @since 1.0.1
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.3.6
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
	
	/**
	 * @name removeDirectory
	 * @category remove a directory
	 * @since 1.4.0
	 * @param $dir
	 */
	public static function removeDirectory ($dir) {
		if($objs = @glob($dir."/*")){
			foreach($objs as $obj) {
				@is_dir($obj)? rmdirr($obj) : @unlink($obj);
			}
		}
		@rmdir($dir);
	}
	
	/**
	 * @name folder2Md5
	 * @category calculate md5 of a folder
	 * @since 1.4.0
	 * @param $folder
	 */
	public static function folder2Md5($folder) {
		$dircontent = scandir($folder);
		$ret='';
		foreach($dircontent as $filename) {
			if ($filename != '.' && $filename != '..') {
				if (filemtime($folder.$filename) === false) return false;
				$ret.=date("YmdHis", filemtime($folder.$filename)).$filename;
			}
		}
		return md5($ret);
	}
	
	/**
	 * @name cleanJsCache
	 * @category clean js cache if expired
	 * @since 1.4.0
	 * @param $folder
	 */
	public static function cleanJsCache($folder) {
		$olddate=time()-3600;
		$dircontent = scandir($folder);
		foreach($dircontent as $filename) {
			if (strlen($filename)>12 && filemtime($folder.$filename) && filemtime($folder.$filename)<$olddate) {
				unlink($folder.$filename);
			}
		}
	}
	
	/**
	 * @name writeResizedImage
	 * @category resize and crop and image 
	 * @since 1.4.0
	 * @param $image
	 * @param $filename
	 * @param $crop
	 * @param $size
	 */
	public static function writeResizedImage($image, $filename, $crop = null, $size = null) {
		$image = ImageCreateFromString(file_get_contents($image));

		if (is_resource($image) === true) {
			$x = 0;
			$y = 0;
			$width = imagesx($image);
			$height = imagesy($image);
	
			/* CROP (Aspect Ratio) Section */
			if (is_null($crop) === true) {
				$crop = array($width, $height);
			} else {
				$crop = array_filter(explode(':', $crop));
	
				if (empty($crop) === true) {
					$crop = array($width, $height);
				} else {
					if ((empty($crop[0]) === true) || (is_numeric($crop[0]) === false)) {
						$crop[0] = $crop[1];
					} else if ((empty($crop[1]) === true) || (is_numeric($crop[1]) === false)) {
						$crop[1] = $crop[0];
					}
				}
	
				$ratio = array(0 => $width / $height, 1 => $crop[0] / $crop[1]);
	
				if ($ratio[0] > $ratio[1]) {
					$width = $height * $ratio[1];
					$x = (imagesx($image) - $width) / 2;
				} else if ($ratio[0] < $ratio[1]) {
					$height = $width / $ratio[1];
					$y = (imagesy($image) - $height) / 2;
				}
			}
	
			/* Resize Section */
			if (is_null($size) === true) {
				$size = array($width, $height);
			} else {
				$size = array_filter(explode('x', $size));
	
				if (empty($size) === true) {
					$size = array(imagesx($image), imagesy($image));
				} else {
					if ((empty($size[0]) === true) || (is_numeric($size[0]) === false)) {
						$size[0] = round($size[1] * $width / $height);
					} else if ((empty($size[1]) === true) || (is_numeric($size[1]) === false)) {
						$size[1] = round($size[0] * $height / $width);
					}
				}
			}
	
			$result = ImageCreateTrueColor($size[0], $size[1]);
	
			if (is_resource($result) === true) {
				ImageSaveAlpha($result, true);
				ImageAlphaBlending($result, true);
				ImageFill($result, 0, 0, ImageColorAllocate($result, 255, 255, 255));
				ImageCopyResampled($result, $image, 0, 0, $x, $y, $size[0], $size[1], $width, $height);
	
				ImageInterlace($result, true);
				ImageJPEG($result, $filename, 90);
			}
		}
	}
	
	public static function addOverlayButton ($target, $src, SygStyle $style) {
		// If you know your originals are of type PNG.
		$image = imagecreatefromjpeg($target);
		$frame = imagecreatefrompng($src);
		
		imagealphablending($frame, TRUE);
		imagesavealpha($frame, TRUE);
		
		$x = ceil(($style->getThumbWidth()/2) - ($style->getThumbOverlaySize()/2));
		$y = ceil(($style->getThumbHeight()/2) - ($style->getThumbOverlaySize()/2));
		
		// imagecopymerge ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h , int $pct )
		imagecopy($image, $frame, $x, $y, 0, 0, $style->getThumbOverlaySize(), $style->getThumbOverlaySize());
		
		// Save the image to a file
		imagejpeg($image, $target);
	}
}
?>