<?php
namespace ZendVN\View\Helper;
use Zend\View\Helper\AbstractHelper;
class CmsSelect extends AbstractHelper{
	public function __invoke($name,$value = null, $options,$dataType = 'multi-level',$attribs = array()){
		$strAttribs = '';
		if(count($attribs)>0){
			foreach ($attribs as $keyAttribs => $valueAttribs){
				$strAttribs .= $keyAttribs . '="' . $valueAttribs . '" ';
			}
		}
				
		$xhtml = '<select  name="' . $name . '" id="' . $name . '" ' . $strAttribs . ' >';
		
		if($dataType == 'multi-level'){
			foreach ($options as $key=> $info){
				$strSelect = '';
				if($info['id'] == $value){
					$strSelect = 'selected="selected"';
				}
				
				if($info['level'] == 1){
					$xhtml .= '<option value="' . $info['id'] . '" ' . $strSelect . ' style="background-color:#dcdcc3;font-weight:bold;" disabled="disabled">+' . $info['name'] . '</option>';
				}else{
					$string = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$newString = '';
					for($i=1;$i<$info['level']; $i++){
						$newString .= $string;
					}
					$info['name'] = $newString . '-' . $info['name'];
					$xhtml .= '<option value="' . $info['id'] . '" ' . $strSelect . '>' . $info['name'] . '</option>';
				}
			}
		}
		if($dataType == 'no-level'){
			foreach ($options as $key=> $info){
				$strSelect	= '';
				if($info['id'] == $value){
					$strSelect = 'selected="selected"';
				}
				$xhtml .= '<option value="' . $info['id'] . '" ' . $strSelect . '>' . $info['name'] . '</option>';
			}
		}

		
		$xhtml .= '</select>';

		return $xhtml;
	}

}