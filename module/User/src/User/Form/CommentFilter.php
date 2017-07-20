<?php
namespace User\Form;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class CommentFilter extends InputFilter{
	public function __construct($options = null){
		
		if($options == null){
			
			
			$this->add(array(
				'name'	=>	'content',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Nội dung!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
					'name'	=>	'StringLength',
					'options'	=>	array(
						'min'	=>	10,
						'max'	=>	222,
						'messages'	=>	array(
							\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Nội dung lớn hơn %min% ký tự !',
							\Zend\Validator\StringLength::TOO_LONG=>'Chiều dài của Nội dung nhỏ hơn %max% ký tự !',
						),
					),
					//'break_chain_on_failure'	=> true
				),
					
				),
				
			));
			
		}

		if($options['task'] == 'edit'){

			
			
		}
		
	}
}