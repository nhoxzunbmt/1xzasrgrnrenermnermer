<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class ConfigDisplay extends Form{
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
        

       

        //Hiển thị giá
        $this->add(array(
                'name'          => 'descriptionNews',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'Hiển thị mô tả ngắn tin tức',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  1,
                        'unchecked_value'   =>  0
                ),
        ));

       //Hiển thị giá
        $this->add(array(
                'name'          => 'descriptionRealEstate',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'Hiển thị mô tả ngắn BĐS',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  1,
                        'unchecked_value'   =>  0
                ),
        ));

        $this->add(array(
                'name'          => 'descriptionLegalhousing',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'Hiển thị mô tả ngắn Pháp lý nhà đất',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  1,
                        'unchecked_value'   =>  0
                ),
        ));

        $this->add(array(
                'name'          => 'commentFacebook',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'Hiển thị comment Facebook',
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