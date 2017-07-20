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
?>
<div class="header-c">
	<div class="hd-in-c">
		<div
			style="display: inline-table !important; float: left; padding-top: 10px;">
			<div style="float: left">
				<a title="Trang chu bat dong san" href="/">
				    <img alt="Logo" height="78" style="border: 0px;" src="<?php echo TEMPLATE_URL;?>/home/images/logo.png" />
				</a>
			</div>
			<div style="float: left; padding-top: 15px;">
				<label style="color: #0099FF; font-size: 25px; font-weight: bold; padding-top: 2px;">WebNew</label>
				<label style="color: #FF9900; font-size: 25px; font-weight: bold; padding-top: 2px;">.vn</label>
				<div style="font-style: italic; color: Gray; margin-bottom: 5px;">
					<h1>Kênh thông tin số 1 về</h1> bất động sản
				</div>
				<div class="g-plusone" data-size="medium"></div>

			</div>
		</div>
		<div style="display: inline-table !important; float: left; padding-top: 5px; padding-right: 25px;"></div>
		<div style="float: right;">
			<div id="viewBanner1_divBanner" class="dv-banner-1">
				<a target="_blank" rel="nofollow" href='<?php echo $url;?>'>
					<img width="<?php echo $width;?>" height="<?php echo $height;?>"  src='<?php echo $banner;?>' />
				</a>
			</div>
		</div>
	</div>
</div>