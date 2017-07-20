<?php
namespace Admin\Model\Entity;

class EmailNewsletter{
	public $id;
	public $fullname;
	public $email;
	public $status;
	public $order;
	public $date_time;
	

	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->fullname  	= 	(!empty($data['fullname'])) ? $data['fullname'] : null;
		$this->email  		= 	(!empty($data['email'])) ? $data['email'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		$this->date_time  		= 	(!empty($data['date_time'])) ? $data['date_time'] : null;
		
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}