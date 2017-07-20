<?php
namespace Admin\Model\Entity;

class NavFooter{
	public $id;
	public $name;
	public $description;
	public $status;
	public $parent;
	public $level;
	public $left;
	public $right;
	public $created;
	public $created_by;
	public $modified;
	public $modified_by;
	public $url;
	
	

	public function exchangeArray($data){
		$this->id 		= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->name  	= 	(!empty($data['name'])) ? $data['name'] : null;
		$this->description  	= 	(!empty($data['description'])) ? $data['description'] : null;
		$this->status  	= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->parent  	= 	(!empty($data['parent'])) ? $data['parent'] : null;
		$this->level 	= 	(!empty($data['level'])) ? $data['level'] : null;
		$this->left  	= 	(!empty($data['left'])) ? $data['left'] : null;
		$this->right 	= 	(!empty($data['right'])) ? $data['right'] : null;
		$this->created 	= 	(!empty($data['created'])) ? $data['created'] : null;
		$this->created_by 	= 	(!empty($data['created_by'])) ? $data['created_by'] : null;
		$this->modified 	= 	(!empty($data['modified'])) ? $data['modified'] : null;
		$this->modified_by 	= 	(!empty($data['modified_by'])) ? $data['modified_by'] : null;
		$this->url 	= 	(!empty($data['url'])) ? $data['url'] : null;
		
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}