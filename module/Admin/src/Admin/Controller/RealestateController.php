<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;
use Zend\EventManager\EventManagerInterface;
use ZendVN\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container as Container;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Validator\Db\RecordExists;
use Zend\Validator\Db\NoRecordExists;
use Zend\Stdlib\ArrayObject;
class RealestateController extends ActionController
{
    
	//======Mảng tham số Router nhận được ở mỗi Action===//
    protected $_arrParam;
    //======Mảng tham số Post nhận được ở mỗi action=====//
    protected $_arrPost;
    //======Đường dẫn của Controller=====================//
    protected $_currentController;
 	//======Đường dẫn của Action chính===================//
 	protected $_actionMain;
    //======Đối tượng view helper========================//
    protected $_viewHelper;
 	//======Lưu session==================================//
 	protected $_namespace;
    //======Phân trang===================================//
    protected $_paginatorParams = array(
        'itemCountPerPage'  =>  10,
        'pageRange'         =>  4,

    );

    protected $_modelTable;


    public function getTable(){
        if(empty($this->_modelTable)){
            $this->_modelTable = $this->getServiceLocator()->get('Admin\Model\RealEstateTable');
        }
        return $this->_modelTable;
    }
   
    public function init()
    {

        $controller = $this;
        
           
            //Mảng tham số Router nhận được ở mỗi Action
        	$this->_arrParam 	= $this->params()->fromRoute();

            //Mảng tham số Post nhận được ở mỗi Action
            $this->_arrPost     = $this->params()->fromPost();

            //Đối tượng view Helper
            $this->_viewHelper  = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');

        	//Đường dẫn của Controller
        	$paramController 			   = $this->_arrParam['controller'];
        	$tmp 						   = explode("\\", $paramController);
        	$this->_arrParam['module']     = strtolower($tmp[0]);//get module name
        	$this->_arrParam['controller'] = strtolower($tmp[2]);//get controller name

        	$this->_currentController 	= '/' . $this->_arrParam['module'] 
									 	. '/' . $this->_arrParam['controller'];


		
        	//Đường dẫn của Action chính		
			$this->_actionMain 			= '/' . $this->_arrParam['module'] 
							 			. '/' . $this->_arrParam['controller']	. '/' . $this->_arrParam['action'];	
        	
      		//---------Dat ten SESSION-----------------------------------------
			$this->_namespace 							= $this->_arrParam['module'] . '_' . $this->_arrParam['controller'] ;
			$ssFilter 									= new Container($this->_namespace);

            if(empty($ssFilter->col)){
                $ssFilter->keywords     = '';
                $ssFilter->col          = 'id';
                $ssFilter->order        = 'DESC';
            }
            if(empty($ssFilter->record)){
                $ssFilter->record   = 10;
            }
        	$this->_arrParam['ssFilter']['keywords'] 	= $ssFilter->keywords;
        	$this->_arrParam['ssFilter']['sort'] 		= $ssFilter->sort;
   	    	$this->_arrParam['ssFilter']['col'] 		= $ssFilter->col;
        	$this->_arrParam['ssFilter']['order'] 		= $ssFilter->order;
            $this->_arrParam['ssFilter']['record']      = $ssFilter->record;
            $this->_arrParam['ssFilter']['field']       = $ssFilter->field ;
            $this->_arrParam['ssFilter']['status']      = $ssFilter->status;
            $this->_arrParam['ssFilter']['group']       = $ssFilter->group;
            $this->_arrParam['ssFilter']['city']        = $ssFilter->city;

           
           
            $this->_paginatorParams['itemCountPerPage'] = (int) $ssFilter->record;
            $this->_paginatorParams['currentPageNumber']= $this->params()->fromRoute('page',1);
            $this->_arrParam['paginator']               = $this->_paginatorParams;

            //Load templates
           	$this->layout('layout/list');


        
    }

    public function indexAction()
    {
    	//Tiêu đề
    	$title      =  'Dự án Bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
       
        $itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        $itemsGroup         = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-real-estate'));

       
       
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'itemsCity'         =>  $itemsCity,
            'itemsGroup'        =>  $itemsGroup,
            'currentController' =>  $this->_currentController,
        ));
    	
    }
    //Ajax load indexAction
    public function listAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            if($this->params()->fromQuery() == true){
                $option = $this->params()->fromQuery('option');
                if($option == 'order'){
                    $id     = $this->params()->fromQuery('id');
                    $value  = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'id'    =>  $id,
                        'order' =>  $value,
                    );
                    $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
                }
                
               
            }
        
            $totalItem      = $this->getTable()->countItem();
            $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items-paginator'));
    
            $dataItems      = $items;
            $dataPaginator  = \ZendVN\Paginator\Paginator::createPaginator($totalItem,$this->_paginatorParams);
                

        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'items'             =>  $dataItems,
            'paginator'         =>  $dataPaginator,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'totalItem'         =>  $totalItem,
        ));
        $view->setTerminal(true);
        return $view;


    }

    public function addAction(){
        $error = array();
        //Tiêu đề
        $title      =  'Đăng tin bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Item select box
        $itemsTypeRealEstate  = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-real-estate'));
        $itemsCity            = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        
        //Form
        $realEstateAdminForm       = $this->serviceLocator->get('FormElementManager')->get('realEstateAdminForm');

        //Nested Menu Left
        $view = new ViewModel();
       

        //Bind
        $object = new ArrayObject(array(
                'fullname'  => $this->identity()->fullname,                
                'phone'     => $this->identity()->phone,               
                'skype'     => $this->identity()->website,               
                'email'     => $this->identity()->email,              
        ));
        $realEstateAdminForm->bind($object);

        if($this->getRequest()->isPost()){
            
            $data = $this->getRequest()->getPost();
            $realEstateAdminForm->setData($data);
            
            //Kiểm tra chọn select box
            if(empty($this->_arrPost['type_real_estate'])){
                $error[]    = 'Bạn phải chọn loại Bất động sản!';
            }if(empty($this->_arrPost['city'])){
                $error[]    = 'Bạn phải chọn Thành phố!';
            }if(empty($this->_arrPost['district'])){
                $error[]    = 'Bạn phải chọn Quận huyện!';
            }
                
            //Upload File
            $jsonImage          = '';
            $arrFileName        = array();
            $upload             = new \ZendVN\File\Upload();
            $fileName           = $upload->getFileName();
            if(!empty($fileName)){
                if(!is_array($fileName)){
                    $arrFileName['image_0_']    = $fileName;
                }else{
                    $arrFileName                = $fileName;
                }     
                foreach($arrFileName as $key => $value){
                    $upload->addValidator('Extension', true, array('png','jpg'), $key );
                    $upload->addValidator ('Size', false, array('min' => '10kb','max' => '500kb'), $key );
                    if(!$upload->isValid($key)){
                        $messages   = $upload->getMessages();
                        if(!empty($messages['fileExtensionFalse'])){
                            $error[]    = 'Định dạng file không hợp lệ';
                        }if(!empty($messages['fileSizeTooBig'])){
                            $error[]    = 'Kích thước file quá lớn';
                        }if(!empty($messages['fileSizeTooSmall'])){
                            $error[]    = 'Kích thước file quá nhỏ';
                        } 
                    }else{
                        $arrImages[]= $upload->uploadFile($key, UPLOAD_PATH .'/real-estate/', array('task' => 'rename'), 'batdongsan_');          
                    }
                }
                $jsonImage          = \Zend\Json\Json::encode($arrImages);  
            }    
                    
            if($realEstateAdminForm->isValid() && empty($error)){
                //Lấy ngày hiện tại
                $date_start = date('d/m/Y');
                //Cộng thêm 7 ngày
                $date_end   = strtotime(date("d-m-Y", strtotime(date('d-m-Y'))) . " +7 day");
                $date_end   = strftime("%d/%m/%Y",$date_end); 

                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data       =  array(
                    'cat_id'        => $purifier->purify($this->_arrPost['type_real_estate_child']),
                    'title'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['title'])),
                    'content'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['content'])),
                    'images'        => $jsonImage,
                    'transaction'   => $purifier->purify($this->_arrPost['type_transaction']),
                    'area'          => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['area'])),
                    'price_type'    => $purifier->purify($this->_arrPost['type_money']),
                    'price'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['price'])),
                    'price_m2'      => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['price_m2'])),
                    'price_display' => $purifier->purify($this->_arrPost['display_price']),
                    'direction'     => $purifier->purify($this->_arrPost['direction']),
                    'avenue'        => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['avenue'])),
                    'juridical'     => $purifier->purify($this->_arrPost['juridical']),
                    'floor'         => $purifier->purify($this->_arrPost['floor']),
                    'bedroom'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['bedroom'])),
                    'bathroom'      => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['bathroom'])),
                    'city'          => $purifier->purify($this->_arrPost['city']),
                    'district'      => $purifier->purify($this->_arrPost['district']),
                    'ward'          => $purifier->purify($this->_arrPost['ward']),
                    'project'       => $purifier->purify($this->_arrPost['project']),
                    'numberhouse'   => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['numberhouse'])),
                    'nameavenue'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['nameavenue'])),
                    'user_id'       => $this->identity()->id,
                    'latitude_gmap' => $purifier->purify($this->_arrPost['latitude']),
                    'longitude_gmap'=> $purifier->purify($this->_arrPost['longitude']),
                    'date_modifi'   => $date_start,
                    'date_start'    => $date_start,
                    'date_end'      => $date_end,
                );

                
                $id = $this->getTable()->saveItem($data,array('task'=>'add'));
                
                $this->redirect()->toUrl('/admin/real-estate/');
            
            }
        }
       
                    

        $view->setVariables(array(
            'title'                     =>  $title,
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'myForm'                    =>  $realEstateAdminForm ,
            'itemsTypeRealEstate'       =>  $itemsTypeRealEstate,
            'itemsCity'                 =>  $itemsCity,
            'error'                     =>  $error,
        ));
        return $view;

    }
    public function editAction(){
        $error = array();
        
        $view = new ViewModel();

        //Tiêu đề
        $title      =  'Sửa tin bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Item select box
        $itemsTypeRealEstate  = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-real-estate'));
        $itemsCity            = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        
        

        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));

        //Bind
        $realEstateAdminForm       = $this->serviceLocator->get('FormElementManager')->get('realEstateAdminForm');
        $realEstateAdminForm->setInputFilter(new \Admin\Form\RealEstateFilter(array('task'=>'edit', 'id'=>$this->_arrParam['id'])));
        $realEstateAdminForm->bind($item);
        
       

        $infoUser       = $this->getTable()->getItem($item->user_id,array('task'=>'get-item-user'));
        

        $object = new ArrayObject(array(
                'fullname'  => $infoUser['fullname'],                
                'phone'     => $infoUser['phone'],               
                'skype'     => $infoUser['website'],              
                'email'     => $infoUser['email'],              
        ));
        $realEstateAdminForm->bind($object);

        //find parent Cat
        $parentCat        = $this->getTable()->getItem($item->cat_id,array('task'=>'get-item-find-parent-cat'));

        if($this->getRequest()->isPost()){
            
            $data = $this->getRequest()->getPost();
            $realEstateAdminForm->setData($data);
            
            //Kiểm tra chọn select box
            if(empty($this->_arrPost['type_real_estate'])){
                $error[]    = 'Bạn phải chọn loại Bất động sản!';
            }if(empty($this->_arrPost['city'])){
                $error[]    = 'Bạn phải chọn Thành phố!';
            }if(empty($this->_arrPost['district'])){
                $error[]    = 'Bạn phải chọn Quận huyện!';
            }
                
             
                    
            if($realEstateAdminForm->isValid() && empty($error)){
                //Lấy ngày hiện tại
                $date_start = date('d/m/Y');
                //Cộng thêm 7 ngày
                $date_end   = strtotime(date("d-m-Y", strtotime(date('d-m-Y'))) . " +7 day");
                $date_end   = strftime("%d/%m/%Y",$date_end); 

                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data       =  array(
                    'id'            => $purifier->purify($this->_arrPost['id']), 
                    'cat_id'        => $purifier->purify($this->_arrPost['type_real_estate_child']),
                    'title'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['title'])),
                    'content'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['content'])),
                    'transaction'   => $purifier->purify($this->_arrPost['type_transaction']),
                    'area'          => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['area'])),
                    'price_type'    => $purifier->purify($this->_arrPost['type_money']),
                    'price'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['price'])),
                    'price_m2'      => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['price_m2'])),
                    'price_display' => $purifier->purify($this->_arrPost['display_price']),
                    'direction'     => $purifier->purify($this->_arrPost['direction']),
                    'avenue'        => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['avenue'])),
                    'juridical'     => $purifier->purify($this->_arrPost['juridical']),
                    'floor'         => $purifier->purify($this->_arrPost['floor']),
                    'bedroom'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['bedroom'])),
                    'bathroom'      => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['bathroom'])),
                    'city'          => $purifier->purify($this->_arrPost['city']),
                    'district'      => $purifier->purify($this->_arrPost['district']),
                    'ward'          => $purifier->purify($this->_arrPost['ward']),
                    'project'       => $purifier->purify($this->_arrPost['project']),
                    'numberhouse'   => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['numberhouse'])),
                    'nameavenue'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['nameavenue'])),
                    'user_id'       => $this->identity()->id,
                    'latitude_gmap' => $purifier->purify($this->_arrPost['latitude']),
                    'longitude_gmap'=> $purifier->purify($this->_arrPost['longitude']),
                    'date_modifi'   => $date_start,
                    /*'type_news'     => 1,
                    'date_start'    => $date_start,
                    'date_end'      => $date_end,*/
                );

               
                $this->getTable()->saveItem($data,array('task'=>'edit'));
                
                $this->redirect()->toUrl('/admin/realestate/');
            
            }
        }
       
                    

        $view->setVariables(array(
            'title'                     =>  $title,
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'myForm'                    =>  $realEstateAdminForm,
            'itemsTypeRealEstate'       =>  $itemsTypeRealEstate,
            'itemsCity'                 =>  $itemsCity,
            'error'                     =>  $error,
            'item'                      =>  $item,
            'parentCat'                 =>  $parentCat,
        ));

        return $view;

    }
      //Upload ảnh sản phẩm
    public function uploadifyDbAction(){
        $result = array();
        if($this->getRequest()->isPost()){
            if(!empty($_FILES)){


                //Upload File
                $upload             = new \ZendVN\File\Upload();
                $fileName           = $upload->getFileName();
                if(!empty($fileName)){
                    $upload->addValidator('Extension', true, array('png','jpg'),'Filedata');
                    $upload->addValidator ('Size', false, array('min' => '10kb','max' => '500kb'), 'Filedata');
                    if(!$upload->isValid('Filedata')){
                        $result['status']   = 'error';
                        $messages           = $upload->getMessages();
                        if(!empty($messages['fileExtensionFalse'])){
                            $result['messages']['upload']    = 'Định dạng file không hợp lệ';
                        }if(!empty($messages['fileSizeTooBig'])){
                             $result['messages']['upload']   = 'Kích thước file quá lớn';
                        }if(!empty($messages['fileSizeTooSmall'])){
                             $result['messages']['upload']   = 'Kích thước file quá nhỏ';
                        } 
                    }else{
                        $filename           = $upload->uploadFile('Filedata', UPLOAD_PATH .'/real-estate/', array('task' => 'rename'), 'batdongsan_');          
                        $item               = $this->getTable()->getItem($this->_arrPost,array('task'=>'get-item'));

                        //Mảng hình ảnh lấy từ database
                        $Imgdata            = \Zend\Json\Json::decode($item->images);

                        // mảng chưa file upload hiện tại
                        $newValue           = array();
                        $newValue[]         = $filename;

                        //Gộp 2 mảng 
                        if(!empty($Imgdata)){
                            $newValue       = array_merge($newValue,$Imgdata);
                        }
                        //mảng chứa chuỗi json hình ảnh
                        $arrParam['id']     = $this->_arrPost['id'];
                        $arrParam['images'] = \Zend\Json\Json::encode($newValue);

                        //Cập nhật hình ảnh vào database
                        $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
                        $result['status']   = 'success';
                        $result['messages']['upload'] = 'Thành công';
                    }
                }               
            }
        }
        echo \Zend\Json\Json::encode($result);      
        return $this->getResponse();   
    }
    //Xóa ảnh
    public function deleteImgAction(){
        if($this->getRequest()->isPost()){ 
            $item       = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));

            //Mảng hình ảnh lấy từ database
            $Imgdata    = \Zend\Json\Json::decode($item->images);

            //lấy ra hình ảnh được chọn
            $check      = $this->_arrPost["check"];

            foreach($check as $key=>$val){
                $check  = $this->_arrPost["check"][$key];
                //--------------xóa file ảnh  ----------------------
                $upload = new \ZendVN\File\Upload();
                   
                $upload->removeFile(UPLOAD_PATH .'/real-estate/'.$Imgdata[$check]);
                   
                //Xỏa ảnh ra khỏi mảng
                unset($Imgdata[$check]);
                $arrParam['id']     = $this->_arrParam['id']; 
                $arrParam['images'] = \Zend\Json\Json::encode($Imgdata);

                //Cập nhật hình ảnh vào database
                $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
            }



            $flagType = 'success';
            $reponse['type'] = $flagType;
            echo \Zend\Json\Json::encode($reponse);
            
        }
        
        return $this->getResponse();   
    }   


    public function successAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $arrParam['id']   = $this->params()->fromQuery('id');
            $item    = $this->getTable()->getItem($arrParam,array('task'=>'get-item'));
        }    
        $view->setVariables(array(
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'item'                      =>  $item, 
        ));

        $view->setTerminal(true);
        return $view;
    }
    public function previewAction(){
        $view = new ViewModel();
        $item = $this->getTable()->getItem($this->_arrParam);
        $view->setVariables(array(
            'item'             => $item,
        ));
        $view->setTerminal(true);
        return $view; 
    }
    public function multiStatusAction(){
        if(!empty($this->_arrParam['id'])){
            $arrParam['id']     = explode(",", $this->_arrParam['id']);
            $arrParam['type']   = $this->_arrParam['type'];
            $this->getTable()->saveItem($arrParam,array('task'=>'multi-status'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được cập nhật thành công'); 
        }
        $this->redirect()->toUrl('/admin/realestate/');
        return $this->getResponse();    
    }
    public function statusAction(){
        if(!empty($this->_arrParam['id'])){
            $filter     = new \Zend\Filter\Digits();
            $id         = $filter->filter($this->_arrParam['id']);
            $arrParam   = array('status'=>$this->_arrParam['status'],'id'=>$id);
            $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
        }
        $this->redirect()->toUrl('/admin/realestate/');    
        return $this->getResponse();
    }
    public function deleteAction(){
        if(!empty($this->_arrParam['id'])){
            $filter   = new \Zend\Filter\Digits();
            $id       = $filter->filter($this->_arrParam['id']);
            $arrParam = array('id'=>$id);
            $item = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
        
            $upload = new \ZendVN\File\Upload();
            $images = \Zend\Json\Json::decode($item->images);
            if(!empty($images)){
                foreach($images as $image){
                    $upload->removeFile(UPLOAD_PATH .'/project/'.$image);
                }      
            }
            
            $this->getTable()->deleteItem($arrParam,array('task'=>'delete-item'));
            
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/admin/realestate/');
        return $this->getResponse();    
    }
    public function multiDeleteAction(){
        if(!empty($this->_arrParam['id'])){
            $arrParam = explode(",", $this->_arrParam['id']);
            $items = $this->getTable()->deleteItem($arrParam,array('task'=>'list-images'));
            if(!empty($items)){
                foreach($items as $item){
                    $upload = new \ZendVN\File\Upload();
                    $images = \Zend\Json\Json::decode($item->images);
                    if(!empty($images)){
                        foreach($images as $image){
                            $upload->removeFile(UPLOAD_PATH .'/project/'.$image);
                        }      
                    }
                }    
            }        
            $this->getTable()->deleteItem($arrParam,array('task'=>'multi-delete-item'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/admin/realestate/');
        return $this->getResponse();    
    }
    public function filterAction(){
        $ssFilter   = new Container($this->_namespace);
        $purifier   = new \HTMLPurifier_HTMLPurifier();
        if($this->_arrParam['type'] == 'search'){
            if($this->_arrParam['col'] == 'null' && $this->_arrParam['by'] == 'null' && $this->_arrParam['key'] == 1){
                if($this->params()->fromPost('keywords') != ''){
                    $ssFilter->keywords = $purifier->purify(trim($this->params()->fromPost('keywords')));
                    $ssFilter->field    = $this->params()->fromPost('field');
                }
                $ssFilter->status   = $this->params()->fromPost('status');
                $ssFilter->city     = $this->params()->fromPost('city_id');
                $ssFilter->group    = $this->params()->fromPost('group_id');
                
            }if($this->_arrParam['col'] == 'null' && $this->_arrParam['by'] == 'null' && $this->_arrParam['key'] == 0){
                $ssFilter->getManager()->getStorage()->clear();
            }
        }

        if($this->_arrParam['type'] == 'order' && $this->_arrParam['col'] != 'null' && $this->_arrParam['by'] != 'null'){
            $ssFilter->col      = $this->_arrParam['col'];
            $ssFilter->order    = $this->_arrParam['by'];
        }
        if($this->_arrParam['type'] == 'record'){
            $ssFilter->record   = $this->params()->fromPost('record');

        }
        
        $this->redirect()->toUrl('/admin/realestate/');
        return $this->getResponse();   
    }

    public function loadSelectTypeRealEstateAction(){
        $view               = new ViewModel();
        $isXmlHttpRequest   = false;
        $data               = null;
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $itemsRealEstateChild  = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-type-real-estate-child'));
            $tyleLand = $this->params()->fromQuery('type');
            foreach($itemsRealEstateChild as $key=>$value){
                if($value['parent'] == $tyleLand) $data[] = $value;
            }  
        }    
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'data'              =>  $data,
        ));
        $view->setTerminal(true);
        return $view;
    }
    

    public function loadSelectDistrictAction(){
        $view               = new ViewModel();
        $isXmlHttpRequest   = false;
        $data               = null;
        $currentDistrict    = null;
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            
            $itemsDistrict  = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-district'));
            $city = $this->params()->fromQuery('city');
            foreach($itemsDistrict as $key=>$value){
                if($value['city_id'] == $city) $data[] = $value;
            }
            if($this->params()->fromQuery('currentDistrict') != ''){
                $currentDistrict = $this->params()->fromQuery('currentDistrict');
            }  
        }    
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'data'              =>  $data,
            'currentDistrict'   =>  $currentDistrict,
        ));
        $view->setTerminal(true);
        return $view;
    }
    public function loadSelectWardAction(){
        $view               = new ViewModel();
        $isXmlHttpRequest   = false;
        $data               = null;
        $currentWard        = null;
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $itemsWard  = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-ward'));
            $district   = $this->params()->fromQuery('district');
            foreach($itemsWard as $key=>$value){
                if($value['district_id'] == $district) $data[] = $value;
            }
            if($this->params()->fromQuery('currentWard') != ''){
                $currentWard = $this->params()->fromQuery('currentWard');
            }    
        }    
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'data'              =>  $data,
            'currentWard'       =>  $currentWard,
        ));
        $view->setTerminal(true);
        return $view;

    }
    public function loadSelectProjectAction(){
        $view               = new ViewModel();
        $isXmlHttpRequest   = false;
        $data               = null;
        $currentProject     = null;
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $itemsProject   = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-project'));
            $district       = $this->params()->fromQuery('district');
            foreach($itemsProject as $key=>$value){
                if($value['district'] == $district) $data[] = $value;
            }
            if($this->params()->fromQuery('currentProject') != ''){
                $currentProject = $this->params()->fromQuery('currentProject');
            }   
        }    
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'data'              =>  $data,
            'currentProject'    =>  $currentProject,
        ));
        $view->setTerminal(true);
        return $view;

    }
    
}
