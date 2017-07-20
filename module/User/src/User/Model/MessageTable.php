<?php
namespace User\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Predicate\Like;
use Zend\Db\Sql\Expression;

class MessageTable{
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
      if($options['task'] == 'count-hop-thu-di'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('m' => 'message_send'))
                              ->columns(array('count'    => new Expression('COUNT(m.id)')));
                              
                              $select->where('m.user_id_send ='.$arrParam['idUser']); 
                                                      
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                       
         return $result;
      }
      if($options['task'] == 'count-hop-thu-den'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('m' => 'message_receive'))
                              ->columns(array('count'    => new Expression('COUNT(m.id)')));
                              
                              $select->where('m.user_id_receive ='.$arrParam['idUser']); 
                                                      
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                       
         return $result;
      }
      
   }
   public function listItem($arrParam = null,$options = null){
      
      
      if($options['task'] == 'list-item-hop-thu-di'){
         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('m' => 'message_send'))
               
               ->join(
                  array('u' => 'users'),
                  'u.id = m.user_id_receive',
                  array('fullname'=>'fullname'),
                  $select::JOIN_LEFT
               )

               ->limit($paginator['itemCountPerPage'])
               ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
               $select->where('m.user_id_send ='.$arrParam['idUser']); 

              
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         return $result;

      }

      if($options['task'] == 'list-item-hop-thu-den'){
         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('m' => 'message_receive'))
               
               ->join(
                  array('u' => 'users'),
                  'u.id = m.user_id_send',
                  array('fullname'=>'fullname'),
                  $select::JOIN_LEFT
               )

               ->limit($paginator['itemCountPerPage'])
               ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
               $select->where('m.user_id_receive ='.$arrParam['idUser']); 

              
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

      if($options['task'] == 'view-send'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('message_send');
                              $select->join(
                                 array('u' => 'users'),
                                 'u.id = message_send.user_id_receive',
                                 array('fullname'=>'fullname'),
                                 $select::JOIN_LEFT
                              );
                              $select->where('message_send.id ='.$arrParam['id']);
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0];
         return $result;
      }

      if($options['task'] == 'view-receive'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('message_receive');
                              $select->join(
                                 array('u' => 'users'),
                                 'u.id = message_receive.user_id_send',
                                 array('fullname'=>'fullname'),
                                 $select::JOIN_LEFT
                              );
                              $select->where('message_receive.id ='.$arrParam['id']);
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0];
         return $result;
      }
      if($options['task'] == 'check-username'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('users')
                              ->columns(array('id'))
                              ->where('username ="'.$arrParam.'"');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         
         return $result;
      }
      
      
      return $row;
   }

   public function saveItem($arrParam = null,$options = null){
      if($options['task'] == 'user_send'){
         
         $data = array(
            'user_id_receive'=>$arrParam['user_id_nhan'],
            'name'=>$arrParam['name'],
            'content'=>$arrParam['content'],
            'date_time'=>$arrParam['date_time'],
            'user_id_send'=>$arrParam['user_id_send']
         );
         $sqlObj     = new \Zend\Db\Sql\Sql($this->adapter);
         $insertObj  = $sqlObj->insert('message_send');
         $insertObj->values($data);
         
         $sqlString  = $sqlObj->getSqlStringForSqlObject($insertObj);
         $this->adapter->query($sqlString)->execute();
      }

      if($options['task'] == 'user_receive'){
         
          $data = array(
            'user_id_send'=>$arrParam['user_id_send'],
            'name'=>$arrParam['name'],
            'content'=>$arrParam['content'],
            'date_time'=>$arrParam['date_time'],
            'user_id_receive'=>$arrParam['user_id_nhan'],
         );
         $sqlObj     = new \Zend\Db\Sql\Sql($this->adapter);
         $insertObj  = $sqlObj->insert('message_receive');
         $insertObj->values($data);
         
         $sqlString  = $sqlObj->getSqlStringForSqlObject($insertObj);
         $this->adapter->query($sqlString)->execute();
      }
      
   }

   public function deleteItem($arrParam = null,$options = null){
      if($options['task'] == 'delete-item'){
         $this->tableGateway->delete(array('id'=>$arrParam['id']));
      }
      if($options['task'] == 'multi-delete-item-message-send'){
         if(!empty($arrParam)){
            foreach ($arrParam as $key => $value) {

               $sqlObj     = new \Zend\Db\Sql\Sql($this->adapter);
               $deleteObj  = $sqlObj->delete('message_send');
               $deleteObj->where(
                  new \Zend\Db\Sql\Predicate\In('id', array($value))      
               );
               $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
               $this->adapter->query($sqlString)->execute();
            }
            
         } 
      }

      if($options['task'] == 'multi-delete-item-message-receive'){
         if(!empty($arrParam)){
            foreach ($arrParam as $key => $value) {

               $sqlObj     = new \Zend\Db\Sql\Sql($this->adapter);
               $deleteObj  = $sqlObj->delete('message_receive');
               $deleteObj->where(
                  new \Zend\Db\Sql\Predicate\In('id', array($value))      
               );
               $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
               $this->adapter->query($sqlString)->execute();
            }
            
         } 
      }

   }

  

}