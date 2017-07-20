<?php
namespace Home\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Predicate\Like;
use Zend\Db\Sql\Expression;
use \Admin\Model\NestedTable as NestedTable;

class NiceHouseTable extends NestedTable{
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
                               ->from(array('n'=>'nice_house'))
                              ->columns(array('count'    => new Expression('COUNT(id)')));
                              
                              if(!empty($arrParam['arrChildId'])){
                                 $select->where( new Predicate\In('n.cat_id', $arrParam['arrChildId']));
                              }
                                 
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }
      
      
     
   }
   public function listItem($arrParam = null,$options = null){
     
      if($options['task'] == 'list-breadcrumb') {
       

         $result  = $this->tableGateway->select(function (Select $select) use ($arrParam){
            $select->columns(array('id','name','level', 'parent'))
                  ->order('left ASC')
                  ->where->greaterThan('level', 0)
                  ->where->lessThanOrEqualTo('left', $arrParam->left)
                  ->where->greaterThanOrEqualTo('right', $arrParam->right)
            ;
         });
               
      }
      if($options['task'] == 'list-category'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('cat'=>'category'))
                              ->columns(array(
                                 'id','name'
                              ))
                              ->where('type = "category_nicehouse"');
                              if(!empty($arrParam['cat_id'])){
                                 $select->where('parent ='.$arrParam['cat_id']);
                              }

                              $select->order('id ASC');
                            

         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         
      }
      if($options['task'] == 'list-items-category'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('cat'=>'category'))
                              ->columns(array(
                                 'id','name'
                              ))
                              ->where('type = "category_nicehouse"');
                              $select->where('parent = 1');
                              $select->order('id ASC');
                              $select->limit(4);

                                   
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
        
      }

      if($options['task'] == 'list-items-news-moi-nhat'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('n'=>'nice_house'))
                              ->columns(array(
                                 'id','cat_id','title','description','content','images','status','date_time',
                                 'order'
                              ));
                              $select->join(
                                 array('cat' => 'category'),
                                 'cat.id = n.cat_id',
                                 array('name_category' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->order('id DESC');
                              $select->limit(5);
                              //$select->where('re.type_news = 3');
                                             
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         
      }
      if($options['task'] == 'list-items-paginator'){

         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('n'=>'nice_house'))
               ->columns(array(
                  'id','cat_id','title','description','content','images','status','date_time',
                  'order'
               ));
               $select->join(
                  array('cat' => 'category'),
                  'cat.id = n.cat_id',
                  array('name_category' => 'name'),
                  $select::JOIN_LEFT
               );
               $select->limit($paginator['itemCountPerPage']);
               $select->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
               
               if(!empty($arrParam['arrChildId'])){
                  $select->where( new Predicate\In('n.cat_id', $arrParam['arrChildId']));
               } 
                            
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();

         

      }
      if($options['task'] == 'statistics-type-nicehouse'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('n'=>'category'))
                              ->columns(array(
                                 'id','name'
                              ))
                              ->where('type = "category_nicehouse"');
                              $select->join(
                                 array('b' => 'nice_house'),
                                 'n.id = b.cat_id',
                                 array('count'    => new Expression('COUNT(b.id)')),
                                 $select::JOIN_LEFT
                              );
                              $select->group('n.id');
                              $select->where('parent = 1');

         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
                          
      }
      if($options['task'] == 'list-items-nicehouse'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('n'=>'nice_house'));
                              
                           
                              $select->join(
                                 array('cat' => 'category'),
                                 'cat.id = n.cat_id',
                                 array('name_category' => 'name'),
                                 $select::JOIN_LEFT
                              );
                             
                              //$select->where('n.cat_id = '.$arrParam['id']);
                              $select->limit(3);
                              $select->where( new Predicate\In('n.cat_id', $arrParam['arrChildId']));
                                
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
        
      }
      
      if($options['task'] == 'tin-tuong-tu'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
        $select->from(array('n'=>'nice_house'))
               ->columns(array(
                  'id','cat_id','title','description','content','images','status','date_time',
                  'order'
               ));
               $select->join(
                  array('cat' => 'category'),
                  'cat.id = n.cat_id',
                  array('name_category' => 'name'),
                  $select::JOIN_LEFT
               )
               ->order('id DESC');
            
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
      }

      return  $result;
      

   }
   public function recusive($arrParam = null, $options = null){
      if($options['task'] == 'list-child-of-parent-nice-house-cat'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->columns(array('id'))
                              ->where('type = "category_nicehouse"')
                              ->where('parent = '.$arrParam);

         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         
        
         $arrChildId = array();
         foreach ($result as $key => $value) {
            $arrChildId[] = $value['id'];
         }
         
         return $arrChildId;
        
      }
   }

   public function getItem($arrParam = null, $options = null){
      if($options['task'] == 'category-frontend') {
         $result  = $this->tableGateway->select(function (Select $select) use ($arrParam){
            $select->columns(array('id', 'name', 'description', 'left', 'right'))
                  ->where->equalTo('id', $arrParam['id']);
            ;
         })->current();
         return $result;
      }
   
      
      if($options['task'] == 'get-item'){
         $row = $this->tableGateway->select(array('id'=>$arrParam['id']))->current();
         if(empty($row)) return false;
      }
      if($options['task'] == 'get-item-find-parent-cat'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('real_estate_type')
                              ->columns(array('parent'))
                              ->where('id = '.$arrParam);
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }
      
      
      if($options == null){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('n'=>'nice_house'))
               ->columns(array(
                  'id','cat_id','title','description','content','images','status','date_time',
                  'order'
               ));
         $select->where('n.id ='.$arrParam['id']);   
         //echo $sqlString  = $sqlObj->getSqlStringForSqlObject($select);        
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = $result[0];
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