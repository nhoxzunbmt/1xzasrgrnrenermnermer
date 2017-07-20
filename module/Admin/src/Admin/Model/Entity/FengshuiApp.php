<?php
namespace Admin\Model\Entity;

class FengshuiApp{
	public $id;
	public $birth;
	public $sex;
	public $direction;
	public $content;
	public $status;
	public $order;
	public $created;
	public $created_by;
	public $modified;
	public $modified_by;
	
	
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->birth 		= 	(!empty($data['birth'])) ? $data['birth'] : null;
		$this->sex  		= 	(!empty($data['sex'])) ? $data['sex'] : null;
		$this->direction  	= 	(!empty($data['direction'])) ? $data['direction'] : null;
		$this->content  	= 	(!empty($data['content'])) ? $data['content'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		$this->created  		= 	(!empty($data['created'])) ? $data['created'] : null;
		$this->created_by  		= 	(!empty($data['created_by'])) ? $data['created_by'] : null;
		$this->modified  		= 	(!empty($data['modified'])) ? $data['modified'] : null;
		$this->modified_by  		= 	(!empty($data['modified_by'])) ? $data['modified_by'] : null;
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}