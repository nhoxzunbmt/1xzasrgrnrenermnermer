<?php if (!empty($this->itemRealestateChinhChu)):?>
    <?php foreach ($this->itemRealestateChinhChu as $key => $item):


        $id = $item['id'];
        $title = $item['title'];
        $name_type = $item['name_type'];
        $cat_id = $item['cat_id'];

        if (!empty($item['images'])) {
            $images = \Zend\Json\Json::decode($item['images']);
            $image = current($images);
            $image = UPLOAD_URL . '/real-estate/' . $image;
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
    <li>
        <a data-gtm-event="mbn-event-link" data-gtm-category="mbn-listing-spright"
           data-gtm-action="listing-spright-posting-id-39392536"
           title="<?php echo $title ?>"
           href="<?php echo $linkDetail ?>">
            <img class="spright-image"
                 title="<?php echo $title ?>"
                 alt="<?php echo $title ?>"
                 data-original="<?php echo $image ?>"
                 src="https://muaban.net/Content/images/1x1.gif" width="100" height="75"/>
            <div class="spright-content">
                <h2><?php echo $title ?></h2>
                <span class="spright-price"></span>
            </div>
        </a>
    </li>
    <?php endforeach ?>
<?php endif ?>