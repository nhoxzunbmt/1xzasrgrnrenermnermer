<?php
namespace Admin\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Expression;
class SitesTable{
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
         $ssFilter   = $arrParam['ssFilter'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city')
                              ->columns(array('count'    => new Expression('COUNT(id)')));
                               //-------Lọc theo keyword và field----
                              if(!empty($ssFilter['keywords']) && !empty($ssFilter['field'])){
                                 $keywords = '%' . $ssFilter['keywords'] . '%';
                                 $select->where->like($ssFilter['field'], $keywords);
                              }
                             
                             
                              //-------Lọc theo status--------------
                              if(!empty($ssFilter['status'])){
                                 $select->where->equalTo('status',$ssFilter['status']);
                              }
                              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }
      if($options['task'] == 'district'){
         $ssFilter   = $arrParam['ssFilter'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city_district')
                              ->columns(array('count'    => new Expression('COUNT(id)')))
                              ->where('city_id = '.$arrParam['idCity']);
                               //-------Lọc theo keyword và field----
                              if(!empty($ssFilter['keywords']) && !empty($ssFilter['field'])){
                                 $keywords = '%' . $ssFilter['keywords'] . '%';
                                 $select->where->like($ssFilter['field'], $keywords);
                              }
                             
                             
                              //-------Lọc theo status--------------
                              if(!empty($ssFilter['status'])){
                                 $select->where->equalTo('status',$ssFilter['status']);
                              }
                              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }

      if($options['task'] == 'ward'){
         $ssFilter   = $arrParam['ssFilter'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city_district_ward')
                              ->columns(array('count'    => new Expression('COUNT(id)')))
                              ->where('district_id = '.$arrParam['idWard']);
                               //-------Lọc theo keyword và field----
                              if(!empty($ssFilter['keywords']) && !empty($ssFilter['field'])){
                                 $keywords = '%' . $ssFilter['keywords'] . '%';
                                 $select->where->like($ssFilter['field'], $keywords);
                              }
                             
                             
                              //-------Lọc theo status--------------
                              if(!empty($ssFilter['status'])){
                                 $select->where->equalTo('status',$ssFilter['status']);
                              }
                              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }
   }
   public function listItem($arrParam = null,$options = null){
      
     
      if($options['task'] == 'list-items-paginator'){
         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from('city')
              
              
               ->limit($paginator['itemCountPerPage'])
               ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         return $result;
      }

      if($options['task'] == 'list-items-paginator-district'){
         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from('city_district')
                  ->where('city_id = '.$arrParam['idCity'])
              
               ->limit($paginator['itemCountPerPage'])
               ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         return $result;
      }

      if($options['task'] == 'list-items-paginator-ward'){
         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from('city_district_ward')
                  ->where('district_id = '.$arrParam['idWard'])
              
               ->limit($paginator['itemCountPerPage'])
               ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         return $result;
      }
   }

   public function getItem($arrParam = null, $options = null){
      if($options['task'] == 'get-item'){
         $row = $this->tableGateway->select(array('id'=>$arrParam['id']))->current();
         if(empty($row)) return false;
         return $row;
      }
      if($options['task'] == 'district'){

         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city_district');
                  
                              $select->where('city_district.id ='.$arrParam['id']);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);                      
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0];
         return $result;
      }

      if($options['task'] == 'ward'){

         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city_district_ward');
                  
                              $select->where('city_district_ward.id ='.$arrParam['id']);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);                      
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0];
         return $result;
      }
      
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
      if($options['task'] == 'edit-district'){
         $data = array(
                  'name'=>$arrParam['name'],
                  );
         
         $sqlObj     = new Sql($this->adapter);
         $updateObj  = $sqlObj->update('city_district');
         $updateObj->set($data);
         $updateObj->where('id = '.$arrParam['id']);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($updateObj);
         $this->adapter->query($sqlString)->execute();
      }
      if($options['task'] == 'edit-ward'){
         $data = array(
                  'name'=>$arrParam['name'],
                  );
         
         $sqlObj     = new Sql($this->adapter);
         $updateObj  = $sqlObj->update('city_district_ward');
         $updateObj->set($data);
         $updateObj->where('id = '.$arrParam['id']);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($updateObj);
         $this->adapter->query($sqlString)->execute();
      }
      if($options['task'] == 'add-district'){
         $data = array(
                     'city_id'=>$arrParam['id'],
                     'name'=>$arrParam['name'],
                     );

         $sqlObj     = new Sql($this->adapter);
         $insertObj  = $sqlObj->insert('city_district');
         $insertObj->values($data);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($insertObj);
         $this->adapter->query($sqlString)->execute();   
      }

      if($options['task'] == 'add-ward'){
         $data = array(
                     'district_id'=>$arrParam['id'],
                     'name'=>$arrParam['name'],
                     );

         $sqlObj     = new Sql($this->adapter);
         $insertObj  = $sqlObj->insert('city_district_ward');
         $insertObj->values($data);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($insertObj);
         $this->adapter->query($sqlString)->execute();   
      }
   }

   public function deleteItem($arrParam = null,$options = null){
      if($options['task'] == 'delete-item'){
         $this->tableGateway->delete(array('id'=>$arrParam['id']));

         
         //Xóa xã, phường của quận. huyện
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from('city_district')
                     ->where('city_id = '.$arrParam['id']);
                        
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         foreach($result as $value){
            
            $deleteObj  = $sqlObj ->delete('city_district_ward');
            $deleteObj->where(
            new \Zend\Db\Sql\Predicate\In('district_id', array($value['id']))      
            );

            $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
            $this->adapter->query($sqlString)->execute();
         }


         //Xóa quận, huyện của thành phố
         $sqlObj     = new Sql($this->adapter);
         $deleteObj  = $sqlObj ->delete('city_district');
         $deleteObj->where(
         new \Zend\Db\Sql\Predicate\In('city_id', array($arrParam['id']))      
         );

         $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
         $this->adapter->query($sqlString)->execute();



      }
      if($options['task'] == 'delete-item-ward'){
         $sqlObj     = new Sql($this->adapter);
         $deleteObj  = $sqlObj ->delete('city_district_ward');
         $deleteObj->where(
         new \Zend\Db\Sql\Predicate\In('id', array($arrParam['id']))      
         );

         $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
         $this->adapter->query($sqlString)->execute();
      }

      if($options['task'] == 'delete-item-district'){
         $sqlObj     = new Sql($this->adapter);
         $deleteObj  = $sqlObj ->delete('city_district');
         $deleteObj->where(
         new \Zend\Db\Sql\Predicate\In('id', array($arrParam['id']))      
         );

         $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
         $this->adapter->query($sqlString)->execute();

         //Xóa xã, phường của quận. huyện
         $deleteObj  = $sqlObj ->delete('city_district_ward');
         $deleteObj->where(
         new \Zend\Db\Sql\Predicate\In('district_id', array($arrParam['id']))      
         );

         $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
         $this->adapter->query($sqlString)->execute();

      }
   }

}