<?php

/**
 * Sliding Youtube Gallery Data Access Object
 *
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2
 */

class SygDao {
	private $db;
	private $table_name ;

	// Query used in DAO
	private $sqlGetAllGalleries = SygConstant::SQL_GET_ALL_GALLERIES;
	private $sqlGetGalleryById = SygConstant::SQL_GET_GALLERY_BY_ID;
	private $sqlDeleteGalleryById = SygConstant::SQL_DELETE_GALLERY_BY_ID;	
	
	/**
	 * Default constructor
	 * @return null
	 */
	public function __construct() {
		// get wordpress dbms linked
		global $wpdb;
		$this->db = $wpdb;
		
		// set table name
		$this->table_name = $this->db->prefix . "syg";
	}
	
	/**
	 * Add a syg gallery to database
	 * @param SygGallery $syg to add
	 * @return $id latest inserted id
	 */
	public function addSyg(SygGallery $syg) {
		$this->db->insert($this->table_name, 
					$syg->toDto(), 
					$syg->getRsType()
					);
		$id = $this->db->insert_id;
		return $id;
	}

	/**
	 * Update a syg gallery to database
	 * @param SygGallery $syg to update
	 * @return null
	 */	
	public function updateSyg(SygGallery $syg) {
		$this->db->update(
				$this->table_name,
				$syg->toDto(),
				array('id' => $syg->getId()),
				$syg->getRsType(),
				array('%d')
		);
	}

	/**
	 * Delete a syg gallery from database
	 * @param SygGallery $syg to delete
	 * @return null
	 */	
	public function deleteSyg(SygGallery $syg) {
		$query = $this->db->prepare(sprintf($this->sqlDeleteGalleryById, $this->table_name, $id));
		$this->db->query($query);
	}

	/**
	 * Get all syg gallery from database
	 * @param $output_type
	 * @return $galleries
	 */
	public function getAllSyg($output_type = 'OBJECT') {
		$galleries = array();
		$query = $this->db->prepare(sprintf($this->sqlGetAllGalleries, $this->table_name));
		$results = $this->db->get_results($query, $output_type);
		foreach ($results as $gallery) {
			$galleries[] = new SygGallery($gallery);
		}
		return $galleries;
	}

	/**
	 * Get a syg gallery object from database
	 * @param $id
	 * @param $output_type
	 * @return $gallery
	 */
	public function getSygById($id, $output_type = 'OBJECT') {
		$query = $this->db->prepare(sprintf($this->sqlGetGalleryById, $this->table_name, $id));
		$result = $this->db->get_row($query, $output_type);
		$gallery = new SygGallery($result);
		return $gallery;
	}
}
?>