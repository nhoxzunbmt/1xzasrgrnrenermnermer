<?php
namespace Admin\Model\Entity;

class EmailTemplate{
	public $id;
	public $name;
	public $content;
	public $images;
	public $status;
	public $order;
	public $date_time;
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->name 		= 	(!empty($data['name'])) ? $data['name'] : null;
		$this->content  		= 	(!empty($data['content'])) ? $data['content'] : null;
		$this->images  		= 	(!empty($data['images'])) ? $data['images'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		$this->date_time  		= 	(!empty($data['date_time'])) ? $data['date_time'] : null;
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}