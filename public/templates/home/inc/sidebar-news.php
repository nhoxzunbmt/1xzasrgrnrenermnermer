<?php 
$menuNews       = $this->url('ListNewsRoute',array('controller'=>'news','action'=>'index'));
?>
<div class="dv-boxsearch-r">
	<div class="dv-pt-item-caption">
		<h3>Tin tức nhà đất</h3>
	</div>
	<table id="ContentPlaceHolder3_topTinTuc1_DataList2" cellspacing="0" style="width: 100%; border-collapse: collapse;">
		<?php echo $this->blkSlideNews();?>
	</table>
	<div class="dv-pt-item">
		<a class="a-linkbtl-l" title="Xem tin tức nhà đất mới nhất" rel="nofollow" href="<?php echo $menuNews;?>">Tin tức nhà đất »</a>
	</div>
</div>