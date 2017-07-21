<?php
namespace ZendVN\View\Helper;
use Zend\View\Helper\AbstractHelper;
class CmsIconButton extends AbstractHelper{
	public function __invoke($title = '', $imgLink, $link = null, $type = 'link'){
		if($type == 'event'){
			$xhtml = '<a  class="action-link-button copy" ' . $link . ' href="javascript:__doPostBack(&#39;ctl00$cph_Main$ctl00$toolbox2$rptAction$ctl01$lbtAction&#39;,&#39;&#39;)">
						<img src="' . $imgLink . '" title="' . $title . '">
						</a>';
		}if($type == 'link'){
			$xhtml = ' <a  class="action-link-button copy" href="' . $link . '">
	                      <img src="' . $imgLink  . '" title="' . $title .'" > 
	                   </a>';
		}
		return $xhtml;
	}

}