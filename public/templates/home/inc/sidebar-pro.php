<?php 
$menuAgency             = $this->url('AgencyBusinessRoute',array('controller'=>'agency','action'=>'category'));
?>
<div id="ContentPlaceHolder3_showThanhVienNoiBat1_pn1">
	<div class="dv-box-mgnb">
		<div class="dv-tabs-mgnb">
			<div class="dv-ico-mgnb">
				<i class="ico-sty moi-gioi-noi-bat"></i>
			</div>
			<div class="dv-ct-tabs-mgnb">
				<a rel="nofollow" title="Môi giới nổi bật" href="#" class="a-title">Môi giới nổi bật</a>
				<a href="<?php echo $menuAgency?>" title="Xem thêm" rel="nofollow" class="a-link-xtc">Xem thêm</a>
			</div>
		</div>
		<div class="dv-body-frm-mgnb">
			<div id="ContentPlaceHolder3_showThanhVienNoiBat1_Panel1" style="height: 450px; overflow-y: scroll;">
				<?php echo $this->blkAgency();?>
			</div>
		</div>
	</div>
</div>