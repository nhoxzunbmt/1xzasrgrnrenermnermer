<?php
namespace Admin\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Expression;

class RealEstateTable{
   protected $tableGateway;
   protected $adapter;

   public function __construct(TableGateway $tableGateway){
      $this->tableGateway = $tableGateway;
      $this->adapter = GlobalAdapterFeature::getStaticAdapter();
   }

   public function itemInselectBox($arrParam = null,$options = null){
      if($options['task'] == 'list-item-type-real-estate'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->columns(array('id', 'name','parents'=>'parent'))
                              ->where('type = "category_realestate"')
                              ->where('parent = 1');
         
         $result  = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
        
         $default[]  = array('id'=>'','name'=>'--Chọn--','level'=>1);
         $result     = array_merge($default,$result);
         return $result;
      }
      if($options['task'] == 'list-item-city'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city')
                              ->columns(array('id', 'name'));                  
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $default[]  = array('id'=>'','name'=>'--Thành Phố--');
         $result     = array_merge($default,$result);
         return $result;
      }
      if($options['task'] == 'list-item-type-news'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('type_news')
                              ->columns(array('id', 'name'));                  
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $default[]  = array('id'=>'','name'=>'--Chọn loại tin--');
         $result     = array_merge($default,$result);
         return $result;
      }

       
   }

   public function countItem($arrParam = null,$options = null){
      if($options == null){
         $ssFilter   = $arrParam['ssFilter'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('real_estate')
                              ->columns(array('count'    => new Expression('COUNT(id)')));
                               //-------Lọc theo keyword và field----
                              if(!empty($ssFilter['keywords']) && !empty($ssFilter['field'])){
                                 $keywords = '%' . $ssFilter['keywords'] . '%';
                                 $select->where->like($ssFilter['field'], $keywords);
                              }
                             
                              //-------Lọc theo nhóm------------
                              if(!empty($ssFilter['group'])){
                                 $select->where->equalTo('cat_id',$ssFilter['group']);  
                              }
                              //-------Lọc theo status--------------
                              if(!empty($ssFilter['status'])){
                                 $select->where->equalTo('status',$ssFilter['status']);
                              }
                              //-------Lọc theo thành phố-------
                              if(!empty($ssFilter['city'])){
                                 $select->where->equalTo('city',$ssFilter['city']);            
                              }
                              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }

   }
   public function listItem($arrParam = null,$options = null){
      
      if($options == null){
         $result = $this->tableGateway->select();
         $result->buffer();
         return  $result;
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
      
      if($options['task'] == 'list-items-paginator'){
         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('r'=>'real_estate'));
                              $select->join(
                                 array('u'=>'users'),
                                 'r.user_id = u.id',
                                 array('fullname','phone','website','email'),
                                 $select::JOIN_LEFT 
                              );
         
         $select->limit($paginator['itemCountPerPage']);
         $select->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
        
          //-------Lọc theo keyword và field----
         if(!empty($ssFilter['keywords']) && !empty($ssFilter['field'])){
            $keywords = '%' . $ssFilter['keywords'] . '%';
            $select->where->like($ssFilter['field'], $keywords);
         }
        
         //-------Lọc theo nhóm------------
         if(!empty($ssFilter['group'])){
            $select->where->equalTo('cat_id',$ssFilter['group']);  
         }
         //-------Lọc theo status--------------
         if(!empty($ssFilter['status'])){
            $select->where->equalTo('status',$ssFilter['status']);
         }
         //-------Lọc theo thành phố-------
         if(!empty($ssFilter['city'])){
            $select->where->equalTo('city',$ssFilter['city']);            
         }
         
                                    
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }
      

   }

   public function getItem($arrParam = null, $options = null){
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
      if($options['task'] == 'get-item-user'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('users')
                              ->columns(array('fullname','phone','website','email'))
                              ->where('id = '.$arrParam);
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         if(!empty($result)) $result = $result[0];
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
      
      return $row;
   }

   public function saveItem($arrParam = null,$options = null){
      if($options == null){
         if($this->getItem($arrParam,array('task' => 'get-item')) == false || $arrParam['id'] == 0){
            $this->tableGateway->insert($arrParam);
         }else{
            $this->tableGateway->update($arrParam,array('id'=> $arrParam['id']));
         }
      }
      if($options['task'] == 'add'){
         $this->tableGateway->insert($arrParam);
      }
      if($options['task']  == 'edit'){
         $this->tableGateway->update($arrParam,array('id' => $arrParam['id']));
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
            $select->columns(array('id','logo'));
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
   }

}