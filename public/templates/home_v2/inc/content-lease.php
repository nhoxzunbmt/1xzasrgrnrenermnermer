
<?php if (!empty($this->itemRealestateMoiNhat)): ?>
	<?php foreach ($this->itemRealestateMoiNhat as $key => $item):
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
        ?>
        <div class="mbn-box-list-content">
            <span class="mbn-label-VIPS"></span>

            <a class="mbn-image" title="<?php echo $title?>" href="<?php echo $linkDetail?>">
                <img title="<?php echo $title?>"
                     alt="<?php echo $title?>"
                     data-original="<?php echo $image?>"
                     src="https://muaban.net/Content/images/1x1.gif" width="120" height="90"/>
            </a>
            <a title="<?php echo $title?>" href="<?php echo $linkDetail?>">
                <div class="mbn-content">
                    <h2 class="mbn-title"><?php echo $title?></h2>
                    <span class="mbn-price"><?php echo $price_m2?> Triệu</span>
                    <span class="mbn-address"><span class="icon icon-map5"></span> Quận Gò Vấp, TP.HCM</span>
                    <span class="mbn-date"><?php echo $date_modifi;?></span>
                    <span class="mbn-item-summary">
                        <?php echo $content?>
                    </span>
                </div>
            </a>
            <div class="clearfix"></div>
        </div>
	<?php endforeach ?>
<?php endif ?>
