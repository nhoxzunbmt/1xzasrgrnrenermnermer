<?php
namespace Admin\Model\Entity;

class Config{
	public $id;
	public $website;
	public $company;
	public $email;
	public $advance;
	public $display;
	public $map;
	public $maintenance;
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->website 		= 	(!empty($data['website'])) ? $data['website'] : null;
		$this->company  	= 	(!empty($data['company'])) ? $data['company'] : null;
		$this->email  		= 	(!empty($data['email'])) ? $data['email'] : null;
		$this->advance  	= 	(!empty($data['advance'])) ? $data['advance'] : null;
		$this->display  	= 	(!empty($data['display'])) ? $data['display'] : null;
		$this->map  		= 	(!empty($data['map'])) ? $data['map'] : null;
		$this->maintenance  = 	(!empty($data['maintenance'])) ? $data['maintenance'] : null;
		
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}