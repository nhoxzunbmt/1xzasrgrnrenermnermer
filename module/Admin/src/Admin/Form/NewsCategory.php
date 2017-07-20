<?php
namespace Admin\Form;

use \Zend\Form\Form as Form;
use Zend\Form\Element as Element;

class NiceHouseCategory extends Form {
    
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
                        'placeholder'   =>  'Danh mục',
                        'style'         =>  'width:300px;',
                ),
                'options'       => array(
                        'label'             => 'Danh mục',
                        'label_attributes'  => array(
                                'for'       => 'name',
                                'class'     => 'col-xs-3 control-label',
                        )
                ),
        ));
        
       
        
       
        
        // Status
        $this->add(array(
                'name'          => 'status',
                'type'          => 'Select',
                'options'       => array(
                        
                        'value_options' => array(
                                '1'    => 'Active',
                                '0'  => 'InActive',
                        ),
                        'label' => 'Status',
                        'label_attributes'  => array(
                                'for'       => 'status',
                                'class'     => 'col-xs-3 control-label',
                        ),
                ),
                'attributes'    => array(
                        'class'         => 'form-control',
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