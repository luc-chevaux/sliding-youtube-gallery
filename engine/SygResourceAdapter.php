<?php
/**
 * @name SygResourceAdapter
 * @category Sliding YouTube Gallery style and script Adapter
 * @since 1.5.0
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.5.4
 */
class SygResourceAdapter {
	private $conditions = null;
	
	private $name = null;
	private $relUrl = null;
	private $type = null;
	private $media = null;
	private $version = null;
	private $indexed = null;
	private $thirdparty = null;
	private $registered = null;
	private $dependencies = array();
	private $galleryId = null;
	private $condition = null;
	
	public function __construct(SimpleXMLElement $element, $galleryId = null, $conditions = array()) {
		$this->setGalleryId($galleryId);
		$this->setIndexed($element->indexed);
		$this->setName($element->name);
		$this->setRelUrl($element->relUrl);
		$this->setType($element->type);
		$this->setMedia($element->media);
		$this->setVersion($element->version);
		$this->setRegistered($element->registered);
		$this->setThirdparty($element->thirdparty);
		$this->setDependencies($element->dependencies);
		$this->setCondition($element->condition);
		$this->setConditions($conditions);
	}
	
	public function enqueue() {
		$condition = ($this->getCondition() != null) ? $this->getCondition() : 'none';
		$conditions = $this->getConditions();
		
		if (($condition == 'none') || (array_key_exists($condition, $conditions) && $conditions[$condition] == true)) {
			// esegui
			switch ($this->getType()) {
				case "js":
					if ($this->getRegistered() == 'no') {
						// register script
						wp_register_script($this->getName(),
                        plugins_url() . SygConstant::WP_PLUGIN_PATH . $this->getRelUrl(),
						$this->getDependencies(),
						$this->getVersion(),
						true
						);
					}
					// enqueue script
					wp_enqueue_script($this->getName());
					break;
				case "css":
					if ($this->getRegistered() == 'no') {
						// register style
						wp_register_style($this->getName(),
                        plugins_url() . SygConstant::WP_PLUGIN_PATH . $this->getRelUrl(),
						$this->getDependencies(),
						$this->getVersion(),
						$this->getMedia()
						);
					}
					// enqueue style
					wp_enqueue_style($this->getName());
					break;
				default:
					break;
			}
		}
	}
	
	/**
	 * @return the $condition
	 */
	public function getCondition() {
		return $this->condition;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $relUrl
	 */
	public function getRelUrl() {
		return $this->relUrl;
	}

	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @return the $media
	 */
	public function getMedia() {
		return $this->media;
	}

	/**
	 * @return the $version
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * @return the $indexed
	 */
	public function getIndexed() {
		return $this->indexed;
	}

	/**
	 * @return the $thirdparty
	 */
	public function getThirdparty() {
		return $this->thirdparty;
	}
	
	/**
	 * @return the $registered
	 */
	public function getRegistered() {
		return $this->registered;
	}

	/**
	 * @return the $dependencies
	 */
	public function getDependencies() {
		return $this->dependencies;
	}
	
	/**
	 * @return the $galleryId
	 */
	public function getGalleryId() {
		return $this->galleryId;
	}
	
	/**
	 * @return the $conditions
	 */
	public function getConditions() {
		return $this->conditions;
	}

	/**
	 * @param NULL $name
	 */
	public function setName($name) {
		if ($this->getIndexed() == 'yes') {
			$this->name = ((String) $name).'-'.$this->getGalleryId();
		} else {
			$this->name = (String) $name;
		}
	}

	/**
	 * @param NULL $relUrl
	 */
	public function setRelUrl($relUrl) {
		if ($this->getIndexed() == 'yes') {
			$this->relUrl = ((String) $relUrl).$this->getGalleryId();
		} else {
			$this->relUrl = (String) $relUrl;
		}
	}

	/**
	 * @param NULL $type
	 */
	public function setType($type) {
		$this->type = (String) $type;
	}

	/**
	 * @param NULL $media
	 */
	public function setMedia($media) {
		$this->media = (String) $media;
	}

	/**
	 * @param NULL $version
	 */
	public function setVersion($version) {
		$this->version = (String) $version;
	}

	/**
	 * @param NULL $indexed
	 */
	public function setIndexed($indexed) {
		$this->indexed = (String) $indexed;
	}

	/**
	 * @param NULL $registered
	 */
	public function setRegistered($registered) {
		$this->registered = (String) $registered;
	}

	/**
	 * @param NULL $thirdparty
	 */
	public function setThirdparty($thirdparty) {
		$this->thirdparty = (String) $thirdparty;
	}

	/**
	 * @param multitype: $dependencies
	 */
	public function setDependencies($dependencies) {
		$this->dependencies = (array) $dependencies;
	}
	
	/**
	 * @param NULL $galleryId
	 */
	public function setGalleryId($galleryId) {
		$this->galleryId = (String) $galleryId;
	}
	
	/**
	 * @param NULL $condition
	 */
	public function setCondition($condition) {
		$this->condition = (String) $condition;
	}
	
	/**
	 * @param NULL $conditions
	 */
	public function setConditions($conditions) {
		$this->conditions = (array) $conditions;
	}
}
?>