<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class {content:class} extends Nip_Model {
	protected $tableName = "{content:tableName}";
	protected $primary = "{content:primary}";

	{content:timestamps}{content:softDeletes}
	{content:createdField}{content:updatedField}{content:deletedField}
	{content:variable}
	protected $validator = array(
			{content:validator});
	
	protected $label = array(
			{content:label});

	public function __construct($options = array()){
		parent::__construct($options);
	}
	{content:relationship}
}