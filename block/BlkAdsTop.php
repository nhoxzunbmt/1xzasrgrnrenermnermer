<?php
namespace Block;
use Zend\View\Helper\AbstractHelper;

class BlkAdsTop extends AbstractHelper{
	protected $_data;

	public function __invoke(){
		require_once  'BlkAdsTop/default.phtml';
	}

	public function setData($table){
		$this->_data = $table->listItem(null,array('task'=>'block-ads-column-top'));
		
		return $this->_data;
	}
}