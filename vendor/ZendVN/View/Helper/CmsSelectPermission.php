<?php
namespace ZendVN\View\Helper;
use Zend\View\Helper\AbstractHelper;
class CmsSelectPermission extends AbstractHelper{
	public function __invoke($name, $checked = null, $options, $attribs = array()){
		$xhtml = "<ul>";
			
			foreach($options as $key=>$value){
				
				$xhtml .= "<li>";
				if($value["level"] == 1){
					$xhtml .= "<div class='btn-link'><span>+ <a href='#'>".$value["name"]."</a> (Module)</span></div>";
				}
				$xhtml .= "<ul>";
				if($value["level"] == 2){		
					$xhtml .= "<div class='btn-link'><span><li>								 
								 - <label><font color='red'>".$value["controller"]."</font> (".$value['name'].")</label>
							 </li></span></div>";
				}else{
					if($value["level"] == 3){
						$strChecked	=	"";
						$styleSpan 	= '';
						$styleDiv 	= '';
						$jsEvent	= 'onclick="javascript:addPrivilege('.$value["id"].')"';
						if(!empty($checked)){
							foreach($checked as $val){
								if($value["id"]	==	$val){
									$strChecked = "checked = 'checked'";
									$styleSpan 	= 'style="color:white;background: url('.TEMPLATE_URL.'/admin/images/apply-hover.png) left center no-repeat;background-color:#696969;"';
									$styleDiv 	= 'style="background-color: #696969;"';
									$jsEvent	= 'onclick="javascript:removePrivilege('.$value["id"].')"';
								}
							}
						}
						
					$xhtml .= "<ul>
								 <div class='btn-link' id='change-permission-".$value["id"]."' ".$jsEvent."  rel='".$value["id"]."'' ".$styleDiv." ><span id='privilege-".$value["id"]."' ".$styleSpan."><li>
									 
									 <label for='check-2-1'>".$value["action"]." :: <font size='1'> <i>".$value["name"]."</i></font></label></span>
								 </li></div>
							 </ul>";
					}
				}				
				$xhtml .= "</ul>";
				$xhtml .= "</li>";				
			}
			
			$xhtml .= "</ul>";
			return $xhtml;
	}

}