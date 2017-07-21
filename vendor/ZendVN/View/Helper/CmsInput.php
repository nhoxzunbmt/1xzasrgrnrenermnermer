<?php
namespace ZendVN\View\Helper;
use Zend\View\Helper\AbstractHelper;
class CmsInput extends AbstractHelper{
	public function __invoke($name,$idTag = null,$type,$attribs = array() ){
		$strAttribs = '';
		if(count($attribs)>0){
			foreach ($attribs as $keyAttribs => $valueAttribs){
				$strAttribs .= $keyAttribs . '="' . $valueAttribs . '" ';
			}
		}

		$xhtml = '<input name="'.$name.'" type="'.$type.'" id="'.$idTag.'" '.$strAttribs.' />';

		return $xhtml;
	}

}