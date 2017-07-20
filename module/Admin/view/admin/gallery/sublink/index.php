
<?php 
	
	
	$linkFileManager 		= '<li><a href="'.$this->basePath('/'.$this->arrParam['module'].'/filemanager/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Quản lý file</a></li>';
	$linkGallery 			= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/gallery/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Thư viện ảnh</a></li>';
	$linkPoll	  			= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/survey/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Thăm dò ý kiến</a></li>';
	$linkSlide 				= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/slide/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Slide show</a></li>';

	

	switch ($this->arrParam['controller']){
	
		case 'gallery' : 	
										$strBtn = $linkFileManager 
										.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/gallery/index').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Thư viện ảnh</a></li>'
										.$linkPoll
										.$linkSlide;
										
													
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
                        