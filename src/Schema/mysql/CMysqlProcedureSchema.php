<?php
/**
 * CMysqlProcedureSchema class file.
 *
 * @author    Qiang Xue <qiang.xue@gmail.com>
 * @link      http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */
namespace DreamFactory\Rave\SqlDb\DB\Schema\MySql;

use DreamFactory\Rave\SqlDb\DB\Schema\CDbProcedureSchema;

/**
 * CMysqlProcedureSchema represents the metadata for a MySQL stored procedure.
 *
 * @author  Qiang Xue <qiang.xue@gmail.com>
 * @package system.db.schema.mysql
 * @since   1.0
 */
class CMysqlProcedureSchema extends CDbProcedureSchema
{
    /**
     * @var string name of the schema (database) that this procedure belongs to.
     * Defaults to null, meaning no schema (or the current database).
     */
    public $schemaName;
}
