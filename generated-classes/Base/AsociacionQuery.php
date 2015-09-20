<?php

namespace Base;

use \Asociacion as ChildAsociacion;
use \AsociacionQuery as ChildAsociacionQuery;
use \Exception;
use \PDO;
use Map\AsociacionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'asociacion' table.
 *
 *
 *
 * @method     ChildAsociacionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAsociacionQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method     ChildAsociacionQuery orderByDomicilio($order = Criteria::ASC) Order by the domicilio column
 * @method     ChildAsociacionQuery orderByContacto($order = Criteria::ASC) Order by the contacto column
 * @method     ChildAsociacionQuery orderByTelefono($order = Criteria::ASC) Order by the telefono column
 * @method     ChildAsociacionQuery orderByCorreoElectronico($order = Criteria::ASC) Order by the correo_electronico column
 *
 * @method     ChildAsociacionQuery groupById() Group by the id column
 * @method     ChildAsociacionQuery groupByNombre() Group by the nombre column
 * @method     ChildAsociacionQuery groupByDomicilio() Group by the domicilio column
 * @method     ChildAsociacionQuery groupByContacto() Group by the contacto column
 * @method     ChildAsociacionQuery groupByTelefono() Group by the telefono column
 * @method     ChildAsociacionQuery groupByCorreoElectronico() Group by the correo_electronico column
 *
 * @method     ChildAsociacionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAsociacionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAsociacionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAsociacionQuery leftJoinAviso($relationAlias = null) Adds a LEFT JOIN clause to the query using the Aviso relation
 * @method     ChildAsociacionQuery rightJoinAviso($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Aviso relation
 * @method     ChildAsociacionQuery innerJoinAviso($relationAlias = null) Adds a INNER JOIN clause to the query using the Aviso relation
 *
 * @method     ChildAsociacionQuery leftJoinIntegranteAsociacion($relationAlias = null) Adds a LEFT JOIN clause to the query using the IntegranteAsociacion relation
 * @method     ChildAsociacionQuery rightJoinIntegranteAsociacion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the IntegranteAsociacion relation
 * @method     ChildAsociacionQuery innerJoinIntegranteAsociacion($relationAlias = null) Adds a INNER JOIN clause to the query using the IntegranteAsociacion relation
 *
 * @method     ChildAsociacionQuery leftJoinProyecto($relationAlias = null) Adds a LEFT JOIN clause to the query using the Proyecto relation
 * @method     ChildAsociacionQuery rightJoinProyecto($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Proyecto relation
 * @method     ChildAsociacionQuery innerJoinProyecto($relationAlias = null) Adds a INNER JOIN clause to the query using the Proyecto relation
 *
 * @method     \AvisoQuery|\IntegranteAsociacionQuery|\ProyectoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAsociacion findOne(ConnectionInterface $con = null) Return the first ChildAsociacion matching the query
 * @method     ChildAsociacion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAsociacion matching the query, or a new ChildAsociacion object populated from the query conditions when no match is found
 *
 * @method     ChildAsociacion findOneById(int $id) Return the first ChildAsociacion filtered by the id column
 * @method     ChildAsociacion findOneByNombre(string $nombre) Return the first ChildAsociacion filtered by the nombre column
 * @method     ChildAsociacion findOneByDomicilio(string $domicilio) Return the first ChildAsociacion filtered by the domicilio column
 * @method     ChildAsociacion findOneByContacto(string $contacto) Return the first ChildAsociacion filtered by the contacto column
 * @method     ChildAsociacion findOneByTelefono(string $telefono) Return the first ChildAsociacion filtered by the telefono column
 * @method     ChildAsociacion findOneByCorreoElectronico(string $correo_electronico) Return the first ChildAsociacion filtered by the correo_electronico column
 *
 * @method     ChildAsociacion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAsociacion objects based on current ModelCriteria
 * @method     ChildAsociacion[]|ObjectCollection findById(int $id) Return ChildAsociacion objects filtered by the id column
 * @method     ChildAsociacion[]|ObjectCollection findByNombre(string $nombre) Return ChildAsociacion objects filtered by the nombre column
 * @method     ChildAsociacion[]|ObjectCollection findByDomicilio(string $domicilio) Return ChildAsociacion objects filtered by the domicilio column
 * @method     ChildAsociacion[]|ObjectCollection findByContacto(string $contacto) Return ChildAsociacion objects filtered by the contacto column
 * @method     ChildAsociacion[]|ObjectCollection findByTelefono(string $telefono) Return ChildAsociacion objects filtered by the telefono column
 * @method     ChildAsociacion[]|ObjectCollection findByCorreoElectronico(string $correo_electronico) Return ChildAsociacion objects filtered by the correo_electronico column
 * @method     ChildAsociacion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AsociacionQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\AsociacionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Asociacion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAsociacionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAsociacionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAsociacionQuery) {
            return $criteria;
        }
        $query = new ChildAsociacionQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAsociacion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AsociacionTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AsociacionTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAsociacion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, nombre, domicilio, contacto, telefono, correo_electronico FROM asociacion WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAsociacion $obj */
            $obj = new ChildAsociacion();
            $obj->hydrate($row);
            AsociacionTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildAsociacion|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildAsociacionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AsociacionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAsociacionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AsociacionTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAsociacionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AsociacionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AsociacionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AsociacionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the nombre column
     *
     * Example usage:
     * <code>
     * $query->filterByNombre('fooValue');   // WHERE nombre = 'fooValue'
     * $query->filterByNombre('%fooValue%'); // WHERE nombre LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nombre The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAsociacionQuery The current query, for fluid interface
     */
    public function filterByNombre($nombre = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nombre)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nombre)) {
                $nombre = str_replace('*', '%', $nombre);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AsociacionTableMap::COL_NOMBRE, $nombre, $comparison);
    }

    /**
     * Filter the query on the domicilio column
     *
     * Example usage:
     * <code>
     * $query->filterByDomicilio('fooValue');   // WHERE domicilio = 'fooValue'
     * $query->filterByDomicilio('%fooValue%'); // WHERE domicilio LIKE '%fooValue%'
     * </code>
     *
     * @param     string $domicilio The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAsociacionQuery The current query, for fluid interface
     */
    public function filterByDomicilio($domicilio = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($domicilio)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $domicilio)) {
                $domicilio = str_replace('*', '%', $domicilio);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AsociacionTableMap::COL_DOMICILIO, $domicilio, $comparison);
    }

    /**
     * Filter the query on the contacto column
     *
     * Example usage:
     * <code>
     * $query->filterByContacto('fooValue');   // WHERE contacto = 'fooValue'
     * $query->filterByContacto('%fooValue%'); // WHERE contacto LIKE '%fooValue%'
     * </code>
     *
     * @param     string $contacto The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAsociacionQuery The current query, for fluid interface
     */
    public function filterByContacto($contacto = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($contacto)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $contacto)) {
                $contacto = str_replace('*', '%', $contacto);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AsociacionTableMap::COL_CONTACTO, $contacto, $comparison);
    }

    /**
     * Filter the query on the telefono column
     *
     * Example usage:
     * <code>
     * $query->filterByTelefono('fooValue');   // WHERE telefono = 'fooValue'
     * $query->filterByTelefono('%fooValue%'); // WHERE telefono LIKE '%fooValue%'
     * </code>
     *
     * @param     string $telefono The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAsociacionQuery The current query, for fluid interface
     */
    public function filterByTelefono($telefono = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($telefono)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $telefono)) {
                $telefono = str_replace('*', '%', $telefono);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AsociacionTableMap::COL_TELEFONO, $telefono, $comparison);
    }

    /**
     * Filter the query on the correo_electronico column
     *
     * Example usage:
     * <code>
     * $query->filterByCorreoElectronico('fooValue');   // WHERE correo_electronico = 'fooValue'
     * $query->filterByCorreoElectronico('%fooValue%'); // WHERE correo_electronico LIKE '%fooValue%'
     * </code>
     *
     * @param     string $correoElectronico The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAsociacionQuery The current query, for fluid interface
     */
    public function filterByCorreoElectronico($correoElectronico = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($correoElectronico)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $correoElectronico)) {
                $correoElectronico = str_replace('*', '%', $correoElectronico);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AsociacionTableMap::COL_CORREO_ELECTRONICO, $correoElectronico, $comparison);
    }

    /**
     * Filter the query by a related \Aviso object
     *
     * @param \Aviso|ObjectCollection $aviso  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAsociacionQuery The current query, for fluid interface
     */
    public function filterByAviso($aviso, $comparison = null)
    {
        if ($aviso instanceof \Aviso) {
            return $this
                ->addUsingAlias(AsociacionTableMap::COL_ID, $aviso->getFkAsociacion(), $comparison);
        } elseif ($aviso instanceof ObjectCollection) {
            return $this
                ->useAvisoQuery()
                ->filterByPrimaryKeys($aviso->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAviso() only accepts arguments of type \Aviso or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Aviso relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAsociacionQuery The current query, for fluid interface
     */
    public function joinAviso($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Aviso');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Aviso');
        }

        return $this;
    }

    /**
     * Use the Aviso relation Aviso object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AvisoQuery A secondary query class using the current class as primary query
     */
    public function useAvisoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAviso($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Aviso', '\AvisoQuery');
    }

    /**
     * Filter the query by a related \IntegranteAsociacion object
     *
     * @param \IntegranteAsociacion|ObjectCollection $integranteAsociacion  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAsociacionQuery The current query, for fluid interface
     */
    public function filterByIntegranteAsociacion($integranteAsociacion, $comparison = null)
    {
        if ($integranteAsociacion instanceof \IntegranteAsociacion) {
            return $this
                ->addUsingAlias(AsociacionTableMap::COL_ID, $integranteAsociacion->getFkAsociacion(), $comparison);
        } elseif ($integranteAsociacion instanceof ObjectCollection) {
            return $this
                ->useIntegranteAsociacionQuery()
                ->filterByPrimaryKeys($integranteAsociacion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByIntegranteAsociacion() only accepts arguments of type \IntegranteAsociacion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the IntegranteAsociacion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAsociacionQuery The current query, for fluid interface
     */
    public function joinIntegranteAsociacion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('IntegranteAsociacion');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'IntegranteAsociacion');
        }

        return $this;
    }

    /**
     * Use the IntegranteAsociacion relation IntegranteAsociacion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \IntegranteAsociacionQuery A secondary query class using the current class as primary query
     */
    public function useIntegranteAsociacionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinIntegranteAsociacion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'IntegranteAsociacion', '\IntegranteAsociacionQuery');
    }

    /**
     * Filter the query by a related \Proyecto object
     *
     * @param \Proyecto|ObjectCollection $proyecto  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAsociacionQuery The current query, for fluid interface
     */
    public function filterByProyecto($proyecto, $comparison = null)
    {
        if ($proyecto instanceof \Proyecto) {
            return $this
                ->addUsingAlias(AsociacionTableMap::COL_ID, $proyecto->getFkAsociacion(), $comparison);
        } elseif ($proyecto instanceof ObjectCollection) {
            return $this
                ->useProyectoQuery()
                ->filterByPrimaryKeys($proyecto->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProyecto() only accepts arguments of type \Proyecto or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Proyecto relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAsociacionQuery The current query, for fluid interface
     */
    public function joinProyecto($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Proyecto');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Proyecto');
        }

        return $this;
    }

    /**
     * Use the Proyecto relation Proyecto object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProyectoQuery A secondary query class using the current class as primary query
     */
    public function useProyectoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProyecto($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Proyecto', '\ProyectoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAsociacion $asociacion Object to remove from the list of results
     *
     * @return $this|ChildAsociacionQuery The current query, for fluid interface
     */
    public function prune($asociacion = null)
    {
        if ($asociacion) {
            $this->addUsingAlias(AsociacionTableMap::COL_ID, $asociacion->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the asociacion table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AsociacionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AsociacionTableMap::clearInstancePool();
            AsociacionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AsociacionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AsociacionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AsociacionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AsociacionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AsociacionQuery
