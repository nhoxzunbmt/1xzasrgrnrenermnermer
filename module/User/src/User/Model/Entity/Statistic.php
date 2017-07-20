<?php
namespace User\Model\Entity;

class Statistic{
	public $id;
	public $cat_id;
	public $title;
	public $content;
	public $images;
	public $transaction;
	public $area;
	public $price_type;
	public $price;
	public $price_m2;
	public $price_display;
	public $direction;
	public $avenue;
	public $juridical;
	public $floor;
	public $bedroom;
	public $bathroom;
	public $city;
	public $district;
	public $ward;
	public $project;
	public $numberhouse;
	public $nameavenue;
	public $user_id;
	public $latitude_gmap;
	public $longitude_gmap;
	public $status;
	public $order;
	public $date_modifi;
	public $type_news;
	public $date_start;
	public $date_end;

	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->cat_id  		= 	(!empty($data['cat_id'])) ? $data['cat_id'] : null;
		$this->title  		= 	(!empty($data['title'])) ? $data['title'] : null;
		$this->content  	= 	(!empty($data['content'])) ? $data['content'] : null;
		$this->images  		= 	(!empty($data['images'])) ? $data['images'] : null;
		$this->transaction 	= 	(!empty($data['transaction'])) ? $data['transaction'] : null;
		$this->area  		= 	(!empty($data['area'])) ? $data['area'] : null;
		$this->price_type  	= 	(!empty($data['price_type'])) ? $data['price_type'] : null;
		$this->price  		= 	(!empty($data['price'])) ? $data['price'] : null;
		$this->price_m2  	= 	(!empty($data['price_m2'])) ? $data['price_m2'] : null;
		$this->price_display= 	(!empty($data['price_display'])) ? $data['price_display'] : null;
		$this->direction  	= 	(!empty($data['direction'])) ? $data['direction'] : null;
		$this->avenue  		= 	(!empty($data['avenue'])) ? $data['avenue'] : null;
		$this->juridical  	= 	(!empty($data['juridical'])) ? $data['juridical'] : null;
		$this->floor  		= 	(!empty($data['floor'])) ? $data['floor'] : null;
		$this->bedroom  	= 	(!empty($data['bedroom'])) ? $data['bedroom'] : null;
		$this->bathroom  	= 	(!empty($data['bathroom'])) ? $data['bathroom'] : null;
		$this->city  		= 	(!empty($data['city'])) ? $data['city'] : null;
		$this->district  	= 	(!empty($data['district'])) ? $data['district'] : null;
		$this->ward  		= 	(!empty($data['ward'])) ? $data['ward'] : null;
		$this->project  	= 	(!empty($data['project'])) ? $data['project'] : null;
		$this->numberhouse  = 	(!empty($data['numberhouse'])) ? $data['numberhouse'] : null;
		$this->nameavenue  	= 	(!empty($data['nameavenue'])) ? $data['nameavenue'] : null;
		$this->user_id  	= 	(!empty($data['user_id'])) ? $data['user_id'] : null;
		$this->latitude_gmap= 	(!empty($data['latitude_gmap'])) ? $data['latitude_gmap'] : null;
		$this->longitude_gmap  	= 	(!empty($data['longitude_gmap'])) ? $data['longitude_gmap'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		$this->date_modifi  	= 	(!empty($data['date_modifi'])) ? $data['date_modifi'] : null;
		$this->type_news  	= 	(!empty($data['type_news'])) ? $data['type_news'] : null;
		$this->date_start  	= 	(!empty($data['date_start'])) ? $data['date_start'] : null;
		$this->date_end  	= 	(!empty($data['date_end'])) ? $data['date_end'] : null;
		
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}