<?php
namespace Admin\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Expression;
class IndexTable{
   protected $tableGateway;
   protected $adapter;

   public function __construct(TableGateway $tableGateway){
      $this->tableGateway = $tableGateway;
      $this->adapter = GlobalAdapterFeature::getStaticAdapter();
   }

   public function itemInselectBox($arrParam = null,$options = null){
      
    
      
   }

   public function countItem($arrParam = null,$options = null){
      if($options['task'] == 'realestate'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('real_estate')
                              ->columns(array('count'    => new Expression('COUNT(id)')));
                              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }

      if($options['task'] == 'project'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('project')
                              ->columns(array('count'    => new Expression('COUNT(id)')));
                              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }

      if($options['task'] == 'business'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('business')
                              ->columns(array('count'    => new Expression('COUNT(id)')));
                              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }

      if($options['task'] == 'user'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('users')
                              ->columns(array('count'    => new Expression('COUNT(id)')));
                              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }

      if($options['task'] == 'contact'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('contact')
                              ->columns(array('count'    => new Expression('COUNT(id)')));
                              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }

      if($options['task'] == 'emailmaketing'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('email_marketing')
                              ->columns(array('count'    => new Expression('COUNT(id)')));
                              
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }


      //Mới cập nhật
      if($options['task'] == 'realestate-new'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('real_estate')
                              ->columns(array('count'    => new Expression('COUNT(id)')))
                              ->where('status = 1');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }

       if($options['task'] == 'contact-new'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('contact')
                              ->columns(array('count'    => new Expression('COUNT(id)')))
                              ->where('status = 1');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                  
         return $result;
      }


   }
   public function listItem($arrParam = null,$options = null){
      
      
      if($options['task'] == 'list-items-realestate-moi-nhat'){
         $paginator  = $arrParam['paginator'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('re'=>'real_estate'));
                             
                              $select->join(
                                 array('retype' => 'category'),
                                 'retype.id = re.cat_id',
                                 array('name_type' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->limit('5');
                                             
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }

      if($options['task'] == 'list-items-user-new'){
         $paginator  = $arrParam['paginator'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('users')
                              ->limit('8')
                              ->order('id DESC');
                                             
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }

      if($options['task'] == 'list-items-email-register-new'){
         $paginator  = $arrParam['paginator'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('email_newsletter')
                              ->limit('8')
                              ->order('id DESC');
                                             
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }

      if($options['task'] == 'ChartStatisticsAccess'){
         $now = getdate();//Thời gian hiện tại
         $paginator  = $arrParam['paginator'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('statistics_access_date')
                              ->where('month ='. $now["mon"])
                              ->where('year = '.$now["year"])
                              ->order('day ASC');
                                             
               
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
                              ->from(array('f'=>'nice_house'))
                              ->columns(array(
                                 'id','cat_id','title','description','content','images','status','date_time',
                                 'order','images',
                              ));
                             
                              $select->join(
                                 array('cat' => 'nice_house_cat'),
                                 'cat.id = f.cat_id',
                                 array('name_category' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              
                              $select->where('f.id ='.$arrParam['id']);   
               
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
            $select->columns(array('id','images'));
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