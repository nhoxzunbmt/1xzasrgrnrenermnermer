<?php 
//nhà đất theo thành phố
$xhtml = '';
if(!empty($this->arrParams['listCity'])){
    $total    = count($this->arrParams['listCity']);
    $i      = 1;
    $j      = 1;
    $num    = ceil($total/5);
    foreach($this->arrParams['listCity'] as $item){

        $urlCity   = $this->url(
                            'CityBatDongSanRoute',
                            array(
                                'controller'    => 'realestate',
                                'action'        => 'city',
                                'cityname'      => \ZendVN\Url\FriendlyLink::filter($item['name']),
                                'page'          => 1,
                                'cityid'        => $item['id']
                            ));
        if($i == 1){
            $xhtml .= '<td valign="top" width="20%" rowspan="2">
                        <table id="ContentPlaceHolder4_getLinkSearch3_DataList1" cellspacing="0" style="width: 100%; border-collapse: collapse;">
						  <tbody>';
        }
        $xhtml   .= '<tr><td><a title="BĐS '.$item['name'].'" href="'.$urlCity.'">BĐS '.$item['name'].'</a></td></tr>';
        if($i == $num || $j == $total){
            $i = 0;
            $xhtml .= '</tbody></table></td>';
        }
        $i++;
        $j++;
    }
}
?>
<div class="dv-ft-dm">
	<div class="ft-dm-in">
		<table class="table">
			<tr>
				<?php echo $xhtml;?>
			</tr>
		</table>
	</div>
</div>
<div class="clear"></div>