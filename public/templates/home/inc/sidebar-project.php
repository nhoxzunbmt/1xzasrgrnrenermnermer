<?php 
$urlTraCuuFengshui  = $this->url('SearchFengshuiRoute',array('module'=>'home','controller'=>'fengshui','action'=>'fengshuiapp'));
?>
<div id="ContentPlaceHolder3_RightControl1_ViewKhuVuc1_Panel1">
	<div class="dv-box-ttbds">
		<div class="dv-tabs-ttbds">
			<div class="dv-ico-ttbds">
				<i class="ico-sty nha-dat-ban"></i>
			</div>
			<div class="dv-ct-tabs-ttbds">
				<a class="a-title" href="#">TIN PHONG THỦY</a>
			</div>
		</div>
		<div class="dv-body-frm-ttbds">
			<div style="padding: 10px;">
    			<table id="ContentPlaceHolder3_RightControl1_viewLoaiBDS1_DataList1" cellspacing="0" style="border-collapse: collapse;">
    				<?php echo $this->blkFengShui();?>
    			</table>
    		</div>
    		<div class="dv-pt-item">
        		<a class="a-linkbtl-l" title="Xem tin tức nhà đất mới nhất" rel="nofollow" href="<?php echo $urlTraCuuFengshui;?>">Tra cứu phong thủy »</a>
        	</div>
		</div>
	</div>
	
</div>