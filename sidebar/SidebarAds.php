<?php
namespace Sidebar;
use Zend\View\Helper\AbstractHelper;

class SidebarAds extends AbstractHelper{
	protected $_data;
	protected $_table;

	public function __invoke($position){
	    $this->setData($position);
		require_once  'SidebarAds/default.phtml';
	}
	public function setTable($table){
	    $this->_table = $table;
	}
	private function setData($position){
	    if($position){
            $this->_data = $this->_table->listItem(null,array('task'=>'block-ads-column-right'));
	    }
		return $this->_data;
	}
}