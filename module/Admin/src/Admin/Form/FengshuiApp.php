<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class FengshuiApp extends Form{
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
            'name'  =>  'birth',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Năm sinh',
                'style'         =>  'width:300px;',
            ),
            'options'   =>  array(
                'label' =>  'Năm sinh',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));


        $this->add(array(
                'name'          => 'sex',
                'type'          => 'Radio',
                'attributes'    => array(
                    'value'         => '1'
                ),
                'options'   => array(
                    'label'             => 'Giới tính',
                    'value_options'         => array(
                            '1'     => 'Nam',
                            '2'     => 'Nữ',
                            
                     )
                ),
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

        
    }
}