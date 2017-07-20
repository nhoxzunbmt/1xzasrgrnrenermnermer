
<?php 
	
	
	$linkNewsManager 		= '<li><a href="'.$this->basePath('/'.$this->arrParam['module'].'/news/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Tin tức BĐS</a></li>';
	$linkNewsCatManager 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/news-category/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Danh mục tin tức BĐS</a></li>';
	$linkNiceHouse  		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/nicehouse/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Nhà đẹp</a></li>';
	$linkNiceHouseCat 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/nicehouse-category/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Danh mục nhà đẹp</a></li>';
	$linkFengshuiNews 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/fengshuinews/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Tin tức phong thủy</a></li>';
	$linkFengshuiApp 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/fengshuiapp/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Ứng dụng phong thủy</a></li>';
	$linkFengshuiCat 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/fengshui-category/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Danh mục phong thủy</a></li>';
	$linkNotifi 			= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/notifi/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Thông báo</a></li>';


	switch ($this->arrParam['controller']){
	
		case 'fengshuicategory' : $strBtn =  $linkNewsManager
										.$linkNewsCatManager
										.$linkNiceHouse
										.$linkNiceHouseCat
										.$linkFengshuiNews 
										.$linkFengshuiApp 
										.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/fengshui-category/index').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Danh mục phong thủ</a></li>'
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
                        