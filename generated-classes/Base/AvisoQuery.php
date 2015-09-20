<?php

namespace Base;

use \Aviso as ChildAviso;
use \AvisoQuery as ChildAvisoQuery;
use \Exception;
use \PDO;
use Map\AvisoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'aviso' table.
 *
 *
 *
 * @method     ChildAvisoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAvisoQuery orderByFkAsociacion($order = Criteria::ASC) Order by the fk_asociacion column
 * @method     ChildAvisoQuery orderByAviso($order = Criteria::ASC) Order by the aviso column
 * @method     ChildAvisoQuery orderByAutor($order = Criteria::ASC) Order by the autor column
 * @method     ChildAvisoQuery orderByFechaAlta($order = Criteria::ASC) Order by the fecha_alta column
 * @method     ChildAvisoQuery orderByFechaVigencia($order = Criteria::ASC) Order by the fecha_vigencia column
 *
 * @method     ChildAvisoQuery groupById() Group by the id column
 * @method     ChildAvisoQuery groupByFkAsociacion() Group by the fk_asociacion column
 * @method     ChildAvisoQuery groupByAviso() Group by the aviso column
 * @method     ChildAvisoQuery groupByAutor() Group by the autor column
 * @method     ChildAvisoQuery groupByFechaAlta() Group by the fecha_alta column
 * @method     ChildAvisoQuery groupByFechaVigencia() Group by the fecha_vigencia column
 *
 * @method     ChildAvisoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAvisoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAvisoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAvisoQuery leftJoinAsociacion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Asociacion relation
 * @method     ChildAvisoQuery rightJoinAsociacion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Asociacion relation
 * @method     ChildAvisoQuery innerJoinAsociacion($relationAlias = null) Adds a INNER JOIN clause to the query using the Asociacion relation
 *
 * @method     \AsociacionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAviso findOne(ConnectionInterface $con = null) Return the first ChildAviso matching the query
 * @method     ChildAviso findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAviso matching the query, or a new ChildAviso object populated from the query conditions when no match is found
 *
 * @method     ChildAviso findOneById(int $id) Return the first ChildAviso filtered by the id column
 * @method     ChildAviso findOneByFkAsociacion(int $fk_asociacion) Return the first ChildAviso filtered by the fk_asociacion column
 * @method     ChildAviso findOneByAviso(string $aviso) Return the first ChildAviso filtered by the aviso column
 * @method     ChildAviso findOneByAutor(string $autor) Return the first ChildAviso filtered by the autor column
 * @method     ChildAviso findOneByFechaAlta(string $fecha_alta) Return the first ChildAviso filtered by the fecha_alta column
 * @method     ChildAviso findOneByFechaVigencia(string $fecha_vigencia) Return the first ChildAviso filtered by the fecha_vigencia column
 *
 * @method     ChildAviso[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAviso objects based on current ModelCriteria
 * @method     ChildAviso[]|ObjectCollection findById(int $id) Return ChildAviso objects filtered by the id column
 * @method     ChildAviso[]|ObjectCollection findByFkAsociacion(int $fk_asociacion) Return ChildAviso objects filtered by the fk_asociacion column
 * @method     ChildAviso[]|ObjectCollection findByAviso(string $aviso) Return ChildAviso objects filtered by the aviso column
 * @method     ChildAviso[]|ObjectCollection findByAutor(string $autor) Return ChildAviso objects filtered by the autor column
 * @method     ChildAviso[]|ObjectCollection findByFechaAlta(string $fecha_alta) Return ChildAviso objects filtered by the fecha_alta column
 * @method     ChildAviso[]|ObjectCollection findByFechaVigencia(string $fecha_vigencia) Return ChildAviso objects filtered by the fecha_vigencia column
 * @method     ChildAviso[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AvisoQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\AvisoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Aviso', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAvisoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAvisoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAvisoQuery) {
            return $criteria;
        }
        $query = new ChildAvisoQuery();
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
     * @return ChildAviso|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AvisoTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AvisoTableMap::DATABASE_NAME);
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
     * @return ChildAviso A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, fk_asociacion, aviso, autor, fecha_alta, fecha_vigencia FROM aviso WHERE id = :p0';
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
            /** @var ChildAviso $obj */
            $obj = new ChildAviso();
            $obj->hydrate($row);
            AvisoTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAviso|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAvisoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AvisoTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAvisoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AvisoTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAvisoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AvisoTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AvisoTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AvisoTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildAvisoQuery The current query, for fluid interface
     */
    public function filterByFkAsociacion($fkAsociacion = null, $comparison = null)
    {
        if (is_array($fkAsociacion)) {
            $useMinMax = false;
            if (isset($fkAsociacion['min'])) {
                $this->addUsingAlias(AvisoTableMap::COL_FK_ASOCIACION, $fkAsociacion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fkAsociacion['max'])) {
                $this->addUsingAlias(AvisoTableMap::COL_FK_ASOCIACION, $fkAsociacion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AvisoTableMap::COL_FK_ASOCIACION, $fkAsociacion, $comparison);
    }

    /**
     * Filter the query on the aviso column
     *
     * Example usage:
     * <code>
     * $query->filterByAviso('fooValue');   // WHERE aviso = 'fooValue'
     * $query->filterByAviso('%fooValue%'); // WHERE aviso LIKE '%fooValue%'
     * </code>
     *
     * @param     string $aviso The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAvisoQuery The current query, for fluid interface
     */
    public function filterByAviso($aviso = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($aviso)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $aviso)) {
                $aviso = str_replace('*', '%', $aviso);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AvisoTableMap::COL_AVISO, $aviso, $comparison);
    }

    /**
     * Filter the query on the autor column
     *
     * Example usage:
     * <code>
     * $query->filterByAutor('fooValue');   // WHERE autor = 'fooValue'
     * $query->filterByAutor('%fooValue%'); // WHERE autor LIKE '%fooValue%'
     * </code>
     *
     * @param     string $autor The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAvisoQuery The current query, for fluid interface
     */
    public function filterByAutor($autor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($autor)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $autor)) {
                $autor = str_replace('*', '%', $autor);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AvisoTableMap::COL_AUTOR, $autor, $comparison);
    }

    /**
     * Filter the query on the fecha_alta column
     *
     * Example usage:
     * <code>
     * $query->filterByFechaAlta('2011-03-14'); // WHERE fecha_alta = '2011-03-14'
     * $query->filterByFechaAlta('now'); // WHERE fecha_alta = '2011-03-14'
     * $query->filterByFechaAlta(array('max' => 'yesterday')); // WHERE fecha_alta > '2011-03-13'
     * </code>
     *
     * @param     mixed $fechaAlta The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAvisoQuery The current query, for fluid interface
     */
    public function filterByFechaAlta($fechaAlta = null, $comparison = null)
    {
        if (is_array($fechaAlta)) {
            $useMinMax = false;
            if (isset($fechaAlta['min'])) {
                $this->addUsingAlias(AvisoTableMap::COL_FECHA_ALTA, $fechaAlta['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechaAlta['max'])) {
                $this->addUsingAlias(AvisoTableMap::COL_FECHA_ALTA, $fechaAlta['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AvisoTableMap::COL_FECHA_ALTA, $fechaAlta, $comparison);
    }

    /**
     * Filter the query on the fecha_vigencia column
     *
     * Example usage:
     * <code>
     * $query->filterByFechaVigencia('2011-03-14'); // WHERE fecha_vigencia = '2011-03-14'
     * $query->filterByFechaVigencia('now'); // WHERE fecha_vigencia = '2011-03-14'
     * $query->filterByFechaVigencia(array('max' => 'yesterday')); // WHERE fecha_vigencia > '2011-03-13'
     * </code>
     *
     * @param     mixed $fechaVigencia The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAvisoQuery The current query, for fluid interface
     */
    public function filterByFechaVigencia($fechaVigencia = null, $comparison = null)
    {
        if (is_array($fechaVigencia)) {
            $useMinMax = false;
            if (isset($fechaVigencia['min'])) {
                $this->addUsingAlias(AvisoTableMap::COL_FECHA_VIGENCIA, $fechaVigencia['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechaVigencia['max'])) {
                $this->addUsingAlias(AvisoTableMap::COL_FECHA_VIGENCIA, $fechaVigencia['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AvisoTableMap::COL_FECHA_VIGENCIA, $fechaVigencia, $comparison);
    }

    /**
     * Filter the query by a related \Asociacion object
     *
     * @param \Asociacion|ObjectCollection $asociacion The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAvisoQuery The current query, for fluid interface
     */
    public function filterByAsociacion($asociacion, $comparison = null)
    {
        if ($asociacion instanceof \Asociacion) {
            return $this
                ->addUsingAlias(AvisoTableMap::COL_FK_ASOCIACION, $asociacion->getId(), $comparison);
        } elseif ($asociacion instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AvisoTableMap::COL_FK_ASOCIACION, $asociacion->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildAvisoQuery The current query, for fluid interface
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
     * @param   ChildAviso $aviso Object to remove from the list of results
     *
     * @return $this|ChildAvisoQuery The current query, for fluid interface
     */
    public function prune($aviso = null)
    {
        if ($aviso) {
            $this->addUsingAlias(AvisoTableMap::COL_ID, $aviso->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the aviso table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AvisoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AvisoTableMap::clearInstancePool();
            AvisoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AvisoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AvisoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AvisoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AvisoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AvisoQuery
