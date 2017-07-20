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
class FengshuinewsController extends ActionController
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

    protected $_fengshuiNewsTable;


    public function getTable(){
        if(empty($this->_fengshuiNewsTable)){
            $this->_fengshuiNewsTable = $this->getServiceLocator()->get('Admin\Model\FengshuiNewsTable');
        }
        return $this->_fengshuiNewsTable;
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
    	$title      =  'Phong thủy';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
       
        
        $itemsGroup         = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-category-fengshui-news'));

       
       
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
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
        $error          = array();
        //Tiêu đề
        $title          =  'Phong thủy > Thêm mới';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
        $fengshuiNewsForm       = $this->serviceLocator->get('FormElementManager')->get('fengshuiNewsForm');
       
        //Danh mục
        $itemsCategoryNews  =   $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-category-fengshui-news'));
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $fengshuiNewsForm->setData($data);


            //Kiểm tra chọn select box
            if(empty($this->_arrPost['cat_id'])){
                $error[]    = 'Bạn phải chọn Danh mục!';
            }

            //Upload 
            $image      = '';
            $upload     = new \ZendVN\File\Upload();
            $fileName   = $upload->getFileName();
            if(!empty($fileName)){
                $upload->addValidator('Extension', true, array('png','jpg'), 'image' );
                $upload->addValidator ('Size', false, array('min' => '20kb','max' => '800kb'), 'image' );
                if(!$upload->isValid('image')){
                    $messages   = $upload->getMessages();
                    if(!empty($messages['fileExtensionFalse'])){
                        $error[]    = 'Định dạng file không hợp lệ!';
                    }if(!empty($messages['fileSizeTooBig'])){
                        $error[]    = 'Kích thước file quá lớn!';
                    }if(!empty($messages['fileSizeTooSmall'])){
                        $error[]    = 'Kích thước file quá nhỏ!';
                    } 
                }else{
                    //upload ảnh mới
                    $image = $upload->uploadFile('image', UPLOAD_PATH .'/fengshui-news/', array('task' => 'rename'), 'batdongsan_');
                }
            } 

            if($fengshuiNewsForm->isValid() && empty($error)){
               
                    
                    //Chống tấn công XSS
                    $purifier   = new \HTMLPurifier_HTMLPurifier();
                    $data    =  array(
                        'title'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['title'])),
                        'description'   => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['description'])),
                        'content'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['content'])),
                        'images'        => $image,
                        'cat_id' =>  $purifier->purify($this->_arrPost['cat_id']),
                        'date_time'     => date('d/m/y h:i:s'),
                    );
                    $this->getTable()->saveItem($data,array('task'=>'add'));
                    $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                    $this->redirect()->toUrl('/admin/fengshuinews/');
            }else{
                //echo '<pre>';
                //print_r($newsForm->getMessages());
                //echo '</pre>';
            }
        }


        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $fengshuiNewsForm,
            'itemsCategoryNews'=>  $itemsCategoryNews,
            'error'             =>  $error,
        ));
    }
    public function editAction(){
        $error          = array();
        //Tiêu đề
        $title          =  'Phong thủy > Chỉnh sửa';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
       
        //Danh mục
        $itemsCategoryNews  =   $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-category-fengshui-news'));
        

        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
       


        $fengshuiNewsForm       = $this->serviceLocator->get('FormElementManager')->get('fengshuiNewsForm');
       
        
        $fengshuiNewsForm->setInputFilter(new \Admin\Form\FengshuiNewsFilter(array('task'=>'edit', 'id'=>$this->_arrParam['id'])));
        $fengshuiNewsForm->bind($item);
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $fengshuiNewsForm->setData($data);

            
            if(empty($this->_arrPost['cat_id'])){
                $error[]    = 'Bạn phải chọn Danh mục của tin tức!';
            }

            if($fengshuiNewsForm->isValid() && empty($error)){
               
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data    =  array(
                    'id'            => $purifier->purify($this->_arrPost['id']), 
                    'cat_id'        => $purifier->purify($this->_arrPost['cat_id']),
                    'title'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['title'])),
                    'description'   => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['description'])),
                    'content'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['content'])),
                    
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/fengshuinews/');
            }else{
                //echo '<pre>';
                //print_r($newsForm->getMessages());
                //echo '</pre>';
            }
        }


        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $fengshuiNewsForm,
            'item'              =>  $item,
            'itemsCategoryNews' =>  $itemsCategoryNews,
            'error'             =>  $error,
        ));
    }
    //ajax upload avatar
    public function uploadAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true; 
            if($this->getRequest()->isPost()){
                $upload = new \ZendVN\File\Upload();
                $upload->addValidator('Extension', true, array('png','jpg'), 'image' );
                $upload->addValidator ('Size', false, array('min' => '1kb','max' => '500kb'), 'image' );
                if($upload->isValid('image')){
                    //upload ảnh mới
                    $fileName = $upload->uploadFile('image', UPLOAD_PATH .'/fengshui-news/', array('task' => 'rename'), 'batdongsan_');
                    //Thực hiện xóa ảnh cũ
                    
                    $upload->removeFile(UPLOAD_PATH .'/fengshui-news/'.$this->_arrPost['image_hidden']);
                        
                    //update database
                    $arrParam = array(
                        'id'    =>  $this->_arrPost['id'],
                        'images'=>  $fileName,
                    );
                    $this->getTable()->saveItem($arrParam,array('task'=>'edit'));

                }else{
                    $fileName   = $this->_arrPost['image_hidden'];
                    $messages   = $upload->getMessages();
                    if(!empty($messages['fileExtensionFalse'])){
                        echo '<script>alert("Định dạng file không hợp lệ");</script>';
                    }if(!empty($messages['fileSizeTooBig'])){
                        echo '<script>alert("Kích thước file quá lớn");</script>';
                    }if(!empty($messages['fileSizeTooSmall'])){
                        echo '<script>alert("Kích thước file quá nhỏ");</script>';
                    } 
                }   
            }
        } 

        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'fileName'          =>  $fileName,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
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
        $this->redirect()->toUrl('/admin/fengshuinews/');
        return $this->getResponse();    
    }
    public function statusAction(){
        if(!empty($this->_arrParam['id'])){
            $filter     = new \Zend\Filter\Digits();
            $id         = $filter->filter($this->_arrParam['id']);
            $arrParam   = array('status'=>$this->_arrParam['status'],'id'=>$id);
            $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
        }
        $this->redirect()->toUrl('/admin/fengshuinews/');   
        return $this->getResponse();
    }
    public function deleteAction(){
        if(!empty($this->_arrParam['id'])){
            $filter   = new \Zend\Filter\Digits();
            $id       = $filter->filter($this->_arrParam['id']);
            $arrParam = array('id'=>$id);
            $item = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
        
            $upload = new \ZendVN\File\Upload();
            $upload->removeFile(UPLOAD_PATH .'/fengshui-news/'.$item->images);
            
            $this->getTable()->deleteItem($arrParam,array('task'=>'delete-item'));
            
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/admin/fengshuinews/');
        return $this->getResponse();    
    }
    public function multiDeleteAction(){
        if(!empty($this->_arrParam['id'])){
            $arrParam = explode(",", $this->_arrParam['id']);
            $items = $this->getTable()->deleteItem($arrParam,array('task'=>'list-images'));
            if(!empty($items)){
                foreach($items as $item){
                    $upload = new \ZendVN\File\Upload();
                    $upload->removeFile(UPLOAD_PATH .'/fengshui-news/'.$item->images);  
                }    
            }        
            $this->getTable()->deleteItem($arrParam,array('task'=>'multi-delete-item'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/admin/fengshuinews/');
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
        
        $this->redirect()->toUrl('/admin/fengshuinews/');
        return $this->getResponse();   
    }

    
    
}
