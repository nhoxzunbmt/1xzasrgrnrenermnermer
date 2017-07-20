<?php
namespace Admin\Model\Entity;

class Gallery{
	public $id;
	public $user_id;
	public $images;
	public $date_time;
	public $status;
	public $name;
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->user_id 		= 	(!empty($data['user_id'])) ? $data['user_id'] : null;
		$this->images  		= 	(!empty($data['images'])) ? $data['images'] : null;
		$this->date_time  		= 	(!empty($data['date_time'])) ? $data['date_time'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->name  		= 	(!empty($data['name'])) ? $data['name'] : null;


	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}