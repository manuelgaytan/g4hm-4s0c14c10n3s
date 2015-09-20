<?php

namespace Base;

use \Aportacion as ChildAportacion;
use \AportacionQuery as ChildAportacionQuery;
use \Exception;
use \PDO;
use Map\AportacionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'aportacion' table.
 *
 *
 *
 * @method     ChildAportacionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAportacionQuery orderByFkItem($order = Criteria::ASC) Order by the fk_item column
 * @method     ChildAportacionQuery orderByFkIntegrante($order = Criteria::ASC) Order by the fk_integrante column
 * @method     ChildAportacionQuery orderByMonto($order = Criteria::ASC) Order by the monto column
 * @method     ChildAportacionQuery orderByFecha($order = Criteria::ASC) Order by the fecha column
 * @method     ChildAportacionQuery orderByNota($order = Criteria::ASC) Order by the nota column
 *
 * @method     ChildAportacionQuery groupById() Group by the id column
 * @method     ChildAportacionQuery groupByFkItem() Group by the fk_item column
 * @method     ChildAportacionQuery groupByFkIntegrante() Group by the fk_integrante column
 * @method     ChildAportacionQuery groupByMonto() Group by the monto column
 * @method     ChildAportacionQuery groupByFecha() Group by the fecha column
 * @method     ChildAportacionQuery groupByNota() Group by the nota column
 *
 * @method     ChildAportacionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAportacionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAportacionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAportacionQuery leftJoinIntegrante($relationAlias = null) Adds a LEFT JOIN clause to the query using the Integrante relation
 * @method     ChildAportacionQuery rightJoinIntegrante($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Integrante relation
 * @method     ChildAportacionQuery innerJoinIntegrante($relationAlias = null) Adds a INNER JOIN clause to the query using the Integrante relation
 *
 * @method     ChildAportacionQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildAportacionQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildAportacionQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     \IntegranteQuery|\ItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAportacion findOne(ConnectionInterface $con = null) Return the first ChildAportacion matching the query
 * @method     ChildAportacion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAportacion matching the query, or a new ChildAportacion object populated from the query conditions when no match is found
 *
 * @method     ChildAportacion findOneById(int $id) Return the first ChildAportacion filtered by the id column
 * @method     ChildAportacion findOneByFkItem(int $fk_item) Return the first ChildAportacion filtered by the fk_item column
 * @method     ChildAportacion findOneByFkIntegrante(int $fk_integrante) Return the first ChildAportacion filtered by the fk_integrante column
 * @method     ChildAportacion findOneByMonto(string $monto) Return the first ChildAportacion filtered by the monto column
 * @method     ChildAportacion findOneByFecha(string $fecha) Return the first ChildAportacion filtered by the fecha column
 * @method     ChildAportacion findOneByNota(string $nota) Return the first ChildAportacion filtered by the nota column
 *
 * @method     ChildAportacion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAportacion objects based on current ModelCriteria
 * @method     ChildAportacion[]|ObjectCollection findById(int $id) Return ChildAportacion objects filtered by the id column
 * @method     ChildAportacion[]|ObjectCollection findByFkItem(int $fk_item) Return ChildAportacion objects filtered by the fk_item column
 * @method     ChildAportacion[]|ObjectCollection findByFkIntegrante(int $fk_integrante) Return ChildAportacion objects filtered by the fk_integrante column
 * @method     ChildAportacion[]|ObjectCollection findByMonto(string $monto) Return ChildAportacion objects filtered by the monto column
 * @method     ChildAportacion[]|ObjectCollection findByFecha(string $fecha) Return ChildAportacion objects filtered by the fecha column
 * @method     ChildAportacion[]|ObjectCollection findByNota(string $nota) Return ChildAportacion objects filtered by the nota column
 * @method     ChildAportacion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AportacionQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\AportacionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Aportacion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAportacionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAportacionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAportacionQuery) {
            return $criteria;
        }
        $query = new ChildAportacionQuery();
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
     * @return ChildAportacion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AportacionTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AportacionTableMap::DATABASE_NAME);
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
     * @return ChildAportacion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, fk_item, fk_integrante, monto, fecha, nota FROM aportacion WHERE id = :p0';
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
            /** @var ChildAportacion $obj */
            $obj = new ChildAportacion();
            $obj->hydrate($row);
            AportacionTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAportacion|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAportacionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AportacionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAportacionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AportacionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAportacionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AportacionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AportacionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AportacionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the fk_item column
     *
     * Example usage:
     * <code>
     * $query->filterByFkItem(1234); // WHERE fk_item = 1234
     * $query->filterByFkItem(array(12, 34)); // WHERE fk_item IN (12, 34)
     * $query->filterByFkItem(array('min' => 12)); // WHERE fk_item > 12
     * </code>
     *
     * @see       filterByItem()
     *
     * @param     mixed $fkItem The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAportacionQuery The current query, for fluid interface
     */
    public function filterByFkItem($fkItem = null, $comparison = null)
    {
        if (is_array($fkItem)) {
            $useMinMax = false;
            if (isset($fkItem['min'])) {
                $this->addUsingAlias(AportacionTableMap::COL_FK_ITEM, $fkItem['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fkItem['max'])) {
                $this->addUsingAlias(AportacionTableMap::COL_FK_ITEM, $fkItem['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AportacionTableMap::COL_FK_ITEM, $fkItem, $comparison);
    }

    /**
     * Filter the query on the fk_integrante column
     *
     * Example usage:
     * <code>
     * $query->filterByFkIntegrante(1234); // WHERE fk_integrante = 1234
     * $query->filterByFkIntegrante(array(12, 34)); // WHERE fk_integrante IN (12, 34)
     * $query->filterByFkIntegrante(array('min' => 12)); // WHERE fk_integrante > 12
     * </code>
     *
     * @see       filterByIntegrante()
     *
     * @param     mixed $fkIntegrante The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAportacionQuery The current query, for fluid interface
     */
    public function filterByFkIntegrante($fkIntegrante = null, $comparison = null)
    {
        if (is_array($fkIntegrante)) {
            $useMinMax = false;
            if (isset($fkIntegrante['min'])) {
                $this->addUsingAlias(AportacionTableMap::COL_FK_INTEGRANTE, $fkIntegrante['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fkIntegrante['max'])) {
                $this->addUsingAlias(AportacionTableMap::COL_FK_INTEGRANTE, $fkIntegrante['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AportacionTableMap::COL_FK_INTEGRANTE, $fkIntegrante, $comparison);
    }

    /**
     * Filter the query on the monto column
     *
     * Example usage:
     * <code>
     * $query->filterByMonto(1234); // WHERE monto = 1234
     * $query->filterByMonto(array(12, 34)); // WHERE monto IN (12, 34)
     * $query->filterByMonto(array('min' => 12)); // WHERE monto > 12
     * </code>
     *
     * @param     mixed $monto The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAportacionQuery The current query, for fluid interface
     */
    public function filterByMonto($monto = null, $comparison = null)
    {
        if (is_array($monto)) {
            $useMinMax = false;
            if (isset($monto['min'])) {
                $this->addUsingAlias(AportacionTableMap::COL_MONTO, $monto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($monto['max'])) {
                $this->addUsingAlias(AportacionTableMap::COL_MONTO, $monto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AportacionTableMap::COL_MONTO, $monto, $comparison);
    }

    /**
     * Filter the query on the fecha column
     *
     * Example usage:
     * <code>
     * $query->filterByFecha('2011-03-14'); // WHERE fecha = '2011-03-14'
     * $query->filterByFecha('now'); // WHERE fecha = '2011-03-14'
     * $query->filterByFecha(array('max' => 'yesterday')); // WHERE fecha > '2011-03-13'
     * </code>
     *
     * @param     mixed $fecha The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAportacionQuery The current query, for fluid interface
     */
    public function filterByFecha($fecha = null, $comparison = null)
    {
        if (is_array($fecha)) {
            $useMinMax = false;
            if (isset($fecha['min'])) {
                $this->addUsingAlias(AportacionTableMap::COL_FECHA, $fecha['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fecha['max'])) {
                $this->addUsingAlias(AportacionTableMap::COL_FECHA, $fecha['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AportacionTableMap::COL_FECHA, $fecha, $comparison);
    }

    /**
     * Filter the query on the nota column
     *
     * Example usage:
     * <code>
     * $query->filterByNota('fooValue');   // WHERE nota = 'fooValue'
     * $query->filterByNota('%fooValue%'); // WHERE nota LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nota The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAportacionQuery The current query, for fluid interface
     */
    public function filterByNota($nota = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nota)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nota)) {
                $nota = str_replace('*', '%', $nota);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AportacionTableMap::COL_NOTA, $nota, $comparison);
    }

    /**
     * Filter the query by a related \Integrante object
     *
     * @param \Integrante|ObjectCollection $integrante The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAportacionQuery The current query, for fluid interface
     */
    public function filterByIntegrante($integrante, $comparison = null)
    {
        if ($integrante instanceof \Integrante) {
            return $this
                ->addUsingAlias(AportacionTableMap::COL_FK_INTEGRANTE, $integrante->getId(), $comparison);
        } elseif ($integrante instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AportacionTableMap::COL_FK_INTEGRANTE, $integrante->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByIntegrante() only accepts arguments of type \Integrante or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Integrante relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAportacionQuery The current query, for fluid interface
     */
    public function joinIntegrante($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Integrante');

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
            $this->addJoinObject($join, 'Integrante');
        }

        return $this;
    }

    /**
     * Use the Integrante relation Integrante object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \IntegranteQuery A secondary query class using the current class as primary query
     */
    public function useIntegranteQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinIntegrante($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Integrante', '\IntegranteQuery');
    }

    /**
     * Filter the query by a related \Item object
     *
     * @param \Item|ObjectCollection $item The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAportacionQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \Item) {
            return $this
                ->addUsingAlias(AportacionTableMap::COL_FK_ITEM, $item->getId(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AportacionTableMap::COL_FK_ITEM, $item->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByItem() only accepts arguments of type \Item or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Item relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAportacionQuery The current query, for fluid interface
     */
    public function joinItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Item');

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
            $this->addJoinObject($join, 'Item');
        }

        return $this;
    }

    /**
     * Use the Item relation Item object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ItemQuery A secondary query class using the current class as primary query
     */
    public function useItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Item', '\ItemQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAportacion $aportacion Object to remove from the list of results
     *
     * @return $this|ChildAportacionQuery The current query, for fluid interface
     */
    public function prune($aportacion = null)
    {
        if ($aportacion) {
            $this->addUsingAlias(AportacionTableMap::COL_ID, $aportacion->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the aportacion table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AportacionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AportacionTableMap::clearInstancePool();
            AportacionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AportacionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AportacionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AportacionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AportacionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AportacionQuery
