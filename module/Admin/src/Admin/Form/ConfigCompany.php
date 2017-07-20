<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class ConfigCompany extends Form{
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
            'name'  =>  'name',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Tên công ty',
                'style'         =>  'width:500px;',
            ),
            'options'   =>  array(
                'label' =>  'Tên công ty',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        $this->add(array(
            'name'  =>  'slogan',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'slogan',
                'style'         =>  'width:500px;',
            ),
            'options'   =>  array(
                'label' =>  'slogan',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        $this->add(array(
            'name'  =>  'address',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Địa chỉ',
                'style'         =>  'width:500px;',
            ),
            'options'   =>  array(
                'label' =>  'Địa chỉ',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        $this->add(array(
            'name'  =>  'phone',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Số điện thoại',
                'style'         =>  'width:150px;',
            ),
            'options'   =>  array(
                'label' =>  'Số điện thoại',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));
        
        $this->add(array(
            'name'  =>  'fax',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Fax',
                'style'         =>  'width:150px;',
            ),
            'options'   =>  array(
                'label' =>  'Fax',
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
                'placeholder'   =>  'Email',
                'style'         =>  'width:150px;',
            ),
            'options'   =>  array(
                'label' =>  'Email',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        $this->add(array(
            'name'  =>  'website',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Website',
                'style'         =>  'width:150px;',
            ),
            'options'   =>  array(
                'label' =>  'Website',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));
       

      
        
    }
}