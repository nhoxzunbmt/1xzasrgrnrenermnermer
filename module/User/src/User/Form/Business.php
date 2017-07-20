<?php
namespace User\Form;
use \Zend\Form\Form as Form;

class Business extends Form{
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
            'name'  =>  'name',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Tên doanh nghiệp',
                'class'         =>  'input_text',
            ),
            'options'   =>  array(
                'label' =>  'Tên doanh nghiệp',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Tên doanh nghiệp
        $this->add(array(
            'name'  =>  'alias',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Tên alias doanh nghiệp',
                'class'         =>  'input_text',
            ),
            'options'   =>  array(
                'label' =>  'Tên alias doanh nghiệp',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Địa chỉ
        $this->add(array(
            'name'  =>  'address',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textbirthday',
                'placeholder'   =>  'Địa chỉ',
                'class'         =>  'input_text',
            ),
            'options'   =>  array(
                'label' =>  'Địa chỉ',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        
        //phone
        $this->add(array(
            'name'  =>  'phone',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textPhone',
                'placeholder'   =>  'Số điện thoại',
                'class'         =>  'input_text',
            ),
            'options'   =>  array(
                'label' =>  'Số điện thoại',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //fax
        $this->add(array(
            'name'  =>  'fax',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textYahoo',
                'placeholder'   =>  'Fax',
                'class'         =>  'input_text',
            ),
            'options'   =>  array(
                'label' =>  'Fax',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //website
        $this->add(array(
            'name'  =>  'website',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textYahoo',
                'placeholder'   =>  'Website',
                'class'         =>  'input_text',
            ),
            'options'   =>  array(
                'label' =>  'Website',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Gioi thiệu
        $this->add(array(
                'name'          => 'intro',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Giới thiệu',
                        
                ),
                'attributes'    => array(
                        'class' => 'textarea',
                        //'cols'      =>  50,
                        //'rows'      =>  10,
                        'style' =>'width:400px;height:100px;'  
                ),
        ));

        //Liên hệ
        $this->add(array(
                'name'          => 'contact',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Liên hệ',
                        
                ),
                'attributes'    => array(
                        'class'     => 'textarea',
                        'style' =>'width:400px;height:100px;'  
                ),
        ));

        //Chi nhánh
        $this->add(array(
                'name'          => 'department',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Chi nhánh',
                        
                ),
                'attributes'    => array(
                        'class'     => 'textarea',
                        'style' =>'width:400px;height:100px;'  
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
                        'label'             => 'Avatar',
                        
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