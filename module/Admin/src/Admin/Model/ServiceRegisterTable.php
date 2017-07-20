<?php
namespace Admin\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class ServiceRegisterTable{
   protected $tableGateway;
   protected $adapter;

   public function __construct(TableGateway $tableGateway){
      $this->tableGateway = $tableGateway;
      $this->adapter = GlobalAdapterFeature::getStaticAdapter();
   }

   public function itemInselectBox($arrParam = null,$options = null){
      
      
   }

   public function countItem($arrParam = null,$options = null){
      if($options == null){
         return $this->tableGateway->select()->count();
      }

   }
   public function listItem($arrParam = null,$options = null){
      
      if($options == null){
         $result = $this->tableGateway->select();
         $result->buffer();
         return  $result;
      }

     
      
      if($options['task'] == 'list-items-paginator'){
         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('s'=>'service_account_register'));
                              $select->join(
                                 array('u'=>'users'),
                                 's.user_id = u.id',
                                 array('fullname','phone','website','email'),
                                 $select::JOIN_LEFT 
                              );
                              $select->join(
                                 array('sa'=>'service_account'),
                                 's.service_account_id = sa.id',
                                 array('name'),
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
      if($options == null){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select     = $sqlObj->select()
                              ->from(array('s'=>'service_account_register'));
                              $select->join(
                                 array('u'=>'users'),
                                 's.user_id = u.id',
                                 array('fullname','phone','website','email'),
                                 $select::JOIN_LEFT 
                              );
                              $select->join(
                                 array('sa'=>'service_account'),
                                 's.service_account_id = sa.id',
                                 array('name','normal','vip','hot','free','chinhchu','price'),
                                 $select::JOIN_LEFT 
                              );
           
               $select->where('s.id ='.$arrParam['id']);   
               
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
      if($options['task'] == 'upgrade'){
         $sqlObj     = new Sql($this->adapter);
         $updateObj  = $sqlObj->update('users');
         $updateObj->set($arrParam);
         $updateObj->where('id = '.$arrParam['id']); 
         $sqlString  = $sqlObj->getSqlStringForSqlObject($updateObj);
         $this->adapter->query($sqlString)->execute();
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