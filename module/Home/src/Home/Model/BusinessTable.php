<?php
namespace Home\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Expression;

class BusinessTable{
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
                              ->from(array('b' => 'business'))
                              ->columns(array('count'    => new Expression('COUNT(b.id)')));
                              if(!empty($arrParam['id'])){
                                 $select->where('b.type_business = '.$arrParam['id']);
                              }
                              if(!empty($arrParam['cityid'])){
                                 $select->where('b.city = '.$arrParam['cityid']);
                              }
                              if(!empty($arrParam['iddistrict'])){
                                 $select->where('b.district = '.$arrParam['iddistrict']);
                              } 
                              if(!empty($arrParam['q'])){
                                 $select->where(new Predicate\Like('b.name', '%'.$arrParam['q'].'%'));
                              }                                 
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                       
         return $result;
      }

      if($options['task'] == 'count-nha-dat-ban-cua-doanh-nghiep'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('re' => 'real_estate'))
                              ->columns(array('count'    => new Expression('COUNT(re.id)')));
                              $select->join(
                                 array('u' => 'users'),
                                 'u.id = re.user_id',
                                 array('username' => 'username'),
                                 $select::JOIN_LEFT
                              );

                              $select->where('u.username = "'.$arrParam['alias'].'"');  
                              if(!empty($arrParam['staff'])){
                                 $select->where('re.user_id IN('.$arrParam['staff'].')', \Zend\Db\Sql\Predicate\Predicate::OP_OR); 
                              }
                              $select->where('re.transaction = 2');                        
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                       
         return $result;
      }
      if($options['task'] == 'count-nha-dat-cho-thue-cua-doanh-nghiep'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('re' => 'real_estate'))
                              ->columns(array('count'    => new Expression('COUNT(re.id)')));
                              $select->join(
                                 array('u' => 'users'),
                                 'u.id = re.user_id',
                                 array('username' => 'username'),
                                 $select::JOIN_LEFT
                              );

                              $select->where('u.username = "'.$arrParam['alias'].'"');
                              if(!empty($arrParam['staff'])){
                                 $select->where('re.user_id IN('.$arrParam['staff'].')', \Zend\Db\Sql\Predicate\Predicate::OP_OR); 
                              }
                              $select->where('re.transaction = 1');                        
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                       
         return $result;
      }

      if($options['task'] == 'count-du-an-chu-dau-tu'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('p' => 'project'))
                              ->columns(array('count'    => new Expression('COUNT(p.id)')));
                              $select->join(
                                 array('u' => 'users'),
                                 'u.id = p.investors',
                                 array('username' => 'username'),
                                 $select::JOIN_LEFT
                              );

                              $select->where('u.username = "'.$arrParam['alias'].'"');                         
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                       
         return $result;
      }

      if($options['task'] == 'count-du-an-thi-cong'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('p' => 'project'))
                              ->columns(array('count'    => new Expression('COUNT(p.id)')));
                              $select->join(
                                 array('u' => 'users'),
                                 'u.id = p.construction',
                                 array('username' => 'username'),
                                 $select::JOIN_LEFT
                              );

                              $select->where('u.username = "'.$arrParam['alias'].'"');                         
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                       
         return $result;
      }

      if($options['task'] == 'count-du-an-quan-ly'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('p' => 'project'))
                              ->columns(array('count'    => new Expression('COUNT(p.id)')));
                              $select->join(
                                 array('u' => 'users'),
                                 'u.id = p.management',
                                 array('username' => 'username'),
                                 $select::JOIN_LEFT
                              );

                              $select->where('u.username = "'.$arrParam['alias'].'"');                         
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                       
         return $result;
      }

      if($options['task'] == 'count-du-an-thiet-ke'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('p' => 'project'))
                              ->columns(array('count'    => new Expression('COUNT(p.id)')));
                              $select->join(
                                 array('u' => 'users'),
                                 'u.id = p.design',
                                 array('username' => 'username'),
                                 $select::JOIN_LEFT
                              );

                              $select->where('u.username = "'.$arrParam['alias'].'"');                         
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result = $result[0]['count'];
                       
         return $result;
      }

      if($options['task'] == 'count-du-an-phan-phoi'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('p' => 'project'))
                              ->columns(array('count'    => new Expression('COUNT(p.id)')));
                              $select->join(
                                 array('u' => 'users'),
                                 'u.id = p.distributors',
                                 array('username' => 'username'),
                                 $select::JOIN_LEFT
                              );

                              $select->where('u.username = "'.$arrParam['alias'].'"');                         
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
                              ->columns(array('id','name'))
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
                              ->from(array('b'=>'business'))
                              ->columns(array(
                                 'id','type_business','name','logo','address','city','district','ward','phone',
                                 'fax','website','intro','contact','department','date_time','status','order','alias'
                              ));
                              $select->join(
                                 array('ct' => 'city'),
                                 'ct.id = b.city',
                                 array('name_city' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->join(
                                 array('ctd' => 'city_district'),
                                 'ctd.id = b.district',
                                 array('name_district' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->join(
                                 array('ctdw' => 'city_district_ward'),
                                 'ctdw.id = b.ward',
                                 array('name_ward' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->limit($paginator['itemCountPerPage']);
                              $select->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
                              
                              if(!empty($arrParam['id'])){
                                 $select->where('b.type_business = '.$arrParam['id']);
                              }
                              if(!empty($arrParam['cityid'])){
                                 $select->where('b.city = '.$arrParam['cityid']);
                              }
                              if(!empty($arrParam['iddistrict'])){
                                 $select->where('b.district = '.$arrParam['iddistrict']);
                              }
                              if(!empty($arrParam['q'])){
                                 $select->where(new Predicate\Like('b.name', '%'.$arrParam['q'].'%'));
                              }
                                    
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }
      
      if($options['task'] == 'list-items-business-highlight'){
         $paginator  = $arrParam['paginator'];
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('b'=>'business'))
                              ->columns(array(
                                 'id','type_business','name','logo','alias','date_time','intro','phone','fax'
                              ))
                              ->limit(16);
                              $select->where('b.highlight = 1');                    
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }

      if($options['task'] == 'statistics-type-business'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('t'=>'category'))
                              ->columns(array(
                                 'id','name'
                              ))
                              ->where('type = "category_business"');
                              $select->join(
                                 array('b' => 'business'),
                                 't.id = b.type_business',
                                 array('count'    => new Expression('COUNT(b.id)')),
                                 $select::JOIN_LEFT
                              );
                              $select->group('t.id');

         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;                     
      }

      if($options['task'] == 'list-items-business'){
         
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('b'=>'business'))
                              ->columns(array(
                                 'id','type_business','name','logo','address','city','district','ward','phone',
                                 'fax','website','intro','contact','department','date_time','status','order','alias'
                              ));
                              $select->join(
                                 array('ct' => 'city'),
                                 'ct.id = b.city',
                                 array('name_city' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->join(
                                 array('ctd' => 'city_district'),
                                 'ctd.id = b.district',
                                 array('name_district' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->join(
                                 array('ctdw' => 'city_district_ward'),
                                 'ctdw.id = b.ward',
                                 array('name_ward' => 'name'),
                                 $select::JOIN_LEFT
                              );
                             
                              $select->where('type_business = '.$arrParam['id']);
                              $select->limit(2);
                              
                                
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;
      }

      if($options['task'] == 'du-an-lien-quan'){

         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('p'=>'project'));
                              
                              $select->join(
                                 array('cat' => 'category'),
                                 'cat.id = p.cat_id',
                                 array('name_type' => 'name'),
                                 $select::JOIN_LEFT
                              );

                              $select->join(
                                 array('u' => 'users'),
                                 'u.id = p.investors',
                                 array('username' => 'username'),
                                 $select::JOIN_LEFT
                              );

                              $select->where('u.username = "'.$arrParam['alias'].'"');
                                             
               
         $sqlString  = $sqlObj->getSqlStringForSqlObject($select);       
         $result     = $this->adapter->query($sqlString)->execute();
         
         return $result;

      }

       if($options['task'] == 'bat-dong-san-moi-nhat-cua-doanh-nghiep'){
        
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('re'=>'real_estate'))
                              ->columns(array(
                                 'id','cat_id','title','content','images','transaction','area',
                                 'price','price_m2','price_display','direction','avenue','juridical',
                                 'floor','bedroom','bathroom','city','district','ward','project',
                                 'numberhouse','nameavenue','user_id','latitude_gmap','longitude_gmap',
                                 'status','order','date_modifi','type_news','date_start','date_end'
                              ));
                              $select->join(
                                 array('retype' => 'category'),
                                 'retype.id = re.cat_id',
                                 array('name_type' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->join(
                                 array('u' => 'users'),
                                 'u.id = re.user_id',
                                 array('username' => 'username'),
                                 $select::JOIN_LEFT
                              );

                              $select->where('u.username = "'.$arrParam['alias'].'"');
                              $select->order('id DESC');
                              $select->limit(10);               
               
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
      if($options['task'] == 'get-item-type-business'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('category')
                              ->columns(array('id','name'))
                              ->where('id ='.$arrParam['id']);
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = $result[0];
         return $result;
      }
      if($options['task'] == 'info-user'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('users')
                              ->columns(array('id'))
                              ->where('username = "'.$arrParam['alias'].'"');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = $result[0];
         return $result;
      }
      if($options['task'] == 'staff'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from('users')
                              ->columns(array('id'))
                              ->where('parent = "'.$arrParam['id'].'"');
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         
         return $result;
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
      if($options == null){

         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('b'=>'business'))
                              ->columns(array(
                                 'id','type_business','name','logo','address','city','district','ward','phone',
                                 'fax','website','intro','contact','department','date_time','status','order','alias'
                              ));
                              $select->join(
                                 array('ct' => 'city'),
                                 'ct.id = b.city',
                                 array('name_city' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->join(
                                 array('ctd' => 'city_district'),
                                 'ctd.id = b.district',
                                 array('name_district' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              $select->join(
                                 array('ctdw' => 'city_district_ward'),
                                 'ctdw.id = b.ward',
                                 array('name_ward' => 'name'),
                                 $select::JOIN_LEFT
                              );
                              
                              $select->where('b.alias = "'.$arrParam['alias'].'"');   
               
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = $result[0];
         return $result;
      }

      if($options['task'] == 'info-user'){

         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select()
                              ->from(array('u'=>'users'))
                              ->columns(array(
                                 'id'
                              ));
                             
                              $select->where('u.username = "'.$arrParam['alias'].'"');   
         
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
      if($options['task'] == 'contact-business'){
         $sqlObj     = new Sql($this->adapter);
         $insertObj  = $sqlObj->insert('contact_business');
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