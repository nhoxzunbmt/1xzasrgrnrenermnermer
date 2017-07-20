<?php
namespace Block;
use Zend\View\Helper\AbstractHelper;

class BlkSlideNews extends AbstractHelper{
	protected $_data = array();
 	
	public function __invoke(){
		require_once  'BlkSlideNews/default.phtml';
	}

	public function setData($table){
		$this->_data['data'] = $table->listItem(null,array('task'=>'list-items-news-moi-nhat'));
		$city = $table->itemInselectBox(null,array('task'=>'list-item-city'));
		$this->_data['city'] = array_slice($city,1,count($city) - 1);
		

		return $this->_data;

	}
}