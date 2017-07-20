
<?php 
	
	$linkProjectManager 		= '<li><a href="'.$this->basePath('/'.$this->arrParam['module'].'/project/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Quản lý dự án</a></li>';
	$linkProjectCategory 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/project-category/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Danh mục dự án</a></li>';
	$linkRealEstate 			= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/realestate/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Quản lý bất động sản</a></li>';
	$linkRealEstateCat 			= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/realestate-category/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Loại bất động sản</a></li>';
	$linkBusiness 				= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/business/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Danh sách doanh nghiệp</a></li>';
	$linkBusinessType 			= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/business-type/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Loại hình doanh nghiệp</a></li>';


	switch ($this->arrParam['controller']){
	
		case 'business' : $strBtn = 
		 						$linkProjectManager
		 						.$linkProjectCategory
		 						.$linkRealEstate 
		 						.$linkRealEstateCat
								.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/business/index').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Doanh nghiệp BĐS</a></li>'
								.$linkBusinessType;
								
                                  						                    	  
			  			break;
								
		default:	$strBtn = '';				  				  					  					  					  				
	}	

?>

<div id="Breadcrumb" class="Block Breadcrumb ui-widget-content ui-corner-top ui-corner-bottom" style="background:white;">
    <ul>
        <?php echo $strBtn;?>
    </ul>
</div>
<div style="clear: both;"></div>
                        