<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class FileManager extends Form{
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
                'placeholder'   =>  'Tên thư mục',
                'style'         =>  'width:300px;',
            ),
            'options'   =>  array(
                'label' =>  'Tên thư mục',
                'label_attributes'  =>  array(
                    'for'   =>  'inputEmail3',
                    'class' =>  'col-sm3 control-label',
                )
            )
        ));

         $this->add(array(
                'name'          => 'description',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Mô tả',
                        
                ),
                'attributes'    => array(
                        'class'     => 'textarea',
                        'style' =>'width:500px;height:50px;'  
                ),
        ));

        
        $this->add(array(
                'name'          => 'ChmodOwnerRead',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'ChmodOwnerRead',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  4,
                        'unchecked_value'   =>  0
                ),
        ));

        $this->add(array(
                'name'          => 'ChmodOwnerWrite',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'ChmodOwnerRead',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  2,
                        'unchecked_value'   =>  0
                ),
        ));

        $this->add(array(
                'name'          => 'ChmodOwnerExecute',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'ChmodOwnerRead',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  1,
                        'unchecked_value'   =>  0
                ),
        ));

        $this->add(array(
                'name'          => 'ChmodGroupRead',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'ChmodOwnerRead',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  4,
                        'unchecked_value'   =>  0
                ),
        ));

        $this->add(array(
                'name'          => 'ChmodGroupWrite',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'ChmodOwnerRead',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  2,
                        'unchecked_value'   =>  0
                ),
        ));

        $this->add(array(
                'name'          => 'ChmodGroupExecute',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'ChmodOwnerRead',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  1,
                        'unchecked_value'   =>  0
                ),
        ));


        $this->add(array(
                'name'          => 'ChmodEveryoneRead',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'ChmodOwnerRead',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  4,
                        'unchecked_value'   =>  0
                ),
        ));

         $this->add(array(
                'name'          => 'ChmodEveryoneWrite',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'ChmodOwnerRead',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  2,
                        'unchecked_value'   =>  0
                ),
        ));

         $this->add(array(
                'name'          => 'ChmodEveryoneExecute',
                'type'          => 'Checkbox',
                'attributes'    => array(
                        //'checked'   => true,
                ),
                'options'       => array(
                        'label'             => 'ChmodOwnerRead',
                        'label_attributes'  => array(
                                'for'       => 'my-checkbox',
                        ),
                        'use_hidden_element'=>  true,
                        'checked_value'     =>  1,
                        'unchecked_value'   =>  0
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