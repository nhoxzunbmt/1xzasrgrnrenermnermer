
<?php 
	
	
	$linkWebsiteAds 		= '<li><a href="'.$this->basePath('/'.$this->arrParam['module'].'/website-ads/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Liên kết website</a></li>';
	$linkSeoGoogle 			= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/seo/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > SEO trên google</a></li>';
	$linkEmailMarketing		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/emailmarketing/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Tiếp thị qua email</a></li>';
	$linkAds 				= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/ads/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Quảng cáo trực tuyến</a></li>';


	switch ($this->arrParam['controller']){
	
		case 'websiteads' : $strBtn =  
										'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/website-ads/index').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Liên kết website</a></li>'
										.$linkSeoGoogle 
										.$linkEmailMarketing 
										.$linkAds;
										
                                  						                    	  
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
                        