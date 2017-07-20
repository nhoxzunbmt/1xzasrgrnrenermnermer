<?php 
	
	
	$linkConfigWebsite 		= '<li><a href="'.$this->basePath('/'.$this->arrParam['module'].'/config/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Cấu hình chung</a></li>';
	$linkSupport 			= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/support/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Hỗ trợ trực tuyến</a></li>';
	$linkSites 				= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/sites/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Địa danh</a></li>';
	

	switch ($this->arrParam['controller']){
	
		case 'sites' : 	 
										$strBtn =  $linkConfigWebsite
										.$linkSupport
										.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/sites/index').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Địa danh</a></li>';
                                  						                    	  
			  				
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
                        