<?php
/**
 * DatabaseAdaperAwareAbstract class. Use for set DbAdapter of model database
 * 
 * @author DAI
 * @since 17/4/2015
 */

namespace Home\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

abstract class DatabaseAdaperAwareAbstract extends AbstractTableGateway
{
    protected $sAdapter = 'default';
    
    /**
     * Set Database Adapter in Module.php
     * 
     * @param Adapter $adapter
     */
    abstract public function setDbAdapter(Adapter $adapter);
    
    
    /**
     * Get Adapter name
     * 
     * @return string
     */
    public function getAdapterName()
    {
        return $this->sAdapter;
    }
    
    
    /**
     * Change db adapter
     * 
     * @param Adapter $adapter
     */
    public function changeAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->sql = new Sql($this->adapter, $this->table);
    }
    
    
    /**
     * Insert multiple row
     *
     * @param array $data
     * @return boolean
     */
    public function multiInsert(array $data)
    {
        if (count($data))
        {
            $columns = (array)current($data);
            $columns = array_keys($columns);
            $columnsCount = count($columns);
            $platform = $this->adapter->getPlatform();
    
            foreach ($columns as $index => $item) {
                $columns[$index] = $platform->quoteIdentifier($item);
            }
    
            $columns = "(" . implode(',', $columns) . ")";
    
            $placeholder = array_fill(0, $columnsCount, '?');
            $placeholder = "(" . implode(',', $placeholder) . ")";
            $placeholder = implode(',', array_fill(0, count($data), $placeholder));
    
            $values = array();
            foreach ($data as $row) {
                foreach ($row as $key => $value) {
                    $values[] = $value;
                }
            }
    
            $q = "INSERT INTO $this->table $columns VALUES $placeholder";
    
            return $this->adapter->query($q)->execute($values)->getAffectedRows();
        }
    
        return false;
    }
    
    
    /**
     * Insert multiple row. Ignore error
     *
     * @param array $data
     * @return boolean
     */
    public function multiInsertIgnore(array $data)
    {
        if (count($data))
        {
            $columns = (array)current($data);
            $columns = array_keys($columns);
            $columnsCount = count($columns);
            $platform = $this->adapter->getPlatform();
    
            foreach ($columns as $index => $item) {
                $columns[$index] = $platform->quoteIdentifier($item);
            }
    
            $columns = "(" . implode(',', $columns) . ")";
    
            $placeholder = array_fill(0, $columnsCount, '?');
            $placeholder = "(" . implode(',', $placeholder) . ")";
            $placeholder = implode(',', array_fill(0, count($data), $placeholder));
    
            $values = array();
            foreach ($data as $row) {
                foreach ($row as $key => $value) {
                    $values[] = $value;
                }
            }
    
            $q = "INSERT IGNORE INTO $this->table $columns VALUES $placeholder";
    
            return $this->adapter->query($q)->execute($values)->getAffectedRows();
        }
    
        return false;
    }
    
    /**
     * Use INSERT .
     * .. ON DUPLICATE KEY UPDATE Syntax
     *
     * @since mysql 5.1
     * @param array $insertData
     *            For insert array('field_name' => 'field_value')
     * @param array $updateData
     *            For update array('field_name' => 'field_value_new')
     * @return bool
     * @author Hieu Le
     */
    public function insertOrUpdate(array $insertData, array $updateData)
    {
        $sqlStringTemplate = 'INSERT INTO %s (%s) VALUES (%s) ON DUPLICATE KEY UPDATE %s';
        $driver = $this->adapter->getDriver();
        $platform = $this->adapter->getPlatform();
    
        $parameterContainer = new \Zend\Db\Adapter\ParameterContainer();
        $statementContainer = $driver->createStatement();
        $statementContainer->setParameterContainer( $parameterContainer );
    
        /* Preparation insert data */
        $insertQuotedValue = array();
        $insertQuotedColumns = array();
        foreach( $insertData as $column => $value )
        {
            $insertQuotedValue[] = $driver->formatParameterName( $column );
            $insertQuotedColumns[] = $platform->quoteIdentifier( $column );
            $parameterContainer->offsetSet( $column, $value );
        }
    
        /* Preparation update data */
        $updateQuotedValue = array();
        foreach( $updateData as $column => $value )
        {
            $updateQuotedValue[] = $platform->quoteIdentifier( $column ) . '=' . $driver->formatParameterName( 'update_' . $column );
            $parameterContainer->offsetSet( 'update_' . $column, $value );
        }
    
        /* Preparation sql query */
        $query = sprintf( $sqlStringTemplate, $this->table, implode( ',', $insertQuotedColumns ), implode( ',', array_values( $insertQuotedValue ) ), implode( ',', $updateQuotedValue ) );
    
        $statementContainer->setSql( $query );
        return $statementContainer->execute();
    }

    public function exeSelect($select)
    {
        // prepare and execute
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        // build result set
        $resultSet = clone $this->resultSetPrototype;
        $resultSet->initialize($result);

        return $resultSet;
    }
}

// End of file
// Location: module/Application/src/Application/Model/DatabaseAdaperAwareAbstract.php