<?php
namespace ZendVN\Url;
use Zend\Filter as ZFilter;
class FriendlyLink{
    
    public static function filter($input){
        $filterChain    = new ZFilter\FilterChain();
        $filterChain->attach(new ZFilter\StringToLower(array('encoding'=>'UTF-8')))
                    ->attach(new \Zend\I18n\Filter\Alnum(true))
                    ->attach(new \ZendVN\Filter\RemoveCircuflex())
                    ->attach(new \Zend\Filter\PregReplace(array(
                        'pattern'     => '#\s+#',
                        'replacement' => '-',
                    )))
                    ->attach(new \Zend\Filter\Word\CamelCaseToDash());
                    
                    
        $output = $filterChain->filter($input);
        
        return $output;
    }

}