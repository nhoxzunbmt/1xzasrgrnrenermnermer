<?php
namespace User\Form;
use \Zend\Form\Form as Form;

class RegisterEmail extends Form{
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
      
        //Tên thư báo
        $this->add(array(
            'name'  =>  'name',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                
                'class'         =>  'input_text',
            ),
            'options'   =>  array(
                'label' =>  'Tên thư báo',
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
                
                'class'         =>  'input_text',
            ),
            'options'   =>  array(
                'label' =>  'Email nhận thư báo',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Diện tích
        $this->add(array(
            'name'  =>  'area',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                
                'class'         =>  'input_text',
            ),
            'options'   =>  array(
                'label' =>  'Diện tích',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Diện tích
        $this->add(array(
            'name'  =>  'road',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
               
                'class'         =>  'input_text',
            ),
            'options'   =>  array(
                'label' =>  'Kích thước mặt đường',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        

       
    }
}