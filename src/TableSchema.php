<?php
/**
 * TableSchema class file.
 *
 * @author    Qiang Xue <qiang.xue@gmail.com>
 * @link      http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */
namespace DreamFactory\Rave\SqlDbCore;

use DreamFactory\Library\Utility\Inflector;

/**
 * TableSchema is the base class for representing the metadata of a database table.
 *
 * It may be extended by different DBMS driver to provide DBMS-specific table metadata.
 *
 * TableSchema provides the following information about a table:
 * <ul>
 * <li>{@link name}</li>
 * <li>{@link rawName}</li>
 * <li>{@link columns}</li>
 * <li>{@link primaryKey}</li>
 * <li>{@link foreignKeys}</li>
 * <li>{@link sequenceName}</li>
 * </ul>
 *
 * @property array $columnNames List of column names.
 *
 * @author  Qiang Xue <qiang.xue@gmail.com>
 * @package system.db.schema
 * @since   1.0
 */
class TableSchema
{
    /**
     * @var string name of the schema that this table belongs to.
     */
    public $schemaName;
    /**
     * @var string name of this table.
     */
    public $name;
    /**
     * @var string raw name of this table. This is the quoted version of table name with optional schema name. It can be directly used in SQLs.
     */
    public $rawName;
    /**
     * @var string public display name of this table. This is the table name with optional non-default schema name. It is to be used by clients.
     */
    public $displayName;
    /**
     * @var string|array primary key name of this table. If composite key, an array of key names is returned.
     */
    public $primaryKey;
    /**
     * @var string sequence name for the primary key. Null if no sequence.
     */
    public $sequenceName;
    /**
     * @var array foreign keys of this table. The array is indexed by column name. Each value is an array of foreign table name and foreign column name.
     */
    public $foreignKeys = [ ];
    /**
     * @var array relationship metadata of this table. Each array element is a RelationSchema object, indexed by relation name.
     */
    public $relations = [ ];
    /**
     * @var array column metadata of this table. Each array element is a ColumnSchema object, indexed by column name.
     */
    public $columns = [ ];

    /**
     * Gets the named column metadata.
     * This is a convenient method for retrieving a named column even if it does not exist.
     *
     * @param string $name column name
     *
     * @return ColumnSchema metadata of the named column. Null if the named column does not exist.
     */
    public function getColumn( $name )
    {
        return isset( $this->columns[$name] ) ? $this->columns[$name] : null;
    }

    /**
     * @return array list of column names
     */
    public function getColumnNames()
    {
        return array_keys( $this->columns );
    }

    /**
     * Gets the named relation metadata.
     *
     * @param string $name relation name
     *
     * @return RelationSchema metadata of the named relation. Null if the named relation does not exist.
     */
    public function getRelation( $name )
    {
        return isset( $this->relations[$name] ) ? $this->relations[$name] : null;
    }

    /**
     * @return array list of column names
     */
    public function getRelationNames()
    {
        return array_keys( $this->columns );
    }

    public function addReference( $type, $ref_table, $ref_field, $field, $join = null )
    {
        $relation = new RelationSchema($type, $ref_table, $ref_field, $field, $join);

        $this->relations[] = $relation;
    }

    public function toArray()
    {
        $fields = [ ];
        /** @var ColumnSchema $column */
        foreach ( $this->columns as $column )
        {
            $fields[] = $column->toArray();
        }

        $relations = [ ];
        /** @var RelationSchema $relation */
        foreach ( $this->relations as $relation )
        {
            $relations[] = $relation->toArray();
        }

        $label = Inflector::camelize( $this->displayName, '_', true );
        $plural = Inflector::pluralize( $label );

        return [
            'name'        => $this->displayName,
            'label'       => $label,
            'plural'      => $plural,
            'primary_key' => $this->primaryKey,
            'field'       => $fields,
            'related'     => $relations
        ];
    }
}
