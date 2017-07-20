
<?php 
	
	
	$linkMenu 				= '<li><a href="'.$this->basePath('/'.$this->arrParam['module'].'/nav-footer/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Quản lý menu (Footer)</a></li>';
	$linkSkinBanner 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/skin/banner').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Banner website</a></li>';
	$linkSkinLogo	  		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/skin/logo').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Logo website</a></li>';
	$linkSkinFooter 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/skin/footer').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Chân trang(footer)</a></li>';
	$linkSkinBackground 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/skin/background').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Thay đổi hình nền</a></li>';
	$linkNotificationtemplate 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/notificationtemplate/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Template thông báo</a></li>';
	$linkEmailtemplate 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/emailtemplate/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Template Email</a></li>';
	

	switch ($this->arrParam['controller']){
	
		case 'skin' : 	if($this->arrParam['action'] == 'logo') 
										$strBtn =  $linkMenu 
										.$linkSkinBanner
										.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/skin/logo').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Logo website</a></li>'
										.$linkSkinFooter
										.$linkSkinBackground
										.$linkNotificationtemplate
										.$linkEmailtemplate;
                                  						                    	  
			  			if($this->arrParam['action'] == 'footer') 
										$strBtn =  $linkMenu 
										.$linkSkinBanner
										.$linkSkinLogo
										.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/skin/footer').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Chân trang(footer)</a></li>'
										.$linkSkinBackground
										.$linkNotificationtemplate
										.$linkEmailtemplate;

						if($this->arrParam['action'] == 'banner') 
										$strBtn =  $linkMenu 
										.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/skin/banner').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Banner website</a></li>'
										.$linkSkinLogo
										.$linkSkinFooter
										.$linkSkinBackground
										.$linkNotificationtemplate
										.$linkEmailtemplate;	

						if($this->arrParam['action'] == 'background') 
										$strBtn =  $linkMenu 
										.$linkSkinBanner
										.$linkSkinLogo
										.$linkSkinFooter
										.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/skin/background').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Thay đổi hình nền</a></li>'
										.$linkNotificationtemplate
										.$linkEmailtemplate;				
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
                        