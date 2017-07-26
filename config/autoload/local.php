<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return array(
   'db' => array(
      	'adapters'	=>	array(
      		'dbBatDongSan'	=>	array(
      			'username'	=>	'root',
      			'password'	=>	'',
      		),
      		'dbVuiMuaSam'	=>	array(
      			'username'	=>	'root',
      			'password'	=>	'',
      		),
      	),
   ),
    'gg' => array(
        'clientId' => '24994711283-rk6k98c6hadt088akukd680c8hlaok09.apps.googleusercontent.com',
        'clientSecret' => 'e6OAammI0l1m8G6JiHmtkVCR',
        'redirectURL' => 'http://dev.bds.com/home/user/gg-callback'
    )
);