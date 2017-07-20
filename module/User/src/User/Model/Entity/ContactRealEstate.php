<?php
namespace User\Model\Entity;

class ContactRealEstate{
	public $id;
	public $real_estate_id;
	public $user_id;
	public $fullname;
	public $phone;
	public $email;
	public $content;
	public $date_time;
	public $status;
	public $order;
	

	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->real_estate_id  	= 	(!empty($data['real_estate_id'])) ? $data['real_estate_id'] : null;
		$this->user_id  	= 	(!empty($data['user_id'])) ? $data['user_id'] : null;
		$this->fullname  		= 	(!empty($data['fullname'])) ? $data['fullname'] : null;
		$this->phone  		= 	(!empty($data['phone'])) ? $data['phone'] : null;
		$this->email  	= 	(!empty($data['email'])) ? $data['email'] : null;
		$this->content  		= 	(!empty($data['content'])) ? $data['content'] : null;
		$this->date_time  = 	(!empty($data['date_time'])) ? $data['date_time'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
	
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}