<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class ConfigMaintenance extends Form{
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
                'name'          => 'notice',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Thông báo',
                        
                ),
                'attributes'    => array(
                        'class'     => 'textarea',
                        'style' =>'width:800px;height:300px;'  
                ),
        ));

       //Hiển thị giá
        $this->add(array(
                'name'          => 'status',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'Đóng cửa, bảo trì website',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  1,
                        'unchecked_value'   =>  0
                ),
        ));

       
       

      
        
    }
}