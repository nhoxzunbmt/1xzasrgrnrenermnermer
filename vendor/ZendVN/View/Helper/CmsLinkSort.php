<?php
namespace ZendVN\View\Helper;
use Zend\View\Helper\AbstractHelper;
class CmsLinkSort extends AbstractHelper{
	public function __invoke($label,$column,$ssFilter,$imgLink,$action_link,$default_order = 'DESC'){
		if($ssFilter['col'] != $column){		
			$linkOder =  $action_link . '/' . $column . '/' . $default_order;		
			$xhtml = '<a href="' . $linkOder . '" title="Sort Z-A">' . $label . '</a>';
		}else{
			if($ssFilter['order'] == 'DESC'){
				$sortOrder= 'ASC';
				$iconSort = $imgLink . '/arrow_down.png';
				$title="Sort A-Z";
			}else{
				$sortOrder = 'DESC';
				$iconSort = $imgLink . '/arrow_up.png';
				$title= "Sort Z-A";
			}
			
			$linkOder =  $action_link . '/' . $column . '/' . $sortOrder;
			$xhtml = '<a href="' . $linkOder . '" title="' . $title . '">
	                ' . $label . '
	               
	               <img src="' . $iconSort .'">
	               </a>';
		}

	
		return $xhtml;
	}

}