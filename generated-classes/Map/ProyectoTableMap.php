<?php

namespace Map;

use \Proyecto;
use \ProyectoQuery;
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
 * This class defines the structure of the 'proyecto' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ProyectoTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ProyectoTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'proyecto';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Proyecto';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Proyecto';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id field
     */
    const COL_ID = 'proyecto.id';

    /**
     * the column name for the nombre field
     */
    const COL_NOMBRE = 'proyecto.nombre';

    /**
     * the column name for the descripcion field
     */
    const COL_DESCRIPCION = 'proyecto.descripcion';

    /**
     * the column name for the contacto field
     */
    const COL_CONTACTO = 'proyecto.contacto';

    /**
     * the column name for the telefono field
     */
    const COL_TELEFONO = 'proyecto.telefono';

    /**
     * the column name for the correo_electronico field
     */
    const COL_CORREO_ELECTRONICO = 'proyecto.correo_electronico';

    /**
     * the column name for the fecha_alta field
     */
    const COL_FECHA_ALTA = 'proyecto.fecha_alta';

    /**
     * the column name for the fecha_inicio field
     */
    const COL_FECHA_INICIO = 'proyecto.fecha_inicio';

    /**
     * the column name for the fecha_fin field
     */
    const COL_FECHA_FIN = 'proyecto.fecha_fin';

    /**
     * the column name for the fk_asociacion field
     */
    const COL_FK_ASOCIACION = 'proyecto.fk_asociacion';

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
        self::TYPE_PHPNAME       => array('Id', 'Nombre', 'Descripcion', 'Contacto', 'Telefono', 'CorreoElectronico', 'FechaAlta', 'FechaInicio', 'FechaFin', 'FkAsociacion', ),
        self::TYPE_CAMELNAME     => array('id', 'nombre', 'descripcion', 'contacto', 'telefono', 'correoElectronico', 'fechaAlta', 'fechaInicio', 'fechaFin', 'fkAsociacion', ),
        self::TYPE_COLNAME       => array(ProyectoTableMap::COL_ID, ProyectoTableMap::COL_NOMBRE, ProyectoTableMap::COL_DESCRIPCION, ProyectoTableMap::COL_CONTACTO, ProyectoTableMap::COL_TELEFONO, ProyectoTableMap::COL_CORREO_ELECTRONICO, ProyectoTableMap::COL_FECHA_ALTA, ProyectoTableMap::COL_FECHA_INICIO, ProyectoTableMap::COL_FECHA_FIN, ProyectoTableMap::COL_FK_ASOCIACION, ),
        self::TYPE_FIELDNAME     => array('id', 'nombre', 'descripcion', 'contacto', 'telefono', 'correo_electronico', 'fecha_alta', 'fecha_inicio', 'fecha_fin', 'fk_asociacion', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Nombre' => 1, 'Descripcion' => 2, 'Contacto' => 3, 'Telefono' => 4, 'CorreoElectronico' => 5, 'FechaAlta' => 6, 'FechaInicio' => 7, 'FechaFin' => 8, 'FkAsociacion' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'nombre' => 1, 'descripcion' => 2, 'contacto' => 3, 'telefono' => 4, 'correoElectronico' => 5, 'fechaAlta' => 6, 'fechaInicio' => 7, 'fechaFin' => 8, 'fkAsociacion' => 9, ),
        self::TYPE_COLNAME       => array(ProyectoTableMap::COL_ID => 0, ProyectoTableMap::COL_NOMBRE => 1, ProyectoTableMap::COL_DESCRIPCION => 2, ProyectoTableMap::COL_CONTACTO => 3, ProyectoTableMap::COL_TELEFONO => 4, ProyectoTableMap::COL_CORREO_ELECTRONICO => 5, ProyectoTableMap::COL_FECHA_ALTA => 6, ProyectoTableMap::COL_FECHA_INICIO => 7, ProyectoTableMap::COL_FECHA_FIN => 8, ProyectoTableMap::COL_FK_ASOCIACION => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'nombre' => 1, 'descripcion' => 2, 'contacto' => 3, 'telefono' => 4, 'correo_electronico' => 5, 'fecha_alta' => 6, 'fecha_inicio' => 7, 'fecha_fin' => 8, 'fk_asociacion' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('proyecto');
        $this->setPhpName('Proyecto');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Proyecto');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('nombre', 'Nombre', 'VARCHAR', true, 120, null);
        $this->addColumn('descripcion', 'Descripcion', 'VARCHAR', false, 255, null);
        $this->addColumn('contacto', 'Contacto', 'VARCHAR', true, 255, null);
        $this->addColumn('telefono', 'Telefono', 'VARCHAR', false, 80, null);
        $this->addColumn('correo_electronico', 'CorreoElectronico', 'VARCHAR', false, 120, null);
        $this->addColumn('fecha_alta', 'FechaAlta', 'DATE', true, null, null);
        $this->addColumn('fecha_inicio', 'FechaInicio', 'DATE', false, null, null);
        $this->addColumn('fecha_fin', 'FechaFin', 'DATE', false, null, null);
        $this->addForeignKey('fk_asociacion', 'FkAsociacion', 'INTEGER', 'asociacion', 'id', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Asociacion', '\\Asociacion', RelationMap::MANY_TO_ONE, array('fk_asociacion' => 'id', ), null, null);
        $this->addRelation('IntegranteProyecto', '\\IntegranteProyecto', RelationMap::ONE_TO_MANY, array('id' => 'fk_proyecto', ), null, null, 'IntegranteProyectos');
        $this->addRelation('Item', '\\Item', RelationMap::ONE_TO_MANY, array('id' => 'fk_proyecto', ), null, null, 'Items');
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
        return $withPrefix ? ProyectoTableMap::CLASS_DEFAULT : ProyectoTableMap::OM_CLASS;
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
     * @return array           (Proyecto object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ProyectoTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ProyectoTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ProyectoTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ProyectoTableMap::OM_CLASS;
            /** @var Proyecto $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ProyectoTableMap::addInstanceToPool($obj, $key);
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
            $key = ProyectoTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ProyectoTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Proyecto $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ProyectoTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ProyectoTableMap::COL_ID);
            $criteria->addSelectColumn(ProyectoTableMap::COL_NOMBRE);
            $criteria->addSelectColumn(ProyectoTableMap::COL_DESCRIPCION);
            $criteria->addSelectColumn(ProyectoTableMap::COL_CONTACTO);
            $criteria->addSelectColumn(ProyectoTableMap::COL_TELEFONO);
            $criteria->addSelectColumn(ProyectoTableMap::COL_CORREO_ELECTRONICO);
            $criteria->addSelectColumn(ProyectoTableMap::COL_FECHA_ALTA);
            $criteria->addSelectColumn(ProyectoTableMap::COL_FECHA_INICIO);
            $criteria->addSelectColumn(ProyectoTableMap::COL_FECHA_FIN);
            $criteria->addSelectColumn(ProyectoTableMap::COL_FK_ASOCIACION);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.nombre');
            $criteria->addSelectColumn($alias . '.descripcion');
            $criteria->addSelectColumn($alias . '.contacto');
            $criteria->addSelectColumn($alias . '.telefono');
            $criteria->addSelectColumn($alias . '.correo_electronico');
            $criteria->addSelectColumn($alias . '.fecha_alta');
            $criteria->addSelectColumn($alias . '.fecha_inicio');
            $criteria->addSelectColumn($alias . '.fecha_fin');
            $criteria->addSelectColumn($alias . '.fk_asociacion');
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
        return Propel::getServiceContainer()->getDatabaseMap(ProyectoTableMap::DATABASE_NAME)->getTable(ProyectoTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ProyectoTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ProyectoTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ProyectoTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Proyecto or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Proyecto object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProyectoTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Proyecto) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ProyectoTableMap::DATABASE_NAME);
            $criteria->add(ProyectoTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ProyectoQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ProyectoTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ProyectoTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the proyecto table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ProyectoQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Proyecto or Criteria object.
     *
     * @param mixed               $criteria Criteria or Proyecto object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProyectoTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Proyecto object
        }

        if ($criteria->containsKey(ProyectoTableMap::COL_ID) && $criteria->keyContainsValue(ProyectoTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ProyectoTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ProyectoQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ProyectoTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ProyectoTableMap::buildTableMap();
