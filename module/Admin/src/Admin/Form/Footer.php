<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class Footer extends Form{
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
        

        
        //Liên hệ
        $this->add(array(
                'name'          => 'content',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Nội dung',
                        
                ),
                'attributes'    => array(
                        'class'     => 'textarea',
                        'style' =>'width:800px;height:300px;'  
                ),
        ));


       

      
        
    }
}