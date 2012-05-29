<?php
class SygDao {
	private $db;
	private $table_name ;

	// Query used in DAO
	private $sqlGetAllGalleries = SygConstant::SQL_GET_ALL_GALLERIES;
	private $sqlGetGalleryById = SygConstant::SQL_GET_GALLERY_BY_ID;
	private $sqlDeleteGalleryById = SygConstant::SQL_DELETE_GALLERY_BY_ID;	
	
	/*$wpdb->prepare(
			"
			
			WHERE post_id = %d
			AND meta_key = %s
			",
			13, 'gargle'
	)*/
	
	/* Default constructor
	 * @param null
	 * @return null
	 */
	public function __construct() {
		global $wpdb;
		
		// get wordpress dbms linked
		$this->db = $wpdb;
		
		// set table name
		$this->table_name = $this->db->prefix . "syg";
	}
	
	/* Add a syg gallery to database
	 * @param SygGallery type to add
	 * @return latest inserted id
	 */
	public function addSyg(SygGallery $syg) {
		$this->db->insert($this->table_name, 
					$syg->toDto(), 
					$syg->getRsType()
					);
		
		return $this->db->insert_id;
	}

	/* Update a syg gallery to database
	 * @param SygGallery type to update
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

	/* Delete a syg gallery to database
	 * @param null
	 * @return null
	 */	
	public function deleteSyg(SygGallery $syg) {
		$query = $this->db->prepare(sprintf($this->sqlDeleteGalleryById, $this->table_name, $id));
		$this->db->query($query);
	}

	/* Get all syg gallery from database
	 * @param null
	 * @return null
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

	/* Add a syg gallery to database
	 * @param null
	 * @return null
	 */
	public function getSygById($id, $output_type = 'OBJECT') {
		$query = $this->db->prepare(sprintf($this->sqlGetGalleryById, $this->table_name, $id));
		$result = $this->db->get_row($query, $output_type);
		$gallery = new SygGallery($result);
		return $gallery;
	}
}
?>