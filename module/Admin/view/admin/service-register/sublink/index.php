
<?php 
	
	$linkService 				= '<li><a href="'.$this->basePath('/'.$this->arrParam['module'].'/service/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Quản lý dịch vụ</a></li>';
	$linkServiceRegister 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/service-register/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Danh sách đăng kí tài khoản cao cấp</a></li>';
	

	switch ($this->arrParam['controller']){
	
		case 'serviceregister' : $strBtn = $linkService 
										 	.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/service-register/index').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Danh sách đăng kí tài khoản cao cấp</a></li>';
								
								
                                  						                    	  
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
                        