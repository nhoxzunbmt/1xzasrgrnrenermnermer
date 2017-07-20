<?php 
$menuSupport       = $this->url('MVC_HomeRouter/action',array('module'=>'home','controller'=>'index','action'=>'support'));
?>
<div class="header-t">
	<div class="hd-in-t">
		<div class="hd-t-r">
			<p>
				<i class="ico-sty i-reg"></i>
				<a title="Quảng cáo & Trợ giúp" rel="nofollow" href="<?php echo $menuSupport;?>">Quảng cáo & Trợ giúp</a>
			</p>
			<?php echo $this->blkAccountGroup($this->identity());?>
		</div>
	</div>
</div>