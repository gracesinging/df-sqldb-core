<?php
/**
 * Connection class file.
 *
 * @author Edgard L. Messias <edgardmessias@gmail.com>
 * @link   https://github.com/edgardmessias/yiidb2
 */
namespace DreamFactory\Rave\SqlDbCore\Ibmdb2;

/**
 * Connection represents a connection to a IBM DB2 database.
 *
 * @author  Edgard L. Messias <edgardmessias@gmail.com>
 * @package ext.yiidb2
 */
class Connection extends \DreamFactory\Rave\SqlDbCore\Connection
{

    protected function initConnection( $pdo )
    {
        parent::initConnection( $pdo );
        $this->setAttribute( \PDO::ATTR_CASE, \PDO::CASE_LOWER );
        $this->setAttribute( \PDO::ATTR_STRINGIFY_FETCHES, true );
    }

    public $driverMap = array(
        'ibm'  => 'Schema', // IBM DB2 driver
        'odbc' => 'Schema', // IBM DB2 driver
    );

    public function getPdoType( $type )
    {
        if ( $type == 'NULL' )
        {
            return \PDO::PARAM_STR;
        }
        else
        {
            return parent::getPdoType( $type );
        }
    }

    /**
     * @var string Custom PDO wrapper class.
     * @since 1.1.8
     */
    public $pdoClass = 'PdoAdapter';

}