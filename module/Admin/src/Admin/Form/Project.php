<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class Project extends Form{
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

        //Tên dự án
        $this->add(array(
            'name'  =>  'name',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Tên dự án',
                'style'         =>  'width:300px;',
            ),
            'options'   =>  array(
                'label' =>  'Tên dự án',
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
                'id'            =>  'textFullname',
                'placeholder'   =>  'Địa chỉ',
                'style'         =>  'width:300px;',
            ),
            'options'   =>  array(
                'label' =>  'Địa chỉ',
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
                'placeholder'   =>  'Diện tích(m2)',
                'style'         =>  'width:200px;',
            ),
            'options'   =>  array(
                'label' =>  'Diện tích(m2)',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Diện tích
        $this->add(array(
            'name'  =>  'price_m2',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Giá (Triệu/ m2)',
                'style'         =>  'width:200px;',
            ),
            'options'   =>  array(
                'label' =>  'Giá (Triệu/ m2)',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));


            
         //ngày khởi công
        $this->add(array(
            'name'  =>  'workstart',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textworkstart',
                'placeholder'   =>  'Ngày khởi công',
                'style'         =>  'width:200px;',
            ),
            'options'   =>  array(
                'label' =>  'Ngày khởi công',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

         //ngày hoàn thành
        $this->add(array(
            'name'  =>  'workend',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'workend',
                'placeholder'   =>  'Ngày hoành thành',
                'style'         =>  'width:200px;',
            ),
            'options'   =>  array(
                'label' =>  'Ngày hoành thành',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

         //Tên gọi khác
        $this->add(array(
            'name'  =>  'nameother',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'workend',
                'placeholder'   =>  'Tên gọi khác',
                'style'         =>  'width:300px;',
            ),
            'options'   =>  array(
                'label' =>  'Tên gọi khác',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));
        //Tổng quan
        $this->add(array(
                'name'          => 'overview',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Tổng quan',
                        
                ),
                'attributes'    => array(
                        'class' => 'textarea',
                        //'cols'      =>  50,
                        //'rows'      =>  10,
                        'id'    =>'overview',
                        'style' =>'width:800px;height:200px;'  
                ),
        ));

        //Tổng quan
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
                        'id'    =>'intro',
                        'style' =>'width:800px;height:200px;'  
                ),
        ));

        //Hạ tầng - dịch vụ
        $this->add(array(
                'name'          => 'service',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Hạ tầng - dịch vụ',
                        
                ),
                'attributes'    => array(
                        'class' => 'textarea',
                        //'cols'      =>  50,
                        //'rows'      =>  10,
                        'id'    =>'service',
                        'style' =>'width:800px;height:200px;'  
                ),
        ));

        //Vị trí
        $this->add(array(
                'name'          => 'location',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Vị trí',
                        
                ),
                'attributes'    => array(
                        'class' => 'textarea',
                        //'cols'      =>  50,
                        //'rows'      =>  10,
                        'id'    =>'location',
                        'style' =>'width:800px;height:200px;'  
                ),
        ));
        
         //Sơ đồ mặt bằng
        $this->add(array(
                'name'          => 'siteplan',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Sơ đồ mặt bằng',
                        
                ),
                'attributes'    => array(
                        'class' => 'textarea',
                        //'cols'      =>  50,
                        //'rows'      =>  10,
                        'id'    =>'siteplan',
                        'style' =>'width:800px;height:200px;'  
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
                        'class' => 'textarea',
                        //'cols'      =>  50,
                        //'rows'      =>  10,
                        'id'    =>'contact',
                        'style' =>'width:800px;height:200px;'  
                ),
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