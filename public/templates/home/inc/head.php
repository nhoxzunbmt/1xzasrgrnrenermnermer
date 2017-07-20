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
                ->prependStylesheet(TEMPLATE_URL . '/home/css/theme.css');
echo $this->headScript()->prependFile(TEMPLATE_URL . '/home/js/jquery.js');
