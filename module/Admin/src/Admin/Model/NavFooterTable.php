<?php
namespace Admin\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Predicate\Like;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Where;

class NavFooterTable extends NestedTable{
   protected $tableGateway;
   protected $adapter;
  
   public function __construct(TableGateway $tableGateway){
      $this->tableGateway = $tableGateway;
      $this->adapter = GlobalAdapterFeature::getStaticAdapter();
   }

   
   public function itemInselectBox($arrParam = null,$options = null){
      if($options['task'] == 'list-level'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('nav_footer')
                              ->columns(array('id','level'))
                              ->order('level DESC')
                              ->limit(1);
                              

         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $items     = $this->adapter->query($sqlString)->execute();
         foreach ($items as $key => $item) {
           $item = $item;
         }
        
         $result = array();
         if(!empty($item)){
            for($i = 1;$i <= $item['level'];$i++){
               $result[$i] = array('id'=>$i,'name'=>'Level '.$i );
            }
         }

         $default[]  = array('id'=>'','name'=>'--Level--');
         $result     = array_merge($default,$result);
         
      }

      if($options['task'] == 'list-item'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('nav_footer')
                              ->columns(array('id','name','level'))
                              ->order('left ASC');
                              
                             
         $items     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         
         $result = array();
         if(!empty($items)){
            foreach ($items as $item) {
               $result[$item['id']]   = array('id'=>$item['id'],'name'=>str_repeat('------', $item['level']) . ' ' . $item['name']);
            }
         }

         $default[]  = array('id'=>'','name'=>'--Danh mục--');
         
         $result     = array_merge($default,$result);
         
      }

      return $result;


   }

   public function countItem($arrParam = null,$options = null){
      if($options == null){
         $ssFilter   = $arrParam['ssFilter'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('nav_footer')
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
                              //-------Lọc theo status--------------
                              if(!empty($ssFilter['level'])){
                                 $select->where->equalTo('level',$ssFilter['level']);
                              }
                              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         
         $result = $result[0]['count'];
                  
         return $result;
      }
   }
   public function listItem($arrParam = null,$options = null){
      
      if($options['task'] == 'list-item'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('nav_footer')
                              ->columns(array('id','name','url'))
                              ->order('id ASC');
                              
                             
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         
         
         
      }
      if($options['task'] == 'list-items-paginator'){
         

         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('menu'=>'nav_footer'));
                              $select->join(
                                 array('mt'=>'nav_footer'),
                                 'menu.parent = mt.id',
                                 array('pleft'=>'left','pright'=>'right'),
                                 $select::JOIN_LEFT 
                              );
         
         $select->limit($paginator['itemCountPerPage']);
         $select->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
         $select->where('menu.level > 0');
        
         //-------Lọc theo keyword và field----
         if(!empty($ssFilter['keywords']) && !empty($ssFilter['field'])){
            $keywords = '%' . $ssFilter['keywords'] . '%';
            $select->where->like('menu.'.$ssFilter['field'], $keywords);
         }
        
         //-------Lọc theo status--------------
         if(!empty($ssFilter['status'])){
            $select->where->equalTo('status',$ssFilter['status']);
         }
         //------Sap xep theo cot-------------
         if(!empty($ssFilter['col']) && !empty($ssFilter['order'])){              
            $select->order(array('menu.'.$ssFilter['col'] . ' ' . $ssFilter['order']));
         }
         //-------Lọc theo level--------------
         if(!empty($ssFilter['level'])){
            $select->where->equalTo('menu_test.level',$ssFilter['level']);
         }
         $select->order('menu.left ASC');
                                    
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
        
      }
      return $result;
   }

   public function moveItem($arrParam = null, $options = null){
      if($options['task'] == 'up'){
         $this->moveUp($arrParam['id']);
      }
      if($options['task'] == 'down'){
         $this->moveDown($arrParam['id']);
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
                              ->from(array('c'=>'nav_footer'));
                              $select->where('c.id ='.$arrParam['id']);   
               
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = $result[0];
         return $result;
      }
      return $row;
   }

   public function saveItem($arrParam = null,$options = null){
      
      if($options['task'] == 'add'){
         $this->insertNode($arrParam,$arrParam['parent'],array('position'=>'right'));
      }
      if($options['task']  == 'edit'){
         $data    =  array(
            'id'              => $arrParam['id'], 
            'name'            => $arrParam['name'],
            'description'     => $arrParam['description'],
            'status'          => $arrParam['status'],
            'modified'        => $arrParam['modified'],
            'modified_by'     => $arrParam['modified_by'],
            'url'             => $arrParam['url'],
         );
         if($arrParam['parent'] == $arrParam['id']) $arrParam['parent'] = null;
         $this->updateNode($data,$arrParam['id'],$arrParam['parent']);
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
      if($options['task'] == 'delete-item'){
         $this->removeNode($arrParam['id'],array('type'=>'only'));
      }
      if($options['task'] == 'multi-delete-item'){
         if(!empty($arrParam)){
            foreach ($arrParam as $key => $value) {
               $this->removeNode($value,array('type'=>'only'));
            }
            
         } 
      }
   }

}