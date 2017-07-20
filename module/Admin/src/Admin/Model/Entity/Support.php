<?php
namespace Admin\Model\Entity;

class Support{
	public $id;
	public $name;
	public $nickname;
	public $phone;
	public $email;
	public $type;
	public $status;
	public $order;
	
	
	
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->name 		= 	(!empty($data['name'])) ? $data['name'] : null;
		$this->nickname  	= 	(!empty($data['nickname'])) ? $data['nickname'] : null;
		$this->phone  		= 	(!empty($data['phone'])) ? $data['phone'] : null;
		$this->email  		= 	(!empty($data['email'])) ? $data['email'] : null;
		$this->type  		= 	(!empty($data['type'])) ? $data['type'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}