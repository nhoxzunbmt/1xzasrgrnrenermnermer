<?php
namespace Zendvn\View\Helper;
use Zend\View\Helper\AbstractHelper;

class CmsBreadcrumb extends AbstractHelper {
	
	public function __invoke($items, $options = null){
		//
		$urlHelper	= $this->getView()->plugin('url');
		$result	= '<ul>';
		$result	.= sprintf('<li><a title="Trang chủ" href="%s">Trang chủ</a></li>', $urlHelper('home'));
		//Dữ liệu database
		if($options['task'] == 'data'){
			$total	= $items->count();
			if(!empty($items)){
				$i = 1;
				foreach ($items as $item) {
					$linkCategory	= $urlHelper('CategoryNiceHouseRoute', array(
						'controller'=> 'nicehouse',
						'action' 	=> 'category',
						'name'		=> \ZendVN\Url\FriendlyLink::filter($item->name),
						'page'		=> 1,
						'id' 		=> $item->id
					));
					
					if($i == $total){
						$result			.= sprintf('<li class="li-active"><a title="%s" href="%s">%s</a>&raquo;</li>',$item->name, 'javascript:;', $item->name);
					}else{
						$result			.= sprintf('<li><a title="%s" href="%s">%s</a>&raquo;</li>',$item->name, $linkCategory, $item->name);
					}
					$i++;
				}
			} 
		}
		
		//Dữ liệu tĩnh
		if($options['task'] == 'no-data' && !empty($items)){
			$result			.= sprintf('<li><a title="No data" href="javascript:;">&gt</a></li>', $items);
		}
		$result .= '</ul>';
		return $result;
	}
}