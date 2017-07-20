<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class ConfigEmail extends Form{
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
            'name'  =>  'protocol',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Sử dụng giao thức để gửi mail',
                'style'         =>  'width:500px;',
            ),
            'options'   =>  array(
                'label' =>  'Sử dụng giao thức để gửi mail',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        $this->add(array(
            'name'  =>  'server',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Server Email',
                'style'         =>  'width:500px;',
            ),
            'options'   =>  array(
                'label' =>  'Server Email',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        $this->add(array(
            'name'  =>  'email',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Email sử dụng',
                'style'         =>  'width:500px;',
            ),
            'options'   =>  array(
                'label' =>  'Email sử dụng',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        $this->add(array(
            'name'  =>  'password',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Password Email',
                'style'         =>  'width:500px;',
            ),
            'options'   =>  array(
                'label' =>  'Password Email',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));
        
         $this->add(array(
            'name'  =>  'port',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Port',
                'style'         =>  'width:150px;',
            ),
            'options'   =>  array(
                'label' =>  'Port',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

       
       

      
        
    }
}