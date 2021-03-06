<?php
namespace Home\Model;
use Home\Model\DatabaseAdaperAwareAbstract;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;

class UserTable extends DatabaseAdaperAwareAbstract {
   protected $tableGateway;
   protected $adapter;

    protected $table     = 'users';
    protected $primary   = 'BrandnameAmountId';

   public function __construct(TableGateway $tableGateway){
      $this->tableGateway = $tableGateway;
      $this->adapter = GlobalAdapterFeature::getStaticAdapter();
   }

    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
        $this->initialize();
    }



   public function countItem($arrParam = null,$options = null){
      if($options == null){
         return $this->tableGateway->select()->count();
      }
   }
   public function listItem($arrParam = null,$options = null){

      
   }

   public function getItem($arrParam = null, $options = null){
      if($options['task'] == 'get-item-notification-template'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('n'=>'notificationtemplate'))
               ->columns(array(
                  'id','content'
               ));
         $select->where('n.id = '.$arrParam['id']);       
         $result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
         $result     = $result[0];
         return $result;
      }

      if($options == null){
         return $result = $this->tableGateway->select(function (Select $select) use($arrParam){
            $select->columns(array('id','username','fullname','email','group_id'));
            $select->where->equalTo('id',$arrParam['id']);
         })->current();

         
      }
      if($options['task'] == 'user-active'){
         return $result = $this->tableGateway->select(function(Select $select) use($arrParam){
            $select->where->equalTo('id',$arrParam['id'])
                  ->where->equalTo('active_code',$arrParam['code']);
         })->count();

      }
      if($options['task'] == 'restore-password'){
         return $result = $this->tableGateway->select(function(Select $select) use($arrParam){
            $select->where->equalTo('fpass_code',$arrParam['code']);
         })->count();

      }
      if($options['task'] == 'store-group-info'){
         $sqlObj     = new Sql($this->adapter);
         $select     = $sqlObj->select();
         $select->from(array('u'=>'user_group'))
               ->columns(array(
                  'id','group_name','group_acp','permission_id'
               ));
         $select->where('u.id = '.$arrParam['id']);       
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
      if($options['task'] == 'user-active'){
         $data = array(
            'status'       => 1,
            'active_code'  => '',
         );

         $this->tableGateway->update($data,array('id'=>$arrParam['id'],'active_code'=>$arrParam['code']));

      }

      if($options['task'] == 'forgot-password-code'){
         $data = array(
            'fpass_code'       => $arrParam['fpass_code'],
         );

         $this->tableGateway->update($data,array('email'=>$arrParam['email']));

      }

      if($options['task'] == 'restore-password'){
         $data = array(
            'password'        => $arrParam['password'],
            'fpass_code'      => '',
         );

         $this->tableGateway->update($data,array('fpass_code'=>$arrParam['fpass_code']));

      }
       
   }

    /**
     * VuND Model
     */


    /**
     * @param $arrData
     * @return mixed
     */
    public function save($arrData)
    {
        $arrData['group_id']    = 4;
        $arrData['register_date'] = new Expression('NOW()');

        $result = $this->insert($arrData);

        return $result;
    }

    /**
     * @param $arrData
     * @return mixed
     */
    public function updateUser($arrData, $email)
    {
        return $this->update($arrData, array('email' => $email));
    }

    /**
     * @param $fbId
     * @return mixed
     */
    public function checkAccount($email){
        return $this->select(['email' => $email]);
    }

    /**
     * END
     */
   

}