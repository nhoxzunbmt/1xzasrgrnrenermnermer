<?php
namespace Home\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Predicate\Like;
use Zend\Db\Sql\Expression;

class ProjectTable{
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
      
       
   }

   public function countItem($arrParam = null,$options = null){
      if($options == null){
         //return $this->tableGateway->select()->count();
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('p' => 'project'))
                              ->columns(array('count'    => new Expression('COUNT(id)')));
                            
                              
                              if(!empty($arrParam['cityid'])){
                                 $select->where('p.city = '.$arrParam['cityid']);
                              }
                              if(!empty($arrParam['iddistrict'])){
                                 $select->where('p.district = '.$arrParam['iddistrict']);
                              } 

                              if(!empty($arrParam['cat_id'])){
                                 $select->where('p.cat_id = '.$arrParam['cat_id']);
                              }

                              //Diện tích
                              if(!empty($arrParam['area'])){
                                 $arrArea = explode('-', $arrParam['area']);
                                 $select->where( new Predicate\Between('p.area', $arrArea[0], $arrArea[1]));   
                              }  

                               
                                          
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
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
     
      if($options['task'] == 'list-item-district'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city_district')
                              ->columns(array('id','name','city_id'));
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }
     
     
      if($options['task'] == 'list-item-district-of-current-city'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city_district')
                              ->columns(array('id','name','city_id'));
                              if(!empty($arrParam['city'])){
                                 $select->where('city_id ='.$arrParam['city']);
                              }
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);

         return $result;
      }


      if($options['task'] == 'list-items-hightlight'){
        
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('p'=>'project'));
                              
                              $select->join(
                                 array('cat' => 'category'),
                                 'cat.id = p.cat_id',
                                 array('name_type' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              //$select->where('re.type_news = 3');
                              $select->limit(4);                
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }
      if($options['task'] == 'list-items-paginator'){

         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('p' => 'project'))
               
               ->join(
                  array('ct' => 'city'),
                  'ct.id = p.city',
                  array('name_city' => 'name'),
                  $select::JOIN_LEFT
               )
               
               ->join(
                  array('ctd' => 'city_district'),
                  'ctd.id = p.district',
                  array('name_district' => 'name'),
                  $select::JOIN_LEFT
               )
               
               ->join(
                  array('retype' => 'category'),
                  'retype.id = p.cat_id',
                  array('name_category' => 'name'),
                  $select::JOIN_LEFT
               )
             
               
             
               ->limit($paginator['itemCountPerPage'])
               ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);

               if(!empty($arrParam['type']) && $arrParam['type'] == 'investors'){
                  $select->join(
                     array('u' => 'users'),
                     'u.id = p.investors',
                     array('username' => 'username'),
                     $select::JOIN_LEFT
                  );
               }

               if(!empty($arrParam['type']) && $arrParam['type'] == 'construction'){
                  $select->join(
                     array('u' => 'users'),
                     'u.id = p.construction',
                     array('username' => 'username'),
                     $select::JOIN_LEFT
                  );
               }

               if(!empty($arrParam['type']) && $arrParam['type'] == 'management'){
                  $select->join(
                     array('u' => 'users'),
                     'u.id = p.management',
                     array('username' => 'username'),
                     $select::JOIN_LEFT
                  );
               }

               if(!empty($arrParam['type']) && $arrParam['type'] == 'design'){
                  $select->join(
                     array('u' => 'users'),
                     'u.id = p.design',
                     array('username' => 'username'),
                     $select::JOIN_LEFT
                  );
               }

               if(!empty($arrParam['type']) && $arrParam['type'] == 'distributors'){
                  $select->join(
                     array('u' => 'users'),
                     'u.id = p.distributors',
                     array('username' => 'username'),
                     $select::JOIN_LEFT
                  );
               }
               if(!empty($arrParam['cityid'])){
                  $select->where('p.city = '.$arrParam['cityid']);
               }
               if(!empty($arrParam['iddistrict'])){
                  $select->where('p.district = '.$arrParam['iddistrict']);
               } 
               
               if(!empty($arrParam['cat_id'])){
                  $select->where('p.cat_id = '.$arrParam['cat_id']);
               } 

               if(!empty($arrParam['alias'])){
                  $select->where('u.username = "'.$arrParam['alias'].'"');      
               } 
               //Diện tích
               if(!empty($arrParam['area'])){
                  $arrArea = explode('-', $arrParam['area']);
                  $select->where( new Predicate\Between('p.area', $arrArea[0], $arrArea[1]));   
               }   


               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();

         return $result;

      }
     

      

   }
   public function recusive($arrParam = null, $options = null){
      if($options['task'] == 'list-child-of-parent-type-real-estate'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('real_estate_type')
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
                              ->from('real_estate_type')
                              ->columns(array('parent'))
                              ->where('id = '.$arrParam);
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }
      if($options['task'] == 'get-item-category'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->where('id = '.$arrParam['id']);
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
        $select->from(array('p' => 'project'))
               
               ->join(
                  array('ct' => 'city'),
                  'ct.id = p.city',
                  array('name_city' => 'name'),
                  $select::JOIN_LEFT
               )
               
               ->join(
                  array('ctd' => 'city_district'),
                  'ctd.id = p.district',
                  array('name_district' => 'name'),
                  $select::JOIN_LEFT
               )
               //chủ đầu tư
               ->join(
                  array('b' => 'business'),
                  'b.id = p.investors',
                  array('name_investors' => 'name','alias_investors'=>'alias'),
                  $select::JOIN_LEFT
               )
               //Đơn vị thi công
               ->join(
                  array('b1' => 'business'),
                  'b1.id = p.construction',
                  array('name_construction' => 'name','alias_construction'=>'alias'),
                  $select::JOIN_LEFT
               )
               //Đơn vị quản lý
               ->join(
                  array('b2' => 'business'),
                  'b2.id = p.management',
                  array('name_management' => 'name','alias_management'=>'alias'),
                  $select::JOIN_LEFT
               )
               //Đơn vị thiết kế
               ->join(
                  array('b3' => 'business'),
                  'b3.id = p.design',
                  array('name_design' => 'name','alias_design'=>'alias'),
                  $select::JOIN_LEFT
               )
               //nhà phân phối
                ->join(
                  array('b4' => 'business'),
                  'b4.id = p.distributors',
                  array('name_distributors' => 'name','alias_distributors'=>'alias','logo_distributors'=>'logo'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('retype' => 'category'),
                  'retype.id = p.cat_id',
                  array('name_category' => 'name'),
                  $select::JOIN_LEFT
               );
           
               $select->where('p.id ='.$arrParam['id']);   
               
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = $result[0];
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