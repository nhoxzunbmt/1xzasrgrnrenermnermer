<?php 
//Bds mới nhất
$xhtmlMoiNhat = '';
if(!empty($this->itemRealestateMoiNhat)){
    foreach ($this->itemRealestateMoiNhat as $key => $item) {
        
        $id             = $item['id'];
        $title          = $item['title'];
        $image          = TEMPLATE_URL .'/default/images/nha_mat_tien_100x75.png';
        $name_type      = $item['name_type'];
        $area           = $item['area'];
        $price_m2       = $item['price_m2'];
        $cat_id         = $item['cat_id'];
        $price          = $item['price'];
        
        $date_modifi    = $item['date_modifi'];
        $content        = \ZendVN\Filter\ReadMore::create($item['content'],0,250);         
        
        if(!empty($item['images'])){
            $images     = \Zend\Json\Json::decode($item['images']);
            $image      = current($images);
            $image      = UPLOAD_URL .'/real-estate/'.$image;
        }


        $linkDetail = $this->url('DetailBatDongSanRoute',array(
            'module'        =>  'home',
            'controller'    =>  'realestate',
            'action'        =>  'detail',
            'namecategory'  =>  \ZendVN\Url\FriendlyLink::filter($name_type),
            'title'         =>  \ZendVN\Url\FriendlyLink::filter($title),
            'cid'           =>  $cat_id,
            'id'            =>  $id,
            'extension'     =>  'html',
        ));

        $xhtmlMoiNhat .= '<div>
            					<div class="dv-item">
            						<div class="dv-img">
            							<a title="'.$title.'" href="'.$linkDetail.'">
            								<img alt="'.$title.'" src="'.$image.'" />
            							</a>
            						</div>
            						<div class="dv-txt">
            							<a class="a-titleVIP" title="'.$title.'" href="'.$linkDetail.'">'.$title.'</a>
            							<p><i class="ico-sty i-time-bla"></i>' . $date_modifi .'</p>
            							<label class="lb-des">'. $content . '</label>
            							<p>
            								<span>
                								<label class="lb-title">Giá:</label>
                								<a href="javascript:;" title="'.$price_m2.'" rel="nofollow" class="a-txt-cl1"> <strong>'.$price_m2.'</strong> tr/m2</a>
            								</span>
            								<span>
            								    <label class="lb-title">-</label>
            								    <a href="javascript:;" title="'.$area.' m²" rel="nofollow" class="a-txt-cl2"> <strong>'.$area.'</strong> m²</a>
            								</span>
            							</p>
            						</div>
            					</div>
            			     </div><br />';

    }
}
?>
<div class="dv-ct-frm-l">
	<div class="dv-tabs">
		<div class="dv-ico">
			<i class="ico-sty nha-dat-ban"></i>
		</div>
		<div class="dv-ct-tabs">
			<a class="a-title" title="Nhà đất mới nhất" href="#">
				NHÀ ĐẤT MỚI NHẤT
			</a>
		</div>
	</div>
	<div class="dv-body-frm">
		<div id="ContentPlaceHolder2_TopTinDang2_DataList1" style="display: inline-block; color: #333333; width: 100%;">
		      <?php echo $xhtmlMoiNhat;?>
		</div>
		<div class="dv-pt-item"></div>
		<div class="dv-pt-item">
			<div class="dv-pt-ttcm">
				<div id="ctl00_ContentPlaceHolder2_KetQuaTimKiem1_divButtonPaging" class="NaviPage">
					<ul>
						<li><a href="#" class="active" title="Xem Tất Cả">Xem Tất Cả »</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>