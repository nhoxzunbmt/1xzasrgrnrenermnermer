<?php
namespace Admin\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class SurveyTable{
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

   }
   public function listItem($arrParam = null,$options = null){
      
      if($options == null){
         $result = $this->tableGateway->select();
         $result->buffer();
         return  $result;
      }

     
      if($options['task'] == 'list-item-answer'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('s'=>'survey_detail'))
                              ->where('survey_id = '.$arrParam['id']);
                                  
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
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
      

   }

   public function getItem($arrParam = null, $options = null){
      if($options['task'] == 'get-item'){
         $row = $this->tableGateway->select(array('id'=>$arrParam['id']))->current();
         if(empty($row)) return false;
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
         return $this->tableGateway->lastInsertValue;
      }
      if($options['task'] == 'add-answer'){
         $sqlObj     = new Sql($this->adapter);
         $option = $arrParam['options'];
         if(count($option > 0)){
            foreach($option as $value){
               $dataSurvey = array(
                  'survey_id' => $arrParam['survey_id'],
                  'answer'    => $value,
               );
               $insertObj  = $sqlObj->insert('survey_detail');
               $insertObj->values($dataSurvey);
               $sqlString  = $sqlObj->getSqlStringForSqlObject($insertObj);
               $this->adapter->query($sqlString)->execute();
                          
            }
         }  
         
      }

      if($options['task'] == 'edit-answer'){
         $sqlObj     = new Sql($this->adapter);
         $option = $arrParam['options'];
         if(count($option > 0)){
            foreach($option as $key => $value){
               $dataSurvey = array(
                  'survey_id' => $arrParam['survey_id'],
                  'answer'    => $value,
               );
               $updateObj  = $sqlObj->update('survey_detail');
               $updateObj->set($dataSurvey);
               $updateObj->where('id = '.$key);
               $sqlString  = $sqlObj->getSqlStringForSqlObject($updateObj);
               $this->adapter->query($sqlString)->execute();
                          
            }
         }  

           
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

         $sqlObj     = new Sql($this->adapter);
         $deleteObj  = $sqlObj->delete('survey_detail');
         $deleteObj->where('survey_id = '.$arrParam['id']);      
         $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
         $this->adapter->query($sqlString)->execute();
      }
      if($options['task'] == 'multi-delete-item'){
         if(!empty($arrParam)){
            foreach ($arrParam as $key => $value) {
               $this->tableGateway->delete(array('id'=>$value));
               $sqlObj     = new Sql($this->adapter);
               $deleteObj  = $sqlObj->delete('survey_detail');
               $deleteObj->where('survey_id = '.$value);      
               $sqlString  = $sqlObj->getSqlStringForSqlObject($deleteObj);
               $this->adapter->query($sqlString)->execute();
            }
            
         } 
      }
   }

}