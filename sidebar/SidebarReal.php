<?php
namespace Sidebar;
use Zend\View\Helper\AbstractHelper;

class SidebarReal extends AbstractHelper{
	protected $_data;
	protected $_table;

	public function __invoke($arrParam){
	    $this->setData($arrParam);
		require_once  'SidebarReal/default.phtml';
	}
	public function setTable($table){
	    $this->_table = $table;
	}
	private function setData($arrParam){
	    $this->_data = $this->_table->listItem($arrParam,array('task'=>'list-items-realestate-chinh-chu'));
		return $this->_data;
	}
}