<?php
/**
 * TableSchema class file.
 *
 * @author    Qiang Xue <qiang.xue@gmail.com>
 * @link      http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */
namespace DreamFactory\Core\SqlDbCore;

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

        $this->relations[$relation->name] = $relation;
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

        $label = static::camelize( $this->displayName, '_', true );
        $plural = static::pluralize( $label );

        return [
            'name'        => $this->displayName,
            'label'       => $label,
            'plural'      => $plural,
            'primary_key' => $this->primaryKey,
            'field'       => $fields,
            'related'     => $relations
        ];
    }

    // Utility methods, remove when this code is reworked, or make it dependent on php-utils

    public static function camelize( $string, $separator = null, $preserveWhiteSpace = false, $isKey = false )
    {
        empty( $separator ) && $separator = [ '_', '-' ];

        $_newString = ucwords( str_replace( $separator, ' ', $string ) );

        if ( false !== $isKey )
        {
            $_newString = lcfirst( $_newString );
        }

        return ( false === $preserveWhiteSpace ? str_replace( ' ', null, $_newString ) : $_newString );
    }


    /**
     * Converts a word to its plural form. Totally swiped from Yii
     *
     * @param string $name the word to be pluralized
     *
     * @return string the pluralized word
     */
    public static function pluralize( $name )
    {
        /** @noinspection SpellCheckingInspection */
        static $_blacklist = array(
            'Amoyese',
            'bison',
            'Borghese',
            'bream',
            'breeches',
            'britches',
            'buffalo',
            'cantus',
            'carp',
            'chassis',
            'clippers',
            'cod',
            'coitus',
            'Congoese',
            'contretemps',
            'corps',
            'debris',
            'deer',
            'diabetes',
            'djinn',
            'eland',
            'elk',
            'equipment',
            'Faroese',
            'flounder',
            'Foochowese',
            'gallows',
            'Genevese',
            'geese',
            'Genoese',
            'Gilbertese',
            'graffiti',
            'headquarters',
            'herpes',
            'hijinks',
            'Hottentotese',
            'information',
            'innings',
            'jackanapes',
            'Kiplingese',
            'Kongoese',
            'Lucchese',
            'mackerel',
            'Maltese',
            '.*?media',
            'metadata',
            'mews',
            'moose',
            'mumps',
            'Nankingese',
            'news',
            'nexus',
            'Niasese',
            'Pekingese',
            'Piedmontese',
            'pincers',
            'Pistoiese',
            'pliers',
            'Portuguese',
            'proceedings',
            'rabies',
            'rice',
            'rhinoceros',
            'salmon',
            'Sarawakese',
            'scissors',
            'sea[- ]bass',
            'series',
            'Shavese',
            'shears',
            'siemens',
            'species',
            'swine',
            'testes',
            'trousers',
            'trout',
            'tuna',
            'Vermontese',
            'Wenchowese',
            'whiting',
            'wildebeest',
            'Yengeese',
        );
        /** @noinspection SpellCheckingInspection */
        static $_rules = array(
            '/(s)tatus$/i'                                                                 => '\1\2tatuses',
            '/(quiz)$/i'                                                                   => '\1zes',
            '/^(ox)$/i'                                                                    => '\1en',
            '/(matr|vert|ind)(ix|ex)$/i'                                                   => '\1ices',
            '/([m|l])ouse$/i'                                                              => '\1ice',
            '/(x|ch|ss|sh|us|as|is|os)$/i'                                                 => '\1es',
            '/(shea|lea|loa|thie)f$/i'                                                     => '\1ves',
            '/(buffal|tomat|potat|ech|her|vet)o$/i'                                        => '\1oes',
            '/([^aeiouy]|qu)ies$/i'                                                        => '\1y',
            '/([^aeiouy]|qu)y$/i'                                                          => '\1ies',
            '/(?:([^f])fe|([lre])f)$/i'                                                    => '\1\2ves',
            '/([ti])um$/i'                                                                 => '\1a',
            '/sis$/i'                                                                      => 'ses',
            '/move$/i'                                                                     => 'moves',
            '/foot$/i'                                                                     => 'feet',
            '/human$/i'                                                                    => 'humans',
            '/tooth$/i'                                                                    => 'teeth',
            '/(bu)s$/i'                                                                    => '\1ses',
            '/(hive)$/i'                                                                   => '\1s',
            '/(p)erson$/i'                                                                 => '\1eople',
            '/(m)an$/i'                                                                    => '\1en',
            '/(c)hild$/i'                                                                  => '\1hildren',
            '/(alumn|bacill|cact|foc|fung|nucle|octop|radi|stimul|syllab|termin|vir)us$/i' => '\1i',
            '/us$/i'                                                                       => 'uses',
            '/(alias)$/i'                                                                  => '\1es',
            '/(ax|cris|test)is$/i'                                                         => '\1es',
            '/s$/'                                                                         => 's',
            '/$/'                                                                          => 's',
        );

        if ( empty( $name ) || in_array( strtolower( $name ), $_blacklist ) )
        {
            return $name;
        }

        foreach ( $_rules as $_rule => $_replacement )
        {
            if ( preg_match( $_rule, $name ) )
            {
                return preg_replace( $_rule, $_replacement, $name );
            }
        }

        return $name;
    }
}
