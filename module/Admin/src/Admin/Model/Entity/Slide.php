<?php
namespace Admin\Model\Entity;

class Slide{
	public $id;
	public $title;
	public $description;
	public $images;
	public $link;
	public $open;
	public $status;
	public $order;
	public $date_time;
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->title 		= 	(!empty($data['title'])) ? $data['title'] : null;
		$this->description  		= 	(!empty($data['description'])) ? $data['description'] : null;
		$this->images  	= 	(!empty($data['images'])) ? $data['images'] : null;
		$this->link  = 	(!empty($data['link'])) ? $data['link'] : null;
		$this->open  		= 	(!empty($data['open'])) ? $data['open'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		$this->date_time  	= 	(!empty($data['date_time'])) ? $data['date_time'] : null;
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}