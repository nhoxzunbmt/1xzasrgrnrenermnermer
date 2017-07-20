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
        $urlCity   = $this->url('CityBatDongSanRoute',array(
            'controller'=>'realestate',
            'action'=>'category',
            'type'  => 'tat-ca',
            'cityname'=>\ZendVN\Url\FriendlyLink::filter($item['name']),
            'page'=>1,
            'id'=>$item['id']
        ));
        
        $xhtmlCityRealestate   .= '<div style="width:120px;">
                <ul>
                   <li><a href="'.$urlCity.'">BĐS '.$item['name'].'</a></li>
                </ul>
            </div>';
     
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

<script type="text/javascript">
    var _urq = _urq || [];
    _urq.push(['initSite', 'd2ae7dbd-665e-46a1-abe6-c1696a0fb1da']);
    (function () {
        var ur = document.createElement('script'); ur.type = 'text/javascript'; ur.async = true;
        ur.src = ('https:' == document.location.protocol ? 'https://cdn.userreport.com/userreport.js' : 'http://cdn.userreport.com/userreport.js');
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ur, s);
    })();
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

    
<div style="width: 585px; position: absolute; left: 338px; top: 10%; z-index: 1000; display: none;" id="ttpopup" class="Dialog_4 pDialog">
        <div class="TitleDialog">
            <h4 id="ctinhthanh">Chọn tỉnh thành</h4>
            <h4 id="cquanhuyen" style="display: none;">Chọn quận huyện</h4>
            <a class="bt_close_1" onclick="$('#ttpopup').hide();" href="javascript:void(0)">Đóng</a>
        </div>
        <div id="lstState" class="ContentDialog"></div>
    </div>
    
    <div style="left: 12%; top: 20%; display: none;" class="signInNewDialog pDialog" id="login_box">
                                <div class="TitleDialog">
                                    <h4 id="login_box_popup_header">Tạo tài khoản</h4>
                                    <a class="bt_close_1" href="javascript:void(0)" id="login_box_popup_closer" onclick="login_box_close();" title="Đóng">Đóng</a>
                                </div>
                                 <div  id="contentlogin" class="ContentDialog">
                                    
                                 </div>
                        </div>

<div style="left: 40%; top: 100px; display: none;" class="signInNewDialog pDialog" id="thongbao_box">
                                <div class="TitleDialog">
                                    <h4>Thông báo</h4>
                                    <a class="bt_close_1" href="javascript:void(0)" onclick="login_box_close();" title="Đóng">Đóng</a>
                                </div>
                                 <div class="ContentDialog" id="thongbaoContent"></div>
</div>
    <div class="sendEmailFriendDialog pDialog" style="left: 12%; top: 20%; display: none;" id="sendEmailbox">
                                <div class="TitleDialog">
                                    <h4 id="sendEmailbox_popup_header">Gửi email cho bạn bè</h4>
                                    <a title="Đóng" href="javascript:void(0)" onclick="login_box_close();" class="bt_close_1">Đóng</a>
                                </div>
                                 <div id="sendEmailboxContent" class="ContentDialog">
                                    
                                 </div>
                        </div>
    <!-- box phong thuy -->   
    <div id="boxPhongThuy" class="fengshuiDialog pDialog" style="left: 40%; top: 20%; display: none;">
        <div class="TitleDialog">
            <h4 id="divTieuDePhongThuy">Xem phong thủy</h4>
            <a title="Đóng" href="javascript:void(0)" onclick="$('#boxPhongThuy').hide();"  class="bt_close_1">Đóng</a>
        </div>
        <div class="ContentDialog" id="divNoiDungPhongPhuy"></div>
    </div> 
    
<div id="EmailAlert_box" class="samePropertyDialog pDialog" style="left: 40%; top: 25%; display: none;">
    <div class="TitleDialog">
        <h4 id="EmailAlert_box_popup_header">Nhận BĐS tương tự qua email</h4>
        <a title="Đóng" rel="nofollow" href="javascript:void(0)"  onclick="$('#EmailAlert_box').hide();" class="bt_close_1">Đóng</a>
    </div>
    <div class="ContentDialog" id="EmailAlert_content"></div>
</div>

 <div id="boxCalculator" class="calculateDialog pDialog" style="left: 40%; top: 70%; display: none;">
        <div class="TitleDialog">
                                    <h4 id="calHeader">Tính toán tài chính</h4>
                                    <a title="Đóng" rel="nofollow" href="javascript:void(0)"  onclick="$('#boxCalculator').hide();"  class="bt_close_1">Đóng</a>
                                </div>
        <div class="ContentDialog" id="calContentBox">   </div>
</div>
    
   
<div class="Dialog_5" style="width: 300px; display: none; position: fixed; bottom: 0pt; right: 2px;" id="divDemSoBdsDaLuu">
            <div id="divOpClQuickSaveBds" style="cursor: pointer;" onclick="nvgData.OpenCloseBDSSaved('mo');" class="TitleDialog">
                <h4>Bạn đã lưu <span id="spnCountBDSDaLuu">0 BĐS</span></h4>
                <a href="javascript:;" class="bt_up_2" style="display: none;"></a>
                <a class="bt_down_2" href="javascript:;"></a>
            </div>
            <div id="divListBDSDaLuuQ" style="display:none;" class="ContentDialog">
                <div class="BoxRS_M1">
                    <ul id="ulListBDSDaLuuQ"></ul>
                   
                </div>
                <div style="display:none;" class="Groups">
                    <input type="text" class="input_text" value="Email nhận danh sách BĐS này" />
                    <div class="Button">
                        <div class="cornerL_button_2"></div>
                        <div class="bg_button_2"><a href="#">Đồng ý</a></div>
                        <div class="cornerR_button_2"></div>
                    </div>
                </div>
            </div>    
        </div>
    
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
    <a onclick="$('html, body').animate({scrollTop:0}, 400);" title="Trở về đầu trang" href="javascript:;"><img width="40" height="40" alt="" src="http://muabannhadat.com.vn/images/scrolltop-control.png" /></a>
    </div>
    <input type="hidden" value="MainContent" id="hdfCtlMst" />