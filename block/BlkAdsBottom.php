<?php
namespace Block;
use Zend\View\Helper\AbstractHelper;

class BlkAdsBottom extends AbstractHelper{
	protected $_data;

	public function __invoke(){
		require_once  'BlkAdsBottom/default.phtml';
	}

	public function setData($table){
		$this->_data = $table->listItem(null,array('task'=>'block-ads-column-bottom'));
		
		return $this->_data;
	}
}