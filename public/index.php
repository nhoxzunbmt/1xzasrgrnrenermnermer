<?php
//ad562ed675cf746e886308b57144220f8e
include 'define.php';

include LIBRARY_PATH . '/Zend/Loader/AutoloaderFactory.php';
        Zend\Loader\AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' 	=> true,
                'namespaces'		=> array(
                	'ZendVN'		=> LIBRARY_PATH .'/ZendVN',
                    'ZendGData'     => LIBRARY_PATH .'/ZendGData',
                    'Block'         => APPLICATION_PATH .'/block',
                    'Sidebar'         => APPLICATION_PATH .'/sidebar',
                ),
                'prefixes'			=>array(
                	'HTMLPurifier'	=> LIBRARY_PATH .'/HTMLPurifier'
                )		
            )
        ));

if (!class_exists('Zend\Loader\AutoloaderFactory')) {
    throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
}        

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
