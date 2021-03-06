<?php
namespace Home\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Predicate\Like;
use Zend\Db\Sql\Expression;

class ContractFormTable{
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
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                               ->from(array('c'=>'contract_forms'))
                              ->columns(array('count'    => new Expression('COUNT(id)')));
                              if(!empty($arrParam['cat_id'])){
                                 $select->where('c.cat_id = '.$arrParam['cat_id']);
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
      if($options['task'] == 'list-category'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('cat'=>'category'))
                              ->columns(array(
                                 'id','name'
                              ))
                              ->where('type = "category_contractform"');
                              $select->order('id ASC');
                            

         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }
     

      
      if($options['task'] == 'list-items-paginator'){

         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('c'=>'contract_forms'));
             
               $select->join(
                  array('cat' => 'category'),
                  'cat.id = c.cat_id',
                  array('name_category' => 'name'),
                  $select::JOIN_LEFT
               );
               $select->limit($paginator['itemCountPerPage']);
               $select->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
               if(!empty($arrParam['cat_id'])){
                  $select->where('c.cat_id = '.$arrParam['cat_id']);
               } 
                          
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();

         return $result;

      }
      


      

   }
   
   public function getItem($arrParam = null, $options = null){
      
      if($options['task'] == 'category-frontend') {
         return $result  = $this->tableGateway->select(function (Select $select) use ($arrParam){
            $select->columns(array('id', 'name', 'description', 'left', 'right'))
                  ->where->equalTo('id', $arrParam['id']);
            ;
         })->current();
         
      }

      if($options['task'] == 'get-item'){
         $row = $this->tableGateway->select(array('id'=>$arrParam['id']))->current();
         if(empty($row)) return false;
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