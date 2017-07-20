<?php
namespace User\Model\Entity;

class Service{
	public $id;
	public $name;
	public $images;
	public $normal;
	public $vip;
	public $hot;
	public $free;
	public $chinhchu;
	public $price;
	

	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->name  		= 	(!empty($data['name'])) ? $data['name'] : null;
		$this->images  		= 	(!empty($data['images'])) ? $data['images'] : null;
		$this->normal  	= 	(!empty($data['normal'])) ? $data['normal'] : null;
		$this->vip 	= 	(!empty($data['vip'])) ? $data['vip'] : null;
		$this->hot  		= 	(!empty($data['hot'])) ? $data['hot'] : null;
		$this->free  	= 	(!empty($data['free'])) ? $data['free'] : null;
		$this->chinhchu  		= 	(!empty($data['chinhchu'])) ? $data['chinhchu'] : null;
		$this->price  	= 	(!empty($data['price'])) ? $data['price'] : null;
		
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}