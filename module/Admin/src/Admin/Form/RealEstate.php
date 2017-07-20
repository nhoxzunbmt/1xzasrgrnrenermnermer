<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class RealEstate extends Form{
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

        //Title
        $this->add(array(
            'name'  =>  'title',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'input_title',
                'id'            =>  'textTitle',
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

        //Nội dung
        $this->add(array(
                'name'          => 'content',
                'type'          => 'Textarea',
                'attributes'    => array(
                        'class'     => 'textarea',
                        'cols'      =>  20,
                        'rows'      =>  2,  
                        'id'        =>  'content'
                ),
        ));


        //Diện tích
        $this->add(array(
            'name'  =>  'area',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'input_text',
                'id'            =>  'textArea',
                'placeholder'   =>  'Diện tích (m2)',
                'style'         =>  'width:100px;',
            ),
            'options'   =>  array(
                'label' =>  'Diện tích (m2)',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Hiển thị giá
        $this->add(array(
                'name'          => 'display_price',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'Hiển thị giá',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  1,
                        'unchecked_value'   =>  0
                ),
        ));

        //Tổng giá
        $this->add(array(
            'name'  =>  'price',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'input_text',
                'id'            =>  'textPrice',
                'placeholder'   =>  '',
                'style'         =>  'width:100px;',
            ),
            'options'   =>  array(
                'label' =>  'Tổng giá',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Giá / m2
        $this->add(array(
            'name'  =>  'price_m2',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'input_text',
                'id'            =>  'textPrice_m2',
                'placeholder'   =>  '',
                'style'         =>  'width:100px;',
            ),
            'options'   =>  array(
                'label' =>  'Giá/m2',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Đường rộng(m)
        $this->add(array(
            'name'  =>  'avenue',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'input_text',
                'id'            =>  'textArea',
                'placeholder'   =>  '',
                'style'         =>  'width:100px;',
            ),
            'options'   =>  array(
                'label' =>  'Đường rộng(m)',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Số phòng ngủ
        $this->add(array(
            'name'  =>  'bedroom',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'input_text',
                'id'            =>  'textArea',
                'placeholder'   =>  '',
                'style'         =>  'width:100px;',
            ),
            'options'   =>  array(
                'label' =>  'Số phòng ngủ',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Số nhà tắm
        $this->add(array(
            'name'  =>  'bathroom',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'input_text',
                'id'            =>  'textArea',
                'placeholder'   =>  '',
                'style'         =>  'width:100px;',
            ),
            'options'   =>  array(
                'label' =>  'Số nhà tắm',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Số nhà
        $this->add(array(
            'name'  =>  'numberhouse',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'input_text',
                'id'            =>  'textArea',
                'placeholder'   =>  '',
                'style'         =>  'width:100px;',
            ),
            'options'   =>  array(
                'label' =>  'Số nhà',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Tên đường
        $this->add(array(
            'name'  =>  'nameavenue',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'input_text',
                'id'            =>  'textArea',
                'placeholder'   =>  '',
                'style'         =>  'width:300px;',
            ),
            'options'   =>  array(
                'label' =>  'Tên đường',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

        //Tên liên hệ
        $this->add(array(
            'name'  =>  'fullname',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'input_text',
                'id'            =>  'textArea',
                'placeholder'   =>  '',
                'disabled'      =>'disabled',
                'readonly'      =>  'readonly',

            ),
            'options'   =>  array(
                'label' =>  'Tên liên hệ',
                'label_attributes'  =>  array(
                    'for'       =>  'inputEmail3',
                    'class'     =>  'col-sm3 control-label',
                    
                )
            )
        ));

        //Skype
        $this->add(array(
            'name'  =>  'phone',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'input_text',
                'id'            =>  'textArea',
                'placeholder'   =>  '',
                'disabled'      =>'disabled',
                'readonly'      =>  'readonly',

            ),
            'options'   =>  array(
                'label' =>  'Điện thoại',
                'label_attributes'  =>  array(
                    'for'       =>  'inputEmail3',
                    'class'     =>  'col-sm3 control-label',
                    
                )
            )
        ));

        //Skype
        $this->add(array(
            'name'  =>  'skype',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'input_text',
                'id'            =>  'textArea',
                'placeholder'   =>  '',
                'disabled'      =>'disabled',
                'readonly'      =>  'readonly',

            ),
            'options'   =>  array(
                'label' =>  'Skype',
                'label_attributes'  =>  array(
                    'for'       =>  'inputEmail3',
                    'class'     =>  'col-sm3 control-label',
                    
                )
            )
        ));

        //Email
        $this->add(array(
            'name'  =>  'email',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'input_text',
                'id'            =>  'textArea',
                'placeholder'   =>  '',
                'disabled'      =>'disabled',
                'readonly'      =>  'readonly',

            ),
            'options'   =>  array(
                'label' =>  'email',
                'label_attributes'  =>  array(
                    'for'       =>  'inputEmail3',
                    'class'     =>  'col-sm3 control-label',
                    
                )
            )
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
            'name'  =>  'button-submit',
            'type'  =>  'Button',
            'attributes'    =>  array(
                'type'  =>  'submit',
                'value' =>  'Đăng tin',
                'class' =>  'btn btn-success btn-sm',
            ),
            'options'   =>  array(
                'label' =>  'find User',
            )
        ));

        //Reset
        $this->add(array(
            'name'  =>  'button-reset',
            'type'  =>  'Button',
            'attributes'    =>  array(
                'type'  =>  'reset',
                'style' =>  'background: #e4e4e4;border: 0;color: #000000;font-weight: bold;',
                'value' =>  'Nhập lại',
                'onclick'   =>  'resetForm()'
            ),
            'options'   =>  array(
                'label' =>  'Reset',
            )
        ));
    }
}