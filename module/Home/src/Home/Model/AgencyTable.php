<?php
namespace Home\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Expression;

class AgencyTable{
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
         $default[]  = array('id'=>'','name'=>'Thành phố');
         $result     = array_merge($default,$result);
         return $result;
      }
      if($options['task'] == 'list-item-type-business'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->columns(array('id', 'name'))
                              ->where('type = "category_business"');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $default[]  = array('id'=>'','name'=>'Loại DN');
         $result     = array_merge($default,$result);
         return $result;
      }
   }

   public function countItem($arrParam = null,$options = null){
      if($options == null){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('b' => 'users'))
                              ->columns(array('count'    => new Expression('COUNT(b.id)')));
                              if(!empty($arrParam['cityid'])){
                                 $select->where('city_id = '.$arrParam['cityid']);
                              }
                              if(!empty($arrParam['iddistrict'])){
                                 $select->where('district = '.$arrParam['iddistrict']);
                              }
                              if(!empty($arrParam['q'])){
                                 $select->where(new Predicate\Like('b.fullname', '%'.$arrParam['q'].'%'));
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
      if($options['task'] == 'list-item-type-business'){
          $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->columns(array('id', 'name'))
                              ->where('type = "category_business"');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }
      if($options['task'] == 'list-item-district'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city_district')
                              ->columns(array('id','name','city_id'));
                              if(!empty($arrParam['id'])){
                                 $select->where('city_id ='.$arrParam['id']);
                              }
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }
      if($options['task'] == 'list-item-ward'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city_district_ward')
                              ->columns(array('id','name','district_id'));
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         return $result;
      }
      
     
      if($options['task'] == 'list-items-paginator'){
         $paginator  = $arrParam['paginator'];
        
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('b'=>'users'))
                              ->order('id DESC')
                              ->where('group_id = 4');
                              $select->limit($paginator['itemCountPerPage']);
                              $select->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
                              
                             
                              if(!empty($arrParam['cityid'])){
                                 $select->where('city_id = '.$arrParam['cityid']);
                              }
                              if(!empty($arrParam['iddistrict'])){
                                 $select->where('district = '.$arrParam['iddistrict']);
                              }
                              if(!empty($arrParam['q'])){
                                 $select->where(new Predicate\Like('b.fullname', '%'.$arrParam['q'].'%'));
                              }
                                    
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }
      if($options['task'] == 'list-items-hightlight'){
         $paginator  = $arrParam['paginator'];
        
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('b'=>'users'))
                              ->order('id DESC')
                              ->where('group_id = 4')
                              ->limit(9);
                                    
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }

      if($options['task'] == 'block-list-items-hightlight'){
         $paginator  = $arrParam['paginator'];
        
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('b'=>'users'))
                              ->order('id DESC')
                              ->where('group_id = 4')
                              ->limit(5);
                                    
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }

      if($options['task'] == 'block-list-items-comment'){
         $paginator  = $arrParam['paginator'];
        
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('c'=>'comment'));
                              $select->join(
                                 array('u' => 'users'),
                                 'u.id = c.user_id',
                                 array('fullname','phone','introduced'),
                                 $select::JOIN_LEFT
                              );
                              $select->order('id DESC');
                              $select->limit(20);
                                    
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }
      
      if($options['task'] == 'dang-moi-gioi'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('re' => 'real_estate'))
               ->columns(array(
                  'id','cat_id','title','content','images','transaction','area',
                  'price','price_m2','price_display','direction','avenue','juridical',
                  'floor','bedroom','bathroom','city','district','ward','project',
                  'numberhouse','nameavenue','user_id','latitude_gmap','longitude_gmap',
                  'status','order','date_modifi','type_news','date_start','date_end'
               ))
             
               ->join(
                  array('retype' => 'category'),
                  'retype.id = re.cat_id',
                  array('name_type' => 'name'),
                  $select::JOIN_LEFT
               )
              
               ->limit(5);
               //Lọc theo Môi giới
               if(!empty($arrParam['id'])){
                  $select->where('re.user_id = '.$arrParam['id']);   
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
      
      if($options['task'] == 'get-item-city'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city')
                              ->columns(array('id','name'))
                              ->where('id ='.$arrParam['cityid']);
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = $result[0];

         return $result;
      }
      if($options['task'] == 'get-item-district'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('city_district')
                              ->columns(array('id','name'))
                              ->where('id ='.$arrParam['iddistrict']);
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
      if($options['task'] == 'contact-me'){
         $sqlObj     = new Sql($this->adapter);
         $insertObj  = $sqlObj->insert('contact_agency');
         $insertObj->values($arrParam);
         $sqlString  = $sqlObj->getSqlStringForSqlObject($insertObj);
         $this->adapter->query($sqlString)->execute();
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