<?php
namespace User\Model;
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
                              ->columns(array('id', 'name','description','day'));                  
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $default[]  = array('id'=>'','name'=>'--Chọn loại tin--');
         $result     = array_merge($default,$result);
         return $result;
      }

       
   }

   public function countItem($arrParam = null,$options = null){
      if($options == null){
         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('re' => 'real_estate'))
                              ->columns(array('count'    => new Expression('COUNT(id)')));
                              
                              $select->where('re.user_id ='.$arrParam['userId']); 
                              if(!empty($arrParam['staffId']) && $arrParam['staffId'] != 0){
                                 $select->where('re.user_id ='.$arrParam['staffId']);   
                              }
                              //if(!empty($arrParam['parent']) && $arrParam['parent'] != 0){
                              //   $select->where('re.user_id ='.$arrParam['parent'], \Zend\Db\Sql\Predicate\Predicate::OP_OR);   
                              //}
                              
                              //Lọc theo nhân viên
                              if(!empty($arrParam['staff'])){
                                 $select->where('re.user_id IN('.$arrParam['staff'].')', \Zend\Db\Sql\Predicate\Predicate::OP_OR);   
                              }
                               //-------Lọc theo keyword và field----
                              if(!empty($ssFilter['keywords'])){
                                 
                                 $select->where('re.id ='.$ssFilter['keywords']);   
                                
                              }
                              //-------Lọc theo thành phố-------
                              if(!empty($ssFilter['city'])){
                                 $select->where('re.city ='.$ssFilter['city']);            
                              }
                               //-------Lọc theo quận huyện-------
                              if(!empty($ssFilter['district'])){
                                 $select->where('re.district ='.$ssFilter['district']);            
                              }
                              //-------Lọc theo status--------------
                              if(!empty($ssFilter['status'])){
                                 $select->where('re.status ='.$ssFilter['status']);
                              }
                              //-------Lọc theo loại tin--------------
                              if(!empty($ssFilter['type_news'])){
                                 $select->where('re.type_news ='.$ssFilter['type_news']);
                              }
                              //-------Lọc theo loại giao dịch--------------
                              if(!empty($ssFilter['type_transaction'])){
                                 $select->where('re.transaction ='.$ssFilter['type_transaction']);
                              }
                              //-------Lọc theo loại bất động sản--------------
                              if(!empty($ssFilter['type_real_estate'])){
                                 $select->where('re.cat_id ='.$ssFilter['type_real_estate']);
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
      if($options['task'] == 'count-favorite'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('f' => 'favorite_real_estate'))
                              ->columns(array('count'    => new Expression('COUNT(f.id)')));
                              
                              $select->where('user_id = '.$arrParam['userId']);
                                                      
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
      if($options['task'] == 'list-items'){

         return $this->tableGateway->select(function(Select $select) use ($arrParam){
            $select->columns(array('id','username','avatar'));
                   //->join(array('ug'=>'user_group'),'ug.id = users.group_id',array('group_name'),$select::JOIN_LEFT
                  //   );
                  //->where->equalTo('email',$arrParam['my-email']);

         });
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
                  array('r_status' => 'real_estate_status'),
                  'r_status.id = re.status',
                  array('name_status' => 'name'),
                  $select::JOIN_LEFT
               )

               ->order('status DESC')
               ->order('date_modifi DESC')

               ->limit($paginator['itemCountPerPage'])
               ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
               $select->where('re.user_id ='.$arrParam['userId']); 
               if(!empty($arrParam['staffId']) && $arrParam['staffId'] != 0){
                  $select->where('re.user_id ='.$arrParam['staffId']);   
               }
               //if(!empty($arrParam['parent']) && $arrParam['parent'] != 0){
               //   $select->where('re.user_id ='.$arrParam['parent'], \Zend\Db\Sql\Predicate\Predicate::OP_OR);   
              // }

               //Lọc theo nhân viên
               if(!empty($arrParam['staff'])){
                  $select->where('re.user_id IN('.$arrParam['staff'].')', \Zend\Db\Sql\Predicate\Predicate::OP_OR);   
               }
               
                //-------Lọc theo keyword và field----
               if(!empty($ssFilter['keywords'])){
                  
                  $select->where('re.id ='.$ssFilter['keywords']);   
                 
               }
               //-------Lọc theo thành phố-------
               if(!empty($ssFilter['city'])){
                  $select->where('re.city ='.$ssFilter['city']);            
               }
                //-------Lọc theo quận huyện-------
               if(!empty($ssFilter['district'])){
                  $select->where('re.district ='.$ssFilter['district']);            
               }
               //-------Lọc theo status--------------
               if(!empty($ssFilter['status'])){
                  $select->where('re.status ='.$ssFilter['status']);
               }
               //-------Lọc theo loại tin--------------
               if(!empty($ssFilter['type_news'])){
                  $select->where('re.type_news ='.$ssFilter['type_news']);
               }
               //-------Lọc theo loại giao dịch--------------
               if(!empty($ssFilter['type_transaction'])){
                  $select->where('re.transaction ='.$ssFilter['type_transaction']);
               }
               //-------Lọc theo loại bất động sản--------------
               if(!empty($ssFilter['type_real_estate'])){
                  $select->where('re.cat_id ='.$ssFilter['type_real_estate']);
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
      if($options['task'] == 'list-items-paginator-favorite'){

         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('re' => 'real_estate'))
               ->join(
                  array('far' => 'favorite_real_estate'),
                  'far.real_estate_id = re.id',
                  array('user_id_favorite'=>'user_id'),
                  $select::JOIN_LEFT
               )
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
               ->order('status DESC')
               ->order('date_modifi DESC')

               ->limit($paginator['itemCountPerPage'])
               ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage'])
               ->where('far.user_id ='.$arrParam['userId']);   
                 
               
              
              
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         return $result;




        
      }
      if($options['task'] == 'list-view-bds'){

        
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('re' => 'real_estate_view'))
               ->order('id DESC')
               ->where('re.real_estate_id ='.$arrParam['real_estate_id']);   
               if(!empty($arrParam['date_time'])){
                  $select->where('re.date_time = "'.$arrParam['date_time'].'"');   
               }        
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         return $result;
        
      }

      if($options['task'] == 'list-TransactionHistory'){

        
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('t' => 'transaction_history'))
               ->join(
                  array('ty' => 'type_news'),
                  'ty.id = t.type_news',
                  array('name_type' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('u' => 'users'),
                  'u.id = t.user_id',
                  array('fullname'),
                  $select::JOIN_LEFT
               )
               ->where('t.service_id ='.$arrParam['real_estate_id']);   
                      
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         return $result;
        
      }

      if($options['task'] == 'list-register-email'){

        
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('r' => 'register_email'));
               
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
      if($options == null){
         $row = $this->tableGateway->select(function (Select $select) use($arrParam){
            $select->columns(array('id','username','fullname','email','birth'));
            $select->where->equalTo('id',$arrParam['id']);
         })->current();

         if(empty($row)) return false;
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
      if($options['task'] == 'staff'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('users')
                              ->columns(array('id'))
                              ->where('parent = "'.$arrParam['id'].'"');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         
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
      if($options['task'] == 'save-history-transaction'){
         $sqlObj     = new \Zend\Db\Sql\Sql($this->adapter);
         $insertObj  = $sqlObj->insert('transaction_history');
         $insertObj->values($arrParam);
         
         $sqlString  = $sqlObj->getSqlStringForSqlObject($insertObj);
         $this->adapter->query($sqlString)->execute();
      }
      if($options['task'] == 'update-info-user'){
         
         $sqlObj     = new \Zend\Db\Sql\Sql($this->adapter);
         $updateObj  = $sqlObj->update('users');
         $updateObj->set($arrParam);
         $updateObj->where('id = '.$arrParam['id']);
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