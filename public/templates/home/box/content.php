<?php 
//BDS nổi bật
$xhtmlHighlight = '';
if(!empty($this->itemRealestateHighlight)){
    foreach ($this->itemRealestateHighlight as $key => $item) {
        
        $id             = $item['id'];
        $title          = $item['title'];
        $date_modifi    = $item['date_modifi'];
        $content        = \ZendVN\Filter\ReadMore::create($item['content'],0,250);
        $image          = TEMPLATE_URL .'/default/images/nha_mat_tien_100x75.png';
        $name_type      = $item['name_type'];
        $area           = $item['area'];
        $price_m2       = $item['price_m2'];
        $cat_id         = $item['cat_id'];
        $i              = 1;
         
        if(!empty($item['images'])){
            $images  = \Zend\Json\Json::decode($item['images']);
            foreach ($images as $key => $image) {
                if($i == 1){
                    $image = UPLOAD_URL .'/real-estate/'.$image;
                    break;
                }
            }
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

        $xhtmlHighlight .= '<div>
            					<div class="dv-item">
            						<div class="dv-img">
            							<a title="'.$title.'" href="'.$linkDetail.'">
            								<i class="i-bds-cc-1"></i>
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
<div id="ContentPlaceHolder2_TopSieuVIP1_TinCungChuyenMuc1_Panel1">
	<div class="dv-ct-frm-l">
		<div class="dv-tabs">
			<div class="dv-ico">
				<i class="ico-sty nha-dat-ban"></i>
			</div>
			<div class="dv-ct-tabs-vip">
				<a class="a-title" title="Nhà Đất Nổi Bật" href="#">Tất cả <span>(<?php echo $this->totalItem;?>)</a>
			</div>
		</div>
		<div class="dv-body-frm">
			<div id="ContentPlaceHolder2_TopSieuVIP1_TinCungChuyenMuc1_DataList1" style="display: inline-block; width: 100%;">
		     <?php echo $xhtmlHighlight;?>
			</div>
		</div>
	</div>
</div>