<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class News extends Form{
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

        //Tên doanh nghiệp
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

       

        
        


        //Gioi thiệu
        $this->add(array(
                'name'          => 'description',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Mô tả ngắn',
                        
                ),
                'attributes'    => array(
                        'class' => 'textarea',
                        //'cols'      =>  50,
                        //'rows'      =>  10,
                        'id'    =>'description',
                        'style' =>'width:600px;height:100px;'  
                ),
        ));

        //Liên hệ
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

       
        //Nhóm
        /*$this->add(array(
                'name'          => 'group_id',
                'type'          => 'Select',
                'attributes'    => array(
                        'style'     => 'padding: 4px 8px; width:206px;',
                        'id'        => 'my-type',
                        'value'     => '3'
                ),
                'options'       => array(
                        'label'             => 'Chọn nhóm',
                        //'empty_option'    => '--Chọn nhóm thành viên--',
                        'value_options' => array(
                                '1'     => 'Admin',
                                '2' => 'Moderator',
                                '3' => 'Member',
                        )
                ),
        ));*/

        //File
        $this->add(array(
                'name'          => 'image',
                'type'          => 'File',
                'attributes'    => array(
                        'multiple'  => false,
                        'id'        => 'image',
                ),
                'options'       => array(
                        'label'             => 'Hình đại diện',
                        
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