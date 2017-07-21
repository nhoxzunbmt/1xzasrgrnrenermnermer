<?php
namespace ZendVN\View\Helper;
use Zend\Form\View\Helper\FormElementErrors;
class ErrorMessages extends FormElementErrors{
    public function __invoke($errors,$module = 'user'){
        $xhtmlError = '';
        if($module == 'user'){
            if(!empty($errors)){
                foreach($errors as $error){
                    $xhtmlError .= '<div id="cph_Main_ctl00_notification_rptNotice_divMessage_0" class="alert alert-error"> '.$error.'
			                        </div>';
                }
            }
        }
        if($module == 'admin'){
            if(!empty($errors)){
                foreach($errors as $key=> $error){
                    $xhtmlError .= '<div id="cph_Main_ctl00_notification_rptNotice_divMessage_'.$key.'" class="alert alert-error">'.$error.'<button data-dismiss="alert" class="close">×</button>
	            					</div>';
                }
            }
        }
        return $xhtmlError;
    }

}