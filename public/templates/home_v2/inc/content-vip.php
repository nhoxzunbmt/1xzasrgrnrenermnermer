
<?php if (!empty($this->itemRealestateHighlight)): ?>
    <?php foreach ($this->itemRealestateHighlight as $key => $item):
        $id = $item['id'];
        $title = $item['title'];
        $date_modifi = $item['date_modifi'];
        $content = \ZendVN\Filter\ReadMore::create($item['content'], 0, 250);
        $image = TEMPLATE_URL . '/default/images/nha_mat_tien_100x75.png';
        $name_type = $item['name_type'];
        $area = $item['area'];
        $price_m2 = $item['price_m2'];
        $cat_id = $item['cat_id'];
        $i = 1;

        if (!empty($item['images'])) {
            $images = \Zend\Json\Json::decode($item['images']);
            foreach ($images as $key => $image) {
                if ($i == 1) {
                    $image = UPLOAD_URL . '/real-estate/' . $image;
                    break;
                }
            }
        }


        $linkDetail = $this->url('DetailBatDongSanRoute', array(
            'module' => 'home',
            'controller' => 'realestate',
            'action' => 'detail',
            'namecategory' => \ZendVN\Url\FriendlyLink::filter($name_type),
            'title' => \ZendVN\Url\FriendlyLink::filter($title),
            'cid' => $cat_id,
            'id' => $id,
            'extension' => 'html',
        ));
        ?>

        <div class="item">
            <a data-gtm-event="mbn-event-link" data-gtm-category="mbn-listing-sptop"
               data-gtm-action="listing-sptop-posting-id-39498618"
               href="<?php echo $linkDetail?>"
               title="<?php echo $title?>">
                <div class="owl-item-image">
                    <img class="lazyOwl" width="136" height="102"
                         data-src="<?php echo $image?>">
                </div>
                <span class="owl-item-title"><?php echo $title?></span>
                <span class="owl-item-price"><?php echo $price_m2;?> Triệu</span>
            </a>
        </div>

    <?php endforeach ?>
<?php endif ?>