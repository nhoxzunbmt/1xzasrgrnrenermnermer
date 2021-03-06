<?php
namespace Admin\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Expression;
class ContactRealEstateTable{
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
                              ->from('contact_real_estate')
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
   }
   public function listItem($arrParam = null,$options = null){
      
     
      if($options['task'] == 'list-items-paginator'){
         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('c' => 'contact_real_estate'))
               ->join(
                  array('r' => 'real_estate'),
                  'r.id = c.real_estate_id',
                  array('rid' => 'id','rcat_id'=>'cat_id','title','images'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('retype' => 'category'),
                  'retype.id = r.cat_id',
                  array('name_type' => 'name'),
                  $select::JOIN_LEFT
               )
               ->join(
                  array('u' => 'users'),
                  'u.id = c.user_id',
                  array('fullname_contact' => 'fullname'),
                  $select::JOIN_LEFT
               )
          

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
      }
      if($options == null){

         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('contact_real_estate');
                              $select->join(
                                 array('r' => 'real_estate'),
                                 'r.id = contact_real_estate.real_estate_id',
                                 array('rid' => 'id','rcat_id'=>'cat_id','title','images'),
                                 $select::JOIN_LEFT
                              );
                              $select->join(
                                 array('retype' => 'category'),
                                 'retype.id = r.cat_id',
                                 array('name_type' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->join(
                                 array('u' => 'users'),
                                 'u.id = contact_real_estate.user_id',
                                 array('fullname_contact' => 'fullname'),
                                 $select::JOIN_LEFT
                              );
                              $select->where('contact_real_estate.id ='.$arrParam['id']);
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0];
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
   }

   public function deleteItem($arrParam = null,$options = null){
      if($options['task'] == 'delete-item'){
         $this->tableGateway->delete(array('id'=>$arrParam['id']));
      }
   }

}