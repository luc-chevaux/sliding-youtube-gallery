<?php

/**
 * @name SygDao
 * @category Sliding Youtube Gallery Data Access Object
 * @since 1.0.1
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
	private $sqlGetStyleById = SygConstant::SQL_GET_STYLE_BY_ID;
	private $sqlDeleteGalleryById = SygConstant::SQL_DELETE_GALLERY_BY_ID;	
	private $sqlCountGalleries = SygConstant::SQL_COUNT_QUERY;
	private $sqlCountStyles = SygConstant::SQL_COUNT_QUERY;
	private $sqlCreateTable12X = SygConstant::SQL_CREATE_TABLE_1_2_X;
	
	/**
	 * @name __construct
	 * @category construct SygDao object
	 * @since 1.2.5
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
	 * @name addSygGallery
	 * @category Add a syg gallery to database
	 * @since 1.2.5
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
	 * @name addSygStyle
	 * @category Add a syg style to database
	 * @since 1.2.5
	 * @param SygStyle $gallery to add
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
	 * @name updateSygGallery
	 * @category Update a syg gallery to database
	 * @since 1.2.5
	 * @param SygGallery $gallery to update
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
	 * @name updateSygStyle
	 * @category Update a syg style to database
	 * @since 1.2.5
	 * @param SygStyle $style to update
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
	 * @name deleteSygGallery
	 * @category Delete a syg gallery to database
	 * @since 1.2.5
	 * @param SygGallery $gallery to delete
	 */
	public function deleteSygGallery(SygGallery $gallery) {
		$query = $this->db->prepare(sprintf($this->sqlDeleteGalleryById, $this->galleries_table_name, $gallery->getId()));
		$this->db->query($query);
	}
	
	/**
	 * @name deleteSygStyle
	 * @category Delete a syg style to database
	 * @since 1.2.5
	 * @param SygStyle $style to delete
	 */
	public function deleteSygStyle(SygStyle $style) {
		$query = $this->db->prepare(sprintf($this->sqlDeleteStyleById, $this->styles_table_name, $style->getId()));
		$this->db->query($query);
	}

	/**
	 * @name getAllSygGallery
	 * @category Get a syg gallery list from database
	 * @since 1.2.5
	 * @param $output_type, $start, $per_page
	 * @return $galleries
	 */
	public function getAllSygGallery($output_type = 'OBJECT', $start = 0, $per_page = SygConstant::SYG_CONFIG_NUMBER_OF_RECORDS_DISPLAYED) {
		$galleries = array();
		$query = $this->db->prepare(sprintf($this->sqlGetAllGalleries, $this->galleries_table_name, $start, $per_page));
		$results = $this->db->get_results($query, $output_type);
		foreach ($results as $gallery) {
			$galleries[] = new SygGallery($gallery);
		}
		return $galleries;
	}
	
	/**
	 * @name getAllStyles
	 * @category Get a syg style list from database
	 * @since 1.2.5
	 * @param $output_type, $start, $per_page
	 * @return $styles
	 */
	public function getAllSygStyles($output_type = 'OBJECT', $start = 0, $per_page = SygConstant::SYG_CONFIG_NUMBER_OF_RECORDS_DISPLAYED) {
		$styles = array();
		$query = $this->db->prepare(sprintf($this->sqlGetAllStyles, $this->styles_table_name, $start, $per_page));
		$results = $this->db->get_results($query, $output_type);
		foreach ($results as $style) {
			$styles[] = new SygStyle($style);
		}
		return $styles;
	}

	/**
	 * @name getSygGalleryById
	 * @category Get a syg gallery from database
	 * @since 1.2.5
	 * @param $id, $output_type
	 * @return $gallery
	 */
	public function getSygGalleryById($id, $output_type = 'OBJECT') {
		$query = $this->db->prepare(sprintf($this->sqlGetGalleryById, $this->galleries_table_name, $id));
		$result = $this->db->get_row($query, $output_type);
		$gallery = new SygGallery($result);
		return $gallery;
	}
	
	/**
	 * @name getSygStyleById
	 * @category Get a syg style from database
	 * @since 1.2.5
	 * @param $id, $output_type
	 * @return $style
	 */
	public function getSygStyleById($id, $output_type = 'OBJECT') {
		$query = $this->db->prepare(sprintf($this->sqlGetStyleById, $this->styles_table_name, $id));
		$result = $this->db->get_row($query, $output_type);
		$style = new SygStyle($result);
		return $style;
	}
	
	/**
	 * @name getGalleriesCount
	 * @category Count galleries
	 * @since 1.2.5
	 * @return $count
	 */
	public function getGalleriesCount() {
		$query = $this->db->prepare(sprintf($this->sqlCountGalleries, $this->galleries_table_name));
		$count= $this->db->get_var($query, 0, 0);

		return (int)$count;
	}
	
	/**
	 * @name getStylesCount
	 * @category Count styles
	 * @since 1.2.5
	 * @return $count
	 */
	public function getStylesCount() {
		$query = $this->db->prepare(sprintf($this->sqlCountStyles, $this->styles_table_name));
		$count= $this->db->get_var($query, 0, 0);
	
		return (int)$count;
	}
	
	/**
	 * @name createTable12x
	 * @category Create table DDL, switch version from 1.0.1 to 1.2.x
	 * @since 1.2.5
	 * @return $dbDelta($query)
	 */
	public function createTable12x() {
		$query = $this->db->prepare(sprintf($this->sqlCreateTable12X, $this->galleries_table_name));
		// run the dbDelta function and return its values
		return dbDelta($query);
	}
}
?>