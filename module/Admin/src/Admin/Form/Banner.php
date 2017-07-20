<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class Banner extends Form{
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
            'name'  =>  'url',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Link Url',
                'style'         =>  'width:300px;',
            ),
            'options'   =>  array(
                'label' =>  'Link Url',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        $this->add(array(
            'name'  =>  'width',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                //'placeholder'   =>  'Chiều rộng',
                'style'         =>  'width:50px;',
            ),
            'options'   =>  array(
                'label' =>  'Chiều rộng',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        $this->add(array(
            'name'  =>  'height',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                //'placeholder'   =>  'Chiều cao',
                'style'         =>  'width:50px;',
            ),
            'options'   =>  array(
                'label' =>  'Chiều cao',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

      
        //File
        $this->add(array(
                'name'          => 'image',
                'type'          => 'File',
                'attributes'    => array(
                        'multiple'  => false,
                        'id'        => 'image',
                ),
                'options'       => array(
                        'label'             => 'Logo',
                        
                ),
        ));

      
        
    }
}