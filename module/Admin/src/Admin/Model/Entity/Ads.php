<?php
namespace Admin\Model\Entity;

class Ads{
	public $id;
	public $name;
	public $url;
	public $area_ads;
	public $flash_image;
	public $width;
	public $height;
	public $status;
	public $order;
	public $date_time;
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->name 		= 	(!empty($data['name'])) ? $data['name'] : null;
		$this->url  		= 	(!empty($data['url'])) ? $data['url'] : null;
		$this->area_ads  	= 	(!empty($data['area_ads'])) ? $data['area_ads'] : null;
		$this->flash_image  = 	(!empty($data['flash_image'])) ? $data['flash_image'] : null;
		$this->width  		= 	(!empty($data['width'])) ? $data['width'] : null;
		$this->height  		= 	(!empty($data['height'])) ? $data['height'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		$this->date_time  	= 	(!empty($data['date_time'])) ? $data['date_time'] : null;
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}