<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class ConfigAdvance extends Form{
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
            'name'  =>  'GoogleAnalyticsCode',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Google Analytics Code',
                'style'         =>  'width:500px;',
            ),
            'options'   =>  array(
                'label' =>  'Google Analytics Code',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

       //Hiển thị giá
        $this->add(array(
                'name'          => 'activeAccountEmail',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'Kích hoạt tài khoản email',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  1,
                        'unchecked_value'   =>  0
                ),
        ));

        $this->add(array(
            'name'  =>  'limitSendEmailMarketing',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Giới hạn gửi email marketing',
                'style'         =>  'width:500px;',
            ),
            'options'   =>  array(
                'label' =>  'Giới hạn gửi email marketing',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

       
       

      
        
    }
}