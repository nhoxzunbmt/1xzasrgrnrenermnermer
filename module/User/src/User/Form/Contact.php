<?php
namespace User\Form;
use \Zend\Form\Form as Form;

class Contact extends Form{
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
      
        //Dịch vụ
        $this->add(array(
            'name'  =>  'title',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                
                'class'         =>  'input_phone',
            ),
            'options'   =>  array(
                'label' =>  'Tên thư báo',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Họ tên
        $this->add(array(
            'name'  =>  'fullname',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                
                'class'         =>  'input_phone',
            ),
            'options'   =>  array(
                'label' =>  'Email nhận thư báo',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Email
        $this->add(array(
            'name'  =>  'email',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                
                'class'         =>  'input_phone',
            ),
            'options'   =>  array(
                'label' =>  'Diện tích',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Email
        $this->add(array(
            'name'  =>  'phone',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                
                'class'         =>  'input_phone',
            ),
            'options'   =>  array(
                'label' =>  'Diện tích',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Nội dung
        $this->add(array(
                'name'          => 'content',
                'type'          => 'Textarea',
                'attributes'    => array(
                        'class'     => 'textarea',
                        'cols'      =>  20,
                        'rows'      =>  2,  
                ),
        ));

        

       
    }
}