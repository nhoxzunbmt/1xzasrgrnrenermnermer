<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class EmailMarketing extends Form{
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
                'placeholder'   =>  'Tiêu đề chiến dịch email',
                'style'         =>  'width:600px;',
            ),
            'options'   =>  array(
                'label' =>  'Tiêu đề chiến dịch email',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

         $this->add(array(
                'name'          => 'email',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Gửi đến - địa chỉ email',
                        
                ),
                'attributes'    => array(
                        'class'     => 'textarea',
                        'style' =>'width:600px;height:100px;'  
                ),
        ));

         //File
        $this->add(array(
                'name'          => 'file',
                'type'          => 'File',
                'attributes'    => array(
                        'multiple'  => false,
                        'id'        => 'file',
                ),
                'options'       => array(
                        'label'             => 'Tập tin đính kèm',
                        
                ),
        ));
        
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