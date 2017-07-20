<?php 
//dự án nổi bật
$listItemHighlight = '';
if(!empty($this->listItemHighlight)){
    foreach($this->listItemHighlight as $item){
        $linkIntro = $this->url('IntroProjectRoute',array(
                                                        'module'        =>  'home',
                                                        'controller'    =>  'project',
                                                        'action'        =>  'intro',
                                                        'title'         =>  \ZendVN\Url\FriendlyLink::filter($item['name']),
                                                        'id'            =>  $item['id'],
                                                        'extension'     =>  'html',
                                                    ));
        $image          =  TEMPLATE_URL .'/admin/images/NoImage.jpg';
        $i = 1;
        if(!empty($item['images'])){
            $images = \Zend\Json\Json::decode($item['images']);
            $image = current($images);
            $image = UPLOAD_URL .'/project/'.$image;
        }

        $listItemHighlight .= '<div>
                					<div class="frm-item-httt">
                						<a title="'.$item['name'].'" class="a-titleVIP" href="'.$linkIntro.'">
        							         <img style="border: 1px solid #CCC; padding: 2px; width: 200px; height: 130px;" class="imageduan" src="'.$image.'" alt="'.$item['name'].'" />
                						</a>
                						<div>
                							<strong>
                							    <a title="'.$linkIntro.'" class="a-titleVIP" href="'.$linkIntro.'">'.\ZendVN\Filter\ReadMore::create($item['name'],0,30).'</a>
                							</strong>
                						</div>
                					</div>
                    			</div>';
    }
}
?>
<div class="dv-ct-frm-l">
	<div class="dv-tabs">
		<div class="dv-ico">
			<i class="ico-sty ttbds"></i>
		</div>
		<div class="dv-ct-tabs-vip">
			<a class="a-title" title="WebOne Mới nhất" href="javascript:;">DỰ ÁN NỔI BẬT</a>
		</div>
	</div>
	<div class="dv-body-frm">
		<div class="dv-frm-httt">
			<div id="ContentPlaceHolder2_duanThanhVien1_DataList1" style="display: inline-block; width: 100%;">
    			<?php echo $listItemHighlight;?>
			</div>
		</div>
	</div>
</div>