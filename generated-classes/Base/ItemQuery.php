<?php

namespace Base;

use \Item as ChildItem;
use \ItemQuery as ChildItemQuery;
use \Exception;
use \PDO;
use Map\ItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'item' table.
 *
 *
 *
 * @method     ChildItemQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildItemQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method     ChildItemQuery orderByResponsable($order = Criteria::ASC) Order by the responsable column
 * @method     ChildItemQuery orderByDescripcion($order = Criteria::ASC) Order by the descripcion column
 * @method     ChildItemQuery orderByFkItemAportacion($order = Criteria::ASC) Order by the fk_item_aportacion column
 * @method     ChildItemQuery orderByFkItemRequisitos($order = Criteria::ASC) Order by the fk_item_requisitos column
 * @method     ChildItemQuery orderByFkProyecto($order = Criteria::ASC) Order by the fk_proyecto column
 *
 * @method     ChildItemQuery groupById() Group by the id column
 * @method     ChildItemQuery groupByNombre() Group by the nombre column
 * @method     ChildItemQuery groupByResponsable() Group by the responsable column
 * @method     ChildItemQuery groupByDescripcion() Group by the descripcion column
 * @method     ChildItemQuery groupByFkItemAportacion() Group by the fk_item_aportacion column
 * @method     ChildItemQuery groupByFkItemRequisitos() Group by the fk_item_requisitos column
 * @method     ChildItemQuery groupByFkProyecto() Group by the fk_proyecto column
 *
 * @method     ChildItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemQuery leftJoinItemAportacion($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemAportacion relation
 * @method     ChildItemQuery rightJoinItemAportacion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemAportacion relation
 * @method     ChildItemQuery innerJoinItemAportacion($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemAportacion relation
 *
 * @method     ChildItemQuery leftJoinProyecto($relationAlias = null) Adds a LEFT JOIN clause to the query using the Proyecto relation
 * @method     ChildItemQuery rightJoinProyecto($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Proyecto relation
 * @method     ChildItemQuery innerJoinProyecto($relationAlias = null) Adds a INNER JOIN clause to the query using the Proyecto relation
 *
 * @method     ChildItemQuery leftJoinAportacion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Aportacion relation
 * @method     ChildItemQuery rightJoinAportacion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Aportacion relation
 * @method     ChildItemQuery innerJoinAportacion($relationAlias = null) Adds a INNER JOIN clause to the query using the Aportacion relation
 *
 * @method     \ItemAportacionQuery|\ProyectoQuery|\AportacionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItem findOne(ConnectionInterface $con = null) Return the first ChildItem matching the query
 * @method     ChildItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItem matching the query, or a new ChildItem object populated from the query conditions when no match is found
 *
 * @method     ChildItem findOneById(int $id) Return the first ChildItem filtered by the id column
 * @method     ChildItem findOneByNombre(string $nombre) Return the first ChildItem filtered by the nombre column
 * @method     ChildItem findOneByResponsable(string $responsable) Return the first ChildItem filtered by the responsable column
 * @method     ChildItem findOneByDescripcion(string $descripcion) Return the first ChildItem filtered by the descripcion column
 * @method     ChildItem findOneByFkItemAportacion(int $fk_item_aportacion) Return the first ChildItem filtered by the fk_item_aportacion column
 * @method     ChildItem findOneByFkItemRequisitos(int $fk_item_requisitos) Return the first ChildItem filtered by the fk_item_requisitos column
 * @method     ChildItem findOneByFkProyecto(int $fk_proyecto) Return the first ChildItem filtered by the fk_proyecto column
 *
 * @method     ChildItem[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItem objects based on current ModelCriteria
 * @method     ChildItem[]|ObjectCollection findById(int $id) Return ChildItem objects filtered by the id column
 * @method     ChildItem[]|ObjectCollection findByNombre(string $nombre) Return ChildItem objects filtered by the nombre column
 * @method     ChildItem[]|ObjectCollection findByResponsable(string $responsable) Return ChildItem objects filtered by the responsable column
 * @method     ChildItem[]|ObjectCollection findByDescripcion(string $descripcion) Return ChildItem objects filtered by the descripcion column
 * @method     ChildItem[]|ObjectCollection findByFkItemAportacion(int $fk_item_aportacion) Return ChildItem objects filtered by the fk_item_aportacion column
 * @method     ChildItem[]|ObjectCollection findByFkItemRequisitos(int $fk_item_requisitos) Return ChildItem objects filtered by the fk_item_requisitos column
 * @method     ChildItem[]|ObjectCollection findByFkProyecto(int $fk_proyecto) Return ChildItem objects filtered by the fk_proyecto column
 * @method     ChildItem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\ItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Item', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemQuery) {
            return $criteria;
        }
        $query = new ChildItemQuery();
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
     * @return ChildItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ItemTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemTableMap::DATABASE_NAME);
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
     * @return ChildItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, nombre, responsable, descripcion, fk_item_aportacion, fk_item_requisitos, fk_proyecto FROM item WHERE id = :p0';
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
            /** @var ChildItem $obj */
            $obj = new ChildItem();
            $obj->hydrate($row);
            ItemTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildItem|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ItemTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ItemTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ItemTableMap::COL_NOMBRE, $nombre, $comparison);
    }

    /**
     * Filter the query on the responsable column
     *
     * Example usage:
     * <code>
     * $query->filterByResponsable('fooValue');   // WHERE responsable = 'fooValue'
     * $query->filterByResponsable('%fooValue%'); // WHERE responsable LIKE '%fooValue%'
     * </code>
     *
     * @param     string $responsable The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByResponsable($responsable = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($responsable)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $responsable)) {
                $responsable = str_replace('*', '%', $responsable);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_RESPONSABLE, $responsable, $comparison);
    }

    /**
     * Filter the query on the descripcion column
     *
     * Example usage:
     * <code>
     * $query->filterByDescripcion('fooValue');   // WHERE descripcion = 'fooValue'
     * $query->filterByDescripcion('%fooValue%'); // WHERE descripcion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $descripcion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByDescripcion($descripcion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($descripcion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $descripcion)) {
                $descripcion = str_replace('*', '%', $descripcion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_DESCRIPCION, $descripcion, $comparison);
    }

    /**
     * Filter the query on the fk_item_aportacion column
     *
     * Example usage:
     * <code>
     * $query->filterByFkItemAportacion(1234); // WHERE fk_item_aportacion = 1234
     * $query->filterByFkItemAportacion(array(12, 34)); // WHERE fk_item_aportacion IN (12, 34)
     * $query->filterByFkItemAportacion(array('min' => 12)); // WHERE fk_item_aportacion > 12
     * </code>
     *
     * @see       filterByItemAportacion()
     *
     * @param     mixed $fkItemAportacion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByFkItemAportacion($fkItemAportacion = null, $comparison = null)
    {
        if (is_array($fkItemAportacion)) {
            $useMinMax = false;
            if (isset($fkItemAportacion['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_FK_ITEM_APORTACION, $fkItemAportacion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fkItemAportacion['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_FK_ITEM_APORTACION, $fkItemAportacion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_FK_ITEM_APORTACION, $fkItemAportacion, $comparison);
    }

    /**
     * Filter the query on the fk_item_requisitos column
     *
     * Example usage:
     * <code>
     * $query->filterByFkItemRequisitos(1234); // WHERE fk_item_requisitos = 1234
     * $query->filterByFkItemRequisitos(array(12, 34)); // WHERE fk_item_requisitos IN (12, 34)
     * $query->filterByFkItemRequisitos(array('min' => 12)); // WHERE fk_item_requisitos > 12
     * </code>
     *
     * @param     mixed $fkItemRequisitos The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByFkItemRequisitos($fkItemRequisitos = null, $comparison = null)
    {
        if (is_array($fkItemRequisitos)) {
            $useMinMax = false;
            if (isset($fkItemRequisitos['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_FK_ITEM_REQUISITOS, $fkItemRequisitos['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fkItemRequisitos['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_FK_ITEM_REQUISITOS, $fkItemRequisitos['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_FK_ITEM_REQUISITOS, $fkItemRequisitos, $comparison);
    }

    /**
     * Filter the query on the fk_proyecto column
     *
     * Example usage:
     * <code>
     * $query->filterByFkProyecto(1234); // WHERE fk_proyecto = 1234
     * $query->filterByFkProyecto(array(12, 34)); // WHERE fk_proyecto IN (12, 34)
     * $query->filterByFkProyecto(array('min' => 12)); // WHERE fk_proyecto > 12
     * </code>
     *
     * @see       filterByProyecto()
     *
     * @param     mixed $fkProyecto The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByFkProyecto($fkProyecto = null, $comparison = null)
    {
        if (is_array($fkProyecto)) {
            $useMinMax = false;
            if (isset($fkProyecto['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_FK_PROYECTO, $fkProyecto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fkProyecto['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_FK_PROYECTO, $fkProyecto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_FK_PROYECTO, $fkProyecto, $comparison);
    }

    /**
     * Filter the query by a related \ItemAportacion object
     *
     * @param \ItemAportacion|ObjectCollection $itemAportacion The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByItemAportacion($itemAportacion, $comparison = null)
    {
        if ($itemAportacion instanceof \ItemAportacion) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_FK_ITEM_APORTACION, $itemAportacion->getId(), $comparison);
        } elseif ($itemAportacion instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_FK_ITEM_APORTACION, $itemAportacion->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByItemAportacion() only accepts arguments of type \ItemAportacion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ItemAportacion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinItemAportacion($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ItemAportacion');

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
            $this->addJoinObject($join, 'ItemAportacion');
        }

        return $this;
    }

    /**
     * Use the ItemAportacion relation ItemAportacion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ItemAportacionQuery A secondary query class using the current class as primary query
     */
    public function useItemAportacionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinItemAportacion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ItemAportacion', '\ItemAportacionQuery');
    }

    /**
     * Filter the query by a related \Proyecto object
     *
     * @param \Proyecto|ObjectCollection $proyecto The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByProyecto($proyecto, $comparison = null)
    {
        if ($proyecto instanceof \Proyecto) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_FK_PROYECTO, $proyecto->getId(), $comparison);
        } elseif ($proyecto instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_FK_PROYECTO, $proyecto->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
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
     * Filter the query by a related \Aportacion object
     *
     * @param \Aportacion|ObjectCollection $aportacion  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByAportacion($aportacion, $comparison = null)
    {
        if ($aportacion instanceof \Aportacion) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_ID, $aportacion->getFkItem(), $comparison);
        } elseif ($aportacion instanceof ObjectCollection) {
            return $this
                ->useAportacionQuery()
                ->filterByPrimaryKeys($aportacion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAportacion() only accepts arguments of type \Aportacion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Aportacion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinAportacion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Aportacion');

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
            $this->addJoinObject($join, 'Aportacion');
        }

        return $this;
    }

    /**
     * Use the Aportacion relation Aportacion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AportacionQuery A secondary query class using the current class as primary query
     */
    public function useAportacionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAportacion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Aportacion', '\AportacionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildItem $item Object to remove from the list of results
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function prune($item = null)
    {
        if ($item) {
            $this->addUsingAlias(ItemTableMap::COL_ID, $item->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemTableMap::clearInstancePool();
            ItemTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ItemQuery
