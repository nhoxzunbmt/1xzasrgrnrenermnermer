<?php 
//===Menu hom===================
$menuHome       = $this->url('home',array('module'=>'home','controller'=>'index','action'=>'index'));
//===Menu rao vặt bất động sản===
$menuBds        = $this->url('ListBatDongSanRoute',array('controller'=>'realestate','action'=>'index'));

$xhtmlMenuNhadatBan     = '';
$xhtmlMenuItemNhadatBan     = '';
if(!empty($this->arrParams['itemTypeRealEstate'])){

    $i = 1;
    foreach($this->arrParams['itemTypeRealEstate'] as $item){
        $item['transaction'] = 2;
        $urlCategory  = $this->url(
            'CategoryBatDongSanRoute',
            array(
                'controller'        => 'Realestate',
                'action'            => 'category',
                'namecity'          => 'toan-quoc',
                'namedistrict'      => 'all-district',
                'type'              => 'tat-ca',
                'name'              => \ZendVN\Url\FriendlyLink::filter($item['name'].' bán'),
                'idcity'            => '0',
                'iddistrict'        => '0',
                'page'              => '1',
                'transaction'       =>  $item['transaction'],
                'id'                =>  $item['id'],
            )
        );
        if($i <= 7){
            $xhtmlMenuNhadatBan .= '<li class="nav-submenu-item><a title="'.$item['name'].' bán" href="'.$urlCategory.'">'.$item['name'].' bán</a></li>';
            $xhtmlMenuItemNhadatBan .= '<li><a title="'.$item['name'].' bán" href="'.$urlCategory.'">'.$item['name'].' bán</a></li>';
        }else{
            break;
        }
        $i++;
    }
}
$xhtmlMenuNhadatChoThue = '';
$xhtmlMenuItemNhadatChoThue = '';
if(!empty($this->arrParams['itemTypeRealEstate'])){

    $i = 1;
    foreach($this->arrParams['itemTypeRealEstate'] as $item){
        $item['transaction'] = 1;
        $urlCategory  = $this->url(
            'CategoryBatDongSanRoute',
            array(
                'controller'        => 'Realestate',
                'action'            => 'category',
                'namecity'          => 'toan-quoc',
                'namedistrict'      => 'all-district',
                'type'              => 'tat-ca',
                'name'              => \ZendVN\Url\FriendlyLink::filter($item['name'] .' cho thuê'),
                'idcity'            => '0',
                'iddistrict'        => '0',
                'page'              => '1',
                'transaction'       =>  $item['transaction'],
                'id'                =>  $item['id'],
            )
        );
        if($i <= 7){
            $xhtmlMenuNhadatChoThue .= '<li class="nav-submenu-item"><a title="'.$item['name'].' cho thuê" href="'.$urlCategory.'">'.$item['name'].' cho thuê</a></li>';
            $xhtmlMenuItemNhadatChoThue .= '<li><a title="'.$item['name'].' cho thuê" href="'.$urlCategory.'">'.$item['name'].' cho thuê</a></li>';

        }else{

            break;
        }
        $i++;
    }
}
//=============Menu dự án=====================
$menuProject           = $this->url('ListProjectRoute',array('module'=>'home','controller'=>'project','action'=>'index'));
$xhtmlProjectCategory = '';
$xhtmlItemProjectCategory = '';
if(!empty($this->arrParams['listItemCategoryProject'])){
    $i = 1;
    foreach($this->arrParams['listItemCategoryProject'] as $item){

        $urlCategory = $this->url('CategoryProjectRoute',array(
                                                            'module'=>'home',
                                                            'controller'  =>'project',
                                                            'action'      =>'category',
                                                            'name'        => \ZendVN\Url\FriendlyLink::filter($item['name']),
                                                            'page'        => '1',
                                                            'id'          => $item['id'],
                                                            'extension'  => 'html',
                                                        ));
        if($i <= 8){
            $xhtmlProjectCategory .= '<li class="nav-submenu-item"><a title="'.$item['name'].' cho thuê" href="'.$urlCategory.'">'.$item['name'].' cho thuê</a></li>';
            $xhtmlItemProjectCategory .= '<li><a title="'.$item['name'].' cho thuê" href="'.$urlCategory.'">'.$item['name'].' cho thuê</a></li>';
        }else{
            break;
        }
        $i++;
    }

}

//=============Menu thị trường=====================
$menuMarket           = $this->url('ListMarketRoute',array('module'=>'home','controller'=>'market','action'=>'index'));
$xhtmlMarketCategory = '';
$xhtmlItemMarketCategory = '';
if(!empty($this->arrParams['listItemCategoryProject'])){
    $i = 1;
    foreach($this->arrParams['listItemCategoryProject'] as $item){

        $urlCategory = $this->url('CategoryMarketRoute',array(
            'module'=>'home',
            'controller'  =>'market',
            'action'      =>'category',
            'name'        => \ZendVN\Url\FriendlyLink::filter($item['name']),
            'page'        => '1',
            'id'          => $item['id'],
            'extension'  => 'html',
        ));
        if($i <= 8){
            $xhtmlMarketCategory .= '<li class="nav-submenu-item"><a title="'.$item['name'].' cho thuê" href="'.$urlCategory.'">'.$item['name'].' cho thuê</a></li>';
            $xhtmlItemMarketCategory .= '<li><a title="'.$item['name'].' cho thuê" href="'.$urlCategory.'">'.$item['name'].' cho thuê</a></li>';
        }else{
            break;
        }
        $i++;
    }

}
//===========Menu Tin tức============
$menuNews       = $this->url('ListNewsRoute',array('controller'=>'news','action'=>'index'));
$xhtmlNewsCategory = '';
$xhtmlItemNewsCategory = '';
if(!empty($this->arrParams['itemsNewsCategory'])){
    foreach($this->arrParams['itemsNewsCategory'] as $item){

        $urlCategory = $this->url('CategoryNewsRoute',array(
            'module'=>'home',
            'controller'  =>'news',
            'action'      =>'category',
            'name'        => \ZendVN\Url\FriendlyLink::filter($item['name']),
            'page'        => '1',
            'id'          => $item['id'],
            'extension'  => 'html',
        ));
        $xhtmlNewsCategory .= '<li class="nav-submenu-item"><a title="'.$item['name'].' cho thuê" href="'.$urlCategory.'">'.$item['name'].' cho thuê</a></li>';
        $xhtmlItemNewsCategory .= '<li><a title="'.$item['name'].' cho thuê" href="'.$urlCategory.'">'.$item['name'].' cho thuê</a></li>';
    }
}
//===========Menu Phong thủy============
$menuFengshui       = $this->url('ListFengshuiRoute',array('controller'=>'fengshui','action'=>'index'));
//Tra cứu phong thủy
$urlTraCuuFengshui  = $this->url('SearchFengshuiRoute',array('module'=>'home','controller'=>'fengshui','action'=>'fengshuiapp'));
$xhtmlFengshuiCategory = '';
$xhtmlItemFengshuiCategory = '';
$i = 1;
if(!empty($this->arrParams['itemsFengshuiCategory'])){
    foreach($this->arrParams['itemsFengshuiCategory'] as $item){

        $urlCategory = $this->url('CategoryFengshuiRoute',array(
            'module'=>'home',
            'controller'  =>'news',
            'action'      =>'category',
            'name'        => \ZendVN\Url\FriendlyLink::filter($item['name']),
            'page'        => '1',
            'id'          => $item['id'],
            'extension'  => 'html',
        ));
        if($i <= 8){
            $xhtmlFengshuiCategory .= '<li class="nav-submenu-item"><a title="'.$item['name'].'" href="'.$urlCategory.'">'.$item['name'].' cho thuê</a></li>';
            $xhtmlItemFengshuiCategory .= '<li><a title="'.$item['name'].'" href="'.$urlCategory.'">'.$item['name'].'</a></li>';
        }else{
            break;
        }
        $i++;

    }
}
//===menu doanh nghiệp====
//loại hình doanh nghiệp
$menuBusiness       = $this->url('ListBusinessRoute',array('controller'=>'business','action'=>'business'));
$xhtmlMenuBusiness  = '';
$xhtmlItemMenuBusiness = '';
if(!empty($this->arrParams['itemsCategory'])){
    $i = 1;
    foreach ($this->arrParams['itemsCategory'] as $key => $item) {
        $urlCategory  = $this->url(
            'CategoryBusinessRoute',
            array(
                'action'    =>'category',
                'name'      =>\ZendVN\Url\FriendlyLink::filter($item['name']),
                'page'      =>1,
                'id'        =>$item['id']
            )
        );
        if($i <= 7){
            $xhtmlMenuBusiness .= '<li class="nav-submenu-item"><a title="'.$item['name'].'" href="'.$urlCategory.'">'.$item['name'].' cho thuê</a></li>';
            $xhtmlItemMenuBusiness .= '<li><a title="'.$item['name'].'" href="'.$urlCategory.'">'.$item['name'].'</a></li>';
        }else{
            $xhtmlMenuBusiness .= '<li class="nav-submenu-item"><a title="Các loại hình khác" href="'.$menuBusiness.'">Các loại hình khác</a></li>';
            $xhtmlItemMenuBusiness .= '<li><a title="Các loại hình khác" href="'.$menuBusiness.'">Các loại hình khác</a></li>';
            break;
        }
        $i++;
    }
}
//===========MEnu pháp lý nhà đất==============
$menuLegalHousing       = $this->url('ListLegalHousingRoute',array('controller'=>'legalhousing','action'=>'index'));

$xhtmlLegalHousingCategory = '';
$xhtmlItemLegalHousingCategory = '';
$i = 1;
if(!empty($this->arrParams['itemsLegalHousingCategory'])){
    foreach($this->arrParams['itemsLegalHousingCategory'] as $item){

        $urlCategory = $this->url('CategoryLegalHousingRoute',array(
            'module'=>'home',
            'controller'  =>'legalhousing',
            'action'      =>'category',
            'name'        => \ZendVN\Url\FriendlyLink::filter($item['name']),
            'page'        => '1',
            'id'          => $item['id'],
            'extension'  => 'html',
        ));
        if($i <= 4){
            $xhtmlLegalHousingCategory .= '<li class="nav-submenu-item"><a title="'.$item['name'].'" href="'.$urlCategory.'">'.$item['name'].' cho thuê</a></li>';
            $xhtmlItemLegalHousingCategory .= '<li><a title="'.$item['name'].'" href="'.$urlCategory.'">'.$item['name'].'</a></li>';
        }else{
            break;
        }
        $i++;
    }
}
//============Menu nhà đẹp=================
$menuNiceHouse           = $this->url('ListNiceHouseRoute',array('module'=>'home','controller'=>'nicehouse','action'=>'index'));

$xhtmlNiceHouseCategory = '';
$xhtmlItemNiceHouseCategory = '';
if(!empty($this->arrParams['listCategoryNiceHouse'])){
    $i = 1;
    foreach($this->arrParams['listCategoryNiceHouse'] as $item){

        $urlCategory = $this->url('CategoryNiceHouseRoute',array(
            'module'=>'home',
            'controller'  =>'nicehouse',
            'action'      =>'category',
            'name'        => \ZendVN\Url\FriendlyLink::filter($item['name']),
            'page'        => '1',
            'id'          => $item['id'],
            'extension'  => 'html',
        ));
        if($i <= 16){
            $xhtmlNiceHouseCategory .= '<li class="nav-submenu-item"><a title="'.$item['name'].'" href="'.$urlCategory.'">'.$item['name'].' cho thuê</a></li>';
            $xhtmlItemNiceHouseCategory .= '<li><a title="'.$item['name'].'" href="'.$urlCategory.'">'.$item['name'].'</a></li>';
        }else{
            break;
        }
        $i++;
    }
}
$menuDangBds           = $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'real-estate','action'=>'add'));
?>
<div class="header-f">
	<div class="header-in-f">
		<div class="hd-mnu-top">
			<nav class="nav">
				<ul class="nav-list">
					<li class="nav-item"><a title="Trang chủ nhà đất" href="<?php echo $menuHome;?>">Trang chủ</a></li>
					<li class="nav-item"><a title="Nhà đất bán" href="<?php echo $menuBds ;?>">Nhà đất bán</a>
						<ul class="nav-submenu">
							<?php echo $xhtmlMenuNhadatBan?>
						</ul>
					</li>
					<li class="nav-item"><a title="Nhà đất cho thuê" href="#">Nhà đất cho thuê</a>
						<ul class="nav-submenu">
							<?php echo $xhtmlMenuNhadatChoThue;?>
						</ul>
				    </li>
				    <li class="nav-item"><a title="Nhà đất cho thuê" href="<?php echo $menuProject;?>">Dự án</a>
						<ul class="nav-submenu">
							<?php echo $xhtmlProjectCategory;?>
						</ul>
				    </li>
				    <li class="nav-item"><a title="Thị trường" href="<?php echo $menuMarket;?>">Thị trường</a>
						<ul class="nav-submenu">
							<?php echo $xhtmlMarketCategory;?>
						</ul>
				    </li>
					<li class="nav-item"><a title="Tin tức nhà đất - Bất động sản" href="<?php echo $menuNews;?>">Tin tức</a>
						<ul class="nav-submenu">
							<?php echo $xhtmlNewsCategory;?>
						</ul>
					</li>
					<li class="nav-item"><a title="Phong thủy" href="<?php echo $menuFengshui;?>">Phong thủy</a>
						<ul class="nav-submenu">
							<?php echo $xhtmlFengshuiCategory;?>
						</ul>
					</li>
					<li class="nav-item"><a title="Doanh nghiệp" href="<?php echo $menuBusiness;?>">Doanh nghiệp</a>
						<ul class="nav-submenu">
							<?php echo $xhtmlMenuBusiness;?>
						</ul>
					</li>
					<li class="nav-item"><a title="Cafe luật" href="<?php echo $menuLegalHousing ;?>">Cafe luật</a>
						<ul class="nav-submenu">
							<?php echo $xhtmlLegalHousingCategory;?>
						</ul>
					</li>
					<li class="nav-item"><a title="Nhà đẹp" href="<?php echo $menuNiceHouse;?>">Nhà đẹp</a>
						<ul class="nav-submenu">
							<?php echo $xhtmlNiceHouseCategory;?>
						</ul>
					</li>
				</ul>
			</nav>
			<ul id="menu">
				<li id="litab0"><a title="Trang chủ Nhà đất" href="<?php echo $menuHome;?>"><i class="ico-sty i-home"></i>Trang Chủ</a></li>
				<li id="litab1"><a title="Nhà đất bán" class="drop" href="<?php echo $menuBds ;?>">Nhà Đất Bán</a>
					<div class="dropdown_3columns">
						<div class="col_1">
							<ul class="greybox">
								<?php echo $xhtmlMenuItemNhadatBan;?>
							</ul>
						</div>
					</div>
				</li>
				<li id="litab2"><a title="Nhà đất cho thuê" href="#">Nhà Đất Cho Thuê</a>
					<div class="dropdown_3columns">
						<div class="col_1">
							<ul class="greybox">
								<?php echo $xhtmlMenuItemNhadatChoThue;?>
							</ul>
						</div>
					</div>
				</li>
				<li id="litab3"><a title="Dự án" href="<?php echo $menuProject;?>">Dự án</a>
					<div class="dropdown_3columns">
						<div class="col_1">
							<ul class="greybox">
								<?php echo $xhtmlItemProjectCategory;?>
							</ul>
						</div>
					</div>
				</li>
				<li id="litab4"><a title="Thị trường" href="<?php echo $menuMarket;?>">Thị trường</a>
					<div class="dropdown_3columns">
						<div class="col_1">
							<ul class="greybox">
								<?php echo $xhtmlItemMarketCategory;?>
							</ul>
						</div>
					</div>
				</li>
				<li class="litab5"><a title="Tin tức nhà đất - Bất động sản" href="<?php echo $menuNews;?>">Tin Tức</a>
					<div class="dropdown_3columns">
						<div class="col_1">
							<ul class="greybox">
								<?php echo $xhtmlItemNewsCategory;?>
							</ul>
						</div>
					</div>
				</li>
				<li class="litab5"><a title="Phong thủy" href="<?php echo $menuFengshui;?>">Phong thủy</a>
					<div class="dropdown_3columns">
						<div class="col_1">
							<ul class="greybox">
								<?php echo $xhtmlItemFengshuiCategory;?>
							</ul>
						</div>
					</div>
				</li>
				<li class="litab5"><a title="Doanh nghiệp" href="<?php echo $menuBusiness;?>">Doanh nghiệp</a>
					<div class="dropdown_3columns">
						<div class="col_1">
							<ul class="greybox">
								<?php echo $xhtmlItemMenuBusiness;?>
							</ul>
						</div>
					</div>
				</li>
				<li class="litab5"><a title="Cafe luật" href="<?php echo $menuLegalHousing ;?>">Cafe luật</a>
					<div class="dropdown_3columns">
						<div class="col_1">
							<ul class="greybox">
								<?php echo $xhtmlItemLegalHousingCategory;?>
							</ul>
						</div>
					</div>
				</li>
				<li class="litab5"><a title="Nhà đẹp" href="<?php echo $menuNiceHouse;?>">Nhà đẹp</a>
					<div class="dropdown_3columns">
						<div class="col_1">
							<ul class="greybox">
								<?php echo $xhtmlItemNiceHouseCategory;?>
							</ul>
						</div>
					</div>
				</li>
				<li class="li-border-m">&nbsp;</li>
			</ul>
		</div>
		<a href="<?php echo $menuDangBds;?>" title="Đăng tin" rel="nofollow" class="a-btl-uload">Đăng Tin</a>
	</div>
	<div style="display: none;">
		<div id="logincontent" style="width: 250px; height: 180px;"></div>
	</div>
</div>