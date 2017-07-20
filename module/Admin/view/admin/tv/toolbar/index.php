<?php 
	$ssFilter = $this->arrParam['ssFilter'];

	//1. Active Items - submit
    $id 				= !empty($this->arrParam['id']) ? $this->arrParam['id'] : '';

	$linkActiveItems 	= "javascript:Confirm('multi-active');";
    $btnActiveItems 	= $this->cmsButton('Kích hoạt',$linkActiveItems,TEMPLATE_URL . '/admin/images/icon-32-active.png','onclick','cph_Main_ctl00_toolbox_rptAction_lbtAction_active');
	//2. Inactive Items - submit										
	$linkInactiveItems 	= "javascript:Confirm('multi-in-active');";
	$btnInactiveItems 	= $this->cmsButton('Ngừng kích hoạt',$linkInactiveItems,TEMPLATE_URL . '/admin/images/icon-32-inactive.png','onclick');
	//3. Add new - link - /default/admin-group/add
	$linkAddNew 		= $this->basePath($this->currentController . '/add');
	$btnAddNew 			= $this->cmsButton('Thêm mới',$linkAddNew,TEMPLATE_URL . '/admin/images/icon-32-new.png','link');	
	//4. Sort Item - submit -
	
	if($ssFilter['order'] == 'DESC'){
		$linkSortItem 	=  $this->basePath($this->currentController . '/filter/order/id/ASC/');
		$btnSortItem		= $this->cmsButton('Hiển thị ASC',$linkSortItem,TEMPLATE_URL . '/admin/images/icon-32-sort-up.png','link');                                    
	}else{
		$linkSortItem 		=  $this->basePath($this->currentController . '/filter/order/id/DESC/');
		$btnSortItem 		= $this->cmsButton('Hiển thị DESC',$linkSortItem,TEMPLATE_URL . '/admin/images/icon-32-sort.png','link');
	}
	
    //4.1 Sort Item - submit -
	
	//5. Delete Items - submit	
	$linkDeleteItems 	= "javascript:Confirm('multi-delete');";
	$btnDeleteItems 	= $this->cmsButton('Xóa dữ liệu',$linkDeleteItems,TEMPLATE_URL . '/admin/images/icon-32-delete.png','onclick','cph_Main_ctl00_toolbox_rptAction_lbtAction_delete');	
	//6. Save Item - submit - default/admin-group/add
	//7. Save Item - submit - default/admin-group/edit/id/1
	if($this->arrParam['action'] == 'add'){
		 $linkSaveItem 	= $this->basePath($this->currentController . '/add');
	}else{
		$linkSaveItem 	= $this->basePath($this->currentController . '/edit/' . $id);
	}
	$btnSaveItem 		= $this->cmsButton('Lưu',$linkSaveItem,TEMPLATE_URL . '/admin/images/icon-32-save.png','submit');
										
	//10. Cancel - link - default/admin-group/index
	$linkCancel 		= $this->basePath($this->currentController . '/index');
	$btnCancel 			= $this->cmsButton('Không đồng ý',$linkCancel,TEMPLATE_URL . '/admin/images/icon-32-cancel.png','link');	
										
	//9. Edit Item - link - default/admin-group/edit/id/1
	$linkEditItem 		= $this->basePath($this->currentController . '/edit/' . $id);
	$btnEditItem 		= $this->cmsButton('Chỉnh sửa',$linkEditItem,TEMPLATE_URL . '/admin/images/icon-32-save.png','link');	
										
	//11. Back - link  - default/admin-group/index
	$linkBack 			= $this->basePath($this->currentController . '/index');
	$btnBack 			= $this->cmsButton('Quay lại',$linkBack,TEMPLATE_URL . '/admin/images/icon-32-back.png','link');
	//12. Accept - submit - default/admin-group/delete/id/1
	$linkAccept 		= $this->basePath($this->currentController . '/delete/'  . $id);
	$btnAccept 			= $this->cmsButton('Đồng ý',$linkAccept,TEMPLATE_URL . '/admin/images/icon-32-accept.png','submit');
																																			
	switch ($this->arrParam['action']){
		case 'index'	: 	$strBtn 	= 	$btnAddNew 
										. ' ' . $btnInactiveItems
										. ' ' . $btnActiveItems
			  				    		. ' ' . $btnSortItem
			  				    		
			  				    		. ' ' . $btnDeleteItems;
			  				$iconTitle 	= 'list-index.png';	    		

			break;
		case 'edit' 	: 	$strBtn 	= $btnSaveItem . ' ' . $btnCancel;
							$iconTitle 	= 'title-edit.png';
			break;	
		case 'add' 		: 	$strBtn = $btnSaveItem . ' ' . $btnCancel;
							$iconTitle 	= 'document_add.png';
			break;	
		case 'delete'	: $strBtn = $btnAccept   . ' ' . $btnCancel;
			break;	
		case 'info' 	: $strBtn = $btnEditItem . ' ' . $btnBack;
			break;		
		default 		:	$strBtn = '';				  				  					  					  					  				
	}										
	
?>
<div class="widget-title">
        <h4><img src="<?php echo TEMPLATE_URL . '/admin/images/'.$iconTitle;?>" width="20" height="20">&nbsp;<?php echo $this->title;?></h4>
        
<div class="ui-widget-content ui-corner-top ui-corner-bottom" style="color:white;">
    <div id="toolbox">
        
        <div style="float:right;" class="toolbox-content">
            
                    <table class="toolbar" style="color:white;">
                        <tr>
                        	

                   		<?php echo $strBtn;?>
                        </tr>
                    </table>
                
        </div>
    </div>
</div>


<div id="hiddenToolBarScroll" class="scrollBox hidden">
            <h4>
                <img src="<?php echo TEMPLATE_URL . '/admin/images/'.$iconTitle;?>" width="20" height="20">&nbsp;<?php echo $this->title;?></h4>
<div class="FloatMenuBar">
                
<div class="ui-widget-content ui-corner-top ui-corner-bottom" style="color:white;">
    <div id="toolbox">
        
        <div style="float:right;" class="toolbox-content">
            
                     <table class="toolbar" style="color:white;">
                        <tr>
                   		<?php echo $strBtn;?>
                        </tr>
                    </table>
                
        </div>
    </div>
</div>
            </div>
        </div>
    </div>