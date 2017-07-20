<?php
if(!empty($this->arrParams['itemSkin'])){
    
    $arrConfigFooter    = \Zend\Json\Json::decode($this->arrParams['itemSkin']->config_footer);
    $footer             = $arrConfigFooter->content;
}

//nhà đất theo thành phố
$xhtmlNavFooter = '';
if(!empty($this->arrParams['itemNavFooter'])){
   
    foreach($this->arrParams['itemNavFooter'] as $item){
        $xhtmlNavFooter       .= '<li><a title="'.$item['name'].'" href="'.$item['url'].'">'.$item['name'].'</a></li>';
      
    }  
}

//nhà đất theo thành phố
$xhtmlCityRealestate = '';
if(!empty($this->arrParams['listCity'])){
    foreach($this->arrParams['listCity'] as $item){

        $urlCity   = $this->url(
            'CityBatDongSanRoute',
            array('controller'=>'realestate','action'=>'city','cityname'=>\ZendVN\Url\FriendlyLink::filter($item['name']),'page'=>1,'cityid'=>$item['id']
        ));
        
        $xhtmlCityRealestate   .= '<div style="width:120px;">
                <ul>
                   <li><a href="'.$urlCity.'">BĐS '.$item['name'].'</a></li>
                </ul>
            </div>';
     
    }  
}

//thông báo
$style      = 'left: 40%; top: 100px;display : none;';
$content    = '';
if(!empty($this->arrParams['itemNotifi'])){

    $title      = $this->arrParams['itemNotifi']->title;
    $content    = $this->arrParams['itemNotifi']->content;
    $status     = $this->arrParams['itemNotifi']->status;
    if($status == 1){
        $style = 'left: 40%; top: 100px;';
    }
}    

       
?>
    <script type="text/javascript">
        setTimeout(function () {
            var a = document.createElement("script");
            var b = document.getElementsByTagName("script")[0];
            a.src = document.location.protocol + "//dnn506yrbagrg.cloudfront.net/pages/scripts/0018/5505.js?" + Math.floor(new Date().getTime() / 3600000);
            a.async = true; a.type = "text/javascript"; b.parentNode.insertBefore(a, b)
        }, 1);
</script>




    
    <div class="mainProvinces">
    		<div class="contentFooter">
                <?php echo $xhtmlCityRealestate;?>
            </div>
    </div>
    <div class="pageWrap">
        <ul class="navFooter">
            <?php echo $xhtmlNavFooter;?>
        </ul>
        <?php echo $footer;?>
       
    </div>    


<script type="text/javascript" src="http://muabannhadat.com.vn/js/ucjs.js"></script>    


<div style="<?php echo $style;?>" class="signInNewDialog pDialog" id="thongbao_box">
	<div class="TitleDialog">
        <h4>Thông báo</h4>
        <a class="bt_close_1" href="javascript:void(0)" id="box_close_notice"  title="Đóng">Đóng</a>
    </div>
	<div class="ContentDialog" id="thongbaoContent">
       <?php echo $content;?>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#box_close_notice").click(function(){

         $("#thongbao_box").removeAttr('style').css({'display':'none'});
    });
})

function box_close(){
    //$("#thongbao_box").removeAttr('style').css({'display':'none'});
}

</script>
  
   
    
    <div class="Dialog_2 hiddenDropBox" id="divFullSearch" style="display: none; width: 700px; top: 30%; left: 33%;"></div>
    
      <div class="signInNewDialog pDialog" style="left: 25%; top: 50px; display: none; width: 700px; position: fixed; *position: absolute;" id="showCoworkerLst"></div>
 <script type="text/javascript">
     $(window).scroll(function () {
         var scrollTop = $(window).scrollTop();
         if (scrollTop > 400) {
             document.getElementById('scrollTopDiv').style.display = '';
             // display add
         }
         else document.getElementById('scrollTopDiv').style.display = 'none';
     });
    </script>
    <div id="scrollTopDiv" style="position: fixed; z-index: 600; bottom: 10px; right: 10px; display:none;" class="topControl">
    <a onclick="$('html, body').animate({scrollTop:0}, 400);" title="Trở về đầu trang" href="javascript:;"><img width="40" height="40" alt="" src="<?php echo TEMPLATE_URL;?>/default/images/scrolltop-control.png" /></a>
    </div>
	<input type="hidden" value="MainContent" id="hdfCtlMst" />