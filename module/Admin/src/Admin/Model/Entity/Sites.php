<?php
namespace Admin\Model\Entity;

class Sites{
	public $id;
	public $name;
	public $status;
	
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->name  		= 	(!empty($data['name'])) ? $data['name'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
	
		
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}