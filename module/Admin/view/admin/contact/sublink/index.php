
<?php 
	
	$linkUserManager 		= '<li><a href="'.$this->basePath('/'.$this->arrParam['module'].'/user/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Quản lý thành viên</a></li>';
	$linkUserGroupManager 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/user-group/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Quản lý nhóm thành viên</a></li>';
	$linkPermission 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/permission/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Phân quyền</a></li>';
	$linkContact 			= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/contact/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Liên hệ từ khách hàng</a></li>';
	$linkContactRealEstate 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/contact-realestate/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Liên hệ BĐS</a></li>';
	$linkContactAgency 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/contact-agency/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Liên hệ môi giới</a></li>';
	$linkContactBusiness 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/contact-business/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Liên hệ doanh nghiệp</a></li>';
	
	$linkEmailRegister 		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/email-newsletter/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Email đăng kí</a></li>';
	$linkComment 			= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/comment/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Nhận xét</a></li>';

	switch ($this->arrParam['controller']){
	
		case 'contact' : $strBtn = $linkUserManager 
								.$linkUserGroupManager
								.$linkPermission
								.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/contact/index').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Liên hệ từ khách hàng</a></li>'
								.$linkContactRealEstate
								.$linkContactAgency
								.$linkContactBusiness
								.$linkEmailRegister
								.$linkComment;
                                  						                    	  
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
                        