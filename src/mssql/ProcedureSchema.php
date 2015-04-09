<?php
/**
 * ProcedureSchema class file.
 *
 * @author    Qiang Xue <qiang.xue@gmail.com>
 * @link      http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

/**
 * ProcedureSchema represents the metadata for a MSSQL stored procedure.
 *
 * @author  Qiang Xue <qiang.xue@gmail.com>
 * @package system.db.schema.mssql
 * @since   1.0
 */
namespace DreamFactory\Rave\SqlDbCore\Mssql;


class ProcedureSchema extends \DreamFactory\Rave\SqlDbCore\ProcedureSchema
{
    /**
     * @var string name of the schema (database) that this procedure belongs to.
     * Defaults to null, meaning no schema (or the current database).
     */
    public $schemaName;
}
