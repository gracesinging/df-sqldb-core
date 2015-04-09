<?php
/**
 * TableSchema class file.
 *
 * @author    Qiang Xue <qiang.xue@gmail.com>
 * @author    Christophe Boulain <Christophe.Boulain@gmail.com>
 * @link      http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */
namespace DreamFactory\Rave\SqlDbCore\Mssql;

/**
 * TableSchema represents the metadata for a MSSQL table.
 *
 * @author  Qiang Xue <qiang.xue@gmail.com>
 * @author  Christophe Boulain <Christophe.Boulain@gmail.com>
 * @package system.db.schema.mssql
 */
class TableSchema extends \DreamFactory\Rave\SqlDbCore\TableSchema
{
    /**
     * @var string name of the catalog (database) that this table belongs to.
     * Defaults to null, meaning no schema (or the current database).
     */
    public $catalogName;
}
