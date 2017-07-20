<?php
namespace Admin\Model\Entity;

class EmailMarketing{
	public $id;
	public $name;
	public $content;
	public $email;
	public $status;
	public $date_time;
	public $file;
	public $count;
	public $order;
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->name 		= 	(!empty($data['name'])) ? $data['name'] : null;
		$this->content  	= 	(!empty($data['content'])) ? $data['content'] : null;
		$this->email  		= 	(!empty($data['email'])) ? $data['email'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->file  		= 	(!empty($data['file'])) ? $data['file'] : null;
		$this->count  		= 	(!empty($data['count'])) ? $data['count'] : null;
		$this->date_time  	= 	(!empty($data['date_time'])) ? $data['date_time'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}