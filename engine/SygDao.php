<?php

/**
 * Sliding Youtube Gallery Data Access Object
 *
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2.5
 */

require_once (ABSPATH . 'wp-admin/includes/plugin.php');

class SygDao {
	private $db;
	private $galleries_table_name ;
	private $styles_table_name ;

	// Query used in DAO
	private $sqlGetAllGalleries = SygConstant::SQL_GET_ALL_GALLERIES;
	private $sqlGetAllStyles = SygConstant::SQL_GET_ALL_STYLES;
	private $sqlGetGalleryById = SygConstant::SQL_GET_GALLERY_BY_ID;
	private $sqlDeleteGalleryById = SygConstant::SQL_DELETE_GALLERY_BY_ID;	
	private $sqlCountGalleries = SygConstant::SQL_COUNT_QUERY;
	private $sqlCountStyles = SygConstant::SQL_COUNT_QUERY;
	private $sqlCreateTable12X = SygConstant::SQL_CREATE_TABLE_1_2_X;
	
	/**
	 * Default constructor
	 * @return null
	 */
	public function __construct() {
		// get wordpress dbms linked
		global $wpdb;
		$this->db = $wpdb;
		
		// set table name
		$this->galleries_table_name = $this->db->prefix . "syg";
		$this->styles_table_name = $this->db->prefix . "syg_styles";
	}
	
	/**
	 * Add a syg gallery to database
	 * @param SygGallery $gallery to add
	 * @return $id latest inserted id
	 */
	public function addSygGallery(SygGallery $gallery) {
		$this->db->insert($this->galleries_table_name, 
					$gallery->toDto(), 
					$gallery->getRsType()
					);
		$id = $this->db->insert_id;
		return $id;
	}
	
	/**
	 * Add a syg style to database
	 * @param SygStyle $style to add
	 * @return $id latest inserted id
	 */
	public function addSygStyle(SygStyle $style) {
		$this->db->insert($this->styles_table_name,
				$style->toDto(),
				$style->getRsType()
		);
		$id = $this->db->insert_id;
		return $id;
	}

	/**
	 * Update a syg gallery to database
	 * @param SygGallery $syg to update
	 * @return null
	 */	
	public function updateSygGallery(SygGallery $gallery) {
		$this->db->update(
				$this->galleries_table_name,
				$gallery->toDto(),
				array('id' => $gallery->getId()),
				$gallery->getRsType(),
				array('%d')
		);
	}
	
	/**
	 * Update a syg style to database
	 * @param SygStyle $style to update
	 * @return null
	 */
	public function updateSygStyle(SygStyle $style) {
		$this->db->update(
				$this->styles_table_name,
				$style->toDto(),
				array('id' => $style->getId()),
				$style->getRsType(),
				array('%d')
		);
	}

	/**
	 * Delete a syg gallery from database
	 * @param SygGallery $syg to delete
	 * @return null
	 */	
	public function deleteSygGallery(SygGallery $gallery) {
		$query = $this->db->prepare(sprintf($this->sqlDeleteGalleryById, $this->galleries_table_name, $gallery->getId()));
		$this->db->query($query);
	}
	
	/**
	 * Delete a syg style from database
	 * @param SygStyle $style to delete
	 * @return null
	 */
	public function deleteSygStyle(SygStyle $style) {
		$query = $this->db->prepare(sprintf($this->sqlDeleteStyleById, $this->styles_table_name, $style->getId()));
		$this->db->query($query);
	}

	/**
	 * Get all syg gallery from database
	 * @param $output_type
	 * @return $galleries
	 */
	public function getAllSyg($output_type = 'OBJECT', $start = 0, $per_page = SygConstant::SYG_CONFIG_NUMBER_OF_RECORDS_DISPLAYED) {
		$galleries = array();
		$query = $this->db->prepare(sprintf($this->sqlGetAllGalleries, $this->galleries_table_name, $start, $per_page));
		$results = $this->db->get_results($query, $output_type);
		foreach ($results as $gallery) {
			$galleries[] = new SygGallery($gallery);
		}
		return $galleries;
	}
	
	/**
	 * Get all syg styles from database
	 * @param $output_type
	 * @return $styles
	 */
	public function getAllStyles($output_type = 'OBJECT', $start = 0, $per_page = SygConstant::SYG_CONFIG_NUMBER_OF_RECORDS_DISPLAYED) {
		$styles = array();
		$query = $this->db->prepare(sprintf($this->sqlGetAllStyles, $this->styles_table_name, $start, $per_page));
		$results = $this->db->get_results($query, $output_type);
		foreach ($results as $style) {
			$styles[] = new SygStyle($style);
		}
		return $styles;
	}

	/**
	 * Get a syg gallery object from database
	 * @param $id
	 * @param $output_type
	 * @return $gallery
	 */
	public function getSygGalleryById($id, $output_type = 'OBJECT') {
		$query = $this->db->prepare(sprintf($this->sqlGetGalleryById, $this->galleries_table_name, $id));
		$result = $this->db->get_row($query, $output_type);
		$gallery = new SygGallery($result);
		return $gallery;
	}
	
	/**
	 * Get a syg style object from database
	 * @param $id
	 * @param $output_type
	 * @return $style
	 */
	public function getSygStyleById($id, $output_type = 'OBJECT') {
		$query = $this->db->prepare(sprintf($this->sqlGetStyleById, $this->styles_table_name, $id));
		$result = $this->db->get_row($query, $output_type);
		$style = new SygStyle($result);
		return $style;
	}
	
	/**
	 * Get syg count from database
	 * @return $count
	 */
	public function getGalleriesCount() {
		$query = $this->db->prepare(sprintf($this->sqlCountGalleries, $this->galleries_table_name));
		$count= $this->db->get_var($query, 0, 0);

		return (int)$count;
	}
	
	/**
	 * Get syg count from database
	 * @return $count
	 */
	public function getStylesCount() {
		$query = $this->db->prepare(sprintf($this->sqlCountStyles, $this->styles_table_name));
		$count= $this->db->get_var($query, 0, 0);
	
		return (int)$count;
	}
	
	/**
	 * 
	 * 
	 */
	public function createTable12x() {
		$query = $this->db->prepare(sprintf($this->sqlCreateTable12X, $this->galleries_table_name));
		// run the dbDelta function and return its values
		return dbDelta($query);
	}
}
?>