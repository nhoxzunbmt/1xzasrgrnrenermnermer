<?php
//BDS chính chủ
$xhtmlChinhChu = '';
$xhtmlChinhChuToolTip = '';
if(!empty($this->itemRealestateChinhChu)){
    foreach ($this->itemRealestateChinhChu as $key => $item) {
        $id             = $item['id'];
        $title          = $item['title'];
        $name_type      = $item['name_type'];

        $cat_id         = $item['cat_id'];


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

        $xhtmlChinhChu .= '<tr>
            					<td>
            						<table>
            							<tr>
            								<td>»</td>
            								<td>
                                                <a title="'.$title.'" class="TieudiemFull" href="'.$linkDetail.'">'.$title.'</a>
            							    </td>
            							</tr>
            						</table>
            					</td>
            				</tr>';
    }
}
?>
<div class="dv-box-ttbds">
	<div class="dv-tabs-ttbds">
		<div class="dv-ico-ttbds">
			<i class="ico-sty nha-dat-ban"></i>
		</div>
		<div class="dv-ct-tabs-ttbds">
			<a class="a-title" href="#">BẤT ĐỘNG SẢN CHÍNH CHỦ</a>
		</div>
	</div>
	<div class="dv-body-frm-ttbds">
		<div style="padding: 10px;">
			<table id="ContentPlaceHolder3_RightControl1_viewLoaiBDS1_DataList1" cellspacing="0" style="border-collapse: collapse;">
				<?php echo $xhtmlChinhChu;?>
			</table>
		</div>
	</div>
</div>