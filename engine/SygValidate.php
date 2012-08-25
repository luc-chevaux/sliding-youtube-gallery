<?php

/**
 * @name SygValidateException
 * @category Sliding Youtube Gallery Custom Exception Class
 * @since 1.3.0
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.3.0
 */

class SygValidateException extends Exception {

	private $problems;

	/**
	 * @name __construct
	 * @category construct SygValidateException object
	 * @since 1.3.0
	 * @param $problems
	 * @param $message
	 * @param $code
	 * @param $previous
	 */
	public function __construct($problems, $message, $code = 0,
			Exception $previous = null) {
		$this->setProblems($problems);

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
	 * @return string $this
	 */
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

	/**
	 * @name getProblems
	 * @category getters and setters
	 * @since 1.3.0
	 * @return array $problemFound
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
	/**
	 * @name validateStyle
	 * @category style validation function
	 * @since 1.3.0
	 * @param $data array of style params to validate
	 * @throws SygValidateException
	 */
	public static function validateStyle($data) {
		// unserialize data
		$data = unserialize($data);

		// validation code
		$problemFound = array();

		// syg_thumbnail_height intero

		if (!(preg_match('/^\d+$/', $data['syg_thumbnail_height']))) {
			array_push($problemFound,
					array('field' => 'syg_thumbnail_height',
							'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}

		// syg_thumbnail_width intero
		if (!(preg_match('/^\d+$/', $data['syg_thumbnail_width']))) {
			array_push($problemFound,
					array('field' => 'syg_thumbnail_width',
							'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}

		// syg_thumbnail_bordersize intero <= 10		
		if (!(preg_match('/^\d+$/', $data['syg_thumbnail_bordersize'])
				&& strval($data['syg_thumbnail_bordersize'] <= 10))) {
			if (!(preg_match('/^\d+$/', $data['syg_thumbnail_bordersize']))) {
				array_push($problemFound,
						array('field' => 'syg_thumbnail_bordersize',
								'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
			} else {
				if (!(strval($data['syg_thumbnail_bordersize']) <= 10)) {
					array_push($problemFound,
							array('field' => 'syg_thumbnail_bordersize',
									'msg' => SygConstant::BE_VALIDATE_NOT_LESS_VALUE));
				}
			}
		}

		// syg_thumbnail_borderradius intero <=20
		if (!(preg_match('/^\d+$/', $data['syg_thumbnail_borderradius'])
				&& strval($data['syg_thumbnail_borderradius'] <= 20))) {
			if (!(preg_match('/^\d+$/', $data['syg_thumbnail_bordersize']))) {
				array_push($problemFound,
						array('field' => 'syg_thumbnail_borderradius',
								'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
			} else {
				if (!(strval($data['syg_thumbnail_bordersize']) <= 20)) {
					array_push($problemFound,
							array('field' => 'syg_thumbnail_borderradius',
									'msg' => SygConstant::BE_VALIDATE_NOT_LESS_VALUE));
				}
			}
		}

		// syg_thumbnail_distance intero
		if (!(preg_match('/^\d+$/', $data['syg_thumbnail_distance']))) {
			array_push($problemFound,
					array('field' => 'syg_thumbnail_distance',
							'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}

		// syg_thumbnail_buttonopacity reale tra 0 e 1
		if (!(preg_match('/\d+(\.\d{1,2})?/',
				$data['syg_thumbnail_buttonopacity'])
				&& strval($data['syg_thumbnail_buttonopacity']) >= 0
				&& strval($data['syg_thumbnail_buttonopacity']) <= 1)) {
			if (!(preg_match('/\d+(\.\d{1,2})?/',
					$data['syg_thumbnail_buttonopacity']))) {
				array_push($problemFound,
						array('field' => 'syg_thumbnail_buttonopacity',
								'msg' => SygConstant::BE_VALIDATE_NOT_A_FLOAT));
			} else {
				if (!(strval($data['syg_thumbnail_buttonopacity']) >= 0
						&& strval($data['syg_thumbnail_buttonopacity']) <= 1)) {
					array_push($problemFound,
							array('field' => 'syg_thumbnail_buttonopacity',
									'msg' => SygConstant::BE_VALIDATE_NOT_IN_RANGE));
				}
			}
		}

		// syg_box_width intero
		if (!(preg_match('/^\d+$/', $data['syg_box_width']))) {
			array_push($problemFound,
					array('field' => 'syg_box_width',
							'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}

		// syg_box_radius intero <=20
		if (!(preg_match('/^\d+$/', $data['syg_box_radius'])
				&& (strval($data['syg_box_radius']) <= 20))) {
			if (!(preg_match('/^\d+$/', $data['syg_box_radius']))) {
				array_push($problemFound,
						array('field' => 'syg_box_radius',
								'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
			} else {
				if (!(strval($data['syg_box_radius']) <= 20)) {
					array_push($problemFound,
							array('field' => 'syg_box_radius',
									'msg' => SygConstant::BE_VALIDATE_NOT_LESS_VALUE));
				}
			}
		}

		// syg_box_padding intero
		if (!(preg_match('/^\d+$/', $data['syg_box_padding']))) {
			array_push($problemFound,
					array('field' => 'syg_box_padding',
							'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}

		// syg_description_fontsize intero
		if (!(preg_match('/^\d+$/', $data['syg_description_fontsize']))) {
			array_push($problemFound,
					array('field' => 'syg_description_fontsize',
							'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}

		if (count($problemFound) > 0) {
			// throws exception			
			$exc = new SygValidateException($problemFound,
					SygConstant::MSG_EX_STYLE_NOT_VALID,
					SygConstant::COD_EX_STYLE_NOT_VALID);
			throw $exc;
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
		// unserialize data
		$data = unserialize($data);

		// validation code
		$problemFound = array();

		// validazione congiunta syg_gallery_type e syg_youtube_src
		switch ($syg_gallery_type) {
		case "feed":
			// check youtube user
			$youtube = new SygYouTube();
			$profile = $youtube->getUserProfile($data['syg_youtube_src']);
			if (!$profile) {
				array_push($problemFound,
						array('field' => 'syg_youtube_src',
								'msg' => SygConstant::BE_VALIDATE_NOT_A_VALID_YT_USER));
			}
			break;
		case "list":
			// check for every video
			$list_of_videos = preg_split('/\r\n|\r|\n/', $data['syg_youtube_src']);
			foreach ($list_of_videos as $key => $value) {
				$list_of_videos[$key] = str_replace('v=', '',
						parse_url($value, PHP_URL_QUERY));
				$videoEntry = $this->sygYouTube
						->getVideoEntry($list_of_videos[$key]);
				if (!videoEntry) {
					array_push($problemFound,
							array('field' => 'syg_youtube_src',
									'msg' => SygConstant::BE_VALIDATE_NOT_A_VALID_VIDEO));
				}
			}
			break;
		case "playlist":
			// check for the playlist
			$playlist_id = str_replace('list=PL', '', parse_url($data['syg_youtube_src'], PHP_URL_QUERY));
			$content = json_decode(
					file_get_contents(
							'http://gdata.youtube.com/feeds/api/playlists/'
									. $playlist_id
									. '/?v=2&alt=json&feature=plcp'));
			$feed_to_object = $content->feed->entry;
			if (!$feed_to_object) {
				array_push($problemFound,
						array('field' => 'syg_youtube_src',
								'msg' => SygConstant::BE_VALIDATE_NOT_A_VALID_PLAYLIST));
			}
			break;
		default:
			break;
		}

		// syg_youtube_maxvideocount intero 
		if (!(preg_match('/^\d+$/', $data['syg_youtube_maxvideocount']))) {
			array_push($problemFound,
					array('field' => 'syg_youtube_maxvideocount',
							'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}

		// throws exception
		if (count($problemFound) > 0) {
			// throws exception
			$exc = new SygValidateException($problemFound,
					SygConstant::MSG_EX_GALLERY_NOT_VALID,
					SygConstant::COD_EX_GALLERY_NOT_VALID);
			throw $exc;
		} else {
			return true;
		}
	}

	/**
	 * @name validateSettings
	 * @category settings validation function
	 * @since 1.3.0
	 * @param $data array of settings to validate
	 * @throws SygValidateException
	 */
	public static function validateSettings($data) {
		// unserialize data
		$data = unserialize($data);
		
		// validation code
		$problemFound = array();
		
		// syg_option_numrec int
		if (!(preg_match('/^\d+$/', $data['syg_option_numrec']))) {
			array_push($problemFound,
			array('field' => 'syg_option_numrec',
			'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}
		
		// syg_option_pagenumrec int
		if (!(preg_match('/^\d+$/', $data['syg_option_pagenumrec']))) {
			array_push($problemFound,
			array('field' => 'syg_option_pagenumrec',
			'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}
		
		// syg_option_paginator_borderradius int
		if (!(preg_match('/^\d+$/', $data['syg_option_paginator_borderradius']))) {
			array_push($problemFound,
			array('field' => 'syg_option_paginator_borderradius',
			'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}
		
		// syg_option_paginator_bordersize int
		if (!(preg_match('/^\d+$/', $data['syg_option_paginator_bordersize']))) {
			array_push($problemFound,
			array('field' => 'syg_option_paginator_bordersize',
			'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}
		
		// syg_option_paginator_shadowsize int
		if (!(preg_match('/^\d+$/', $data['syg_option_paginator_shadowsize']))) {
			array_push($problemFound,
			array('field' => 'syg_option_paginator_shadowsize',
			'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}
		
		// syg_option_paginator_fontsize int
		if (!(preg_match('/^\d+$/', $data['syg_option_paginator_fontsize']))) {
			array_push($problemFound,
			array('field' => 'syg_option_paginator_fontsize',
			'msg' => SygConstant::BE_VALIDATE_NOT_A_INTEGER));
		}
		
		// throws exception
		if (count($problemFound) > 0) {
			// throws exception
			$exc = new SygValidateException($problemFound,
					SygConstant::MSG_EX_SETTING_NOT_VALID,
					SygConstant::COD_EX_SETTING_NOT_VALID);
			throw $exc;
		} else {
			return true;
		}
	}
}
?>