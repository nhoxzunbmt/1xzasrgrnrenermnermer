<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class ConfigWebsite extends Form{
    public function __construct(){
        parent::__construct();

        $this->setAttributes(array(
            'action'    =>  '',
            'method'    =>  'POST',
            'class'     =>  'form-horizontal',
            'role'      =>  'form',
            'name'      =>  'login-form',
            'id'        =>  'login-form',
            'enctype'   =>  'multipart/form-data',
        ));
        

        $this->add(array(
            'name'  =>  'title',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Tiêu đề website',
                'style'         =>  'width:300px;',
            ),
            'options'   =>  array(
                'label' =>  'Tiêu đề website',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));
        
        $this->add(array(
                'name'          => 'keyword',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Thẻ từ khóa',
                        
                ),
                'attributes'    => array(
                        'class'     => 'textarea',
                        'style' =>'width:800px;height:50px;'  
                ),
        ));

        $this->add(array(
                'name'          => 'description',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Thẻ mô tả',
                        
                ),
                'attributes'    => array(
                        'class'     => 'textarea',
                        'style' =>'width:800px;height:50px;'  
                ),
        ));
       

      
        
    }
}