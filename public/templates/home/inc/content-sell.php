<?php 
//Doanh nghiệp nổi bật
$itemBusinessHighlight = '';
if(!empty($this->itemBusinessHighlight)){
    foreach($this->itemBusinessHighlight as $item){
        
        $linkDetail     = $this->url('IntroBusinessRoute',array('action'=>'detail','alias'=>$item['alias']));
        $title          = $item['name'];
        $logo           = (!empty($item['logo']))  ? UPLOAD_URL .'/logo-business/'.$item['logo'] :  TEMPLATE_URL .'/admin/images/NoImage.jpg';
        $date_time      = $item['date_time'];
        $intro          = \ZendVN\Filter\ReadMore::create($item['intro'],0,250);
        $phone          = $item['phone'];
        $fax            = $item['fax'];
        //$itemBusinessHighlight      .= '<li><a href="'.$linkIntro.'" title="'.$item['name'].'"><img src="'.$logo.'" width="113" alt="'.$item['name'].'" title="'.$item['name'].'"></a><h3><a href="'.$linkIntro.'" title="'.$item['name'].'">'.\ZendVN\Filter\ReadMore::create($item['name'],0,30).'</a></h3></li>';
        $itemBusinessHighlight .= '<div>
                    					<div class="dv-item">
                    						<div class="dv-img">
                    							<a title="'.$title.'" href="'.$linkDetail.'">
                    								<img alt="'.$title.'" src="'.$logo.'" />
                    							</a>
                    						</div>
                    						<div class="dv-txt">
                    							<a class="a-titleVIP" title="'.$title.'" href="'.$linkDetail.'">'.$title.'</a>
                    							<p><i class="ico-sty i-time-bla"></i>' . $date_time .'</p>
                    							<label class="lb-des">'. $intro . '</label>
                    							<p>
                    								<span>
                        								<label class="lb-title">Phone:</label>
                        								<a href="javascript:;" title="'.$phone.'" rel="nofollow" class="a-txt-cl1"> <strong>'.$phone.'</strong></a>
                    								</span>
                    								<span>
                    								    <label class="lb-title">-</label>
                    								    <a href="javascript:;" title="'.$fax.'" rel="nofollow" class="a-txt-cl2"> <strong>'.$fax.'</strong></a>
                    								</span>
                    							</p>
                    						</div>
                    					</div>
                    			     </div><br />';
    }
}
$menuBusiness       = $this->url('ListBusinessRoute',array('controller'=>'business','action'=>'business'));
?>
<div class="dv-ct-frm-l">
	<div class="dv-tabs">
		<div class="dv-ico">
			<i class="ico-sty nha-dat-ban"></i>
		</div>
		<div class="dv-ct-tabs">
			<a class="a-title" title="Nhà đất bán" href="<?php echo $menuBusiness;?>">DOANH NGHIỆP NỔI BẬT</a>
		</div>
	</div>
	<div class="dv-body-frm">
		<div id="ContentPlaceHolder2_TopTinDang1_DataList1" style="display: inline-block; color: #333333; width: 100%;">
		      <?php echo $itemBusinessHighlight;?>
		</div>
		<div class="dv-pt-item"></div>
		<div class="dv-pt-item">
			<div class="dv-pt-ttcm">
				<div id="ctl00_ContentPlaceHolder2_KetQuaTimKiem1_divButtonPaging"
					class="NaviPage">
					<ul>
						<li><a href="<?php echo $menuBusiness;?>" class="active" title="Xem Tất Cả">Xem Tất Cả »</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>