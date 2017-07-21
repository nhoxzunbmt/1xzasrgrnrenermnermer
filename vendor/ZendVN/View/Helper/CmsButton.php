<?php
namespace ZendVN\View\Helper;
use Zend\View\Helper\AbstractHelper;
class CmsButton extends AbstractHelper{
	public function __invoke($name, $link = '#',$imgUrl, $type = 'link',$idTag = 'cph_Main_ctl00_toolbox_rptAction_lbtAction_1'){
		if($type == 'link'){
			$aTag = ' id="'.$idTag.'" title="'.$name.'" class="toolbar btn btn-info" href="' . $link . '" ';
		}if($type == 'submit'){
			$aTag = ' id="'.$idTag.'" title="'.$name.'" class="toolbar btn btn-info" href="#" onclick="OnSubmitForm(\'' . $link . '\')"';
		}if($type == 'onclick'){
			$aTag = ' id="'.$idTag.'" title="'.$name.'" class="toolbar btn btn-info" href="#" onclick="' . $link . '"';
		}
		
		$xhtml = '<td align="center">
                        <a ' . $aTag . '>
                        <img src="'.$imgUrl.'" width="20" height="20">
                       <font color="white">' . $name . '</font>
                        </a>
                     </td>';
		return $xhtml;
	}

}