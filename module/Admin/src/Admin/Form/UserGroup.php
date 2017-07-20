<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class UserGroup extends Form{
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
      

        //Tên nhóm
        $this->add(array(
            'name'  =>  'group_name',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'textFullname',
                'placeholder'   =>  'Tên nhóm khách hàng',
                'style'         =>  'width:300px;',
            ),
            'options'   =>  array(
                'label' =>  'Tên nhóm khách hàng',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

         //Màu nhóm
        $this->add(array(
            'name'  =>  'color',
            'type'  =>  'Text',
            'attributes'    =>  array(
                'class'         =>  'TextInput',
                'id'            =>  'colorpickerField1',
                'placeholder'   =>  'Màu nhóm',
                'style'         =>  'width:100px;',
            ),
            'options'   =>  array(
                'label' =>  'Màu nhóm',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));
        //Admin Control Panel
        $this->add(array(
                'name'          => 'group_acp',
                'type'          => 'Radio',
                'attributes'    => array(
                    'value'         => '1'
                ),
                'options'   => array(
                    'label'             => 'Admin Control Panel',
                    'value_options'         => array(
                            '1'     => 'No',
                            '2'     => 'Yes',
                            
                     )
                ),
        ));

        //Group default
        $this->add(array(
                'name'          => 'group_default',
                'type'          => 'Radio',
                'attributes'    => array(
                    'value'         => '1'
                ),
                'options'   => array(
                    'label'             => 'Group default',
                    'value_options'         => array(
                            '1'     => 'No',
                            '2'     => 'Yes',
                            
                     )
                ),
        ));

        //Group default
        $this->add(array(
                'name'          => 'status',
                'type'          => 'Radio',
                'attributes'    => array(
                    'value'         => '1'
                ),
                'options'   => array(
                    'label'             => 'Status',
                    'value_options'         => array(
                            '0'     => 'Không kích hoạt',
                            '1'     => 'Kích hoạt',
                            
                     )
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