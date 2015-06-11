<?php
/**
 * ColumnSchema class file.
 *
 * @author    Qiang Xue <qiang.xue@gmail.com>
 * @link      http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */
namespace DreamFactory\Core\SqlDbCore\MySql;

/**
 * ColumnSchema class describes the column meta data of a MySQL table.
 *
 * @author  Qiang Xue <qiang.xue@gmail.com>
 * @package system.db.schema.mysql
 * @since   1.0
 */
class ColumnSchema extends \DreamFactory\Core\SqlDbCore\ColumnSchema
{
    /**
     * Extracts the default value for the column.
     * The value is typecasted to correct PHP type.
     *
     * @param mixed $defaultValue the default value obtained from metadata
     */
    public function extractDefault( $defaultValue )
    {
        if ( strncmp( $this->dbType, 'bit', 3 ) === 0 )
        {
            $this->defaultValue = bindec( trim( $defaultValue, 'b\'' ) );
        }
        else
        {
            parent::extractDefault( $defaultValue );
        }
    }

    /**
     * Extracts size, precision and scale information from column's DB type.
     *
     * @param string $dbType the column's DB type
     */
    public function extractLimit( $dbType )
    {
        if ( strncmp( $dbType, 'enum', 4 ) === 0 && preg_match( '/\(([\'"])(.*)\\1\)/', $dbType, $matches ) )
        {
            // explode by (single or double) quote and comma (ENUM values may contain commas)
            $values = explode( $matches[1] . ',' . $matches[1], $matches[2] );
            $size = 0;
            foreach ( $values as $value )
            {
                if ( ( $n = strlen( $value ) ) > $size )
                {
                    $size = $n;
                }
            }
            $this->size = $this->precision = $size;
        }
        else
            parent::extractLimit( $dbType );
    }
}