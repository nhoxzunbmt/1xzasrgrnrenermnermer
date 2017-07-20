<?php
namespace Admin\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate;
class FileManagerTable{
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

       if($options['task'] == 'file'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                               ->from(array('m'=>'manager_file'))
                              ->columns(array('count'    => new Expression('COUNT(id)')))
                              ->where('m.folder_id = '.$arrParam['id']);
                                 
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

      if($options['task'] == 'list-items-paginator-file'){
         
         $paginator  = $arrParam['paginator'];
         $ssFilter   = $arrParam['ssFilter'];
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('mfile' => 'manager_file'))
               
               ->join(
                  array('mfolder' => 'manager_folder'),
                  'mfolder.id = mfile.folder_id',
                  array('name_folder' => 'name'),
                  $select::JOIN_LEFT
               )
               ->where('mfile.folder_id = '.$arrParam['id'])
               ->limit($paginator['itemCountPerPage'])
               ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
               //------Sap xep theo cot-------------
               if(!empty($ssFilter['col']) && !empty($ssFilter['order'])){              
                  $select->order(array($ssFilter['col'] . ' ' . $ssFilter['order']));
               }
               //-------Lọc theo keyword và field----
               if(!empty($ssFilter['keywords_file'])){
                  $keywords = '%' . $ssFilter['keywords_file'] . '%';
                  $select->where( new Predicate\Like('mfile.name', $keywords));
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
      if($options['task'] == 'file'){
          $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('mfile' => 'manager_file'))
               
               ->join(
                  array('mfolder' => 'manager_folder'),
                  'mfolder.id = mfile.folder_id',
                  array('name_folder' => 'name'),
                  $select::JOIN_LEFT
               )
               ->where('mfile.id ='.$arrParam['id']);   
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = (!empty($result)) ? $result[0] : '';
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
      if($options['task'] == 'save-file'){
         $sqlObj     = new Sql($this->adapter);
         $insertObj  = $sqlObj->insert('manager_file');
         $insertObj->values($arrParam);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($insertObj);
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
      if($options['task'] == 'delete-folder'){
         $this->tableGateway->delete(array('id'=>$arrParam['id']));
         $sqlObj     = new Sql($this->adapter);
         $deleteObj  = $sqlObj->delete('manager_file');
         $deleteObj->where('folder_id IN('.$arrParam['id'].')');      
         $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
         $this->adapter->query($sqlString)->execute();

      }
      if($options['task'] == 'multi-delete-item-file'){
         $sqlObj     = new Sql($this->adapter);
         $deleteObj  = $sqlObj->delete('manager_file');
         $deleteObj->where('id IN('.$arrParam['id'].')');      
          
         $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
         $this->adapter->query($sqlString)->execute();
      }

      if($options['task'] == 'list-file'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
          $select->from(array('mfile' => 'manager_file'))
               
               ->join(
                  array('mfolder' => 'manager_folder'),
                  'mfolder.id = mfile.folder_id',
                  array('name_folder' => 'name'),
                  $select::JOIN_LEFT
               );
         $select->where('mfile.id IN('.$arrParam['id'].')');
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();

         return $result;                        
      }
   }

}