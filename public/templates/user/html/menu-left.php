<?php
$linkCpanel 		= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'index','action'=>'index'));
$linkAddLand 		= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'real-estate','action'=>'add'));
$linkListLand 		= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'real-estate','action'=>'index'));
$linkSaveLand 		= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'real-estate','action'=>'favorite'));
$linkInfoAccount 	= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'account','action'=>'index'));
$linkChangePass 	= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'account','action'=>'change-password'));
$linkAccoutAdd 		= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'account','action'=>'add'));
$linkListStaff 		= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'account','action'=>'staff'));
$linkCreateBusiness = $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'business','action'=>'add'));
$linkInfoBusiness 	= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'business','action'=>'index'));
$linkStatisticBds 	= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'statistic','action'=>'realestate'));
$linkStatisticService 	= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'statistic','action'=>'service'));

$linkRegisterEmail 	= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'register-email','action'=>'add'));
$linkListEmail 		= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'register-email','action'=>'index'));
$linkService 		= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'service','action'=>'index'));

$linkMessageAdd 	= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'message','action'=>'add'));
$linkMessageSend 	= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'message','action'=>'send'));
$linkMessageReceive = $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'message','action'=>'receive'));
$linkContact 		= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'contact','action'=>'add'));
$linkRealEstateContact 		= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'contact-realestate','action'=>'index'));
$linkAgencyContact 	= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'contact-agency','action'=>'index'));
$linkBusinessContact= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'contact-business','action'=>'index'));
$linkComment		= $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'comment','action'=>'index'));

?>
<div style="position:absolute; top: 372px; left: 55%; visibility: hidden; z-index: 1;" id="dhtmltooltip" class="toolTipAcc"></div>
    <div style="left: 534px; visibility: hidden; top: 383px" id="dhtmlpointer"></div>
    <div style="display: none; left: 5px; position: fixed; top: 2px; background-color: #ffffcc" id="divWating">
        <font color="red"><b>Đang xử lí ... </b></font>
    </div>
    <a name="usrTop"></a>
<div id="MainMenu">
	<ul>
		<li class="menuheaders"><a href="<?php echo $linkCpanel;?>"><span>Trang thành viên</span></a></li>
		<li class="menuheaders"><a href="javascript:NvgUsrFunction.SetToggleMenu('4');" class="current"><span>Đăng tin BĐS</span></a>
			<ul class="menucontents" id="ulMenu4">
				<li><a id="realestate-add" href="<?php echo $linkAddLand;?>"><span>Đăng tin</span></a></li>
				<li><a id="realestate-index" href="<?php echo $linkListLand;?>"><span>Danh sách BĐS</span></a></li>
			</ul>
		</li>
		<li class="menuheaders"><a href="javascript:NvgUsrFunction.SetToggleMenu('13');"><span>Dịch vụ tài khoản cao cấp</span></a>
			<ul class="menucontents" id="ulMenu13">
				<li><a id="service-index" href="<?php echo $linkService;?>"><span>Dịch vụ tài khoản cao cấp</span></a></li>
			</ul>
		</li>
		<li class="menuheaders"><a href="javascript:NvgUsrFunction.SetToggleMenu('6');"><span>Tìm kiếm BĐS</span></a>
			<ul class="menucontents" id="ulMenu6">
				<li><a id="registeremail-add" href="<?php echo $linkRegisterEmail ;?>"><span>Đăng kí tìm mua - tìm thuê</span></a></li>
				<li><a id="registeremail-index" href="<?php echo $linkListEmail ;?>"><span>Danh sách đăng kí tìm mua</span></a></li>
				<li><a id="realestate-favorite" href="<?php echo $linkSaveLand;?>"><span>BĐS đã lưu</span></a></li>
			</ul>
		</li>

		<li class="menuheaders"><a href="javascript:NvgUsrFunction.SetToggleMenu('2');"><span>Tài khoản cá nhân</span></a>
			<ul class="menucontents" id="ulMenu2">
				<li><a id="account-index" href="<?php echo $linkInfoAccount;?>"><span>Thông tin tài khoản</span></a></li>
				<li><a id="account-change-password" href="<?php echo $linkChangePass;?>"><span>Đổi password</span></a></li>
				<li><a id="account-add" href="<?php echo $linkAccoutAdd;?>"><span>Thêm nhân viên</span></a></li>
				<li><a id="account-staff" href="<?php echo $linkListStaff;?>"><span>Danh sách nhân viên</span></a></li>
				
			</ul>
		</li>
		<li class="menuheaders"><a href="javascript:NvgUsrFunction.SetToggleMenu('8');"><span>Trang doanh nghiệp</span></a>
			<ul class="menucontents" id="ulMenu8">
				<li><a id="business-add" href="<?php echo $linkCreateBusiness;?>"><span>Tạo trang doanh nghiệp</span></a></li>
				<li><a id="business-index" href="<?php echo $linkInfoBusiness;?>"><span>Thông tin doanh nghiệp</span></a></li>
				
			</ul>
		</li>
		<li class="menuheaders"><a href="javascript:NvgUsrFunction.SetToggleMenu('5');"><span>Báo cáo &amp; Thống kê</span></a>
			<ul class="menucontents" id="ulMenu5">

				<li><a id="statistic-service" href="<?php echo $linkStatisticService;?>"><span>Báo cáo dịch vụ </span></a></li>
				<li><a id="statistic-realestate" href="<?php echo $linkStatisticBds;?>"><span>Thống kê BĐS</span></a></li>
				
			</ul>
		</li>

		<li class="menuheaders"><a href="javascript:NvgUsrFunction.SetToggleMenu('7');"><span>Tin nhắn</span></a>
			<ul class="menucontents" id="ulMenu7">

				<li><a id="message-add" href="<?php echo $linkMessageAdd;?>"><span>Gửi tin nhắn</span></a></li>
				<li><a id="message-receive" href="<?php echo $linkMessageReceive;?>"><span>Hộp thư đến</span></a></li>
				<li><a id="message-send" href="<?php echo $linkMessageSend;?>"><span>Hộp thư đi</span></a></li>
			</ul>
		</li>

		<li class="menuheaders"><a href="javascript:NvgUsrFunction.SetToggleMenu('11');"><span>Hỗ trợ/ Liên Hệ</span></a>
			<ul class="menucontents" id="ulMenu11">

				<li><a id="contact-add" href="<?php echo $linkContact;?>"><span>Hỗ trợ</span></a></li>
				<li><a id="contactrealestate-index" href="<?php echo $linkRealEstateContact;?>"><span>Liên hệ BĐS</span></a></li>
				<li><a id="contactagency-index" href="<?php echo $linkAgencyContact;?>"><span>Liên hệ Môi Giới</span></a></li>
				<li><a id="contactbusiness-index" href="<?php echo $linkBusinessContact;?>"><span>Liên hệ Doanh nghiệp</span></a></li>
				<li><a id="comment-index" href="<?php echo $linkComment;?>"><span>Nhận xét của khách hàng</span></a></li>
			
			</ul>
		</li>

		
	</ul>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        var classCurrent = '<?php echo $this->arrParams['controller'] ."-".$this->arrParams['action'];?>';
        if(classCurrent == 'account-edit' || classCurrent == 'account-index'){
            $('ul > li > a#account-index').addClass("current");
        }
        if(classCurrent == 'business-edit' || classCurrent == 'business-index'){
            $('ul > li > a#business-index').addClass("current");
        }
        if(classCurrent == 'service-index' || classCurrent == 'service-pay'){
            $('ul > li > a#service-index').addClass("current");
        }
        if(classCurrent == 'realestate-edit' || classCurrent == 'realestate-active'){
            $('ul > li > a#realestate-index').addClass("current");
        }

        if(classCurrent == 'message-send' || classCurrent == 'message-view-send'){
            $('ul > li > a#message-send').addClass("current");
        }

        if(classCurrent == 'message-receive' || classCurrent == 'message-view-receive'){
            $('ul > li > a#message-receive').addClass("current");
        }

        if(classCurrent == 'contactrealestate-index' || classCurrent == 'contactrealestate-view'){
            $('ul > li > a#contactrealestate-index').addClass("current");
        }

        if(classCurrent == 'contactagency-index' || classCurrent == 'contactagency-view'){
            $('ul > li > a#contactagency-index').addClass("current");
        }

        if(classCurrent == 'contactbusiness-index' || classCurrent == 'contactbusiness-view'){
            $('ul > li > a#contactbusiness-index').addClass("current");
        }
        if(classCurrent == 'comment-index' || classCurrent == 'comment-add'){
            $('ul > li > a#comment-index').addClass("current");
        }
        $('ul > li > a#' + classCurrent).addClass("current");
    });
</script>    