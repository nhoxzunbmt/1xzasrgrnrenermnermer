<?php
namespace Admin\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Expression;
class ContractFormTable{
   protected $tableGateway;
   protected $adapter;

   public function __construct(TableGateway $tableGateway){
      $this->tableGateway = $tableGateway;
      $this->adapter = GlobalAdapterFeature::getStaticAdapter();
   }

   public function itemInselectBox($arrParam = null,$options = null){
     
      if($options['task'] == 'list-item-category'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->columns(array('id', 'name','parents'=>'parent'))
                              ->where('type = "category_contractform"');
         $resultRoot[]  = array('id'=>1,'name'=>'Root','parents'=>0);
         $result  = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = array_merge($resultRoot,$result);
         
         $system = new \ZendVN\System\Recursive($result);
         $result = $system->buildArray(0);
         $default[]  = array('id'=>'','name'=>'Danh mục','level'=>1);
         $result     = array_merge($default,$result);
         return $result;
      }
      
   }

   public function countItem($arrParam = null,$options = null){
      if($options == null){
         return $this->tableGateway->select()->count();
      }
      if($options['task'] == 'count-item'){
         $ssFilter   = $arrParam['ssFilter'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('contract_forms')
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

     
      
      if($options['task'] == 'list-items-paginator'){
         return $this->tableGateway->select(function(Select $select) use ($arrParam){
            $paginator  = $arrParam['paginator'];
            $ssFilter   = $arrParam['ssFilter'];
            
          
            $select->limit($paginator['itemCountPerPage']);
            $select->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
           
            //-------Lọc theo keyword và field----
            if(!empty($ssFilter['keywords']) && !empty($ssFilter['field'])){
               $keywords = '%' . $ssFilter['keywords'] . '%';
               $select->where->like($ssFilter['field'], $keywords);
            }
           
            //-------Lọc theo nhóm------------
            if(!empty($ssFilter['group'])){
               $select->where->equalTo('type_business',$ssFilter['group']);  
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

         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('c'=>'contract_forms'));
                             
                              $select->join(
                                 array('cat' => 'category'),
                                 'cat.id = c.cat_id',
                                 array('name_category' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              
                              $select->where('c.id ='.$arrParam['id']);   
               
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