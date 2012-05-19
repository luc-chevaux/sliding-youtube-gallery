<?php

class SygDao {
	private $wpDatabaseLink;
	
	// query
	private $sqlGetAllGalleries = 'SELECT id, syg_youtube_username, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_thumbnail_height, syg_thumbnail_width, syg_thumbnail_bordersize, syg_thumbnail_bordercolor, syg_thumbnail_borderradius, syg_thumbnail_distance, syg_thumbnail_overlaysize, syg_thumbnail_image, syg_thumbnail_buttonopacity, syg_description_width, syg_description_fontsize, syg_description_fontcolor, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_box_width, syg_box_background, syg_box_radius, syg_box_padding FROM wp_syg';
	
	// default constructor
	public function __construct() {
		global $wpdb;
		$this->wpDatabaseLink = $wpdb;
	}
	
	// add a syg gallery to database
	public function addSyg() {
		
	}

	// update a syg gallery to database	
	public function updateSyg() {
	
	}
	
	// delete a syg gallery to database	
	public function deleteSyg() {
	
	}
	
	// get all syg gallery from database
	public function getAllSyg($output_type = 'OBJECT') {
		$galleries = array();
		$data = $this->wpDatabaseLink->get_results($this->sqlGetAllGalleries, $output_type);
		foreach ($data as $gallery) {
			$galleries[] = $this->freeze($gallery);
		}
		
		return $galleries;
	}

	// get syg gallery by id from database
	public function getSygById($id, $output_type = 'OBJECT') {
		//return $this->wpDatabaseLink->
	}
	
	private function freeze($result) {
		$gallery = new SygGallery();
		
		$gallery->setBoxBackground($result->syg_box_background);
		$gallery->setBoxPadding($result->syg_box_padding);
		$gallery->setBoxRadius($result->syg_box_radius);
		$gallery->setBoxWidth($result->syg_box_width);
		
		$gallery->setDefaultLeft($defaultLeft);
		$gallery->setDefaultTop($defaultTop);
		
		$gallery->setDescFontColor($result->syg_description_fontcolor);
		$gallery->setDescFontSize($result->syg_description_fontsize);
		$gallery->setDescShow($result->syg_description_show);
		$gallery->setDescShowCategories($result->syg_description_showcategories);
		$gallery->setDescShowDuration($result->syg_description_showduration);
		$gallery->setDescShowRatings($result->syg_description_showratings);
		$gallery->setDescShowTags($result->syg_description_showtags);
		$gallery->setDescWidth($result->syg_description_width);
		
		$gallery->setPercOccH($percOccH);
		$gallery->setPercOccW($percOccW);
		
		$gallery->setThumbBorderColor($result->syg_thumbnail_bordercolor);
		$gallery->setThumbBorderRadius($result->syg_thumbnail_borderradius);
		$gallery->setThumbBorderSize($result->syg_thumbnail_bordersize);
		$gallery->setThumbButtonOpacity($result->syg_thumbnail_buttonopacity);
		$gallery->setThumbDistance($result->syg_thumbnail_distance);
		$gallery->setThumbHeight($result->syg_thumbnail_height);
		$gallery->setThumbImage($result->syg_thumbnail_image);
		
		$gallery->setThumbLeft($result->);
		$gallery->setThumbOverlaySize($result->syg_thumbnail_overlaysize);
		$gallery->setThumbTop($result->);
		
		$gallery->setThumbWidth($result->syg_thumbnail_width);
		$gallery->setYtMaxVideoCount($result->syg_youtube_maxvideocount);
		$gallery->setYtVideoFormat($result->syg_youtube_videoformat);
		$gallery->setYtUsername($result->syg_youtube_username);
		$gallery->setId($result->id);
	}
	
	private function unFreeze($gallery) {
		
		
		return $result;
	}
}
?>