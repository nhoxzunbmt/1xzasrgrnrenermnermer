<?php
namespace User\Form;
use \Zend\Form\Form as Form;

class Comment extends Form{
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
      
       
        //Nội dung
        $this->add(array(
                'name'          => 'content',
                'type'          => 'Textarea',
                'attributes'    => array(
                        'class'     => 'textarea',
                        'cols'      =>  20,
                        'rows'      =>  2,  
                ),
        ));

        

       
    }
}