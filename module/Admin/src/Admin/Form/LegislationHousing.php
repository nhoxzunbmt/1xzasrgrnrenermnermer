<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class LegislationHousing extends Form{
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
        //add Field set Email
        //$this->add(new \Admin\Form\UserFieldset());

        //Tiêu đề
        $this->add(array(
            'name'  =>  'title',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Tiêu đề',
                'style'         =>  'width:300px;',
            ),
            'options'   =>  array(
                'label' =>  'Tiêu đề',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

         //Số hiệu
        $this->add(array(
            'name'  =>  'number',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Số hiệu',
                'style'         =>  'width:200px;',
            ),
            'options'   =>  array(
                'label' =>  'Số hiệu',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

         //Số hiệu
        $this->add(array(
            'name'  =>  'placeissued',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Nơi ban hành',
                'style'         =>  'width:200px;',
            ),
            'options'   =>  array(
                'label' =>  'Nơi ban hành',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

         //Ngày ban hành
        $this->add(array(
            'name'  =>  'dateissued',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'text_dateissued',
                'placeholder'   =>  'Ngày ban hành',
                'style'         =>  'width:200px;',
            ),
            'options'   =>  array(
                'label' =>  'Ngày ban hành',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));
         //Ngày hiệu lực
        $this->add(array(
            'name'  =>  'effectivedate',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'text_effectivedate',
                'placeholder'   =>  'Ngày hiệu lực',
                'style'         =>  'width:200px;',
            ),
            'options'   =>  array(
                'label' =>  'Ngày hiệu lực',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

         //Ngày hết hiệu lực
        $this->add(array(
            'name'  =>  'expirydate',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'text_expirydate',
                'placeholder'   =>  'Ngày hết hiệu lực',
                'style'         =>  'width:200px;',
            ),
            'options'   =>  array(
                'label' =>  'Ngày hết hiệu lực',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));


         //Hiệu lực
        $this->add(array(
            'name'  =>  'effect',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Hiệu lực',
                'style'         =>  'width:200px;',
            ),
            'options'   =>  array(
                'label' =>  'Hiệu lực',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //content
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