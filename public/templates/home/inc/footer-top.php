<?php 
$xhtmlNavFooter = '';
if(!empty($this->arrParams['itemNavFooter'])){
     
    foreach($this->arrParams['itemNavFooter'] as $item){
        $xhtmlNavFooter       .= '<li><a title="'.$item['name'].'" href="'.$item['url'].'">'.$item['name'].'</a>|</li>';
    }
}

?>
<div class="ft-top">
	<div class="ft-in-top">
		<ul>
			<?php echo $xhtmlNavFooter;?>
		</ul>
	</div>
</div>