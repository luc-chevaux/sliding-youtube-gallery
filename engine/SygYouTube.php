<?php

global $wpdb;

class SygYouTube {
	private $wpDatabaseLink;
		
	// default constructor
	public function __construct() {
		$this->wpDatabaseLink = $wpdb;
	}
	
	
}
?>