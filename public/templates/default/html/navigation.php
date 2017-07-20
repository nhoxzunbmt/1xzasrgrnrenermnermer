<?php
//===Menu hom===================
$menuHome       = $this->url('home',array('module'=>'home','controller'=>'index','action'=>'index'));
//===Menu rao vặt bất động sản===
$menuBds        = $this->url('ListBatDongSanRoute',array('controller'=>'realestate','action'=>'index'));

$xhtmlMenuNhadatBan     = '';
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
          $xhtmlMenuNhadatBan .= '<li><a title="'.$item['name'].' bán" href="'.$urlCategory.'">'.$item['name'].' bán</a></li>'; 
          
        }else{

            break;
        }
        $i++;
    }  
}    

$xhtmlMenuNhadatChoThue = '';
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
          $xhtmlMenuNhadatChoThue .= '<li><a title="'.$item['name'].' cho thuê" href="'.$urlCategory.'">'.$item['name'].' cho thuê</a></li>'; 
          
        }else{

            break;
        }
        $i++;
    }  
} 



//nhà đất theo thành phố
$xhtmlCityRealestate = '';
if(!empty($this->arrParams['listCity'])){
    $i = 1;
    foreach($this->arrParams['listCity'] as $item){
        $urlCity   = $this->url('CityBatDongSanRoute',array(
            'controller'=>'realestate',
            'action'=>'category',
            'type'  => 'tat-ca',
            'cityname'=>\ZendVN\Url\FriendlyLink::filter($item['name']),
            'page'=>1,
            'id'=>$item['id']
        ));
        if($i <= 8){
            $xhtmlCityRealestate      .= '<li><a title="'.$item['name'].'" href="'.$urlCity.'">'.$item['name'].'</a></li>';
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
           $xhtmlMenuBusiness .= '<li><a title="'.$item['name'].'" href="'.$urlCategory.'">'.$item['name'].'</a></li>'; 
        }else{
            $xhtmlMenuBusiness .= '<li><a class="otherLink" title="Các loại hình khác" href="'.$menuBusiness.'">Các loại hình khác</a></li>';
            break;
        }
       $i++;
        
    }
}
//theo thành phố
$xhtmlCity = '';
if(!empty($this->arrParams['listCity'])){
    $i = 1;
    foreach($this->arrParams['listCity'] as $item){
        $urlCity   = $this->url(
            'CityBusinessRoute',
            array('action'=>'category','cityname'=>\ZendVN\Url\FriendlyLink::filter($item['name']),'page'=>1,'id'=>$item['id']
        ));
        if($i <= 12){
            $xhtmlCity      .= '<li><a title="'.$item['name'].'" href="'.$urlCity.'">'.$item['name'].'</a></li>';
        }else{

            break;
        }
        $i++;
    }  
}

//=======Menu môi giới============
$menuAgency       = $this->url('AgencyBusinessRoute',array('controller'=>'agency','action'=>'category'));

//theo thành phố
$xhtmlAgencyCity = '';
if(!empty($this->arrParams['listCity'])){
    $i = 1;
    foreach($this->arrParams['listCity'] as $item){
        $urlAgencyCity   = $this->url(
            'AgencyBusinessRoute',
            array('module'=>'agency','action'=>'category','cityname'=>\ZendVN\Url\FriendlyLink::filter($item['name']),'cityid'=>$item['id'],'page'=>1,
        ));
        if($i <= 12){
            $xhtmlAgencyCity      .= '<li><a title="'.$item['name'].'" href="'.$urlAgencyCity.'">'.$item['name'].'</a></li>';
        }else{

            break;
        }
        $i++;
    }  
}


//===========Menu Tin tức============
$menuNews       = $this->url('ListNewsRoute',array('controller'=>'news','action'=>'index'));
$xhtmlNewsCategory = '';
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
        $xhtmlNewsCategory .='<li><a href="'.$urlCategory.'" title="'.$item['name'].'">'.$item['name'].'</a></li>
                            ';
    }

}

//tin tức theo thành phố
$xhtmlNewsCity = '';
if(!empty($this->arrParams['listCity'])){
    $i = 1;
    foreach($this->arrParams['listCity'] as $item){
         $urlCity   = $this->url('CityNewsRoute',array(
              'controller'=>'news',
              'action'=>'city',
              'cityname'=>\ZendVN\Url\FriendlyLink::filter($item['name']),
              'page'=>1,
              'cityid'=>$item['id']
        ));
        if($i <= 12){
            $xhtmlNewsCity      .= '<li><a title="'.$item['name'].'" href="'.$urlCity.'">'.$item['name'].'</a></li>';
        }else{

            break;
        }
        $i++;
    }  
}

//===========Menu Phong thủy============
$menuFengshui       = $this->url('ListFengshuiRoute',array('controller'=>'fengshui','action'=>'index'));
//Tra cứu phong thủy
$urlTraCuuFengshui  = $this->url('SearchFengshuiRoute',array('module'=>'home','controller'=>'fengshui','action'=>'fengshuiapp'));
$xhtmlFengshuiCategory = '';
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
            $xhtmlFengshuiCategory .='<li><a href="'.$urlCategory.'" title="'.$item['name'].'">'.$item['name'].'</a></li>
                            ';
        }else{
             break;
        } 
        $i++;                   

    }

}

//===========MEnu pháp lý nhà đất==============
$menuLegalHousing       = $this->url('ListLegalHousingRoute',array('controller'=>'legalhousing','action'=>'index'));

$xhtmlLegalHousingCategory = '';
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
            $xhtmlLegalHousingCategory .='<li><a href="'.$urlCategory.'" title="'.$item['name'].'">'.$item['name'].'</a></li>
                            ';
        }else{
             break;
        } 
        $i++;                   

    }

}

//=============Menu văn bản luật nhà đất=========
$menuLegislationHousing       = $this->url('ListLegislationHousingRoute',array('controller'=>'legislationhousing','action'=>'index'));

$i = 1;
$xhtmlLegislationHousingCategory = '';
if(!empty($this->arrParams['itemsLegislationHousingCategory'])){
    foreach($this->arrParams['itemsLegislationHousingCategory'] as $item){

        $urlCategory = $this->url('CategoryLegislationHousingRoute',array(
              'module'=>'home',
              'controller'  =>'legislationhousing',
              'action'      =>'category',
              'name'        => \ZendVN\Url\FriendlyLink::filter($item['name']),
              'page'        => '1',
              'id'          => $item['id'],
               'extension'  => 'html',
        ));
        if($i <= 4){
            $xhtmlLegislationHousingCategory .='<li><a href="'.$urlCategory.'" title="'.$item['name'].'">'.$item['name'].'</a></li>
                            ';
        }else{
             break;
        } 
        $i++;                   

    }

}

//============Menu biểu mẫu hợp đồng=========
$menuContractForm       = $this->url('ListContractFormRoute',array('controller'=>'contractform','action'=>'index'));
$i = 1;
$xhtmlContractFormCategory = '';
if(!empty($this->arrParams['itemsContractFormCategory'])){
    foreach($this->arrParams['itemsContractFormCategory'] as $item){

        $urlCategory = $this->url('CategoryContractFormRoute',array(
              'module'=>'home',
              'controller'  =>'contractform',
              'action'      =>'category',
              'name'        => \ZendVN\Url\FriendlyLink::filter($item['name']),
              'page'        => '1',
              'id'          => $item['id'],
               'extension'  => 'html',
        ));
        if($i <= 4){
            $xhtmlContractFormCategory .='<li><a href="'.$urlCategory.'" title="'.$item['name'].'">'.$item['name'].'</a></li>
                            ';
        }else{
             break;
        } 
        $i++;                   

    }

}

//============Menu nhà đẹp=================
$menuNiceHouse           = $this->url('ListNiceHouseRoute',array('module'=>'home','controller'=>'nicehouse','action'=>'index'));

$xhtmlNiceHouseCategory = '';
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
          $xhtmlNiceHouseCategory .="
                            <li><a title='".$item['name']."' href='".$urlCategory."'>".$item['name']."</a></li>
                           
                            ";
        }else{

            break;
        }
        $i++;                    
    }

}

//=============Menu dự án=====================
$menuProject           = $this->url('ListProjectRoute',array('module'=>'home','controller'=>'project','action'=>'index'));

//theo thành phố
$xhtmlProjectCity = '';
if(!empty($this->arrParams['listCity'])){
    $i = 1;
    foreach($this->arrParams['listCity'] as $item){
        $urlCity   = $this->url(
            'CityProjectRoute',
            array('action'=>'category','cityname'=>\ZendVN\Url\FriendlyLink::filter($item['name']),'page'=>1,'cityid'=>$item['id']
        ));
        if($i <= 12){
            $xhtmlProjectCity      .= '<li><a title="'.$item['name'].'" href="'.$urlCity.'">'.$item['name'].'</a></li>';
        }else{

            break;
        }
        $i++;
    }  
}

$xhtmlProjectCategory = '';

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
          $xhtmlProjectCategory .="
                            <li><a title='".$item['name']."' href='".$urlCategory."'>".$item['name']."</a></li>
                           
                            ";
        }else{
          break;
        }
        $i++;                    
    }

}

//=============Menu thị trường=====================
$menuMarket           = $this->url('ListMarketRoute',array('module'=>'home','controller'=>'market','action'=>'index'));

//theo thành phố
$xhtmlMarketCity = '';
if(!empty($this->arrParams['listCity'])){
    $i = 1;
    foreach($this->arrParams['listCity'] as $item){
        $urlCity   = $this->url(
            'CityMarketRoute',
            array('action'=>'category','cityname'=>\ZendVN\Url\FriendlyLink::filter($item['name']),'page'=>1,'cityid'=>$item['id']
        ));
        if($i <= 8){
            $xhtmlMarketCity      .= '<li><a title="'.$item['name'].'" href="'.$urlCity.'">Giá dự án '.$item['name'].'</a></li>';
        }else{

            break;
        }
        $i++;
    }  
}

//Chuyên mục
$xhtmlMarketCategory = '';

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
          $xhtmlMarketCategory .="
                            <li><a title='".$item['name']."' href='".$urlCategory."'>Giá ".$item['name']."</a></li>
                           
                            ";
        }else{
          break;
        }
        $i++;                    
    }

}

//
$menuDangBds           = $this->url('MVC_UserRouter/action',array('module'=>'user','controller'=>'real-estate','action'=>'add'));


?>


          <ul>
              <li class="home" id="index"><a title="Trang chủ" href="<?php echo $menuHome;?>" onmouseover="nvgData.DemBDSTheoLoai();">Home</a>
                    <div class="subMainNav">
                      <div class="subContent">
                          <h4>Chuyên trang khu vực</h4>
                            <ul>
                               <?php echo $xhtmlCityRealestate;?>
                            </ul>
                      </div>
                        <div class="subContent">
                          <h4>Nhà đất bán</h4>
                            <ul>
                              <?php echo $xhtmlMenuNhadatBan;?>
                            </ul>
                        </div>
                        <div class="subContent">
                          <h4>Nhà đất cho thuê</h4>
                            <ul>
                              <?php echo $xhtmlMenuNhadatChoThue;?>
                            </ul>
                            
                        </div>
                    </div>
                </li>
              <li class="mapItem" id="realestate"><a href="<?php echo $menuBds ;?>" title="Nhà đất bán" onmouseover="nvgData.DemBDSTheoLoai();">Nhà đất</a>
                <div class="subMainNav">
                        
                        <div class="subContent">
                          <h5>Nhà đất bán</h5>
                            <ul>
                              <?php echo $xhtmlMenuNhadatBan;?>
                            </ul>
                        </div>
                         <div class="subContent">
                            <h5>Nhà đất cho thuê</h5>
                            <ul>
                                <?php echo $xhtmlMenuNhadatChoThue;?>
                            </ul>
                        </div>
                        <div class="subContent">
                            <h4>Nhà đất theo khu vực</h4>
                            <ul>
                                <?php echo $xhtmlCityRealestate;?>
                            </ul>
                        </div>
                    </div>
                </li>
               
              
                <li class="projectItem" id="project"><a title="Dự án bất động sản" href="<?php echo $menuProject;?>">Dự án</a>
                  <div class="subMainNav">
                      <div class="subContent">
                          <h5>Dự án theo loại hình</h5>
                            <ul>
                                <?php echo $xhtmlProjectCategory;?>
                            </ul>
                        </div>
                        <div class="subContent">
                          <h5>Dự án theo khu vực</h5>
                            <ul>
                                <?php echo $xhtmlProjectCity;?>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="marketItem" id="market"><a title="Thị trường bất động sản" href="<?php echo $menuMarket;?>">Thị trường</a>
                  <div class="subMainNav">
                      <div class="subContent">
                          <h5>Giá Dự án theo loại hình</h5>
                            <ul>
                              <?php echo $xhtmlMarketCategory;?>
                            </ul>
                        </div>
                        <div class="subContent">
                          <h5>Giá dự án theo khu vực</h5>
                            <ul>
                                <?php echo $xhtmlMarketCity;?>
                            </ul>
                        </div>
                    </div>
                </li>
              <li class="marketItem" id="news"><a title="Tin tức bất động sản" href="<?php echo $menuNews;?>">Tin tức</a>
                  <div class="subMainNav">
                      <div class="subContent">
                          <h5>Theo chuyên mục</h5>
                            <ul>
                               <?php echo $xhtmlNewsCategory;?>
                            </ul>
                        </div>
                        <div class="subContent">
                          <h5>Tin địa phương</h5>
                            <ul>
                              <?php echo $xhtmlNewsCity;?>
                            </ul>
                        </div>
                    </div>
                </li>
                 <li class="marketItem" id="fengshui"><a title="Phong thủy" href="<?php echo $menuFengshui;?>">Phong thủy</a>
                    <div class="subMainNav">
                        <div class="subContent">
                            <h5>Theo chuyên mục</h5>
                            <ul>
                                <?php echo $xhtmlFengshuiCategory;?>
                            </ul>
                        </div>
                        <div class="subContent">
                            <h5>Tra cứu phong thủy</h5>
                            <ul>
                                <li><a href="<?php echo $urlTraCuuFengshui ;?>" title="Tra cứu phong thủy">Tra cứu phong thủy</a></li>


                            </ul>
                        </div>
                    </div>
                </li>
               
               
                <li id="business" class="companyItem"><a title="Doanh nghiệp" href="<?php echo $menuBusiness;?>">Doanh nghiệp</a>
                  <div class="subMainNav">
                      <div class="subContent">
                          <h5>Loại hình doanh nghiệp</h5>
                            <ul>
                                <?php echo $xhtmlMenuBusiness;?>
                            </ul>
                        </div>
                        <div class="subContent">
                          <h5>Theo tỉnh thành</h5>
                            <ul>
                              <?php echo $xhtmlCity;?>
                            </ul>                            
                        </div>
                    </div>
                </li>
                <li class="mapItem" id="cafeluat"><a title="Nhà đẹp" href="<?php echo $menuLegalHousing ;?>">Cafe luật</a>                  
                  <div class="subMainNav">
                      <div class='subContent'>
                          <h5><a title='Pháp lý nhà đất' href='<?php echo $menuLegalHousing;?>'>Pháp lý nhà đất</a></h5>
                            <ul>
                                <?php echo $xhtmlLegalHousingCategory;?>
                            </ul>
                        </div>
                        <div class='subContent'>
                          <h5><a title='Văn bản luật nhà đất' href='<?php echo $menuLegislationHousing ;?>'>Văn bản luật nhà đất</h5>
                            <ul><?php echo $xhtmlLegislationHousingCategory;?></ul>
                       
                        </div>
                        <div class='subContent'>
                          <h5><a title='Biểu mẫu hợp đồng' href='<?php echo $menuContractForm;?>'>Biểu mẫu hợp đồng</a></h5>
                            <ul>
                                <?php echo $xhtmlContractFormCategory;?>
                            </ul>

                        </div>

       
                    </div>
                </li>

                <li class="newsItem" id="nicehouse"><a title="Nhà đẹp" href="<?php echo $menuNiceHouse;?>">Nhà đẹp</a>                  
                    <div class="subMainNav">
                       <div class="subContent" style="width:603px;">
                            <h5>Danh mục</h5>
                            <ul>
                                <?php echo $xhtmlNiceHouseCategory;?>
                            </ul>
                        </div>
                    </div>
                </li>

               
              <li class="upload" id="postAdss"><a href="<?php echo $menuDangBds;?>" title="Đăng tin bất động sản" rel="nofollow">Đăng tin</a></li>
                

            
                
            </ul>




<script type="text/javascript">
    $(document).ready(function(){
        var classCurrent = '<?php echo $this->arrParams['controller'];?>';
        if(classCurrent != 'index'){
            $('ul > li#index').removeClass().addClass('home');
        }
        if(classCurrent == 'legalhousing' || classCurrent == 'legislationhousing' || classCurrent == 'contractform'){
            $('ul > li#cafeluat').addClass("current");
        }
        $('ul > li#' + classCurrent).addClass("current");
    });
</script>         
  