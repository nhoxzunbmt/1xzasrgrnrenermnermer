<?php
namespace Home\Model;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Expression;

class PermissionTable{
   protected $tableGateway;
   protected $adapter;

   public function __construct(TableGateway $tableGateway){
      $this->tableGateway = $tableGateway;
      $this->adapter = GlobalAdapterFeature::getStaticAdapter();
   }


   public function getItem($arrParam = null, $options = null){
      
      if($options['task'] == 'store-permission-info'){
         if(empty($arrParam['permission_id'])) return 'full';
         $permissions = $this->tableGateway->select(function (Select $select) use($arrParam){
            $permissionID = \Zend\Json\Json::decode($arrParam['permission_id']);
            //$select->columns(array('permission'=> new Expression('CONCAT(module,"||",controller,"||",action)')))
            //      ->where->in('id',$permissionID);
            $select->columns(array('module','controller','action'))
                  ->where->in('id',$permissionID);

         });

         foreach ($permissions  as  $value) $result[] = $value->module .'||'.$value->controller.'||'.$value->action; 

         
      }
 
      return $result;
   }

  

   

}