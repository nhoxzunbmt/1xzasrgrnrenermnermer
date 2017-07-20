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
class FilemanagerController extends ActionController
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

    protected $_newsTable;


    public function getTable(){
        if(empty($this->_newsTable)){
            $this->_newsTable = $this->getServiceLocator()->get('Admin\Model\FileManagerTable');
        }
        return $this->_newsTable;
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
            $this->_arrParam['ssFilter']['keywords_file']    = $ssFilter->keywords_file;
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
    	$title      =  'Quản lý file';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
       
        $itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        $itemsGroup         = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-category-news'));

        $redirect   = new Container('redirect');
        $redirect->curentUrl = '/admin/filemanager/';
        

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

    public function fileAction()
    {
        
        $error          = array();
        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
        
        
        $redirect   = new Container('redirect');
        $redirect->curentUrl = '/admin/filemanager/file/'.$item->id;
        $totalItem      = $this->getTable()->countItem($this->_arrParam,array('task'=>'file'));
        $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items-paginator-file'));

        $fileFolderSize = 0;
        foreach($items as $value){
            $folder = FILE_MANAGER_URL_CODINH .'/'.$value['name_folder'];
            $fileFolderSize +=  @filesize($folder.'/'.$value['filename']);
        }
        $fileFolderSize = \ZendVN\File\ConvertSize::convert($fileFolderSize,2,' '); 

        //Tiêu đề
        $title      =  'Quản lý file > Thư mục '.$item->name .' | Tổng số file : '.$totalItem .' | Tổng dung lượng: '.$fileFolderSize;   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        if($this->getRequest()->isPost()){
           
            //Upload 
            $image      = '';
            $upload     = new \ZendVN\File\Upload();

            $fileName   = $upload->getFileName();
            if(!empty($fileName)){
                $upload->addValidator('Extension', true, array('png','jpg','gif','txt','rar','zip','exe','doc','docx','xls','pdf'), 'file' );
                $upload->addValidator ('Size', false, array('min' => '20kb','max' => '5mb'), 'file' );
                if(!$upload->isValid('file')){
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
                    $file = $upload->uploadFile('file', FILE_MANAGER_PATH .'/'.$item->name.'/', array('task' => 'rename'), 'batdongsan_');
                }
            }else{
                $error[]    = 'Bạn chưa chọn file upload';
            }

            if(empty($this->_arrPost['name'])){
                $error[]    = 'Bạn chưa nhập tên file';
            }

            if(empty($error)){
                $data = array(
                    'folder_id'     =>$item->id,
                    'filename'      =>$file,
                    'name'          =>$this->_arrPost['name'],
                    'date_time'     =>date('d/m/y h:i:s'),
                );
                $this->getTable()->saveItem($data,array('task'=>'save-file'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/filemanager/file/'.$item->id);
            }    
        }    
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'error'             =>  $error
        ));
        
    }
    //Ajax load indexAction
    public function fileListAction(){
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

            $this->_arrParam['id'] = $this->params()->fromQuery('id');
        
            $totalItem      = $this->getTable()->countItem($this->_arrParam,array('task'=>'file'));
            $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items-paginator-file'));
    
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

    public function downloadAction(){
        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'file'));

        $filename       = $item['filename'];
        $name_folder    = $item['name_folder'];
        $filePath       = FILE_MANAGER_PATH .'/'.$name_folder.'/' . $filename;
        if(!empty($filename)){
            if(file_exists($filePath)){
                $fsize = filesize($filePath); 
                $path_parts = pathinfo($filename); 
                $ext = strtolower($path_parts["extension"]); 
                switch ($ext) { 
                    case "pdf": $ctype="application/pdf"; break; 
                    case "exe": $ctype="application/octet-stream"; break; 
                    case "zip": $ctype="application/zip"; break; 
                    case "rar": $ctype="application/x-rar-compressed"; break; 
                    case "doc": $ctype="application/msword"; break; 
                    case "xls": $ctype="application/vnd.ms-excel"; break; 
                    case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
                    case "gif": $ctype="image/gif"; break; 
                    case "png": $ctype="image/png"; break; 
                    case "jpeg": 
                    case "jpg": $ctype="image/jpg"; break; 
                    default: $ctype="application/force-download"; 
                }
             
                header("Pragma: public"); // required 
                header("Expires: 0"); 
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
                header("Cache-Control: private",false); // required for certain browsers 
                header("Content-Type: $ctype"); 
                header('Content-Disposition: attachment; filename="'.basename($filePath).'";' ); 
                header("Content-Transfer-Encoding: binary"); 
                header("Content-Length: ".$fsize); 
                ob_clean(); 
                flush(); 
                readfile($filePath);
            }else{
                die('File is not exist');
            }
        }else{
         
            die('Address not valid');
        }
        return $this->getResponse(); 
    }

    public function addAction(){
        $error          = array();
        //Tiêu đề
        $title          =  'Quản lý file > Tạo thư mục mới';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
        $fileManagerAdminForm       = $this->serviceLocator->get('FormElementManager')->get('fileManagerAdminForm');
        

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $fileManagerAdminForm->setData($data);

            if(file_exists(FILE_MANAGER_PATH .'/'.$this->_arrPost['name']))
            {
                $error[] = "Thư mục đã tồn tại";
            }  

            if($fileManagerAdminForm->isValid() && empty($error)){
                //Phân quyền thư mục hiển thị người dùng dễ nhận biết
                $ChmodOwner = $this->_arrPost['ChmodOwnerRead'] + $this->_arrPost['ChmodOwnerWrite'] + $this->_arrPost['ChmodOwnerExecute'];
                $ChmodGroup = $this->_arrPost['ChmodGroupRead'] + $this->_arrPost['ChmodGroupWrite'] + $this->_arrPost['ChmodGroupExecute'];
                $ChmodEveryone = $this->_arrPost['ChmodEveryoneRead'] + $this->_arrPost['ChmodEveryoneWrite'] + $this->_arrPost['ChmodEveryoneExecute'];
                $mod = 0;
                $Chmod = $mod.$ChmodOwner . $ChmodGroup . $ChmodEveryone;
                //-------Creat thư mục--------------------------------------------
                mkdir(FILE_MANAGER_PATH .'/'.$this->_arrPost['name'],$Chmod);
                chmod(FILE_MANAGER_PATH .'/'.$this->_arrPost['name'],$Chmod);
                    
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data    =  array(
                    'name'                  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['name'])),
                    'description'           => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['description'])),
                    'date_time'             => date('d/m/y h:i:s'),
                    'chmod'                 =>$Chmod,
                    'ChmodOwnerRead'        =>$this->_arrPost['ChmodOwnerRead'],
                    'ChmodOwnerWrite'       =>$this->_arrPost['ChmodOwnerWrite'],
                    'ChmodOwnerExecute'     =>$this->_arrPost['ChmodOwnerExecute'],
                    'ChmodGroupRead'        =>$this->_arrPost['ChmodGroupRead'],
                    'ChmodGroupWrite'       =>$this->_arrPost['ChmodGroupWrite'],
                    'ChmodGroupExecute'     =>$this->_arrPost['ChmodGroupExecute'],
                    'ChmodEveryoneRead'     =>$this->_arrPost['ChmodEveryoneRead'],
                    'ChmodEveryoneWrite'    =>$this->_arrPost['ChmodEveryoneWrite'],
                    'ChmodEveryoneExecute'  =>$this->_arrPost['ChmodEveryoneExecute'], 
                );
                $this->getTable()->saveItem($data,array('task'=>'add'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/filemanager/');
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
            'myForm'            =>  $fileManagerAdminForm,
            'error'             =>  $error,
        ));
    }
    public function editAction(){
        $error          = array();
        //Tiêu đề
        $title          =  'Quản lý file > Chỉnh sửa thư mục';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
       
        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
       


        $fileManagerAdminForm       = $this->serviceLocator->get('FormElementManager')->get('fileManagerAdminForm');
        
        $fileManagerAdminForm->setInputFilter(new \Admin\Form\FileManagerFilter(array('task'=>'edit', 'id'=>$this->_arrParam['id'])));
        $fileManagerAdminForm->bind($item);
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $fileManagerAdminForm->setData($data);

            //Phân quyền thư mục hiển thị người dùng dễ nhận biết
            $ChmodOwner = $this->_arrPost['ChmodOwnerRead'] + $this->_arrPost['ChmodOwnerWrite'] + $this->_arrPost['ChmodOwnerExecute'];
            $ChmodGroup = $this->_arrPost['ChmodGroupRead'] + $this->_arrPost['ChmodGroupWrite'] + $this->_arrPost['ChmodGroupExecute'];
            $ChmodEveryone = $this->_arrPost['ChmodEveryoneRead'] + $this->_arrPost['ChmodEveryoneWrite'] + $this->_arrPost['ChmodEveryoneExecute'];
            $mod = 0;
            $Chmod = $mod.$ChmodOwner . $ChmodGroup . $ChmodEveryone;
            
            //Nếu tên thư mục khác với tên thư mục trong database nghĩa là người dùng muốn đổi tên thư mục
            if($this->_arrPost['name'] != $item->name){
                //-------Rename thư mục-------------------------------------------
                @rename(FILE_MANAGER_PATH .'/'.$item->name,FILE_MANAGER_PATH .'/'.$this->_arrPost['name']);
            }
           
            if($fileManagerAdminForm->isValid() && empty($error)){
               
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data    =  array(
                    'id'            => $purifier->purify($this->_arrPost['id']), 
                    'name'                  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['name'])),
                    'description'           => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['description'])),
                    'chmod'                 =>$Chmod,
                    'ChmodOwnerRead'        =>$this->_arrPost['ChmodOwnerRead'],
                    'ChmodOwnerWrite'       =>$this->_arrPost['ChmodOwnerWrite'],
                    'ChmodOwnerExecute'     =>$this->_arrPost['ChmodOwnerExecute'],
                    'ChmodGroupRead'        =>$this->_arrPost['ChmodGroupRead'],
                    'ChmodGroupWrite'       =>$this->_arrPost['ChmodGroupWrite'],
                    'ChmodGroupExecute'     =>$this->_arrPost['ChmodGroupExecute'],
                    'ChmodEveryoneRead'     =>$this->_arrPost['ChmodEveryoneRead'],
                    'ChmodEveryoneWrite'    =>$this->_arrPost['ChmodEveryoneWrite'],
                    'ChmodEveryoneExecute'  =>$this->_arrPost['ChmodEveryoneExecute'], 
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/filemanager/');
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
            'myForm'            =>  $fileManagerAdminForm,
            'item'              =>  $item,
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
                    $fileName = $upload->uploadFile('image', UPLOAD_PATH .'/email-template/', array('task' => 'rename'), 'batdongsan_');
                    //Thực hiện xóa ảnh cũ
                    
                    $upload->removeFile(UPLOAD_PATH .'/email-template/'.$this->_arrPost['image_hidden']);
                        
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
        $this->redirect()->toUrl('/admin/filemanager/');
        return $this->getResponse();    
    }
    public function statusAction(){
        if(!empty($this->_arrParam['id'])){
            $filter     = new \Zend\Filter\Digits();
            $id         = $filter->filter($this->_arrParam['id']);
            $arrParam   = array('status'=>$this->_arrParam['status'],'id'=>$id);
            $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
        }
        $this->redirect()->toUrl('/admin/filemanager/');   
        return $this->getResponse();
    }
    public function deleteAction(){
        if(!empty($this->_arrParam['id'])){
            $filter   = new \Zend\Filter\Digits();
            $id       = $filter->filter($this->_arrParam['id']);
            $arrParam = array('id'=>$id);
            $item = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
            
            
            //-------Tiến hành xóa  toàn bộ file của folder trước
            $upload = new \ZendVN\File\Upload();
            $folder = FILE_MANAGER_URL_CODINH .'/'.$item->name;
            $fileList = scandir($folder);
            foreach ($fileList as $file) {
                if ($file != '.' && $file != '..'){
                    $upload->removeFile(FILE_MANAGER_PATH .'/'.$item->name.'/'.$file);
                }
            }
            //--------Sau đó xóa folder-----------------------------
            @rmdir(FILE_MANAGER_URL_CODINH .'/'.$item->name);

            $this->getTable()->deleteItem($arrParam,array('task'=>'delete-folder'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/admin/filemanager/');
        return $this->getResponse();    
    }
    public function multiDeleteAction(){
        
        if(!empty($this->_arrParam['id'])){
            
            $items = $this->getTable()->deleteItem($this->_arrParam,array('task'=>'list-file'));
            
            if(!empty($items)){
                foreach($items as $item){
                    $upload = new \ZendVN\File\Upload();
                    $upload->removeFile(FILE_MANAGER_PATH .'/'.$item['name_folder'].'/'.$item['filename']);
                }    
            }        
            $this->getTable()->deleteItem($this->_arrParam,array('task'=>'multi-delete-item-file'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $redirect   = new Container('redirect');
        $this->redirect()->toUrl($redirect->curentUrl);
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
                if($this->params()->fromPost('keywords_file') != ''){
                    $ssFilter->keywords_file = $purifier->purify(trim($this->params()->fromPost('keywords_file')));
                    
                }
                $ssFilter->status   = $this->params()->fromPost('status');
                $ssFilter->city     = $this->params()->fromPost('city_id');
                $ssFilter->group    = $this->params()->fromPost('group_id');
                
            }if($this->_arrParam['col'] == 'null' && $this->_arrParam['by'] == 'null' && $this->_arrParam['key'] == 0){
                $ssFilter->getManager()->getStorage()->clear($this->_namespace);
            }
        }

        if($this->_arrParam['type'] == 'order' && $this->_arrParam['col'] != 'null' && $this->_arrParam['by'] != 'null'){
            $ssFilter->col      = $this->_arrParam['col'];
            $ssFilter->order    = $this->_arrParam['by'];
        }
        if($this->_arrParam['type'] == 'record'){
            $ssFilter->record   = $this->params()->fromPost('record');

        }
        $redirect   = new Container('redirect');
        
        $this->redirect()->toUrl($redirect->curentUrl);
        return $this->getResponse();   
    }

    
    
}
