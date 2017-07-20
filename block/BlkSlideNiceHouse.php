<?php
namespace Block;
use Zend\View\Helper\AbstractHelper;

class BlkSlideNiceHouse extends AbstractHelper{
	protected $_data;

	public function __invoke(){
		require_once  'BlkSlideNiceHouse/default.phtml';
	}

	public function setData($table){
		$this->_data = $table->listItem(null,array('task'=>'list-items-news-moi-nhat'));
		
		return $this->_data;
	}
}