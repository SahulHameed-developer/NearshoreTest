<?php
App::uses('Model', 'Model');
/**
 * APPのModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class AppModel extends Model {
	public function __construct($id = false, $table = null, $ds = null) {
		if (is_array($id)) {
			extract(array_merge(array('name' => $this->name), $id));
		}
		if ($this->name === null) {
			$this->name = (isset($name) ? $name : get_class($this));
		}
		$this->useTable = Inflector::underscore($this->name);
		parent::__construct($id, $table, $ds);
	}
}
