<?php
namespace src;

abstract class Entity
{
    protected $dbc;
    protected $tableName;
    protected $fields;
    protected $primaryKey = ['id'];

    abstract protected function initValue();

    public function __construct( $dbc, $tableName )
    {
        $this->dbc = $dbc;
        $this->tableName = $tableName;
        $this->initValue();
    }

    public function findAll()
    {
        $results = [];
        $data = $this->find( '', '' );
        if ( $data ) {
            $className = static::class;
            foreach ( $data as $objectData ) {
                $object = new $className( $this->dbc );
                $object = $this->setValues( $objectData, $object );
                $results[] = $object;
            }
        }
        return $results;
    }

    public function find( $fieldName, $fieldValue )
    {
        $prepareFields = [];
        $sql = 'SELECT * FROM ' . $this->tableName;
        if ( !empty( $fieldName ) ) {
            $sql .= ' WHERE ' . $fieldName . ' = :value';
            $prepareFields = ['value' => $fieldValue];
        }
        $st = $this->dbc->prepare( $sql );
        $st->execute( $prepareFields );

        $dbData = $st->fetchAll();
        return $dbData;
    }

    public function findBy( $fieldName, $fieldValue )
    {
        $data = $this->find( $fieldName, $fieldValue );
        if ( $data && $data[0] ) {
            $this->setValues( $data[0] );
        }
    }

    public function save()
    {
        // $sql = 'UPDATE tableName SET title =:title, content=:content WHERE id =:id';
        $fieldBinds = [];
        $prepareFields = [];
        $keyBind = [];

        foreach ( $this->primaryKey as $keyName ) {
            $keyBind[$keyName] = $keyName . ' = :' . $keyName;
            $prepareFields[$keyName] = $this->$keyName;
        }
        foreach ( $this->fields as $fieldName ) {
            $fieldBinds[$fieldName] = $fieldName . ' = :' . $fieldName;
            $prepareFields[$fieldName] = $this->$fieldName;
        }

        $fieldBindStr = join( ', ', $fieldBinds );
        $keyBindStr = join( ', ', $keyBind );
        $sql = 'UPDATE ' . $this->tableName . ' SET ' . $fieldBindStr . ' WHERE ' . $keyBindStr;

        $sm = $this->dbc->prepare( $sql );
        $sm->execute( $prepareFields );
    }

    public function setValues( $values, $object = null )
    {
        if ( $object === null ) {
            $object = $this;
        }

        foreach ( $object->primaryKey as $keyName ) {
            if ( isset( $values[$keyName] ) ) {
                $object->$keyName = $values[$keyName];
            }
        }

        foreach ( $object->fields as $fieldName ) {
            if ( isset( $values[$fieldName] ) ) {
                $object->$fieldName = $values[$fieldName];
            }
        }
        return $object;
    }
}