<?php
namespace Admin\Form;

use \Zend\Form\Form as Form;
use Zend\Form\Element as Element;

class Seo extends Form {
    
    public function __construct(){
        parent::__construct();
        
        // FORM Attribute
        
        
        // ID
        $this->add(array(
                'name'          => 'id',
                'attributes'    => array(
                        'type'  => 'hidden',
                ),
        ));
        
        // Action
        $this->add(array(
                'name'          => 'action',
                'attributes'    => array(
                        'type'  => 'hidden',
                ),
        ));
        
        // Name 
        $this->add(array(
                'name'          => 'name',
                'type'          => 'Text',
                'attributes'    => array(
                        'class'         =>  'TextInput',
                        'id'            =>  'textFullname',
                        'placeholder'   =>  'Tiêu đề',
                        'style'         =>  'width:300px;',
                        
                ),
                'options'       => array(
                        'label'             => 'Tiêu đề',
                        'label_attributes'  => array(
                                'for'       => 'name',
                                'class'     => 'col-xs-3 control-label',
                        )
                ),
        ));
        
        // Name 
        $this->add(array(
                'name'          => 'seo_keyword',
                'type'          => 'Text',
                'attributes'    => array(
                        'class'         =>  'TextInput',
                        'id'            =>  'textFullname',
                        'placeholder'   =>  'Thẻ từ khóa',
                        'style'         =>  'width:300px;',
                ),
                'options'       => array(
                        'label'             => 'Thẻ từ khóa',
                        'label_attributes'  => array(
                                'for'       => 'name',
                                'class'     => 'col-xs-3 control-label',
                        )
                ),
        ));
        
        // Description
        $this->add(array(
                'name'          => 'seo_description',
                'type'          => 'Textarea',
                'attributes'    => array(
                        'class'         => 'form-control',
                        'id'            => 'Thẻ mô tả',
                        'style'         =>  'width:300px;height:50px;',

                ),
                'options'       => array(
                        'label'             => 'Description',
                        'label_attributes'  => array(
                                'for'       => 'Thẻ mô tả',
                                'class'     => 'col-xs-3 control-label',
                        )
                ),
        ));
        
       
    }
    
    public function showMessage(){
        $messages = $this->getMessages();
        
        if(empty($messages)) return false;
        
        $xhtml = '<div class="callout callout-danger">';
        foreach($messages as $key => $msg){
            $xhtml .= sprintf('<p><b>%s:</b> %s</p>',ucfirst($key), current($msg));
        }
        $xhtml .= '</div>';
        return $xhtml;
    }
    
    
    
    
    
    
    
}