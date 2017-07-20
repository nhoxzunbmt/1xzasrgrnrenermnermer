<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class Ads extends Form{
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
                'placeholder'   =>  'Tiêu đề quảng cáo',
                'style'         =>  'width:300px;',
            ),
            'options'   =>  array(
                'label' =>  'Tiêu đề quảng cáo',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        $this->add(array(
            'name'  =>  'url',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Url quảng cáo',
                'style'         =>  'width:300px;',
            ),
            'options'   =>  array(
                'label' =>  'Url quảng cáo',
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
                //'placeholder'   =>  'Rộng',
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
                //'placeholder'   =>  'Rộng',
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
                        'label'             => 'Hình ảnh quảng cáo',
                        
                ),
        ));
        
       
        

        //ID
        $this->add(array(
            'name'  =>  'id',
            
            'attributes'    =>  array(
                'type'  =>  'hidden',
                
            ),
            
        ));

        //Submit
        $this->add(array(
            'name'  =>  'my-button-submit',
            'type'  =>  'Button',
            'attributes'    =>  array(
                'type'  =>  'submit',
                'class' =>  'btn btn-success btn-sm',
            ),
            'options'   =>  array(
                'label' =>  'find User',
            )
        ));

        //Reset
        $this->add(array(
            'name'  =>  'my-button-reset',
            'type'  =>  'Button',
            'attributes'    =>  array(
                'type'  =>  'reset',
                'class' =>  'btn btn-default btn-sm',
                'value' =>  'Reset',
                'onclick'   =>  'resetForm()'
            ),
            'options'   =>  array(
                'label' =>  'Reset',
            )
        ));
    }
}