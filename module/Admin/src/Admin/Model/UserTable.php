<?php
namespace Admin\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class UserTable{
   protected $tableGateway;
   protected $adapter;

   public function __construct(TableGateway $tableGateway){
      $this->tableGateway = $tableGateway;
      $this->adapter = GlobalAdapterFeature::getStaticAdapter();
   }

   public function itemInselectBox($arrParam = null,$options = null){
      if($options['task'] == 'list-item-city'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city')
                              ->columns(array('id', 'name'));
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $default[]  = array('id'=>'','name'=>'--Thành phố--');
         $result     = array_merge($default,$result);
         return $result;
      }
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
      
      if($options['task'] == 'list-items'){

         return $this->tableGateway->select(function(Select $select) use ($arrParam){
            $select->columns(array('id','username','avatar'));
                   //->join(array('ug'=>'user_group'),'ug.id = users.group_id',array('group_name'),$select::JOIN_LEFT
                  //   );
                  //->where->equalTo('email',$arrParam['my-email']);

         });
      }
      if($options['task'] == 'list-items-paginator'){
         return $this->tableGateway->select(function(Select $select) use ($arrParam){
            $paginator  = $arrParam['paginator'];
            $ssFilter   = $arrParam['ssFilter'];
            
            $select->columns(array('id','username','avatar','register_date','status','group_id','email','order','banned'));
            $select->limit($paginator['itemCountPerPage']);
            $select->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
           
            //-------Lọc theo keyword và field----
            if(!empty($ssFilter['keywords']) && !empty($ssFilter['field'])){
               $keywords = '%' . $ssFilter['keywords'] . '%';
               $select->where->like($ssFilter['field'], $keywords);
            }
            //-------Lọc theo thành phố-------
            if(!empty($ssFilter['city'])){
               $select->where->equalTo('city_id',$ssFilter['city']);            
            }
            //-------Lọc theo nhóm------------
            if(!empty($ssFilter['group'])){
               $select->where->equalTo('group_id',$ssFilter['group']);  
            }
            //-------Lọc theo status--------------
            if(!empty($ssFilter['status'])){
               $select->where->equalTo('status',$ssFilter['status']);
            }
            //------Sap xep theo cot-------------
            if(!empty($ssFilter['col']) && !empty($ssFilter['order'])){              
               $select->order(array($ssFilter['col'] . ' ' . $ssFilter['order']));
            }

         });
      }
      

   }

   public function getItem($arrParam = null, $options = null){
      if($options['task'] == 'get-item'){
         $row = $this->tableGateway->select(array('id'=>$arrParam['id']))->current();
         if(empty($row)) return false;
      }
      if($options == null){
         $row = $this->tableGateway->select(function (Select $select) use($arrParam){
            $select->columns(array('id','username','fullname','email','birth'));
            $select->where->equalTo('id',$arrParam['id']);
         })->current();

         if(empty($row)) return false;
      }
      if($options['task'] == 'get-item-with-id'){

         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('u'=>'user_ban'))
                              ->columns(array(
                                 'nguyennhan'
                              ));
                              $select->where('u.user_id ='.$arrParam['id']);   
               
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = !empty($result) ? $result[0] : '';
         return $result;
      }
      if($options['task'] == 'get-item-with-ip'){

         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('u'=>'user_ban'))
                              ->columns(array(
                                 'nguyennhan'
                              ));   
                              $select->where('u.ip = "'.$arrParam['ip'].'"');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = !empty($result) ? $result[0] : '';
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
      if($options['task'] == 'ban'){
         //add ban
         $data = array(
            'user_id'      =>$arrParam['user_id'],
            'ip'           =>$arrParam['ip'],
            'nguyennhan'   =>$arrParam['nguyennhan'],
         );

         $sqlObj     = new Sql($this->adapter);
         $insertObj  = $sqlObj->insert('user_ban');
         $insertObj->values($data);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($insertObj);
         $this->adapter->query($sqlString)->execute();  


         //update user
         $dataUser = array(
            'banned'=>$arrParam['banned'],
         );
         
         $sqlObj     = new Sql($this->adapter);
         $updateObj  = $sqlObj->update('users');
         $updateObj->set($dataUser);
         $updateObj->where('id = '.$arrParam['user_id']);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($updateObj);
         $this->adapter->query($sqlString)->execute();

      }

      if($options['task'] == 'un-ban'){
         
         //update user
         $dataUser = array(
            'banned' => 'false',
         );
         
         $sqlObj     = new Sql($this->adapter);
         $updateObj  = $sqlObj->update('users');
         $updateObj->set($dataUser);
         $updateObj->where('id = '.$arrParam['id']);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($updateObj);
         $this->adapter->query($sqlString)->execute();

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

      if($options['task'] == 'un-ban'){
         $sqlObj     = new Sql($this->adapter);
         $deleteObj  = $sqlObj ->delete('user_ban');
         $deleteObj->where(
         new \Zend\Db\Sql\Predicate\In('user_id', array($arrParam['id']))      
         );

         $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
         $this->adapter->query($sqlString)->execute();


      }
   }

}