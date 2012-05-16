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
		return $this->wpDatabaseLink->get_results($this->sqlGetAllGalleries, $output_type);
	}

	// get syg gallery by id from database
	public function getSygById($id, $output_type = 'OBJECT') {
		//return $this->wpDatabaseLink->
	}
}
?>