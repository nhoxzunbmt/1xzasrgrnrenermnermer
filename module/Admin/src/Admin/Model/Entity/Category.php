<?php
namespace Admin\Model\Entity;

class Category{
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
	public $type;
	public $seo_keyword;
	public $seo_description;
	public $seo_title;

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
		$this->type 	= 	(!empty($data['type'])) ? $data['type'] : null;
		$this->seo_keyword 	= 	(!empty($data['seo_keyword'])) ? $data['seo_keyword'] : null;
		$this->seo_description 	= 	(!empty($data['seo_description'])) ? $data['seo_description'] : null;
		$this->seo_title 	= 	(!empty($data['seo_title'])) ? $data['seo_title'] : null;
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}