<?php
if(!empty($this->arrParams['itemSkin'])){
    $menuHome       = $this->url('home',array('module'=>'home','controller'=>'index','action'=>'index'));
    $arrConfigLogo  = \Zend\Json\Json::decode($this->arrParams['itemSkin']->config_logo);
    $logo           = (!empty($arrConfigLogo->logo))  ? UPLOAD_URL .'/skin/'.$arrConfigLogo->logo :  TEMPLATE_URL .'/admin/images/NoImage.jpg';
    $slogan         = $arrConfigLogo->slogan;

    $arrConfigBanner= \Zend\Json\Json::decode($this->arrParams['itemSkin']->config_banner);
    $banner         = (!empty($arrConfigBanner->banner))  ? UPLOAD_URL .'/skin/'.$arrConfigBanner->banner :  TEMPLATE_URL .'/admin/images/NoImage.jpg';
    $url            = $arrConfigBanner->url;
    $width          = $arrConfigBanner->width;
    $height         = $arrConfigBanner->height;
} 
$xhtml = '';
if(!empty($this->arrParams['itemSupport'])){
    $xhtml = '';
    foreach ($this->arrParams['itemSupport'] as $item) {
        
        if($item['type'] == 'yahoo')
            $xhtml .= '<a class="yahoo" title="'.$item['name'].'" href="ymsgr:sendIM?'.$item['nickname'].'">&nbsp;</a>';
        if($item['type'] == 'skype')
            $xhtml .= '<a class="skype" title="'.$item['name'].'" href="skype:'.$item['nickname'].'?userinfo">&nbsp;</a>';
        
    }
} 
$menuSupport       = $this->url('MVC_HomeRouter/action',array('module'=>'home','controller'=>'index','action'=>'support'));

?>


    <div class="topInfo">
        <div class="pageWrap">
            <strong><a id="aMHoTro" rel="nofollow" title="Quảng cáo &amp; Trợ giúp" href="<?php echo $menuSupport;?>">Quảng cáo & Trợ giúp</a></strong> 
                Hỗ trợ trực tuyến: <?php echo $xhtml;?> </p>
        </div>
    </div>
    <div class="pageWrap">
    <h1 class="logo"><a title="<?php echo $slogan;?>" href='<?php echo $menuHome;?>'><img width="250" height="80" title="<?php echo $slogan;?>" alt='<?php echo $slogan;?>' src='<?php echo $logo;?>' /></a></h1>
        
        <div class="topBanner">
            
            <a href='<?php echo $url;?>'><img width="<?php echo $width;?>" height="<?php echo $height;?>"  src='<?php echo $banner;?>' /></a>
            
        </div>
    </div>
