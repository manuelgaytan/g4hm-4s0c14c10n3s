<?php

namespace Base;

use \IntegranteAsociacion as ChildIntegranteAsociacion;
use \IntegranteAsociacionQuery as ChildIntegranteAsociacionQuery;
use \Exception;
use \PDO;
use Map\IntegranteAsociacionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'integrante_asociacion' table.
 *
 *
 *
 * @method     ChildIntegranteAsociacionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildIntegranteAsociacionQuery orderByFkAsociacion($order = Criteria::ASC) Order by the fk_asociacion column
 * @method     ChildIntegranteAsociacionQuery orderByFkIntegrante($order = Criteria::ASC) Order by the fk_integrante column
 *
 * @method     ChildIntegranteAsociacionQuery groupById() Group by the id column
 * @method     ChildIntegranteAsociacionQuery groupByFkAsociacion() Group by the fk_asociacion column
 * @method     ChildIntegranteAsociacionQuery groupByFkIntegrante() Group by the fk_integrante column
 *
 * @method     ChildIntegranteAsociacionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildIntegranteAsociacionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildIntegranteAsociacionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildIntegranteAsociacionQuery leftJoinIntegrante($relationAlias = null) Adds a LEFT JOIN clause to the query using the Integrante relation
 * @method     ChildIntegranteAsociacionQuery rightJoinIntegrante($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Integrante relation
 * @method     ChildIntegranteAsociacionQuery innerJoinIntegrante($relationAlias = null) Adds a INNER JOIN clause to the query using the Integrante relation
 *
 * @method     ChildIntegranteAsociacionQuery leftJoinAsociacion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Asociacion relation
 * @method     ChildIntegranteAsociacionQuery rightJoinAsociacion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Asociacion relation
 * @method     ChildIntegranteAsociacionQuery innerJoinAsociacion($relationAlias = null) Adds a INNER JOIN clause to the query using the Asociacion relation
 *
 * @method     \IntegranteQuery|\AsociacionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildIntegranteAsociacion findOne(ConnectionInterface $con = null) Return the first ChildIntegranteAsociacion matching the query
 * @method     ChildIntegranteAsociacion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildIntegranteAsociacion matching the query, or a new ChildIntegranteAsociacion object populated from the query conditions when no match is found
 *
 * @method     ChildIntegranteAsociacion findOneById(int $id) Return the first ChildIntegranteAsociacion filtered by the id column
 * @method     ChildIntegranteAsociacion findOneByFkAsociacion(int $fk_asociacion) Return the first ChildIntegranteAsociacion filtered by the fk_asociacion column
 * @method     ChildIntegranteAsociacion findOneByFkIntegrante(int $fk_integrante) Return the first ChildIntegranteAsociacion filtered by the fk_integrante column
 *
 * @method     ChildIntegranteAsociacion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildIntegranteAsociacion objects based on current ModelCriteria
 * @method     ChildIntegranteAsociacion[]|ObjectCollection findById(int $id) Return ChildIntegranteAsociacion objects filtered by the id column
 * @method     ChildIntegranteAsociacion[]|ObjectCollection findByFkAsociacion(int $fk_asociacion) Return ChildIntegranteAsociacion objects filtered by the fk_asociacion column
 * @method     ChildIntegranteAsociacion[]|ObjectCollection findByFkIntegrante(int $fk_integrante) Return ChildIntegranteAsociacion objects filtered by the fk_integrante column
 * @method     ChildIntegranteAsociacion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class IntegranteAsociacionQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\IntegranteAsociacionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\IntegranteAsociacion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildIntegranteAsociacionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildIntegranteAsociacionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildIntegranteAsociacionQuery) {
            return $criteria;
        }
        $query = new ChildIntegranteAsociacionQuery();
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
     * @return ChildIntegranteAsociacion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = IntegranteAsociacionTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(IntegranteAsociacionTableMap::DATABASE_NAME);
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
     * @return ChildIntegranteAsociacion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, fk_asociacion, fk_integrante FROM integrante_asociacion WHERE id = :p0';
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
            /** @var ChildIntegranteAsociacion $obj */
            $obj = new ChildIntegranteAsociacion();
            $obj->hydrate($row);
            IntegranteAsociacionTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildIntegranteAsociacion|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildIntegranteAsociacionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(IntegranteAsociacionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildIntegranteAsociacionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(IntegranteAsociacionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildIntegranteAsociacionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(IntegranteAsociacionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(IntegranteAsociacionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IntegranteAsociacionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the fk_asociacion column
     *
     * Example usage:
     * <code>
     * $query->filterByFkAsociacion(1234); // WHERE fk_asociacion = 1234
     * $query->filterByFkAsociacion(array(12, 34)); // WHERE fk_asociacion IN (12, 34)
     * $query->filterByFkAsociacion(array('min' => 12)); // WHERE fk_asociacion > 12
     * </code>
     *
     * @see       filterByAsociacion()
     *
     * @param     mixed $fkAsociacion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIntegranteAsociacionQuery The current query, for fluid interface
     */
    public function filterByFkAsociacion($fkAsociacion = null, $comparison = null)
    {
        if (is_array($fkAsociacion)) {
            $useMinMax = false;
            if (isset($fkAsociacion['min'])) {
                $this->addUsingAlias(IntegranteAsociacionTableMap::COL_FK_ASOCIACION, $fkAsociacion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fkAsociacion['max'])) {
                $this->addUsingAlias(IntegranteAsociacionTableMap::COL_FK_ASOCIACION, $fkAsociacion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IntegranteAsociacionTableMap::COL_FK_ASOCIACION, $fkAsociacion, $comparison);
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
     * @return $this|ChildIntegranteAsociacionQuery The current query, for fluid interface
     */
    public function filterByFkIntegrante($fkIntegrante = null, $comparison = null)
    {
        if (is_array($fkIntegrante)) {
            $useMinMax = false;
            if (isset($fkIntegrante['min'])) {
                $this->addUsingAlias(IntegranteAsociacionTableMap::COL_FK_INTEGRANTE, $fkIntegrante['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fkIntegrante['max'])) {
                $this->addUsingAlias(IntegranteAsociacionTableMap::COL_FK_INTEGRANTE, $fkIntegrante['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IntegranteAsociacionTableMap::COL_FK_INTEGRANTE, $fkIntegrante, $comparison);
    }

    /**
     * Filter the query by a related \Integrante object
     *
     * @param \Integrante|ObjectCollection $integrante The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIntegranteAsociacionQuery The current query, for fluid interface
     */
    public function filterByIntegrante($integrante, $comparison = null)
    {
        if ($integrante instanceof \Integrante) {
            return $this
                ->addUsingAlias(IntegranteAsociacionTableMap::COL_FK_INTEGRANTE, $integrante->getId(), $comparison);
        } elseif ($integrante instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IntegranteAsociacionTableMap::COL_FK_INTEGRANTE, $integrante->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildIntegranteAsociacionQuery The current query, for fluid interface
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
     * Filter the query by a related \Asociacion object
     *
     * @param \Asociacion|ObjectCollection $asociacion The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIntegranteAsociacionQuery The current query, for fluid interface
     */
    public function filterByAsociacion($asociacion, $comparison = null)
    {
        if ($asociacion instanceof \Asociacion) {
            return $this
                ->addUsingAlias(IntegranteAsociacionTableMap::COL_FK_ASOCIACION, $asociacion->getId(), $comparison);
        } elseif ($asociacion instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IntegranteAsociacionTableMap::COL_FK_ASOCIACION, $asociacion->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAsociacion() only accepts arguments of type \Asociacion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Asociacion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIntegranteAsociacionQuery The current query, for fluid interface
     */
    public function joinAsociacion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Asociacion');

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
            $this->addJoinObject($join, 'Asociacion');
        }

        return $this;
    }

    /**
     * Use the Asociacion relation Asociacion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AsociacionQuery A secondary query class using the current class as primary query
     */
    public function useAsociacionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAsociacion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Asociacion', '\AsociacionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildIntegranteAsociacion $integranteAsociacion Object to remove from the list of results
     *
     * @return $this|ChildIntegranteAsociacionQuery The current query, for fluid interface
     */
    public function prune($integranteAsociacion = null)
    {
        if ($integranteAsociacion) {
            $this->addUsingAlias(IntegranteAsociacionTableMap::COL_ID, $integranteAsociacion->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the integrante_asociacion table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IntegranteAsociacionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            IntegranteAsociacionTableMap::clearInstancePool();
            IntegranteAsociacionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(IntegranteAsociacionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(IntegranteAsociacionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            IntegranteAsociacionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            IntegranteAsociacionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // IntegranteAsociacionQuery
