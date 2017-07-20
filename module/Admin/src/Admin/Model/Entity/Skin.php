<?php
namespace Admin\Model\Entity;

class Skin{
	public $id;
	public $config_logo;
	public $config_banner;
	public $config_footer;
	public $config_background;
	
	
	
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->config_logo 		= 	(!empty($data['config_logo'])) ? $data['config_logo'] : null;
		$this->config_banner  		= 	(!empty($data['config_banner'])) ? $data['config_banner'] : null;
		$this->config_footer  	= 	(!empty($data['config_footer'])) ? $data['config_footer'] : null;
		$this->config_background  	= 	(!empty($data['config_background'])) ? $data['config_background'] : null;
		
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}