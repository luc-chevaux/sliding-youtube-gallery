<?php
class SygDao {
	private $db;
	private $table_name;

	// query
	private $sqlGetAllGalleries = 'SELECT id, syg_youtube_username, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_thumbnail_height, syg_thumbnail_width, syg_thumbnail_bordersize, syg_thumbnail_bordercolor, syg_thumbnail_borderradius, syg_thumbnail_distance, syg_thumbnail_overlaysize, syg_thumbnail_image, syg_thumbnail_buttonopacity, syg_description_width, syg_description_fontsize, syg_description_fontcolor, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_box_width, syg_box_background, syg_box_radius, syg_box_padding FROM wp_syg';
	private $sqlGetGalleryById = 'SELECT id, syg_youtube_username, syg_youtube_videoformat, syg_youtube_maxvideocount, syg_thumbnail_height, syg_thumbnail_width, syg_thumbnail_bordersize, syg_thumbnail_bordercolor, syg_thumbnail_borderradius, syg_thumbnail_distance, syg_thumbnail_overlaysize, syg_thumbnail_image, syg_thumbnail_buttonopacity, syg_description_width, syg_description_fontsize, syg_description_fontcolor, syg_description_show, syg_description_showduration, syg_description_showtags, syg_description_showratings, syg_description_showcategories, syg_box_width, syg_box_background, syg_box_radius, syg_box_padding FROM wp_syg WHERE id=%d';

	/* Default constructor
	 * @param null
	 * @return null
	 */
	public function __construct() {
		global $wpdb;
		$this->db = $wpdb;
		$this->table_name = $this->db->prefix . "syg";	
	}
	
	/* Add a syg gallery to database
	 * @param null
	 * @return null
	 */
	public function addSyg(SygGallery $syg) {
		$this->db->insert($this->table_name, 
					$syg->toDto(), 
					$syg->()
					);
		
		$wpdb->insert_id;
	}

	/* Update a syg gallery to database
	 * @param null
	 * @return null
	 */	
	public function updateSyg() {

	}

	/* Delete a syg gallery to database
	 * @param null
	 * @return null
	 */	
	public function deleteSyg() {

	}

	/* Get all syg gallery from database
	 * @param null
	 * @return null
	 */
	public function getAllSyg($output_type = 'OBJECT') {
		$galleries = array();
		$results = $this->db->get_results($this->sqlGetAllGalleries, $output_type);
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
		$query = $this->db->prepare($this->sqlGetGalleryById, $id);
		$result = $this->db->get_row($query, $output_type);
		$gallery = new SygGallery($result);
		return $gallery;
	}
}
?>