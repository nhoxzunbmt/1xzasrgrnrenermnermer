<?php

namespace Admin\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class DistrictTable
{
    protected $tableGateway;
    protected $adapter;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
    }

    public function itemInselectBox($arrParam = null, $options = null)
    {


    }

    public function countItem($arrParam = null, $options = null)
    {
        if ($options == null) {
            return $this->tableGateway->select()->count();
        }

    }

    public function listItem($arrParam = null, $options = null)
    {

        if ($options == null) {
            $result = $this->tableGateway->select();
            $result->buffer();
            return $result;
        }


        if ($options['task'] == 'list-items-paginator') {
            return $this->tableGateway->select(function (Select $select) use ($arrParam) {
                $paginator = $arrParam['paginator'];
                $ssFilter = $arrParam['ssFilter'];

                $select->limit($paginator['itemCountPerPage']);
                $select->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);

                //-------Lọc theo keyword và field----
                if (!empty($ssFilter['keywords']) && !empty($ssFilter['field'])) {
                    $keywords = '%' . $ssFilter['keywords'] . '%';
                    $select->where->like($ssFilter['field'], $keywords);
                }


                //-------Lọc theo status--------------
                if (!empty($ssFilter['status'])) {
                    $select->where->equalTo('status', $ssFilter['status']);
                }
                //------Sap xep theo cot-------------
                if (!empty($ssFilter['col']) && !empty($ssFilter['order'])) {
                    $select->order(array($ssFilter['col'] . ' ' . $ssFilter['order']));
                }

            });
        }


        if ($options['task'] == 'block-ads-column-top') {

            $sqlObj = new Sql($this->adapter);
            $select = $sqlObj->select()
                ->from(array('a' => 'ads'))
                ->where('a.area_ads = "top"')
                ->order('order ASC');


            $sqlString = $sqlObj->getSqlStringForSqlObject($select);
            $result = $this->adapter->query($sqlString)->execute();

            return $result;
        }


    }

    public function getItem($arrParam = null, $options = null)
    {
        if ($options['task'] == 'get-item') {
            $row = $this->tableGateway->select(array('id' => $arrParam['id']))->current();
            if (empty($row)) return false;
        }
        return $row;
    }

    public function saveItem($arrParam = null, $options = null)
    {

        if ($options == null) {
            if ($this->getItem($arrParam, array('task' => 'get-item')) == false || $arrParam['id'] == 0) {
                $this->tableGateway->insert($arrParam);
            } else {
                $this->tableGateway->update($arrParam, array('id' => $arrParam['id']));
            }
        }
        if ($options['task'] == 'add') {
            return $this->tableGateway->insert($arrParam);
        }
        if ($options['task'] == 'edit') {
            return $this->tableGateway->update($arrParam, array('id' => $arrParam['id']));
        }
        if ($options['task'] == 'multi-status') {
            if (!empty($arrParam)) {
                foreach ($arrParam['id'] as $key => $value) {
                    if ($arrParam['type'] == 'multi-active') {
                        $status = 1;
                    }
                    if ($arrParam['type'] == 'multi-in-active') {
                        $status = 0;
                    }
                    $data = array(
                        'id' => $value,
                        'status' => $status,
                    );
                    $this->tableGateway->update($data, array('id' => $value));
                }
            }
        }
    }

    public function deleteItem($arrParam = null, $options = null)
    {
        if ($options['task'] == 'list-images') {
            return $this->tableGateway->select(function (Select $select) use ($arrParam) {
                $select->columns(array('id', 'logo'));
                $select->where(array(
                    'id' => $arrParam
                ));

            });
        }
        if ($options['task'] == 'delete-item') {
            $this->tableGateway->delete(array('id' => $arrParam['id']));
        }
        if ($options['task'] == 'multi-delete-item') {
            if (!empty($arrParam)) {
                foreach ($arrParam as $key => $value) {
                    $this->tableGateway->delete(array('id' => $value));
                }

            }
        }
    }

}