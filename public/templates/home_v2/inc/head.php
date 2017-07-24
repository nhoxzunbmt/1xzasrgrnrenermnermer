<!--<meta charset="utf-8" />-->
<!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">-->
<!--<meta name="apple-itunes-app" content="app-id=1034726283" />-->
<!---->
<!--<title>abc</title>-->
<!---->
<!---->
<!--<meta name="description" content="Trang thông tin rao vặt, mua bán bất động sản uy tín tại Toàn quốc. 2,000,000 tin mua, bán, cho thuê phòng trọ, căn hộ ,nhà đất, khách sạn,... được cập nhật 24/7 tại muaban.net." />-->
<!--<meta name="keywords" content=" Toan quoc, Toàn quốc, Bat dong san, Nha dat, Bất động sản, Nhà đất, Ban nha, Bán nhà, muaban" />-->
<!--<meta name="robots" content="index,follow" />-->
<!--<meta name="msnbot" content="index,follow" />-->
<!--<meta name="author" content="Muaban.net" />-->
<!--<meta name="dcterms.rightsHolder" content="Muaban.net" />-->
<!--<meta name="dcterms.dateCopyrighted" content="2009" />-->
<!--<meta name="distribution" content="Global" />-->
<!--<meta property="fb:app_id" content="319048434870565" />-->
<!--<meta property="og:url" content="https://muaban.net/mua-ban-nha-dat-cho-thue-toan-quoc-l0-c3" />-->
<!--<meta property="og:image" content="https://muaban.net/content/images/mbn-fb-icon.png" />-->
<!--<meta property="og:title" content="Bất động sản trên Toàn Quốc " />-->
<!--<meta property="og:description" content="Trang thông tin rao vặt, mua bán bất động sản uy tín tại Toàn quốc. 2,000,000 tin mua, bán, cho thuê phòng trọ, căn hộ ,nhà đất, khách sạn,... được cập nhật 24/7 tại muaban.net." />-->
<!---->
<!---->
<!---->
<!--<link rel="canonical" href="https://muaban.net/mua-ban-nha-dat-cho-thue-toan-quoc-l0-c3" />-->
<!---->
<!--<link href="--><?php //echo TEMPLATE_URL;?><!--/ver2/css/style.css" rel="stylesheet"/>-->
<!---->
<!--<script async src='--><?php //echo TEMPLATE_URL;?><!--/ver2/js/modernizr.js'> </script>-->
<?php
$config = new \ZendVN\Config\Config();
if(!empty($this->arrParams['itemSkin'])){
    $arrConfigBackground    = \Zend\Json\Json::decode($this->arrParams['itemSkin']->config_background);
    $curentBackground       = UPLOAD_URL .'/skin/'.$arrConfigBackground->curentBackground->background;
    $fixed                  = $arrConfigBackground->curentBackground->style;
}

echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
echo $this->headTitle()->setSeparator(" - ")->append($config->title());
echo $this->headMeta()
            ->appendName('description', $config->description())
            ->prependName('keywords',$config->keyword())
            ->appendHttpEquiv('REFRESH', '600');
            
echo $this->headLink(array(
                  'rel' => 'shortcut icon',
                  'type' => 'image/vnd.microsoft.icon',
                  'href' => TEMPLATE_URL . '/home/images/favicon.png'
                ))
                ->prependStylesheet(TEMPLATE_URL . '/home_v2/css/style.css');


echo $this->headScript()->prependFile(TEMPLATE_URL . '/home_v2/js/modernizr.js');
echo $this->headScript()->prependFile(TEMPLATE_URL . '/home_v2/js/modernizr.js');







