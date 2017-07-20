<?php
namespace Admin\Model\Entity;

class Project{
	public $id;
	public $cat_id;
	public $name;
	public $city;
	public $district;
	public $overview;
	public $intro;
	public $service;
	public $location;
	public $siteplan;
	public $contact;
	public $address;
	public $area;
	public $floor;
	public $workstart;
	public $workend;
	public $status_quo;
	public $investors;
	public $construction;
	public $management;
	public $design;
	public $images;
	public $nameother;
	public $distributors;
	public $date_time;
	public $order;
	public $latitude_gmap;
	public $longitude_gmap;
	public $status;
 	public $price_m2;
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->cat_id 		= 	(!empty($data['cat_id'])) ? $data['cat_id'] : null;
		$this->name  		= 	(!empty($data['name'])) ? $data['name'] : null;
		$this->city  		= 	(!empty($data['city'])) ? $data['city'] : null;
		$this->district  	= 	(!empty($data['district'])) ? $data['district'] : null;
		$this->overview  	= 	(!empty($data['overview'])) ? $data['overview'] : null;
		$this->intro  		= 	(!empty($data['intro'])) ? $data['intro'] : null;
		$this->service  	= 	(!empty($data['service'])) ? $data['service'] : null;
		$this->location  	= 	(!empty($data['location'])) ? $data['location'] : null;
		$this->siteplan  	= 	(!empty($data['siteplan'])) ? $data['siteplan'] : null;
		$this->contact  	= 	(!empty($data['contact'])) ? $data['contact'] : null;
		$this->address  	= 	(!empty($data['address'])) ? $data['address'] : null;
		$this->area  		= 	(!empty($data['area'])) ? $data['area'] : null;
		$this->floor  		= 	(!empty($data['floor'])) ? $data['floor'] : null;
		$this->workstart  	= 	(!empty($data['workstart'])) ? $data['workstart'] : null;
		$this->workend  	= 	(!empty($data['workend'])) ? $data['workend'] : null;
		$this->status_quo  	= 	(!empty($data['status_quo'])) ? $data['status_quo'] : null;
		$this->investors  	= 	(!empty($data['investors'])) ? $data['investors'] : null;
		$this->construction = 	(!empty($data['construction'])) ? $data['construction'] : null;
		$this->management  	= 	(!empty($data['management'])) ? $data['management'] : null;
		$this->design  		= 	(!empty($data['design'])) ? $data['design'] : null;
		$this->images  		= 	(!empty($data['images'])) ? $data['images'] : null;
		$this->nameother  		= 	(!empty($data['nameother'])) ? $data['nameother'] : null;
		$this->distributors  		= 	(!empty($data['distributors'])) ? $data['distributors'] : null;
		$this->date_time  		= 	(!empty($data['date_time'])) ? $data['date_time'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		$this->latitude_gmap  		= 	(!empty($data['latitude_gmap'])) ? $data['latitude_gmap'] : null;
		$this->longitude_gmap  		= 	(!empty($data['longitude_gmap'])) ? $data['longitude_gmap'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->price_m2  		= 	(!empty($data['price_m2'])) ? $data['price_m2'] : null;
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}