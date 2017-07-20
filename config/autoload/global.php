<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
   'service_manager' => array(
      /*'factories' => array(
         'Zend\Db\Adapter\Adapter'
            => 'Zend\Db\Adapter\AdapterServiceFactory',
      ),
      'aliases'   => array(
         'dbConfig'  => 'Zend\Db\Adapter\Adapter'
      ),*/
      'abstract_factories' => array(
         'Zend\Db\Adapter\AdapterAbstractServiceFactory'
      ),
   ),
   'db' => array(
      'adapters'  => array(
         'dbBatDongSan' => array(
            'driver'    => 'Pdo_Mysql',
            'database'  => 'admin_zend2',
            'hostname'  => 'localhost',
            'charset'   => 'utf8',
         ),
         'dbVuiMuaSam' => array(
            'driver'    => 'Pdo_Mysql',
            'database'  => 'vuimuasam',
            'hostname'  => 'localhost',
            'charset'   => 'utf8',
         ),
      ),
   ),
);
