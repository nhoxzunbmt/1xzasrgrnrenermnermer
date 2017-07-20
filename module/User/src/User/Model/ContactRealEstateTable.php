<?php
namespace User\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate;
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
      if($options['task'] == 'list-item-group'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('user_group')
                              ->columns(array('id','name'=>'group_name'))
                              ->where('group_default = 1');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $default[]  = array('id'=>'','name'=>'--Nhóm--');
         $result     = array_merge($default,$result);
         return $result;
      }
   }

   public function countItem($arrParam = null,$options = null){
       if($options == null){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('b' => 'contact_real_estate'))
                              ->columns(array('count'    => new Expression('COUNT(b.id)')));
                              
                              $select->where('user_id = '.$arrParam['user_id']);
                                                      
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
          

               ->limit($paginator['itemCountPerPage'])
               ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
               $select->where('c.user_id ='.$arrParam['user_id']);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         return $result;
      }
      

   }

   public function getItem($arrParam = null, $options = null){
      if($options['task'] == 'get-item'){
         
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
                              $select->where('contact_real_estate.id ='.$arrParam['id']);
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
   }

}