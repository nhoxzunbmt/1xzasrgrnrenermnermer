<?php
namespace ZendVN\View\Helper;
use Zend\Form\View\Helper\FormElementErrors;
use Zend\Form\ElementInterface;
class ElementError extends FormElementErrors{
	public function __invoke(ElementInterface $element = null){
        $messages = $element->getMessages();
        if(empty($messages)) return '';
        return sprintf('<div id="cph_Main_ctl00_notification_rptNotice_divMessage_0" class="alert">%s<button data-dismiss="alert" class="close">×</button>
	            </div>',current($messages));
    }

}