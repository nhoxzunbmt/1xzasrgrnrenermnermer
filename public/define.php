<?php
//đường dẫn thư mục hiện tại
chdir(dirname(__DIR__));

define('APPLICATION_ENV',
			(getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV')
											:'production'));

//Hằng số lưu đường dẫn thư mục ứng dụng
define('APPLICATION_PATH',realpath(dirname(__DIR__)));
define('DS',DIRECTORY_SEPARATOR);

//Hằng số lưu đường dẫn thư mục thư viện
define('LIBRARY_PATH',APPLICATION_PATH . DS . 'vendor');

//Hằng số lưu đường dẫn thư mục thư viện HTMLPurifier
define('HTMLPURIFIER_PREFIX',APPLICATION_PATH . DS . 'vendor');

//Hằng số lưu đường dẫn thư mục public
define('PUBLIC_PATH',APPLICATION_PATH . DS . 'public');

//Hằng số lưu đường dẫn thư mục templates
define('TEMPLATE_PATH', PUBLIC_PATH . DS . 'templates');


//Hằng số lưu đường dẫn thư mục upload
define('UPLOAD_PATH',PUBLIC_PATH . DS . 'upload');

//Hằng số lưu đường dẫn thư mục file-manager
define('FILE_MANAGER_PATH',UPLOAD_PATH . DS . 'file-manager');

//Hằng số lưu đường dẫn thư mục upload
define('CAPTCHA_PATH',PUBLIC_PATH . DS . 'captcha');


define('APPLICATION_URL','');
define('PUBLIC_URL', APPLICATION_URL .'/public');

//Đường dẫn Url đến thư mục upload
define('UPLOAD_URL',APPLICATION_URL.'/public/upload');
//Đường dẫn tới thư mục Captcha
define('CAPTCHA_URL',APPLICATION_URL.'/public/captcha');
//Đường dẫn tới thư mục file-manager
define('FILE_MANAGER_URL',UPLOAD_URL.'/file-manager');
define('FILE_MANAGER_URL_CODINH','public/upload/file-manager');
//Đường dẫn Url đến thư mục templates
define('TEMPLATE_URL',APPLICATION_URL .'/public/templates');
//Đường dẫn Url đến thư mục Editor
define('EDITOR_URL',APPLICATION_URL .'/public/scripts/editor');

