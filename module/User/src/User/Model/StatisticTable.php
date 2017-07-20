<?php
namespace User\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Predicate\Like;
use Zend\Db\Sql\Expression;

class StatisticTable{
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
                              ->from('real_estate_type')
                              ->columns(array('id', 'name'))
                              ->where('parent = 0');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $default[]  = array('id'=>'','name'=>'--Chọn--');
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
      if($options['task'] == 'count-favorite'){
         $ssFilter   = $arrParam['ssFilter'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('re' => 'real_estate'))
                              ->columns(array('count'    => new Expression('COUNT(re.id)')));
                              
                              $select->where('user_id = '.$arrParam['userId']);

                                //-------Lọc theo thành phố-------
                              if(!empty($ssFilter['city'])){
                                 $select->where('re.city ='.$ssFilter['city']);            
                              }
                               //-------Lọc theo quận huyện-------
                              if(!empty($ssFilter['district'])){
                                 $select->where('re.district ='.$ssFilter['district']);            
                              }
                              //-------Lọc theo ngày đăng--------------
                              if(!empty($ssFilter['date_start'])){
                                 $keywords = '%' . $ssFilter['date_start'] . '%';
                                 $select->where(array(   
                                       new Like('re.date_start', $keywords)
                                 ));
                                 
                              }
                              //Lọc theo ngày hết hạn
                              if(!empty($ssFilter['date_end'])){
                                 $keywords = '%' . $ssFilter['date_end'] . '%';
                                 $select->where(array(   
                                       new Like('re.date_end', $keywords)
                                 ));
                              }    
                                                      
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                       
         return $result;
      }
      if($options['task'] == 'count-transaction-history'){
         $ssFilter   = $arrParam['ssFilter'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('t' => 'transaction_history'))
                              ->columns(array('count'    => new Expression('COUNT(t.id)')));
                              
                              $select->where('user_id = '.$arrParam['userId']);
                              if(!empty($arrParam['IdBds'])){
                                 $select->where('t.service_id ='.$arrParam['IdBds']);
                              }
                              
                              
                                                      
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                       
         return $result;
      }
   }
   public function listItem($arrParam = null,$options = null){
      
      if($options['task'] == 'list-item-child-user'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('users')
                              ->columns(array('id','name'=>'fullname'))
                              ->where('parent ='.$arrParam);                 
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }
      
      if($options['task'] == 'list-items-paginator-favorite'){

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
                  array('status' => 'real_estate_status'),
                  'status.id = re.status',
                  array('name_status' => 'name'),
                  $select::JOIN_LEFT
               )
               ->order('status DESC')
               ->order('date_modifi DESC')

               
               ->where('re.user_id ='.$arrParam['userId']);   
                 //-------Lọc theo thành phố-------
               if(!empty($ssFilter['city'])){
                  $select->where('re.city ='.$ssFilter['city']);            
               }
                //-------Lọc theo quận huyện-------
               if(!empty($ssFilter['district'])){
                  $select->where('re.district ='.$ssFilter['district']);            
               }
               //-------Lọc theo ngày đăng--------------
               if(!empty($ssFilter['date_start'])){
                  $keywords = '%' . $ssFilter['date_start'] . '%';
                  $select->where(array(   
                        new Like('re.date_start', $keywords)
                  ));
                  
               }
               //Lọc theo ngày hết hạn
               if(!empty($ssFilter['date_end'])){
                  $keywords = '%' . $ssFilter['date_end'] . '%';
                  $select->where(array(   
                        new Like('re.date_end', $keywords)
                  ));
               }    
               
              
              
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         return $result;




        
      }

      if($options['task'] == 'list-items-paginator-transaction-history'){

         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('t' => 'transaction_history'))
              
               ->join(
                  array('u' => 'users'),
                  'u.id = t.user_id',
                  array('fullname'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('ty' => 'type_news'),
                  'ty.id = t.type_news',
                  array('name_type'=>'name','day'),
                  $select::JOIN_LEFT
               )
               
               ->where('t.user_id ='.$arrParam['userId'])
               ->limit($paginator['itemCountPerPage'])
               ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);   
               if(!empty($arrParam['IdBds'])){
                  $select->where('t.service_id ='.$arrParam['IdBds']);
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

      if($options['task'] == 'get-item-statistic-service'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('users')
                              ->columns(array('id','info_service_account'));
                              
                              $select->where('id = '.$arrParam);
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = $result[0];
         return $result;
      }
      
      return $row;
   }

  

}