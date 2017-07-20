
<?php 
	
	
	$linklegalhousing 		= '<li><a href="'.$this->basePath('/'.$this->arrParam['module'].'/legalhousing/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Pháp lý nhà đất</a></li>';
	$linklegalhousingCat 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/legalhousing-category/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Danh mục pháp lý nhà đất</a></li>';
	$linklegislationhousing = '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/legislationhousing/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Văn bản luật nhà đất</a></li>';
	$linklegislationhousingCat 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/legislationhousing-category/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Danh mục văn bản luật nhà đất</a></li>';
	$linkcontractform 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/contractform/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Biểu mẫu hợp đồng</a></li>';
	
	$linkcontractformCat 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/contractform-category/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Danh mục biểu mẫu hợp đồng</a></li>';


	switch ($this->arrParam['controller']){
	
		case 'legalhousingcategory' : $strBtn =  
										$linklegalhousing
										.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/legalhousing-category/index').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Danh mục pháp lý nhà đất</a></li>'
										.$linklegislationhousing
										.$linklegislationhousingCat 
										.$linkcontractform 
										.$linkcontractformCat;
										
                                  						                    	  
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
                        