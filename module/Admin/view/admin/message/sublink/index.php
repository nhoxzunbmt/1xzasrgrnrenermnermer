
<?php 
	
	
	$linkMessageAdd 		= '<li><a href="'.$this->basePath('/'.$this->arrParam['module'].'/message/add').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Gửi tin nhắn</a></li>';
	$linkMessageReceive		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/message/receive').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Hộp thư đến</a></li>';
	$linkMessageSend		= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/message/index').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Hộp thư đi</a></li>';
	$linkMessageUserReceive = '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/message/user-receive').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Lưu trữ tin nhắn đến</a></li>';
	$linkMessageUserSend 	= '<li class="SecondLast"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/message/user-send').'"><img src="'.TEMPLATE_URL.'/admin/images/icon_menu.png" width="10px" > Lưu trữ tin nhắn đi</a></li>';

	switch ($this->arrParam['controller']){
	
		case 'message' :  	if($this->arrParam['action'] == 'add')
										$strBtn = 
										'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/message/add').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Gửi tin nhắn</a></li>'
										.$linkMessageReceive 
										.$linkMessageSend 
										.$linkMessageUserReceive
										.$linkMessageUserSend;

							if($this->arrParam['action'] == 'index')
										$strBtn = 
										$linkMessageAdd
										.$linkMessageReceive 
										.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/message/index').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Hộp thư đi</a></li>'
										.$linkMessageUserReceive
										.$linkMessageUserSend;

							if($this->arrParam['action'] == 'receive')
										$strBtn = 
										$linkMessageAdd
										.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/message/index').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Hộp thư đến</a></li>'
										.$linkMessageSend 
										.$linkMessageUserReceive
										.$linkMessageUserSend;	

                            if($this->arrParam['action'] == 'user-receive')
										$strBtn = 
										$linkMessageAdd
										.$linkMessageReceive 
										.$linkMessageSend 
										.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/message/user-receive').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Lưu trữ tin nhắn đến</a></li>'
										.$linkMessageUserSend;	

							if($this->arrParam['action'] == 'user-send')
										$strBtn = 
										$linkMessageAdd
										.$linkMessageReceive 
										.$linkMessageSend 
										.$linkMessageUserReceive
										.'<li class="Last"><a href="'.$this->basePath('/'.$this->arrParam['module'].'/message/user-send').'"><img src="'.TEMPLATE_URL.'/admin/images/tablet_menu_icon.png" width="10px" > Lưu trữ tin nhắn đi</a></li>';
													      						                    	  
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
                        