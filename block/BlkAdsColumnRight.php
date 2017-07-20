<?php
namespace Block;
use Zend\View\Helper\AbstractHelper;

class BlkAdsColumnRight extends AbstractHelper{
	protected $_data;

	public function __invoke(){
		require_once  'BlkAdsColumnRight/default.phtml';
	}

	public function setData($table){
		$this->_data = $table->listItem(null,array('task'=>'block-ads-column-right'));
		
		return $this->_data;
	}
}