
<?php 
	
	$linkBusinessManager 		= '<li><a href="'.$this->basePath('/'.$this->arrParam['module'].'/business/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Doanh nghiệp BĐS</a></li>';
	$linkBusinessTypeManager 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/business-type/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Loại hình doanh nghiệp</a></li>';


	switch ($this->arrParam['controller']){
	
		case 'business' : $strBtn =  '<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/business/index').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Doanh nghiệp BĐS</a></li>'
								.$linkBusinessTypeManager;
								
                                  						                    	  
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
                        