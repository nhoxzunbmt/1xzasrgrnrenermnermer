<?php
namespace ZendVN\View\Helper;
use Zend\View\Helper\AbstractHelper;
class CmsReplaceString extends AbstractHelper{
	public function __invoke($string,$options = null){
		if($options == null){
			$str = str_replace('\"','"',$string);
			$str = str_replace("\'","'",$str);
		}
		
		return $str;
	}

}