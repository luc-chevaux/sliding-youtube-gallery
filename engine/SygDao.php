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
	private $sqlDeleteStyleById = SygConstant::SQL_DELETE_STYLE_BY_ID;
	private $sqlCountGalleries = SygConstant::SQL_COUNT_QUERY;
	private $sqlCountStyles = SygConstant::SQL_COUNT_QUERY;
	private $sqlCreateTable12X = SygConstant::SQL_CREATE_TABLE_1_2_X;
	private $sqlCreateTableStyles13x = SygConstant::SQL_CREATE_TABLE_STYLES_1_3_X;
	private $sqlCreateTableGalleries13x = SygConstant::SQL_CREATE_TABLE_GALLERIES_1_3_X;
	private $sqlCopyTable = SygConstant::SQL_COPY_TABLE;
	private $sqlCopyData = SygConstant::SQL_COPY_DATA;
	private $sqlCheckTableExist = SygConstant::SQL_CHECK_TABLE_EXIST;
	private $sqlRemoveTable = SygConstant::SQL_REMOVE_TABLE;
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
	public function getAllSygGalleries($output_type = 'OBJECT', $start = 0, $per_page = SygConstant::SYG_CONFIG_NUMBER_OF_RECORDS_DISPLAYED) {
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
	 * @return dbDelta($query)
	 */
	public function createTable12x() {
		$query = $this->db->prepare(sprintf($this->sqlCreateTable12X, $this->galleries_table_name));
		// run the dbDelta function and return its values
		return dbDelta($query);
	}
	
	/**
	 * @name createTableGallery13x
	 * @category Create table DDL, switch version from 1.2.x to 1.3.x
	 * @since 1.3.0
	 * @return dbDelta($query)
	 */
	public function createTableGalleries13x() {
		$query = $this->db->prepare(sprintf($this->sqlCreateTableGalleries13x, $this->galleries_table_name)); // @todo autoincrement issue
		// run the dbDelta function and return its values
		return dbDelta($query);
	}
	
	/**
	 * @name createTableStyles13x
	 * @category Create table DDL, switch version from 1.2.x to 1.3.x
	 * @since 1.3.0
	 * @return dbDelta($query)
	 */
	public function createTableStyles13x() {
		$query = $this->db->prepare(sprintf($this->sqlCreateTableStyles13x, $this->styles_table_name)); // @todo autoincrement issue
		// run the dbDelta function and return its values
		return dbDelta($query);
	}
	
	/**
	 * @name parseOldData
	 * @category parse old data
	 * @since 1.3.0
	 * @param 
	 * @return dbDelta($query)
	 */
	public function parseOldData($installed_ver, $target_ver) {
		if (!$installed_ver){
			// we're updating from version 1.0.1
			
			// get the table name
			$syg_table_name = $wpdb->prefix . "syg";
			
			$syg_youtube_username = get_option('syg_youtube_username');
			$syg_youtube_videoformat = get_option('syg_youtube_videoformat');
			$syg_youtube_maxvideocount = get_option('syg_youtube_maxvideocount');
			$syg_thumbnail_height = get_option('syg_thumbnail_height');
			$syg_thumbnail_width = get_option('syg_thumbnail_width');
			$syg_thumbnail_bordersize = get_option('syg_thumbnail_bordersize');
			$syg_thumbnail_bordercolor = get_option('syg_thumbnail_bordercolor');
			$syg_thumbnail_borderradius = get_option('syg_thumbnail_borderradius');
			$syg_thumbnail_distance = get_option('syg_thumbnail_distance');
			$syg_thumbnail_overlaysize = get_option('syg_thumbnail_overlaysize');
			$syg_thumbnail_image = get_option('syg_thumbnail_image');
			$syg_thumbnail_buttonopacity = get_option('syg_thumbnail_buttonopacity');
			$syg_description_width = get_option('syg_description_width');
			$syg_description_fontsize = get_option('syg_description_fontsize');
			$syg_description_fontcolor = get_option('syg_description_fontcolor');
			$syg_description_show = get_option('syg_description_show');
			$syg_description_showduration = get_option('syg_description_showduration');
			$syg_description_showtags = get_option('syg_description_showtags');
			$syg_description_showratings = get_option('syg_description_showratings');
			$syg_description_showcategories = get_option('syg_description_showcategories');
			$syg_box_width = get_option('syg_box_width');
			$syg_box_background = get_option('syg_box_background');
			$syg_box_radius = get_option('syg_box_radius');
			$syg_box_padding = get_option('syg_box_padding');
			
			//$this->sygDao->;
			
			$wpdb->insert($syg_table_name,
					array('syg_box_background' => $syg_box_background,
							'syg_box_padding' => $syg_box_padding,
							'syg_box_radius' => $syg_box_radius,
							'syg_box_width' => $syg_box_width,
							'syg_description_fontcolor' => $syg_description_fontcolor,
							'syg_description_fontsize' => $syg_description_fontsize,
							'syg_description_show' => $syg_description_show,
							'syg_description_showcategories' => $syg_description_showcategories,
							'syg_description_showduration' => $syg_description_showduration,
							'syg_description_showratings' => $syg_description_showratings,
							'syg_description_showtags' => $syg_description_showtags,
							'syg_description_width' => $syg_description_width,
							'syg_thumbnail_bordercolor' => $syg_thumbnail_bordercolor,
							'syg_thumbnail_borderradius' => $syg_thumbnail_borderradius,
							'syg_thumbnail_bordersize' => $syg_thumbnail_bordersize,
							'syg_thumbnail_buttonopacity' => $syg_thumbnail_buttonopacity,
							'syg_thumbnail_distance' => $syg_thumbnail_distance,
							'syg_thumbnail_height' => $syg_thumbnail_height,
							'syg_thumbnail_image' => $syg_thumbnail_image,
							'syg_thumbnail_width' => $syg_thumbnail_width,
							'syg_thumbnail_overlaysize' => $syg_thumbnail_overlaysize,
							'syg_youtube_maxvideocount' => $syg_youtube_maxvideocount,
							'syg_youtube_videoformat' => $syg_youtube_videoformat,
							'syg_youtube_username' => $syg_youtube_username),
							SygGallery::getRsType());
		} else if (strpos($installed_ver, '1.2.')) {
			// we're updating from version 1.2.x
			
		}
	}
	
	/**
	 * @name copyTable
	 * @category Copy table
	 * @since 1.3.0
	 * @param $from
	 * @param $to
	 * @return dbDelta($query)
	 */
	function copyTable($from, $to) {
		if($this->tableExists($to)) {
			$success = false;
		} else {
			$query = $this->db->prepare(sprintf($this->sqlCopyTable, $to, $from));
			$success = true | dbDelta($query);
			$query = $this->db->prepare(sprintf($this->sqlCopyData, $to, $from));
			$success = $success | dbDelta($query);	
		}
		 
		return $success;
	}
	
	/**
	 * @name tableExists
	 * @category Check if table exists
	 * @since 1.3.0
	 * @param $installed_ver
	 * @param $target_ver
	 * @return dbDelta($query)
	 */
	function tableExists($tablename) {
		$query = $this->db->prepare(sprintf($this->sqlCheckTableExist, DB_NAME, $tablename));
		$res = $this->db->get_results($query, 'ARRAY_A');		 
		return $this->db->num_rows == 1;
	}
	
	/**
	 * @name backupTables
	 * @category Backup tables
	 * @since 1.3.0
	 * @param $installed_ver
	 * @param $target_ver
	 * @return dbDelta($query)
	 */
	public function backupTables($installed_ver, $target_ver) {
		if (strpos($installed_ver, '1.2.')) {
			$this->copyTable($this->galleries_table_name, $this->galleries_table_name.'_OLD_V12X');
		}
	}
	
	/**
	 * @name removeTable
	 * @category Remove table
	 * @since 1.3.0
	 * @param $table
	 * @return dbDelta($query)
	 */
	public function removeTable($table) {
		$query = $this->db->prepare(sprintf($this->sqlRemoveTable, $table));
		return dbDelta($query);
	}
	
	/**
	 * @name updateVersion
	 * @category Database updater
	 * @since 1.3.0
	 * @param $installed_ver
	 * @param $target_ver
	 * @return dbDelta($query)
	 */
	public function updateVersion($installed_ver, $target_ver) {
		// we have to update database structure
		if (!$installed_ver){
			// we're updating from version 1.0.1
			
			// create styles table
			$this->createTableStyles13x();
				
			// create galleries table
			$this->createTableGalleries13x();

			// parse old data
			$this->parseOldData($installed_ver, $target_ver);
			
			// we're updating from version 1.0.1
			if (get_option('syg_youtube_username')) SygPlugin::removeOldOption();
			
		} else if (strpos($installed_ver, '1.2.')) {
			// we're updating from version 1.2.x
		
			// backup_tables
			$this->backupTables($installed_ver, $target_ver);
			
			// remove table
			$this->removeTable($this->galleries_table_name);
			
			// create styles table
			$this->createTableStyles13x();
			
			// create galleries table
			$this->createTableGalleries13x();
			
			// parse old data
			$this->parseOldData($installed_ver, $target_ver);
		}
	}
}
?>