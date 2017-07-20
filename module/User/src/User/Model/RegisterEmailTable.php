<?php
namespace User\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Predicate\Like;
use Zend\Db\Sql\Expression;

class RegisterEmailTable{
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

       
   }

   public function countItem($arrParam = null,$options = null){
      if($options == null){
         return $this->tableGateway->select()->count();
      }
      if($options['task'] == 'count'){
         $ssFilter   = $arrParam['ssFilter'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('re' => 'register_email'))
                              ->columns(array('count'    => new Expression('COUNT(re.id)')));
                              
                              $select->where('user_id = '.$arrParam['userId']);

                             
                                                      
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                       
         return $result;
      }
   }
   public function listItem($arrParam = null,$options = null){
     if($options['task'] == 'list-item-type-real-estate-child'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->columns(array('id','name','parent'));
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
      
      
      if($options['task'] == 'list-items-paginator'){

         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('re' => 'register_email'))
              
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
                  array('retype' => 'category'),
                  'retype.id = re.cat_id',
                  array('name_type' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('ju' => 'juridical'),
                  'ju.id = re.juridical',
                  array('name_juridical' => 'name'),
                  $select::JOIN_LEFT
               )
               
               ->where('re.user_id ='.$arrParam['userId']);   
               
               
              
              
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
      if($options['task'] == 'add'){
         $this->tableGateway->insert($arrParam);
         return $this->tableGateway->lastInsertValue;
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
     
      if($options['task'] == 'delete-item'){
         $this->tableGateway->delete(array('id'=>$arrParam['id']));
      }
      if($options['task'] == 'delete-item-favorite'){
        
         
         $sqlObj     = new \Zend\Db\Sql\Sql($this->adapter);
         $deleteObj  = $sqlObj->delete('favorite_real_estate');
         $deleteObj->where(
            new \Zend\Db\Sql\Predicate\In('id', $arrParam)      
         );
          
       
         $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
         $this->adapter->query($sqlString)->execute();
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