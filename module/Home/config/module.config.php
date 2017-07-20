<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Home\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'AuthRedirect' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/user/account/',
                    'defaults' => array(
                        'controller' => 'User\Controller\Account',
                        'action'     => 'index',
                    ),
                ),
            ),
            //=====Tin bất động sản=====
            //Trang Bất động sản
            'ListBatDongSanRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/bat-dong-san.html',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Realestate',
                            'action'            => 'index',
                            
                    ),
                    'spec'      => '/bat-dong-san.html',
                ),
            ),
            //category
            'CategoryBatDongSanRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/bat-dong-san-((?<type>[a-zA-Z][a-zA-Z0-9-_]+)/(?<name>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<transaction>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Realestate',
                            'action'            => 'category',
                            'type'              => 'tat-ca',
                            'name'              => 'nha-dat',
                            'page'              => '1',
                            'transaction'       => '1',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/bat-dong-san-%type%/%name%/%page%-%transaction%-%id%.%extension%',
                ),
            ),
            //Bất động sản theo thành phố
            'CityBatDongSanRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/bat-dong-san/((?<type>[a-zA-Z][a-zA-Z0-9-_]+)/(?<cityname>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<cityid>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Realestate',
                            'action'            => 'city',
                            'type'              => 'tat-ca',
                            'cityname'          => 'toan-quoc',
                            'page'              => '1',
                            'cityid'            => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/bat-dong-san/%type%/%cityname%/%page%-%cityid%.%extension%',
                ),
            ),
            //Tìm kiếm BĐS
            /*'SearchBatDongSanRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/bat-dong-san/tim-kiem/((?<keyword>[a-zA-Z][a-zA-Z0-9-_]+)/(?<cat>[0-9]+)/(?<city>[0-9]+)/(?<district>[0-9]+)/(?<price>[0-9-]+)/(?<area>[0-9-]+)/(?<project>[0-9]+))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Realestate',
                            'action'            => 'search',
                            'keyword'           => '',
                            'cat'               => '',
                            'city'              => '',
                            'district'          => '',
                            'price'             => '',
                            'area'              => '',
                            'project'           => '',
                    ),
                    'spec'      => '/bat-dong-san/tim-kiem/%keyword%/%cat%/%city%/%district%/%price%/%area/%project%',
                ),
            ),*/
             //Bất động sản theo quận huyện
            'DistrictBatDongSanRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/bat-dong-san/((?<type>[a-zA-Z][a-zA-Z0-9-_]+)/(?<cityname>[a-zA-Z][a-zA-Z0-9-_]+)/(?<districtname>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<cityid>[0-9]+)-(?<iddistrict>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Realestate',
                            'action'            => 'district',
                            'type'              => 'tat-ca',
                            'cityname'          => 'tp-ho-chi-minh',
                            'districtname'      => 'quan-1',
                            'page'              => '1',
                            'cityid'                => '1',
                            'iddistrict'        =>  '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/bat-dong-san/%type%/%cityname%/%districtname%/%page%-%cityid%-%iddistrict%.%extension%',
                ),
            ),
            //detail
            'DetailBatDongSanRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/bat-dong-san/(?<namecategory>[a-zA-Z][a-zA-Z0-9-_]+)/((?<title>[a-zA-Z][a-zA-Z0-9-_]+)-(?<cid>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Realestate',
                            'action'            => 'detail',
                            'namecategory'      => 'nha-dan-ban',
                            'title'             => 'bat-dong-san-chi-tiet',
                            'cid'               => '10',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/bat-dong-san/%namecategory%/%title%-%cid%-%id%.%extension%',
                ),
            ),

            //===Doanh nghiệp BĐS====
            //Danh sách doanh nghiệp
            'ListBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/doanh-nghiep.html',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'business',
                            
                    ),
                    'spec'      => '/doanh-nghiep.html',
                ),
            ),
            //category
            'CategoryBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/doanh-nghiep-bds/((?<name>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'category',
                            'name'              => 'sgd-bat-dong-san',
                            'page'              => '1',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/doanh-nghiep-bds/%name%/%page%-%id%.%extension%',
                ),
            ),
            //Doanh nghiệp theo thành phố
            'CityBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/doanh-nghiep/((?<cityname>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<cityid>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'city',
                            'cityname'          => 'tp-ho-chi-minh',
                            'page'              => '1',
                            'cityid'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/doanh-nghiep/%cityname%/%page%-%cityid%.%extension%',
                ),
            ),
            //Doanh nghiệp theo quận huyện
            'DistrictBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/doanh-nghiep/((?<cityname>[a-zA-Z][a-zA-Z0-9-_]+)/(?<districtname>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<cityid>[0-9]+)-(?<iddistrict>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'district',
                            'cityname'          => 'tp-ho-chi-minh',
                            'districtname'      => 'quan-1',
                            'page'              => '1',
                            'cityid'                => '1',
                            'iddistrict'        =>  '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/doanh-nghiep/%cityname%/%districtname%/%page%-%cityid%-%iddistrict%.%extension%',
                ),
            ),
             //Tìm doanh nghiệp
            'SearchBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/doanh-nghiep/tim-kiem/((?<name>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'search',
                            'name'              => 'sgd-bat-dong-san',
                            'page'              => '1',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/doanh-nghiep/tim-kiem/%name%/%page%-%id%.%extension%',
                ),
            ),
            //Intro
            'IntroBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/(?<alias>[a-zA-Z][a-zA-Z0-9-_]+)(/)?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'detail',
                            'alias'              => 'seareal',
                    ),
                    'spec'      => '/%alias%',
                ),
            ),
            //Liên hệ
            'ContactBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/(?<alias>[a-zA-Z][a-zA-Z0-9-_]+)/(?<contact>lien-he)',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'contact',
                            'alias'             => 'seareal',
                            'contact'           => 'lien-he',
                           
                    ),
                    'spec'      => '/%alias%/%contact%',
                ),
            ),
            //Chi nhánh
            'DepartmentBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/(?<alias>[a-zA-Z][a-zA-Z0-9-_]+)/(?<department>chi-nhanh)',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'department',
                            'alias'             => 'seareal',
                            'department'        => 'chi-nhanh',
                            
                    ),
                    'spec'      => '/%alias%/%department%',
                ),
            ),
            //Nhà đất bán
            'LandSaleBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/(?<alias>[a-zA-Z][a-zA-Z0-9-_]+)/(?<landsale>[a-zA-Z][a-zA-Z0-9-_]+)/(?<transaction>[ban]+)-(?<page>[0-9]+)',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'landsale',
                            'alias'             => 'seareal',
                            'landsale'          => 'nha-dat',
                            'transaction'       => 'ban',
                            'page'              => '1',
                            
                    ),
                    'spec'      => '/%alias%/%landsale%/%transaction%-%page%',
                ),
            ),
            //Nhà đất cho thuê
            'LandForRentBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/(?<alias>[a-zA-Z][a-zA-Z0-9-_]+)/(?<landforrent>[a-zA-Z][a-zA-Z0-9-_]+)/(?<transaction>cho-thue)-(?<page>[0-9]+)',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'landforrent',
                            'alias'             => 'seareal',
                            'landforrent'          => 'nha-dat',
                            'transaction'       => 'cho-thue',
                            'page'              => '1',
                            
                    ),
                    'spec'      => '/%alias%/%landforrent%/%transaction%-%page%',
                ),
            ),
            //Dự án chủ đầu tư
            'investorsBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/(?<alias>[a-zA-Z][a-zA-Z0-9-_]+)/(?<project>du-an)/(?<type>chu-dau-tu)-(?<page>[0-9]+)',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'investors',
                            'alias'             => 'seareal',
                            'project'           => 'du-an',
                            'type'              => 'chu-dau-tu',
                            'page'              => '1',
                            
                    ),
                    'spec'      => '/%alias%/%project%/%type%-%page%',
                ),
            ),
            //Dự án thi công
            'constructionBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/(?<alias>[a-zA-Z][a-zA-Z0-9-_]+)/(?<project>du-an)/(?<type>thi-cong)-(?<page>[0-9]+)',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'construction',
                            'alias'             => 'seareal',
                            'project'           => 'du-an',
                            'type'              => 'thi-cong',
                            'page'              => '1',
                            
                    ),
                    'spec'      => '/%alias%/%project%/%type%-%page%',
                ),
            ),

            //Dự án quản lý
            'managementBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/(?<alias>[a-zA-Z][a-zA-Z0-9-_]+)/(?<project>du-an)/(?<type>quan-ly)-(?<page>[0-9]+)',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'management',
                            'alias'             => 'seareal',
                            'project'           => 'du-an',
                            'type'              => 'quan-ly',
                            'page'              => '1',
                            
                    ),
                    'spec'      => '/%alias%/%project%/%type%-%page%',
                ),
            ),

            //Dự án thiết kế
            'designBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/(?<alias>[a-zA-Z][a-zA-Z0-9-_]+)/(?<project>du-an)/(?<type>thiet-ke)-(?<page>[0-9]+)',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'design',
                            'alias'             => 'seareal',
                            'project'           => 'du-an',
                            'type'              => 'thiet-ke',
                            'page'              => '1',
                            
                    ),
                    'spec'      => '/%alias%/%project%/%type%-%page%',
                ),
            ),

            //Dự án thiết kế
            'distributorsBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/(?<alias>[a-zA-Z][a-zA-Z0-9-_]+)/(?<project>du-an)/(?<type>phan-phoi)-(?<page>[0-9]+)',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Business',
                            'action'            => 'distributors',
                            'alias'             => 'seareal',
                            'project'           => 'du-an',
                            'type'              => 'phan-phoi',
                            'page'              => '1',
                            
                    ),
                    'spec'      => '/%alias%/%project%/%type%-%page%',
                ),
            ),
            //====End Doanh nghiệp===
            //====Môi giới======
            //Danh sách Môi giới
            'AgencyBusinessRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/moi-gioi/((?<cityname>[a-zA-Z][a-zA-Z0-9-_]+)-)?(?<cityid>[0-9]+)-(?<page>[0-9]+)(/)?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Agency',
                            'action'            => 'category',
                            'cityname'          => 'toan-quoc',
                            'cityid'            => '0',
                            'page'              => '1',
                    ),
                    'spec'      => '/moi-gioi/%cityname%-%cityid%-%page%',
                ),
            ),
            //Chi tiết
            'DetailAgencyRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/moi-gioi/((?<name>[a-zA-Z][a-zA-Z0-9-_]+)-)?(?<id>[0-9]+)-(?<page>[0-9]+).(?<extension>(html|php|asp))',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Agency',
                            'action'            => 'detail',
                            'name'              => 'chu-kim-phuong',
                            'id'                => '1',
                            'page'              =>  '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/moi-gioi/%name%-%id%-%page%.%extension%',
                ),
            ),

            //=====Router Tin tức========
            'ListNewsRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/tin-tuc-(?<page>[0-9]+).html',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'News',
                            'action'            => 'index',
                            'page'              => '1',
                    ),
                    'spec'      => '/tin-tuc-%page%.html',
                ),
            ),
            //category
            'CategoryNewsRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/tin-tuc/((?<name>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'News',
                            'action'            => 'category',
                            'name'              => 'tin-thi-truong',
                            'page'              => '1',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/tin-tuc/%name%/%page%-%id%.%extension%',
                ),
            ),
            //Tin tức theo thành phố
            'CityNewsRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/tin-tuc/thanh-pho/((?<cityname>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<cityid>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'News',
                            'action'            => 'city',
                            'cityname'          => 'tp-ho-chi-minh',
                            'page'              => '1',
                            'cityid'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/tin-tuc/thanh-pho/%cityname%/%page%-%cityid%.%extension%',
                ),
            ),
             //detail
            'DetailNewsRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/tin-tuc/(?<namecategory>[a-zA-Z][a-zA-Z0-9-_]+)/((?<title>[a-zA-Z][a-zA-Z0-9-_]+)-(?<cid>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'News',
                            'action'            => 'detail',
                            'namecategory'      => 'tin-thi-truong',
                            'title'             => 'chi-tiet-tin',
                            'cid'               => '10',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/tin-tuc/%namecategory%/%title%-%cid%-%id%.%extension%',
                ),
            ),
            //print
            'PrintNewsRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/tin-tuc/print/((?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'News',
                            'action'            => 'print',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/tin-tuc/print/%id%.%extension%',
                ),
            ),
            //=====Router Phong thủy========
            'ListFengshuiRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/phong-thuy-(?<page>[0-9]+).html',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Fengshui',
                            'action'            => 'index',
                            'page'              => '1',
                    ),
                    'spec'      => '/phong-thuy-%page%.html',
                ),
            ),
            //Tra cứu phong thủy
            'SearchFengshuiRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/tra-cuu-phong-thuy.html',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Fengshui',
                            'action'            => 'fengshuiapp',
                            'page'              => '1',
                    ),
                    'spec'      => '/tra-cuu-phong-thuy.html',
                ),
            ),

            //category
            'CategoryFengshuiRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/phong-thuy/((?<name>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Fengshui',
                            'action'            => 'category',
                            'name'              => 'phong-thuy-nha-o',
                            'page'              => '1',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/phong-thuy/%name%/%page%-%id%.%extension%',
                ),
            ),
             //detail
            'DetailFengshuiRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/phong-thuy/(?<namecategory>[a-zA-Z][a-zA-Z0-9-_]+)/((?<title>[a-zA-Z][a-zA-Z0-9-_]+)-(?<cid>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Fengshui',
                            'action'            => 'detail',
                            'namecategory'      => 'phong-thuy-nha-o',
                            'title'             => 'chi-tiet-tin',
                            'cid'               => '10',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/phong-thuy/%namecategory%/%title%-%cid%-%id%.%extension%',
                ),
            ),
            //print
            'PrintFengshuiRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/phong-thuy/print/((?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Fengshui',
                            'action'            => 'print',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/phong-thuy/print/%id%.%extension%',
                ),
            ),
            //=====Router Pháp lý nhà dất========
            'ListLegalHousingRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/phap-ly-nha-dat-(?<page>[0-9]+).html',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Legalhousing',
                            'action'            => 'index',
                            'page'              => '1',
                    ),
                    'spec'      => '/phap-ly-nha-dat-%page%.html',
                ),
            ),
             //category
            'CategoryLegalHousingRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/phap-ly-nha-dat/((?<name>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Legalhousing',
                            'action'            => 'category',
                            'name'              => 'uy-quyen',
                            'page'              => '1',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/phap-ly-nha-dat/%name%/%page%-%id%.%extension%',
                ),
            ),
            //detail
            'DetailLegalHousingRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/phap-ly-nha-dat/(?<namecategory>[a-zA-Z][a-zA-Z0-9-_]+)/((?<title>[a-zA-Z][a-zA-Z0-9-_]+)-(?<cid>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Legalhousing',
                            'action'            => 'detail',
                            'namecategory'      => 'phong-thuy-nha-o',
                            'title'             => 'chi-tiet-tin',
                            'cid'               => '10',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/phap-ly-nha-dat/%namecategory%/%title%-%cid%-%id%.%extension%',
                ),
            ),
            //print
            'PrintLegalHousingRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/phap-ly-nha-dat/print/((?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Legalhousing',
                            'action'            => 'print',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/phap-ly-nha-dat/print/%id%.%extension%',
                ),
            ),
            //=====Router Văn bản luật nhà đất========
            'ListLegislationHousingRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/van-ban-luat-nha-dat-(?<page>[0-9]+).html',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Legislationhousing',
                            'action'            => 'index',
                            'page'              => '1',
                    ),
                    'spec'      => '/van-ban-luat-nha-dat-%page%.html',
                ),
            ),
            //detail
            'DetailLegislationHousingRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/van-ban-luat-nha-dat/(?<namecategory>[a-zA-Z][a-zA-Z0-9-_]+)/((?<title>[a-zA-Z][a-zA-Z0-9-_]+)-(?<cid>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Legislationhousing',
                            'action'            => 'detail',
                            'namecategory'      => 'phong-thuy-nha-o',
                            'title'             => 'chi-tiet-tin',
                            'cid'               => '10',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/van-ban-luat-nha-dat/%namecategory%/%title%-%cid%-%id%.%extension%',
                ),
            ),
            //category
            'CategoryLegislationHousingRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/van-ban-luat-nha-dat/((?<name>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Legislationhousing',
                            'action'            => 'category',
                            'name'              => 'uy-quyen',
                            'page'              => '1',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/van-ban-luat-nha-dat/%name%/%page%-%id%.%extension%',
                ),
            ),
            //=====Router biểu mẫu hợp đồng========
            'ListContractFormRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/bieu-mau-hop-dong-(?<page>[0-9]+).html',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Contractform',
                            'action'            => 'index',
                            'page'              => '1',
                    ),
                    'spec'      => '/bieu-mau-hop-dong-%page%.html',
                ),
            ),
            //category
            'CategoryContractFormRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/bieu-mau-hop-dong/((?<name>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Contractform',
                            'action'            => 'category',
                            'name'              => 'uy-quyen',
                            'page'              => '1',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/bieu-mau-hop-dong/%name%/%page%-%id%.%extension%',
                ),
            ),
            //print
            'DownloadContractFormRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/bieu-mau-hop-dong/dowload/((?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Contractform',
                            'action'            => 'download',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/bieu-mau-hop-dong/dowload/%id%.%extension%',
                ),
            ),
             //=====Router nhà đẹp========
            'ListNiceHouseRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/nha-dep.html',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Nicehouse',
                            'action'            => 'index',
                    ),
                    'spec'      => '/nha-dep.html',
                ),
            ),
             //category
            'CategoryNiceHouseRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/nha-dep/((?<name>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Nicehouse',
                            'action'            => 'category',
                            'name'              => 'mau-nha-doc',
                            'page'              => '1',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/nha-dep/%name%/%page%-%id%.%extension%',
                ),
            ),
            //detail
            'DetailNiceHouseRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/nha-dep/(?<namecategory>[a-zA-Z][a-zA-Z0-9-_]+)/((?<title>[a-zA-Z][a-zA-Z0-9-_]+)-(?<cid>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Nicehouse',
                            'action'            => 'detail',
                            'namecategory'      => 'mau-nha-doc',
                            'title'             => 'chi-tiet-tin',
                            'cid'               => '10',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/nha-dep/%namecategory%/%title%-%cid%-%id%.%extension%',
                ),
            ),
            //print
            'PrintNiceHouseRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/nha-dep/print/((?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Nicehouse',
                            'action'            => 'print',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/nha-dep/print/%id%.%extension%',
                ),
            ),

            //===Dự án====
            //Danh sách doanh nghiệp
            'ListProjectRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/du-an-(?<page>[0-9]+).html',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Project',
                            'action'            => 'index',
                            'page'              => '1',
                    ),
                    'spec'      => '/du-an-%page%.html',
                ),
            ),
             //category
            'CategoryProjectRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/du-an/((?<name>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Project',
                            'action'            => 'category',
                            'name'              => 'chung-cu',
                            'page'              => '1',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/du-an/%name%/%page%-%id%.%extension%',
                ),
            ),
            //Dự án theo thành phố
            'CityProjectRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/du-an/thanh-pho/((?<cityname>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<cityid>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Project',
                            'action'            => 'city',
                            'cityname'          => 'tp-ho-chi-minh',
                            'page'              => '1',
                            'cityid'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/du-an/thanh-pho/%cityname%/%page%-%cityid%.%extension%',
                ),
            ),
            //Intro
            'IntroProjectRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/du-an/intro/((?<title>[a-zA-Z][a-zA-Z0-9-_]+)/(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Project',
                            'action'            => 'intro',
                            'title'             =>  'chi-tiet-tin',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/du-an/intro/%title%/%id%.%extension%',
                ),
            ),
            //detail
            'DetailProjectRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/du-an/(?<namecategory>[a-zA-Z][a-zA-Z0-9-_]+)/((?<title>[a-zA-Z][a-zA-Z0-9-_]+)-(?<cid>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Project',
                            'action'            => 'detail',
                            'namecategory'      => 'mau-nha-doc',
                            'title'             => 'chi-tiet-tin',
                            'cid'               => '10',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/du-an/%namecategory%/%title%-%cid%-%id%.%extension%',
                ),
            ),
            //Dự án theo quận huyện
            'DistrictProjectRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/du-an/((?<cityname>[a-zA-Z][a-zA-Z0-9-_]+)/(?<districtname>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<cityid>[0-9]+)-(?<iddistrict>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Project',
                            'action'            => 'district',
                            'cityname'          => 'tp-ho-chi-minh',
                            'districtname'      => 'quan-1',
                            'page'              => '1',
                            'cityid'                => '1',
                            'iddistrict'        =>  '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/du-an/%cityname%/%districtname%/%page%-%cityid%-%iddistrict%.%extension%',
                ),
            ),
            //===Thị trường====
            //Danh sách bảng giá bất động sản
            'ListMarketRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/thi-truong-(?<page>[0-9]+).html',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Market',
                            'action'            => 'index',
                            'page'              => '1',
                    ),
                    'spec'      => '/thi-truong-%page%.html',
                ),
            ),
            //Thị trường theo thành phố
            'CityMarketRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/thi-truong/thanh-pho/((?<cityname>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<cityid>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Market',
                            'action'            => 'city',
                            'cityname'          => 'tp-ho-chi-minh',
                            'page'              => '1',
                            'cityid'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/thi-truong/thanh-pho/%cityname%/%page%-%cityid%.%extension%',
                ),
            ),
            //Thị trươgf theo quận huyện
            'DistrictMarketRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/thi-truong/((?<cityname>[a-zA-Z][a-zA-Z0-9-_]+)/(?<districtname>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<cityid>[0-9]+)-(?<iddistrict>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Market',
                            'action'            => 'district',
                            'cityname'          => 'tp-ho-chi-minh',
                            'districtname'      => 'quan-1',
                            'page'              => '1',
                            'cityid'                => '1',
                            'iddistrict'        =>  '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/thi-truong/%cityname%/%districtname%/%page%-%cityid%-%iddistrict%.%extension%',
                ),
            ),
             //category
            'CategoryMarketRoute' => array(
                'type'      => 'Regex',
                'options'   => array(
                    'regex'     => '/thi-truong/((?<name>[a-zA-Z][a-zA-Z0-9-_]+)/(?<page>[0-9]+)-(?<id>[0-9]+).(?<extension>(html|php|asp)))?',
                    'defaults'  => array(
                            '__NAMESPACE__'     => 'Home\Controller',
                            'controller'        => 'Market',
                            'action'            => 'category',
                            'name'              => 'chung-cu',
                            'page'              => '1',
                            'id'                => '1',
                            'extension'         => 'html',
                    ),
                    'spec'      => '/thi-truong/%name%/%page%-%id%.%extension%',
                ),
            ),
            //MVC
            'MVC_HomeRouter' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/home',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Home\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action]][/]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'active' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action]]/id[/:id]/code[/:code][/]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[0-9,]*',
                                'code'       => '[0-9,]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'restorepass' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action]]/code[/:code][/]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'code'       => '[0-9,]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'action' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action[/:id[/:status]]]][/]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[0-9,]*',
                                'status'     => '[0-9]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'filter' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action[/:type[/:col[/:by[/:key]]]]]][/]',
                            'constraints' => array(
                                'controller'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'type'          => '[a-zA-Z-]*',
                                'col'           => '[a-zA-Z-]*',
                                'by'            => '[a-zA-Z-]*',
                                'key'           => '[0-9]*',
                                
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'pagination' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action]]/page[/:page][/]',
                            'constraints' => array(
                                'controller'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page'          => '[0-9]*', 
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'multiStatus' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action[/:id[/:type]]]][/]',
                            'constraints' => array(
                                'controller'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'            => '[0-9,]*',
                                'type'          => '[a-zA-Z-]*',

                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'MapApi' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action[/:latitude[/:longitude]]]][/]',
                            'constraints' => array(
                                'controller'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'latitude'      => '[0-9a-zA-Z-.]*',
                                'longitude'     => '[0-9a-zA-Z-.]*',

                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),    
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'invokables'    =>  array(
            'Zend\Authentication\AuthenticationService'=>'Zend\Authentication\AuthenticationService',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Home\Controller\Index'         => 'Home\Controller\IndexController',
            'Home\Controller\User'          => 'Home\Controller\UserController',
            'Home\Controller\Realestate'    => 'Home\Controller\RealestateController',
            'Home\Controller\MapApi'        => 'Home\Controller\MapApiController',
            'Home\Controller\Business'      => 'Home\Controller\BusinessController',
            'Home\Controller\Agency'        => 'Home\Controller\AgencyController',
            'Home\Controller\News'          => 'Home\Controller\NewsController',
            'Home\Controller\Fengshui'      => 'Home\Controller\FengshuiController',
            'Home\Controller\Legalhousing'  => 'Home\Controller\LegalhousingController',
            'Home\Controller\Legislationhousing'  => 'Home\Controller\LegislationhousingController',
            'Home\Controller\Contractform'  => 'Home\Controller\ContractformController',
            'Home\Controller\Nicehouse'     => 'Home\Controller\NicehouseController',
            'Home\Controller\Project'       => 'Home\Controller\ProjectController',
            'Home\Controller\Market'        => 'Home\Controller\MarketController',
            'Home\Controller\Notice'        => 'Home\Controller\NoticeController',
        ),
    ),
    'view_manager' => array(   
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',    
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
//             'layout/home'             => TEMPLATE_PATH . '/default/index.phtml',
            'layout/home'             => TEMPLATE_PATH . '/home/index.phtml',
            'layout/login'            => TEMPLATE_PATH . '/default/login.phtml',
            //'error/404'               => TEMPLATE_PATH . '/default/404.phtml',
            //'error/index'             => TEMPLATE_PATH . '/default/404.phtml',
            
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'default_template_suffix'   =>  'phtml',
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
