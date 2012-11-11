<?php

/**
 * @name SygDao
 * @category Sliding Youtube Gallery Data Access Object
 * @since 1.0.1
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.3.6
 */

require_once (ABSPATH . 'wp-admin/includes/plugin.php');

class SygDao {
	private $db;
	private $galleries_table_name ;
	private $styles_table_name ;

	// Query used in DAO
	private $sqlGetAllGalleries = SygConstant::SQL_GET_ALL_GALLERIES;
	// transitory query
	private $sqlGetAllGalleries12X = SygConstant::SQL_GET_ALL_GALLERIES_1_2_X;
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
	private $sqlCheckAutoIncrement = SygConstant::SQL_CHECK_AUTO_INCREMENT;
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
	 * @return int $id latest inserted id
	 */
	public function addSygGallery(SygGallery $gallery) {
		// sanitize youtube source
		$gallery->sanitizeYouTubeSource();
		
		// execute the insert
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
	 * @param SygStyle $style to add
	 * @return int $id latest inserted id
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
		// sanitize youtube source
		$gallery->sanitizeYouTubeSource();
		
		// execute the update
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
	 * @param $output_type
	 * @param $start
	 * @param $per_page
	 * @return array of $galleries
	 */
	public function getAllSygGalleries($output_type = 'OBJECT', $start = 0, $per_page = PHP_INT_MAX) {
		$galleries = array();
		$query = $this->db->prepare(sprintf($this->sqlGetAllGalleries, $this->galleries_table_name, $start, $per_page));
		$results = $this->db->get_results($query, $output_type);
		foreach ($results as $gallery) {
			$galleries[] = new SygGallery($gallery);
		}
		return $galleries;
	}
	
	/**
	 * @name getAllSygGallery12X
	 * @category Get a syg gallery list from database
	 * @since 1.2.5
	 * @param $output_type
	 * @param $start
	 * @param $per_page
	 * @return array of $galleries
	 */
	public function getAllSygGalleries12X($output_type = 'OBJECT', $start = 0, $per_page = PHP_INT_MAX) {
		$galleries = array();
		$query = $this->db->prepare(sprintf($this->sqlGetAllGalleries12X, $this->galleries_table_name.'_OLD_V12X', $start, $per_page));
		$results = $this->db->get_results($query, $output_type);
		return $results;
	}
	
	/**
	 * @name getAllStyles
	 * @category Get a syg style list from database
	 * @since 1.2.5
	 * @param $output_type
	 * @param $start
	 * @param $per_page
	 * @return array of $styles
	 */
	public function getAllSygStyles($output_type = 'OBJECT', $start = 0, $per_page = PHP_INT_MAX) {
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
	 * @param $id
	 * @param $output_type
	 * @throws SygGalleryNotFoundException
	 * @return $gallery
	 */
	public function getSygGalleryById($id, $output_type = 'OBJECT') {
		$query = $this->db->prepare(sprintf($this->sqlGetGalleryById, $this->galleries_table_name, $id));
		$result = $this->db->get_row($query, $output_type);
		if ($result) {
			$gallery = new SygGallery($result);
			return $gallery;
		} else {
			throw new SygGalleryNotFoundException(SygConstant::MSG_EX_GALLERY_NOT_FOUND);
		}
	}
	
	/**
	 * @name getSygStyleById
	 * @category Get a syg style from database
	 * @since 1.2.5
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
	 * @name getGalleriesCount
	 * @category Count galleries
	 * @since 1.2.5
	 * @return int $count
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
	 * @return int $count
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
		if ($this->tableExists($this->galleries_table_name.'_OLD_V12X')) {
			// check autoincrement, version >= 1.2.5
			$query = $this->db->prepare(sprintf($this->sqlCheckAutoIncrement, DB_NAME, $this->galleries_table_name.'_OLD_V12X'));
			$autoincrement = (int) $this->db->get_var($query, 0, 0);
		} else {
			$autoincrement = 1;
		}
		
		$query = $this->db->prepare(sprintf($this->sqlCreateTableGalleries13x, $this->galleries_table_name, $autoincrement));
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
		$query = $this->db->prepare(sprintf($this->sqlCreateTableStyles13x, $this->styles_table_name));
		// run the dbDelta function and return its values
		return dbDelta($query);
	}
	
	/**
	 * @name parseOldData
	 * @category parse old data
	 * @since 1.3.0
	 * @param $installed_ver
	 * @param $target_ver
	 */
	public function updateData($installed_ver, $target_ver) {
		if (!$installed_ver) {
			// we're updating from version 1.0.1			
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
			
			// create and separate a style
			$style = new SygStyle();
			
			// style name
			$style->setStyleName('Custom Style');
			$style->setStyleDetails('This style has been generated automatically from your latest update');
			
			// box option values
			$style->setBoxBackground(($syg_box_background) ? $syg_box_background : SygConstant::SYG_BOX_DEFAULT_BACKGROUND_COLOR);
			$style->setBoxPadding($syg_box_padding);
			$style->setBoxRadius($syg_box_radius);
			$style->setBoxWidth($syg_box_width);
			
			// description option values
			$style->setDescFontColor(($syg_description_fontcolor) ? ($syg_description_fontcolor) : SygConstant::SYG_DESC_DEFAULT_FONT_COLOR);
			$style->setDescFontSize($syg_description_fontsize);
			$style->setDescWidth(($syg_description_width > 0) ? $syg_description_width : SygConstant::SYG_THUMB_DEFAULT_WIDTH);
			
			// thumbnail option values
			$style->setThumbBorderColor(($syg_thumbnail_bordercolor) ? $syg_thumbnail_bordercolor : SygConstant::SYG_THUMB_DEFAULT_BORDER_COLOR);
			$style->setThumbBorderRadius($syg_thumbnail_borderradius);
			$style->setThumbBorderSize($syg_thumbnail_bordersize);
			$style->setThumbButtonOpacity($syg_thumbnail_buttonopacity);
			$style->setThumbDistance($syg_thumbnail_distance);
			$style->setThumbHeight(($syg_thumbnail_height > 0) ? $syg_thumbnail_height : SygConstant::SYG_THUMB_DEFAULT_HEIGHT);
			$style->setThumbImage((!empty($syg_thumbnail_image)) ? $syg_thumbnail_image : SygConstant::SYG_THUMB_DEFAULT_IMAGE);
			$style->setThumbWidth(($syg_thumbnail_width > 0) ? $syg_thumbnail_width : SygConstant::SYG_THUMB_DEFAULT_WIDTH);
			$style->setThumbOverlaySize($syg_thumbnail_overlaysize);
			
			// store style into db
			$style_id = $this->addSygStyle($style);
			
			// create the gallery and add into database
			$gallery = new SygGallery();
			
			// gallery name
			$gallery->setGalleryName($syg_youtube_username);
			$gallery->setGalleryDetails('This gallery has been generated automatically from your latest update');
			
			// youtube option values
			$gallery->setYtMaxVideoCount($syg_youtube_maxvideocount);
			$gallery->setYtVideoFormat($syg_youtube_videoformat);
			$gallery->setYtDisableRelatedVideo(true);
			$gallery->setYtSrc($syg_youtube_username);
			
			// set youtube user profile
			$gallery->setGalleryType('feed');
			
			// description option values
			$gallery->setDescShow($syg_description_show);
			$gallery->setDescShowCategories($syg_description_showcategories);
			$gallery->setDescShowDuration($syg_description_showduration);
			$gallery->setDescShowRatings($syg_description_showratings);
			$gallery->setDescShowTags($syg_description_showtags);
			
			// set style id
			$gallery->setStyleId($style_id);			
			
			// store gallery into db
			$gallery_id = $this->addSygGallery($gallery);
		} else if (strpos($installed_ver, '1.2.') == 0) {
			// we're updating from version 1.2.x
			$galleries = $this->getAllSygGalleries12X('OBJECT', 0, 100000);
			
			foreach ($galleries as $gallery) {
				// create and separate a style
				$style = new SygStyle();
					
				// style name
				$style->setStyleName($gallery->syg_youtube_username . ' Custom Style');
				$style->setStyleDetails('This style has been generated automatically from your latest update');
					
				// box option values
				$style->setBoxBackground(($gallery->syg_box_background) ? $gallery->syg_box_background : SygConstant::SYG_BOX_DEFAULT_BACKGROUND_COLOR);
				$style->setBoxPadding($gallery->syg_box_padding);
				$style->setBoxRadius($gallery->syg_box_radius);
				$style->setBoxWidth($gallery->syg_box_width);
					
				// description option values
				$style->setDescFontColor(($gallery->syg_description_fontcolor) ? ($gallery->syg_description_fontcolor) : SygConstant::SYG_DESC_DEFAULT_FONT_COLOR);
				$style->setDescFontSize($gallery->syg_description_fontsize);
				$style->setDescWidth(($gallery->syg_description_width > 0) ? $gallery->syg_description_width : SygConstant::SYG_THUMB_DEFAULT_WIDTH);
					
				// thumbnail option values
				$style->setThumbBorderColor(($gallery->syg_thumbnail_bordercolor) ? $gallery->syg_thumbnail_bordercolor : SygConstant::SYG_THUMB_DEFAULT_BORDER_COLOR);
				$style->setThumbBorderRadius($gallery->syg_thumbnail_borderradius);
				$style->setThumbBorderSize($gallery->syg_thumbnail_bordersize);
				$style->setThumbButtonOpacity($gallery->syg_thumbnail_buttonopacity);
				$style->setThumbDistance($gallery->syg_thumbnail_distance);
				$style->setThumbHeight(($gallery->syg_thumbnail_height > 0) ? $gallery->syg_thumbnail_height : SygConstant::SYG_THUMB_DEFAULT_HEIGHT);
				$style->setThumbImage((!empty($gallery->syg_thumbnail_image)) ? $gallery->syg_thumbnail_image : SygConstant::SYG_THUMB_DEFAULT_IMAGE);
				$style->setThumbWidth(($gallery->syg_thumbnail_width > 0) ? $gallery->syg_thumbnail_width : SygConstant::SYG_THUMB_DEFAULT_WIDTH);
				$style->setThumbOverlaySize($gallery->syg_thumbnail_overlaysize);
					
				// store style into db
				$style_id = $this->addSygStyle($style);
				
				// create the gallery and add into database
				$galleryOut = new SygGallery();
					
				// gallery name
				$galleryOut->setGalleryName($gallery->syg_youtube_username);
				$galleryOut->setGalleryDetails($gallery->syg_youtube_username.' gallery');
					
				// youtube option values
				$galleryOut->setYtMaxVideoCount($gallery->syg_youtube_maxvideocount);
				$galleryOut->setYtVideoFormat($gallery->syg_youtube_videoformat);
				$galleryOut->setYtDisableRelatedVideo(true);
				$galleryOut->setYtSrc($gallery->syg_youtube_username);
					
				// set youtube user profile
				$galleryOut->setGalleryType('feed');
					
				// description option values
				$galleryOut->setDescShow($gallery->syg_description_show);
				$galleryOut->setDescShowCategories($gallery->syg_description_showcategories);
				$galleryOut->setDescShowDuration($gallery->syg_description_showduration);
				$galleryOut->setDescShowRatings($gallery->syg_description_showratings);
				$galleryOut->setDescShowTags($gallery->syg_description_showtags);
					
				// set style id
				$galleryOut->setStyleId($style_id);
					
				// store gallery into db
				$gallery_id = $this->addSygGallery($galleryOut);
			}
		}
	}
	
	/**
	 * @name copyTable
	 * @category Copy table
	 * @since 1.3.0
	 * @param $from
	 * @param $to
	 * @return bool $success
	 */
	function copyTable($from, $to) {
		if($this->tableExists($to)) {
			$success = false;
		} else {
			// copy table structure
			$query = $this->db->prepare(sprintf($this->sqlCopyTable, $to, $from));
			$success = true | dbDelta($query);
			
			// copy table data
			$query = $this->db->prepare(sprintf($this->sqlCopyData, $to, $from));
			$success = $success | dbDelta($query);
		}
		 
		return $success;
	}
	
	/**
	 * @name tableExists
	 * @category Check if table exists
	 * @since 1.3.0
	 * @param $tablename
	 * @return bool $exist
	 */
	function tableExists($tablename) {
		$query = $this->db->prepare(sprintf($this->sqlCheckTableExist, DB_NAME, $tablename));
		$exist= $this->db->get_var($query, 0, 0);
		$exist = (int) $exist;
		return $exist == 1;
	}
	
	/**
	 * @name backupTables
	 * @category Backup tables
	 * @since 1.3.0
	 * @param $installed_ver
	 * @param $target_ver
	 */
	public function backupTables($installed_ver, $target_ver) {
		if (strpos($installed_ver, '1.2.') == 0) {
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
		return $this->db->query($query);
	}
	
	/**
	 * @name updateVersion
	 * @category Database updater
	 * @since 1.3.0
	 * @param $installed_ver
	 * @param $target_ver
	 */
	public function updateVersion($installed_ver, $target_ver) {		
		// we have to update database structure
		if (!$installed_ver) {
			// we're updating from version 1.0.1 or null version
			
			// create styles table
			$this->createTableStyles13x();
				
			// create galleries table
			$this->createTableGalleries13x();

			// parse and update data only if updating from 1.0.1 
			if (get_option('syg_youtube_username')) {
				// parse old data
				$this->updateData($installed_ver, $target_ver);
					
				// we're updating from version 1.0.1
				SygPlugin::removeOldOption();
			}			
		} else if (strpos($installed_ver, '1.2.') == 0) {			
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
			$this->updateData($installed_ver, $target_ver);
		}
		
		// set default option
		SygPlugin::setDefaultOption();
	}
}
?>