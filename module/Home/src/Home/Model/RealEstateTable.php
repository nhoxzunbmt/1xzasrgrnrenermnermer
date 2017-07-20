<?php
namespace Home\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Predicate\Like;
use Zend\Db\Sql\Expression;


class RealEstateTable{
   protected $tableGateway;
   protected $adapter;

   public function __construct(TableGateway $tableGateway){
      $this->tableGateway = $tableGateway;
      $this->adapter = GlobalAdapterFeature::getStaticAdapter();
   }

   public function itemInselectBox($arrParam = null,$options = null){
      if($options['task'] == 'list-item-project-category'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->columns(array('id', 'name'))
                              ->where('type = "category_project"');
                              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $default[]  = array('id'=>'','name'=>'Loại dự án');
         $result     = array_merge($default,$result);
         return $result;
      }
      if($options['task'] == 'list-item-type-real-estate'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->columns(array('id', 'name','parents'=>'parent'))
                              ->where('type = "category_realestate"')
                              ->where('parent = 1');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $default[]  = array('id'=>'','name'=>'Loại bất động sản');
         $result     = array_merge($default,$result);
         return $result;
      }
      if($options['task'] == 'list-item-city'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city')
                              ->columns(array('id', 'name'));                  
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $default[]  = array('id'=>'','name'=>'Thành Phố');
         $result     = array_merge($default,$result);
         return $result;
      }
      if($options['task'] == 'list-item-project'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('project')
                              ->columns(array('id', 'name'));                  
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $default[]  = array('id'=>'','name'=>'Thuộc Dự án');
         $result     = array_merge($default,$result);
         return $result;
      }
       
   }

   public function countItem($arrParam = null,$options = null){
      if($options == null){
         //return $this->tableGateway->select()->count();
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('re' => 'real_estate'))
                              ->columns(array('count'    => new Expression('COUNT(id)')));
                              
                              if(!empty($arrParam['arrChildId'])){
                                 $select->where( new Predicate\In('cat_id', $arrParam['arrChildId']));
                              }
                              //Lọc theo loại giao dịch
                              if(!empty($arrParam['transaction'])){
                                 $select->where('transaction = '.$arrParam['transaction']);   
                              }
                              //Tin chính chủ
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'chinh-chu'){
                                 //$select->where('type_news = 5');   
                              }
                              //Tin có hình
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'co-hinh'){
                                // $select->where('images != ""');   
                              }
                              //Tin mới nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'tin-moi-nhat'){
                                 $select->order('id DESC'); 
                              }
                              //Gía cao nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'gia-cao-nhat'){
                                 $select->order('price DESC'); 
                              }
                              //Gía thấp nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'gia-thap-nhat'){
                                 $select->order('price ASC'); 
                              }
                              //Diện tích lớn nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'dien-tich-lon-nhat'){
                                 $select->order('area DESC'); 
                              }
                              //Diện tích nhỏ nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'dien-tich-nho-nhat'){
                                 $select->order('area ASC'); 
                              }
                              //Lọc theo thành phố
                              if(!empty($arrParam['idcity']) && $arrParam['idcity'] != '0'){
                                 $select->where('city = '.$arrParam['idcity']);   
                              }
                              //Lọc theo quận huyện
                              if(!empty($arrParam['iddistrict']) && $arrParam['iddistrict'] != '0'){
                                 $select->where('district = '.$arrParam['iddistrict']);   
                              }
                              //Lọc theo Môi giới
                              if(!empty($arrParam['idUser'])){
                                 $select->where('user_id = '.$arrParam['idUser']);   
                              }
                              //Lọc theo nhân viên
                              if(!empty($arrParam['staff'])){
                                 $select->where('re.user_id IN('.$arrParam['staff'].')', \Zend\Db\Sql\Predicate\Predicate::OP_OR);   
                              }
                              //Lọc theo dự án
                              if(!empty($arrParam['project'])){
                                 $select->where('project = '.$arrParam['project']);   
                              } 

                              //Loại bất động sản
                              if(!empty($arrParam['cat'])){
                                 $select->where('re.cat_id = '.$arrParam['cat']);   
                              } 
                              //Khoảng giá
                              if(!empty($arrParam['price'])){
                                 $arrPrice = explode('-', $arrParam['price']);
                                 $select->where( new Predicate\Between('re.price', $arrPrice[0], $arrPrice[1]));   
                              } 
                              //Diện tích
                              if(!empty($arrParam['area'])){
                                 $arrArea = explode('-', $arrParam['area']);
                                 $select->where( new Predicate\Between('re.area', $arrArea[0], $arrArea[1]));   
                              }                 
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }
      if($options['task'] == 'isImage'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('real_estate')
                              ->columns(array('count'    => new Expression('COUNT(id)')))
                              ->where('images != ""'); 
                              if(!empty($arrParam['arrChildId'])){
                                 $select->where( new Predicate\In('cat_id', $arrParam['arrChildId']));
                              }
                              //Lọc theo loại giao dịch
                              if(!empty($arrParam['transaction'])){
                                 $select->where('transaction = '.$arrParam['transaction']);   
                              }
                              //Tin chính chủ
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'chinh-chu'){
                                 //$select->where('type_news = 5');   
                              }
                              //Tin có hình
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'co-hinh'){
                                 //$select->where('images != ""');   
                              }
                              //Tin mới nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'tin-moi-nhat'){
                                 $select->order('id DESC'); 
                              }
                              //Gía cao nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'gia-cao-nhat'){
                                 $select->order('price DESC'); 
                              }
                              //Gía thấp nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'gia-thap-nhat'){
                                 $select->order('price ASC'); 
                              }
                              //Diện tích lớn nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'dien-tich-lon-nhat'){
                                 $select->order('area DESC'); 
                              }
                              //Diện tích nhỏ nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'dien-tich-nho-nhat'){
                                 $select->order('area ASC'); 
                              }
                              //Lọc theo thành phố
                              if(!empty($arrParam['idcity']) && $arrParam['idcity'] != '0'){
                                 $select->where('city = '.$arrParam['idcity']);   
                              }
                              //Lọc theo quận huyện
                              if(!empty($arrParam['iddistrict']) && $arrParam['iddistrict'] != '0'){
                                 $select->where('district = '.$arrParam['iddistrict']);   
                              }
                              //Lọc theo Môi giới
                              if(!empty($arrParam['idUser'])){
                                 $select->where('user_id = '.$arrParam['idUser']);   
                              }
                              //Lọc theo dự án
                              if(!empty($arrParam['project'])){
                                 $select->where('project = '.$arrParam['project']);   
                              }                              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
                          
         return $result;
      }
      if($options['task'] == 'chinh-chu'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('real_estate')
                              ->columns(array('count'    => new Expression('COUNT(id)')))
                              ->where('type_news = 5');
                              if(!empty($arrParam['arrChildId'])){
                                 $select->where( new Predicate\In('cat_id', $arrParam['arrChildId']));
                              }
                              //Lọc theo loại giao dịch
                              if(!empty($arrParam['transaction'])){
                                 $select->where('transaction = '.$arrParam['transaction']);   
                              }
                              //Tin chính chủ
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'chinh-chu'){
                                 //$select->where('type_news = 5');   
                              }
                              //Tin có hình
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'co-hinh'){
                                 //$select->where('images != ""');   
                              }
                              //Tin mới nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'tin-moi-nhat'){
                                 $select->order('id DESC'); 
                              }
                              //Gía cao nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'gia-cao-nhat'){
                                 $select->order('price DESC'); 
                              }
                              //Gía thấp nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'gia-thap-nhat'){
                                 $select->order('price ASC'); 
                              }
                              //Diện tích lớn nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'dien-tich-lon-nhat'){
                                 $select->order('area DESC'); 
                              }
                              //Diện tích nhỏ nhất
                              if(!empty($arrParam['type']) && $arrParam['type'] == 'dien-tich-nho-nhat'){
                                 $select->order('area ASC'); 
                              }
                              //Lọc theo thành phố
                              if(!empty($arrParam['idcity']) && $arrParam['idcity'] != '0'){
                                 $select->where('city = '.$arrParam['idcity']);   
                              }
                              //Lọc theo quận huyện
                              if(!empty($arrParam['iddistrict']) && $arrParam['iddistrict'] != '0'){
                                 $select->where('district = '.$arrParam['iddistrict']);   
                              }
                              //Lọc theo Môi giới
                              if(!empty($arrParam['idUser'])){
                                 $select->where('user_id = '.$arrParam['idUser']);   
                              } 
                             
                              //Lọc theo dự án
                              if(!empty($arrParam['project'])){
                                 $select->where('project = '.$arrParam['project']);   
                              }           
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);                  
         return $result;
      }
     
   }
   public function listItem($arrParam = null,$options = null){
       if($options['task'] == 'list-breadcrumb') {
       

         return $result  = $this->tableGateway->select(function (Select $select) use ($arrParam){
            $select->columns(array('id','name','level', 'parent'))
                  ->order('left ASC')
                  ->where->greaterThan('level', 0)
                  ->where->lessThanOrEqualTo('left', $arrParam->left)
                  ->where->greaterThanOrEqualTo('right', $arrParam->right)
            ;
         });
               
      }
      if($options == null){
         $result = $this->tableGateway->select();
         $result->buffer();
         return  $result;
      }
      if($options['task'] == 'list-item-type-real-estate'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->columns(array('id', 'name','parents'=>'parent'))
                              ->where('type = "category_realestate"')
                              ->where('parent = 1');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }
      if($options['task'] == 'list-item-type-real-estate-child'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->columns(array('id','name','parent'))
                              ->where('type = "category_realestate"');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }
      if($options['task'] == 'list-item-district'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city_district')
                              ->columns(array('id','name','city_id'));
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }
      if($options['task'] == 'list-item-ward'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city_district_ward')
                              ->columns(array('id','name','district_id'));
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }
      if($options['task'] == 'list-item-project'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('project')
                              ->columns(array('id','name','district'));
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }
      if($options['task'] == 'list-item-district-of-current-city'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city_district')
                              ->columns(array('id','name','city_id'));
                              if(!empty($arrParam['cityid'])){
                                 $select->where('city_id ='.$arrParam['cityid']);
                              }
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }

      if($options['task'] == 'list-items-realestate-highlight'){
         $paginator  = $arrParam['paginator'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('re'=>'real_estate'));
                              
                              $select->join(
                                 array('retype' => 'category'),
                                 'retype.id = re.cat_id',
                                 array('name_type' => 'name'),
                                 $select::JOIN_LEFT
                              );


                              $select->where('re.type_news = 3');
                              $select->limit(12);               
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }
      if($options['task'] == 'list-items-realestate-chinh-chu'){
         $paginator  = $arrParam['paginator'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('re'=>'real_estate'));
                              
                              $select->join(
                                 array('retype' => 'category'),
                                 'retype.id = re.cat_id',
                                 array('name_type' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->join(
                                 array('ct' => 'city'),
                                 'ct.id = re.city',
                                 array('name_city' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->join(
                                 array('ctd' => 'city_district'),
                                 'ctd.id = re.district',
                                 array('name_district' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->join(
                                 array('ctdw' => 'city_district_ward'),
                                 'ctdw.id = re.ward',
                                 array('name_ward' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->join(
                                 array('ju' => 'juridical'),
                                 'ju.id = re.juridical',
                                 array('name_juridical' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->where('re.type_news = 5');
                              $select->limit(12);                
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }

      if($options['task'] == 'list-items-realestate-moi-nhat'){
         $paginator  = $arrParam['paginator'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('re'=>'real_estate'));
                              
                              $select->join(
                                 array('retype' => 'category'),
                                 'retype.id = re.cat_id',
                                 array('name_type' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->order('re.id DESC');
                              //$select->where('re.type_news = 3');
                              $select->limit(20);                    
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }
      if($options['task'] == 'list-items-paginator'){

         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('re' => 'real_estate'))
               
               ->join(
                  array('ct' => 'city'),
                  'ct.id = re.city',
                  array('name_city' => 'name'),
                  $select::JOIN_LEFT
               )
               
               ->join(
                  array('ctd' => 'city_district'),
                  'ctd.id = re.district',
                  array('name_district' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('ctdw' => 'city_district_ward'),
                  'ctdw.id = re.ward',
                  array('name_ward' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('retype' => 'category'),
                  'retype.id = re.cat_id',
                  array('name_type' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('project' => 'project'),
                  'project.id = re.project',
                  array('name_project' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('sre' => 'favorite_real_estate'),
                  'sre.real_estate_id = re.id',
                  array('id_favorite' => 'id','user_id_favorite'=>'user_id'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('ty' => 'type_news'),
                  'ty.id = re.type_news',
                  array('priority'),
                  $select::JOIN_LEFT
               )

               ->group(array('re.id'))
               ->order('ty.priority DESC')
               //->order('date_modifi DESC')

               ->limit($paginator['itemCountPerPage'])
               ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
               
               if(!empty($arrParam['arrChildId'])){
                  $select->where( new Predicate\In('re.cat_id', $arrParam['arrChildId']));
               }
               //Lọc theo loại giao dịch
               if(!empty($arrParam['transaction'])){
                  $select->where('re.transaction = '.$arrParam['transaction']);   
               }
               //Tin chính chủ
               if(!empty($arrParam['type']) && $arrParam['type'] == 'chinh-chu'){
                  $select->where('re.type_news = 5');   
               }
               //Tin có hình
               if(!empty($arrParam['type']) && $arrParam['type'] == 'co-hinh'){
                  $select->where('re.images != ""');   
               }
               //Tin mới nhất
               if(!empty($arrParam['type']) && $arrParam['type'] == 'tin-moi-nhat'){
                  $select->order('re.id DESC'); 
               }
               //Gía cao nhất
               if(!empty($arrParam['type']) && $arrParam['type'] == 'gia-cao-nhat'){
                  $select->order('re.price DESC'); 
               }
               //Gía thấp nhất
               if(!empty($arrParam['type']) && $arrParam['type'] == 'gia-thap-nhat'){
                  $select->order('re.price ASC'); 
               }
               //Diện tích lớn nhất
               if(!empty($arrParam['type']) && $arrParam['type'] == 'dien-tich-lon-nhat'){
                  $select->order('re.area DESC'); 
               }
               //Diện tích nhỏ nhất
               if(!empty($arrParam['type']) && $arrParam['type'] == 'dien-tich-nho-nhat'){
                  $select->order('re.area ASC'); 
               }
               //Lọc theo thành phố
               if(!empty($arrParam['idcity']) && $arrParam['idcity'] != '0'){
                  $select->where('re.city = '.$arrParam['idcity']);   
               }
               //Lọc theo quận huyện
               if(!empty($arrParam['iddistrict']) && $arrParam['iddistrict'] != '0'){
                  $select->where('re.district = '.$arrParam['iddistrict']);   
               }
               //Lọc theo Môi giới
               if(!empty($arrParam['idUser'])){
                  $select->where('re.user_id = '.$arrParam['idUser']);   
               }
               //Lọc theo nhân viên
               if(!empty($arrParam['staff'])){
                  $select->where('re.user_id IN('.$arrParam['staff'].')', \Zend\Db\Sql\Predicate\Predicate::OP_OR);   
               }
               //Lọc theo dự án
               if(!empty($arrParam['project'])){
                  $select->where('re.project = '.$arrParam['project']);   
               } 
               //Loại bất động sản
               if(!empty($arrParam['cat'])){
                  $select->where('re.cat_id = '.$arrParam['cat']);   
               } 
               //Khoảng giá
               if(!empty($arrParam['price'])){
                  $arrPrice = explode('-', $arrParam['price']);
                  $select->where( new Predicate\Between('re.price', $arrPrice[0], $arrPrice[1]));   
               } 
               //Diện tích
               if(!empty($arrParam['area'])){
                  $arrArea = explode('-', $arrParam['area']);
                  $select->where( new Predicate\Between('re.area', $arrArea[0], $arrArea[1]));   
               } 
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();

         return $result;

      }
      if($options['task'] == 'tin-tuong-tu'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('re' => 'real_estate'))
               
               ->join(
                  array('ct' => 'city'),
                  'ct.id = re.city',
                  array('name_city' => 'name'),
                  $select::JOIN_LEFT
               )
               
               ->join(
                  array('ctd' => 'city_district'),
                  'ctd.id = re.district',
                  array('name_district' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('ctdw' => 'city_district_ward'),
                  'ctdw.id = re.ward',
                  array('name_ward' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('retype' => 'category'),
                  'retype.id = re.cat_id',
                  array('name_type' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('project' => 'project'),
                  'project.id = re.project',
                  array('name_project' => 'name'),
                  $select::JOIN_LEFT
               )
               ->order('id DESC')
               ->where('re.cat_id = '.$arrParam['cid'])
               ->where('re.transaction = '.$arrParam['transaction']);
               

               
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         return $result;
      }


      

   }
   public function recusive($arrParam = null, $options = null){
      if($options['task'] == 'list-child-of-parent-type-real-estate'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->columns(array('id'))
                              ->where('parent = '.$arrParam);

         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         

         $arrChildId = array();
         foreach ($result as $key => $value) {
            $arrChildId[] = $value['id'];
         }
         
         return $arrChildId;
        
      }
   }
   public function getItem($arrParam = null, $options = null){
      if($options['task'] == 'category-frontend') {
         $result  = $this->tableGateway->select(function (Select $select) use ($arrParam){
            $select->columns(array('id', 'name', 'description', 'left', 'right'))
                  ->where->equalTo('id', $arrParam['id']);
            ;
         })->current();
         return $result;
      }
      if($options['task'] == 'get-item'){
         $row = $this->tableGateway->select(array('id'=>$arrParam['id']))->current();
         if(empty($row)) return false;
      }
      if($options['task'] == 'get-item-find-parent-cat'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->columns(array('parent'))
                              ->where('id = '.$arrParam);
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }
      if($options['task'] == 'get-item-fengshui'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('fengshui')
                              ->columns(array('id','birth','sex','direction','content'));
                              //Năm sinh
                              $select->where('birth ='.$arrParam['feng-shui-birth']);   
                              if(!empty($arrParam['feng-shui-sex'])){
                                 $select->where('sex ='.$arrParam['feng-shui-sex']);   
                              }
                              if(!empty($arrParam['feng-shui-huong'])){
                                 $select->where('direction ='.$arrParam['feng-shui-huong']);   
                              }
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = $result[0];
         return $result;
      }
      if($options['task'] == 'get-item-city'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city')
                              ->columns(array('id','name'))
                              ->where('id ='.$arrParam['cityid']);
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = $result[0];

         return $result;
      }
      if($options == null){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('re' => 'real_estate'))
               
               ->join(
                  array('ct' => 'city'),
                  'ct.id = re.city',
                  array('name_city' => 'name'),
                  $select::JOIN_LEFT
               )
               
               ->join(
                  array('ctd' => 'city_district'),
                  'ctd.id = re.district',
                  array('name_district' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('ctdw' => 'city_district_ward'),
                  'ctdw.id = re.ward',
                  array('name_ward' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('retype' => 'category'),
                  'retype.id = re.cat_id',
                  array('name_type' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('project' => 'project'),
                  'project.id = re.project',
                  array('name_project' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('u' => 'users'),
                  'u.id = re.user_id',
                  array('fullname','phone','avatar'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('ju' => 'juridical'),
                  'ju.id = re.juridical',
                  array('name_juridical'=>'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('status' => 'real_estate_status'),
                  'status.id = re.status',
                  array('name_status'=>'name'),
                  $select::JOIN_LEFT
               );
           
               $select->where('re.id ='.$arrParam['id']);   
               
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = $result[0];
         return $result;
      }
      if($options['task'] == 'view-bds'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('re' => 'real_estate_view'))
               ->columns(array(
                  'id','real_estate_id','date_time','view'
               ));
               
               $select->where('re.real_estate_id = '.$arrParam['id']);   
               $select->where('re.date_time = "'.$arrParam['date_time'].'"');   
         
              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         if(!empty($result)){
            $result     = $result[0];
         }
         
         return $result;
      }

      return $row;
   }

   public function saveItem($arrParam = null,$options = null){
      if($options['task'] == 'add'){
         $this->tableGateway->insert($arrParam);
         return $this->tableGateway->lastInsertValue;
      }
      if($options['task']  == 'edit'){
         $this->tableGateway->update($arrParam,array('id' => $arrParam['id']));
      }
      if($options['task'] == 'contact-me'){
         $sqlObj     = new Sql($this->adapter);
         $insertObj  = $sqlObj->insert('contact_real_estate');
         $insertObj->values($arrParam);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($insertObj);
         $this->adapter->query($sqlString)->execute();
      }
      if($options['task'] == 'save-real-estate-favorite'){
         $sqlObj     = new Sql($this->adapter);
         $insertObj  = $sqlObj->insert('favorite_real_estate');
         $insertObj->values($arrParam);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($insertObj);
         $this->adapter->query($sqlString)->execute();
      }

      if($options['task'] == 'add-view-bds'){
         $sqlObj     = new Sql($this->adapter);
         $insertObj  = $sqlObj->insert('real_estate_view');
         $insertObj->values($arrParam);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($insertObj);
         $this->adapter->query($sqlString)->execute();
      }

      if($options['task'] == 'update-view-bds'){
         
         $sqlObj     = new Sql($this->adapter);
         $updateObj  = $sqlObj->update('real_estate_view');
         $updateObj->set($arrParam);
         $updateObj->where('id = '.$arrParam['id']);
         $updateObj->where('real_estate_id = '.$arrParam['real_estate_id']);
          
         $sqlString  = $sqlObj->getSqlStringForSqlObject($updateObj);
         $this->adapter->query($sqlString)->execute();
      }
      if($options['task']  == 'multi-status'){
          if(!empty($arrParam)){
            foreach ($arrParam['id'] as $key => $value) {
               if($arrParam['type'] == 'multi-active'){
                  $status  = 1;
               }if($arrParam['type'] == 'multi-in-active'){
                  $status  = 0;
               }
               $data = array(
                  'id'     => $value,
                  'status' => $status,
               );
               $this->tableGateway->update($data,array('id' => $value));
            } 
         }
      }
   }

   public function deleteItem($arrParam = null,$options = null){
      if($options['task'] == 'list-images'){   
         return $this->tableGateway->select(function(Select $select) use ($arrParam){
            $select->columns(array('id','avatar'));
            $select->where(array(
                'id' => $arrParam
            ));
                 
         });                         
      }
      if($options['task'] == 'delete-item'){
         $this->tableGateway->delete(array('id'=>$arrParam['id']));
      }
      if($options['task'] == 'multi-delete-item'){
         if(!empty($arrParam)){
            foreach ($arrParam as $key => $value) {
               $this->tableGateway->delete(array('id'=>$value));
            }
            
         } 
      }

      if($options['task'] == 'delete-real-estate-favorite'){
         $sqlObj     = new Sql($this->adapter);
         $deleteObj  = $sqlObj->delete('favorite_real_estate');
         $deleteObj->where(
            new \Zend\Db\Sql\Predicate\In('id', array($arrParam['id']))      
         );
          
         $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
         $this->adapter->query($sqlString)->execute();
      }
   }

}