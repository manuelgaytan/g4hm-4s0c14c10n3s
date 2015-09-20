<?php

namespace Map;

use \Integrante;
use \IntegranteQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'integrante' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class IntegranteTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.IntegranteTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'integrante';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Integrante';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Integrante';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 14;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 14;

    /**
     * the column name for the id field
     */
    const COL_ID = 'integrante.id';

    /**
     * the column name for the fk_usuario field
     */
    const COL_FK_USUARIO = 'integrante.fk_usuario';

    /**
     * the column name for the nombre field
     */
    const COL_NOMBRE = 'integrante.nombre';

    /**
     * the column name for the apellido_paterno field
     */
    const COL_APELLIDO_PATERNO = 'integrante.apellido_paterno';

    /**
     * the column name for the apellido_materno field
     */
    const COL_APELLIDO_MATERNO = 'integrante.apellido_materno';

    /**
     * the column name for the fecha_nacimiento field
     */
    const COL_FECHA_NACIMIENTO = 'integrante.fecha_nacimiento';

    /**
     * the column name for the rfc field
     */
    const COL_RFC = 'integrante.rfc';

    /**
     * the column name for the curp field
     */
    const COL_CURP = 'integrante.curp';

    /**
     * the column name for the domicilio field
     */
    const COL_DOMICILIO = 'integrante.domicilio';

    /**
     * the column name for the estado_civil field
     */
    const COL_ESTADO_CIVIL = 'integrante.estado_civil';

    /**
     * the column name for the correo_electronico field
     */
    const COL_CORREO_ELECTRONICO = 'integrante.correo_electronico';

    /**
     * the column name for the ocupacion field
     */
    const COL_OCUPACION = 'integrante.ocupacion';

    /**
     * the column name for the quien_recomienda field
     */
    const COL_QUIEN_RECOMIENDA = 'integrante.quien_recomienda';

    /**
     * the column name for the observaciones field
     */
    const COL_OBSERVACIONES = 'integrante.observaciones';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'FkUsuario', 'Nombre', 'ApellidoPaterno', 'ApellidoMaterno', 'FechaNacimiento', 'Rfc', 'Curp', 'Domicilio', 'EstadoCivil', 'CorreoElectronico', 'Ocupacion', 'QuienRecomienda', 'Observaciones', ),
        self::TYPE_CAMELNAME     => array('id', 'fkUsuario', 'nombre', 'apellidoPaterno', 'apellidoMaterno', 'fechaNacimiento', 'rfc', 'curp', 'domicilio', 'estadoCivil', 'correoElectronico', 'ocupacion', 'quienRecomienda', 'observaciones', ),
        self::TYPE_COLNAME       => array(IntegranteTableMap::COL_ID, IntegranteTableMap::COL_FK_USUARIO, IntegranteTableMap::COL_NOMBRE, IntegranteTableMap::COL_APELLIDO_PATERNO, IntegranteTableMap::COL_APELLIDO_MATERNO, IntegranteTableMap::COL_FECHA_NACIMIENTO, IntegranteTableMap::COL_RFC, IntegranteTableMap::COL_CURP, IntegranteTableMap::COL_DOMICILIO, IntegranteTableMap::COL_ESTADO_CIVIL, IntegranteTableMap::COL_CORREO_ELECTRONICO, IntegranteTableMap::COL_OCUPACION, IntegranteTableMap::COL_QUIEN_RECOMIENDA, IntegranteTableMap::COL_OBSERVACIONES, ),
        self::TYPE_FIELDNAME     => array('id', 'fk_usuario', 'nombre', 'apellido_paterno', 'apellido_materno', 'fecha_nacimiento', 'rfc', 'curp', 'domicilio', 'estado_civil', 'correo_electronico', 'ocupacion', 'quien_recomienda', 'observaciones', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'FkUsuario' => 1, 'Nombre' => 2, 'ApellidoPaterno' => 3, 'ApellidoMaterno' => 4, 'FechaNacimiento' => 5, 'Rfc' => 6, 'Curp' => 7, 'Domicilio' => 8, 'EstadoCivil' => 9, 'CorreoElectronico' => 10, 'Ocupacion' => 11, 'QuienRecomienda' => 12, 'Observaciones' => 13, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'fkUsuario' => 1, 'nombre' => 2, 'apellidoPaterno' => 3, 'apellidoMaterno' => 4, 'fechaNacimiento' => 5, 'rfc' => 6, 'curp' => 7, 'domicilio' => 8, 'estadoCivil' => 9, 'correoElectronico' => 10, 'ocupacion' => 11, 'quienRecomienda' => 12, 'observaciones' => 13, ),
        self::TYPE_COLNAME       => array(IntegranteTableMap::COL_ID => 0, IntegranteTableMap::COL_FK_USUARIO => 1, IntegranteTableMap::COL_NOMBRE => 2, IntegranteTableMap::COL_APELLIDO_PATERNO => 3, IntegranteTableMap::COL_APELLIDO_MATERNO => 4, IntegranteTableMap::COL_FECHA_NACIMIENTO => 5, IntegranteTableMap::COL_RFC => 6, IntegranteTableMap::COL_CURP => 7, IntegranteTableMap::COL_DOMICILIO => 8, IntegranteTableMap::COL_ESTADO_CIVIL => 9, IntegranteTableMap::COL_CORREO_ELECTRONICO => 10, IntegranteTableMap::COL_OCUPACION => 11, IntegranteTableMap::COL_QUIEN_RECOMIENDA => 12, IntegranteTableMap::COL_OBSERVACIONES => 13, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'fk_usuario' => 1, 'nombre' => 2, 'apellido_paterno' => 3, 'apellido_materno' => 4, 'fecha_nacimiento' => 5, 'rfc' => 6, 'curp' => 7, 'domicilio' => 8, 'estado_civil' => 9, 'correo_electronico' => 10, 'ocupacion' => 11, 'quien_recomienda' => 12, 'observaciones' => 13, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('integrante');
        $this->setPhpName('Integrante');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Integrante');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('fk_usuario', 'FkUsuario', 'INTEGER', 'usuario', 'id', false, null, null);
        $this->addColumn('nombre', 'Nombre', 'VARCHAR', true, 120, null);
        $this->addColumn('apellido_paterno', 'ApellidoPaterno', 'VARCHAR', false, 120, null);
        $this->addColumn('apellido_materno', 'ApellidoMaterno', 'VARCHAR', false, 120, null);
        $this->addColumn('fecha_nacimiento', 'FechaNacimiento', 'DATE', false, null, null);
        $this->addColumn('rfc', 'Rfc', 'VARCHAR', false, 13, null);
        $this->addColumn('curp', 'Curp', 'VARCHAR', false, 18, null);
        $this->addColumn('domicilio', 'Domicilio', 'VARCHAR', false, 255, null);
        $this->addColumn('estado_civil', 'EstadoCivil', 'VARCHAR', false, 50, null);
        $this->addColumn('correo_electronico', 'CorreoElectronico', 'VARCHAR', false, 120, null);
        $this->addColumn('ocupacion', 'Ocupacion', 'VARCHAR', false, 255, null);
        $this->addColumn('quien_recomienda', 'QuienRecomienda', 'VARCHAR', false, 255, null);
        $this->addColumn('observaciones', 'Observaciones', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Usuario', '\\Usuario', RelationMap::MANY_TO_ONE, array('fk_usuario' => 'id', ), null, null);
        $this->addRelation('Aportacion', '\\Aportacion', RelationMap::ONE_TO_MANY, array('id' => 'fk_integrante', ), null, null, 'Aportacions');
        $this->addRelation('IntegranteAsociacion', '\\IntegranteAsociacion', RelationMap::ONE_TO_MANY, array('id' => 'fk_integrante', ), null, null, 'IntegranteAsociacions');
        $this->addRelation('IntegranteProyecto', '\\IntegranteProyecto', RelationMap::ONE_TO_MANY, array('id' => 'fk_integrante', ), null, null, 'IntegranteProyectos');
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? IntegranteTableMap::CLASS_DEFAULT : IntegranteTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Integrante object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = IntegranteTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = IntegranteTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + IntegranteTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = IntegranteTableMap::OM_CLASS;
            /** @var Integrante $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            IntegranteTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = IntegranteTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = IntegranteTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Integrante $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                IntegranteTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(IntegranteTableMap::COL_ID);
            $criteria->addSelectColumn(IntegranteTableMap::COL_FK_USUARIO);
            $criteria->addSelectColumn(IntegranteTableMap::COL_NOMBRE);
            $criteria->addSelectColumn(IntegranteTableMap::COL_APELLIDO_PATERNO);
            $criteria->addSelectColumn(IntegranteTableMap::COL_APELLIDO_MATERNO);
            $criteria->addSelectColumn(IntegranteTableMap::COL_FECHA_NACIMIENTO);
            $criteria->addSelectColumn(IntegranteTableMap::COL_RFC);
            $criteria->addSelectColumn(IntegranteTableMap::COL_CURP);
            $criteria->addSelectColumn(IntegranteTableMap::COL_DOMICILIO);
            $criteria->addSelectColumn(IntegranteTableMap::COL_ESTADO_CIVIL);
            $criteria->addSelectColumn(IntegranteTableMap::COL_CORREO_ELECTRONICO);
            $criteria->addSelectColumn(IntegranteTableMap::COL_OCUPACION);
            $criteria->addSelectColumn(IntegranteTableMap::COL_QUIEN_RECOMIENDA);
            $criteria->addSelectColumn(IntegranteTableMap::COL_OBSERVACIONES);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.fk_usuario');
            $criteria->addSelectColumn($alias . '.nombre');
            $criteria->addSelectColumn($alias . '.apellido_paterno');
            $criteria->addSelectColumn($alias . '.apellido_materno');
            $criteria->addSelectColumn($alias . '.fecha_nacimiento');
            $criteria->addSelectColumn($alias . '.rfc');
            $criteria->addSelectColumn($alias . '.curp');
            $criteria->addSelectColumn($alias . '.domicilio');
            $criteria->addSelectColumn($alias . '.estado_civil');
            $criteria->addSelectColumn($alias . '.correo_electronico');
            $criteria->addSelectColumn($alias . '.ocupacion');
            $criteria->addSelectColumn($alias . '.quien_recomienda');
            $criteria->addSelectColumn($alias . '.observaciones');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(IntegranteTableMap::DATABASE_NAME)->getTable(IntegranteTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(IntegranteTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(IntegranteTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new IntegranteTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Integrante or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Integrante object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IntegranteTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Integrante) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(IntegranteTableMap::DATABASE_NAME);
            $criteria->add(IntegranteTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = IntegranteQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            IntegranteTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                IntegranteTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the integrante table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return IntegranteQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Integrante or Criteria object.
     *
     * @param mixed               $criteria Criteria or Integrante object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IntegranteTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Integrante object
        }

        if ($criteria->containsKey(IntegranteTableMap::COL_ID) && $criteria->keyContainsValue(IntegranteTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.IntegranteTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = IntegranteQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // IntegranteTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
IntegranteTableMap::buildTableMap();
