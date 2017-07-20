<?php
if(!empty($this->arrParams['itemSkin'])){
    $menuHome       = $this->url('home',array('module'=>'home','controller'=>'index','action'=>'index'));
    $arrConfigLogo  = \Zend\Json\Json::decode($this->arrParams['itemSkin']->config_logo);
    $image          = (!empty($arrConfigLogo->logo))  ? UPLOAD_URL .'/skin/'.$arrConfigLogo->logo :  TEMPLATE_URL .'/admin/images/NoImage.jpg';
    $slogan         = $arrConfigLogo->slogan;
} 

$linkCpanel       = $this->url('MVC_AdminRouter/action',array('module'=>'admin','controller'=>'index','action'=>'index'));   


$actionUser = '';
if(!empty($this->identity()->id)){
    $linkEditUser       = $this->url('MVC_AdminRouter/action',array('module'=>'admin','controller'=>'user','action'=>'edit','id'=>$this->identity()->id));   
    $linkLogout         =  $this->url('MVC_HomeRouter/action',array('module'=>'home','controller'=>'user','action'=>'logout'));
    $actionUser = '<li class="ViewWebsite"><a class="link-topmenu" title="Chào '.$this->identity()->fullname.'" href="'.$menuHome.'" target="_blank"><img src="'. TEMPLATE_URL.'/admin/images/inav.png" width="10" height="10"> <font color="red"><b>'.\ZendVN\Filter\ReadMore::create($this->identity()->fullname,0,10).'</font></b></a>
            <ul class="hidden-topmenu">
                <li><a class="" href="'.$linkEditUser.'" target="_blank">
                    <div class="perMenuItem">
                        Chỉnh sửa</div>
                </a></li>
                <li><a class="" href="'.$linkLogout.'" target="_blank">
                    <div class="perMenuItem">
                        Đăng xuất</div>
                </a></li>
               
            </ul>
        </li>';
}
?>  
<div class="LogoHeader" >

    <div class="logoimage">
        <a class="SiteName" href="<?php echo $linkCpanel;?>">
            <img border="0" style="max-width:43%;" src="<?php echo $image;?>" alt="logo"
                title="logo" height="43px" />
        </a>
    </div>
    <div class="linkroot">
        <a class="SiteName" href="<?php echo $linkCpanel;?>" target="_blank">
            Admin Control Panel
        </a>
    </div>
</div>

<div class="SystemMenu" >
            
                
<style type="text/css">
    .sysMenu li
    {
        display: block;
        min-width: 80px;
        height: 24px;
        float: left;
        position: relative;
        padding-top: 3px;
        
    }
    .hidden-topmenu
    {
        background-color: #FFF;
        border: 1px solid #dbdbdb;
        display: none;
        position: absolute;
        z-index: 192;
        list-style-type: none;
        left:-1px;
        width: 155px;
        -webkit-border-radius: 3px;
        -webkit-border-top-left-radius: 0;
        -moz-border-radius: 3px;
        -moz-border-radius-topleft: 0;
        border-radius: 3px;
        border-top-left-radius: 0;
    }

    .HaveSubmenu .hidden-topmenu {
        top: 24px;
    }

    .ViewWebsite.hidden-topmenu {
        top: 23px;
    }

    .hidden-topmenu li
    {
        display: block;
        position: relative;
        width: 155px;
    }
    .hidden-topmenu li a
    {
        color: #686868;
    }
    .hidden-topmenu li:hover a
    {
        color: #fff;
    }
    .hidden-topmenu li:hover
    {
        background-color: #24C2CE;
    }
       
    .perMenuItem
    {
        display: block;
        height: 20px;
        margin-left: 10px;
    }
    #ReportingChart
    {
        display: block;
    }
    .HaveSubmenu, .ViewWebsite
    {
        border-top: 1px solid #fff;
        border-left: 1px solid #fff;
        border-right: 1px solid #fff;    
    }

    .HaveSubmenu:after
    {
        background: none repeat scroll 0 0 #FFFFFF;
        content: "";
        display: block;
        height: 1px;
        left: 0;
        position: absolute;
        top: 24px;
        width: 100px;
        z-index: 1000;
    }
    .ViewWebsite:after
    {
        background: none repeat scroll 0 0 #FFFFFF;
        content: "";
        display: block;
        height: 1px;
        left: 0;
        position: absolute;
        top: 23px;
        width: 112px;
        z-index: 1000;
    }
    .HaveSubmenu, .ViewWebsite
    {
        background: none;
        height:0px;        
    }

    .HaveSubmenu ul, .ViewWebsite ul {
        margin:0;
        padding:0;
    }

    .HaveSubmenu:hover, .ViewWebsite:hover {
        border-top: 1px solid #dbdbdb !important;
        border-left: 1px solid #dbdbdb !important;
        border-right: 1px solid #dbdbdb !important;
        border-bottom: 1px solid #fff !important;
        display: block;
        height: 22px;
        z-index: 193;
        text-align: left;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }

    .HaveSubmenu:hover .hidden-topmenu, .ViewWebsite:hover .hidden-topmenu {
        display:block;
    }
    .dropdown-menu li {
        clear:both !important;
        padding-top:0 !important;
        height: 26px !important;
        float:none !important;
    }
    .ViewWebsite {
        width:92px;
    }

</style>
<div style="display:block;">
    <ul class="sysMenu">
        <li class="first"><a class="link-topmenu" href="<?php echo $linkCpanel;?>"><img src="<?php echo TEMPLATE_URL;?>/admin/images/inav.png" width="10" height="10">Trang
            chủ</a></li>
       
        <li class="ViewWebsite"><a class="link-topmenu" href="<?php echo $menuHome;?>" target="_blank"><img src="<?php echo TEMPLATE_URL;?>/admin/images/inav.png" width="10" height="10"> Xem website</a>
            <ul class="hidden-topmenu">
                <li><a class="" href="<?php echo $menuHome;?>" target="_blank">
                    <div class="perMenuItem">
                        Chỉ xem website</div>
                </a></li>
               
            </ul>
        </li>
        <?php echo $actionUser;?>
     
        
    </ul>
    <div style="clear:both"></div>
</div>
<div class="siteinfo">
    <?php  /*<ul><li style="padding-top:5px;">Bạn còn</li><li class="block-time">14</li><li style="margin-right:5px; padding-top:5px;">ngày dùng thử miễn phí</li></ul>*/?>
</div>
            </div>
       