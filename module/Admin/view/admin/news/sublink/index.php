
<?php 
	
	$linkNewsManager 			= '<li><a href="'.$this->basePath('/'.$this->arrParam['module'].'/news/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Tin tức BĐS</a></li>';
	$linkNewsCategoryManager 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/news-category/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Danh mục tin tức BĐS</a></li>';
	$linkNiceHouseManager 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/nicehouse/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Nhà đẹp</a></li>';
	$linkNiceHouseCatManager 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/nicehouse-category/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Danh mục Nhà đẹp</a></li>';
	
	$linkFengshuiNewsManager 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/fengshuinews/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Tin tức phong thủy</a></li>';
	$linkFengshuiAppManager 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/fengshuiapp/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Ứng dụng phong thủy</a></li>';
	$linkFengshuiCatManager 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/fengshui-category/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Danh mục phong thủy</a></li>';
	$linkNotifi 			= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/notifi/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Thông báo</a></li>';


	switch ($this->arrParam['controller']){
	
		case 'news' : $strBtn =  '<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/news/index').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Tin tức BĐS</a></li>'
								.$linkNewsCategoryManager
								.$linkNiceHouseManager
								.$linkNiceHouseCatManager
								.$linkFengshuiNewsManager
								.$linkFengshuiAppManager
								.$linkFengshuiCatManager
								.$linkNotifi;
								
                                  						                    	  
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
                        