<?php
namespace Admin\Model\Entity;

class Permission{
	public $id;
	public $group_name;
	public $type;
	public $group_acp;
	public $group_default;
	public $created;
	public $created_by;
	public $modified;
	public $modified_by;
	public $permission;
	public $status;
	public $order;
	public $color;
	public $permission_id;

	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->group_name  	= 	(!empty($data['group_name'])) ? $data['group_name'] : null;
		$this->type  		= 	(!empty($data['type'])) ? $data['type'] : null;
		$this->group_acp  	= 	(!empty($data['group_acp'])) ? $data['group_acp'] : null;
		$this->group_default = 	(!empty($data['group_default'])) ? $data['group_default'] : null;
		$this->fullname  	= 	(!empty($data['fullname'])) ? $data['fullname'] : null;
		$this->sex  		= 	(!empty($data['sex'])) ? $data['sex'] : null;
		$this->modified  	= 	(!empty($data['modified'])) ? $data['modified'] : null;
		$this->modified_by  = 	(!empty($data['modified_by'])) ? $data['modified_by'] : null;
		$this->permission  	= 	(!empty($data['permission'])) ? $data['permission'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		$this->color  		= 	(!empty($data['color'])) ? $data['color'] : null;
		$this->permission_id  		= 	(!empty($data['permission_id'])) ? $data['permission_id'] : null;
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}