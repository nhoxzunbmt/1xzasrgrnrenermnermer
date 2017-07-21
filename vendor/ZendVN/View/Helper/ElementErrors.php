<?php
namespace ZendVN\View\Helper;
use Zend\Form\View\Helper\FormElementErrors;
use Zend\Form\ElementInterface;
class ElementErrors extends FormElementErrors{
	public function __invoke($elementArray = null, $module = 'admin'){
		if($module == 'admin'){
			if(empty($elementArray)) return '';
			$result = null;
			$i = 0;
			foreach($elementArray as $key => $element){
				$messages = $element->getMessages();
				if(empty($messages)) continue;
				$result .= sprintf('<div id="cph_Main_ctl00_notification_rptNotice_divMessage_'.$i.'" class="alert alert-error">%s<button data-dismiss="alert" class="close">×</button>
		            </div>',current($messages));
				$i++;
			}
		}
		if($module == 'user'){
			if(empty($elementArray)) return '';
			$result = null;
			$i = 0;
			foreach($elementArray as $key => $element){
				$messages = $element->getMessages();
				if(empty($messages)) continue;
				$result .= sprintf('<div id="cph_Main_ctl00_notification_rptNotice_divMessage_'.$i.'" class="alert alert-error">%s
		            </div>',current($messages));
				$i++;
			}
		}
        
        return sprintf('<div id="cph_Main_ctl00_notification_divNotice" style="padding-top:10px;">%s</div>',$result);
    }

}