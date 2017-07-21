<?php
namespace ZendVN\Validator;

use Zend\Validator\AbstractValidator;

class ConfirmPassword extends AbstractValidator{

	const NOT_EQUAL = 'NOT_EQUAL';
 
    protected $messageTemplates = array(
        self::NOT_EQUAL => 'Password & Confirm password không bằng nhau',
    );
 
    private $field;
 
    public function __construct(array $options = array())
    {
        if (! isset($options['field'])) {
            //throw new Exception\InvalidArgumentException('Field to check missing');
        }
 
        $this->field = $options['field'];
 
        parent::__construct($options);
    }
 
    public function isValid($value, $context = null)
    {
        if (! is_array($context) or ! isset($context[$this->field])) {
            //throw new Exception\RuntimeException(sprintf('Field "%s" missing in the context', $this->field));
        }
 
        $this->setValue($value);
 
        if ($value !== $context[$this->field]) {
            $this->error(self::NOT_EQUAL);
 
            return false;
        }
 
        return true;
    }


}