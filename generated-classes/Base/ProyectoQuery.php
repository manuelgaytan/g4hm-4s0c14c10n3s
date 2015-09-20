<?php

namespace Base;

use \Proyecto as ChildProyecto;
use \ProyectoQuery as ChildProyectoQuery;
use \Exception;
use \PDO;
use Map\ProyectoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'proyecto' table.
 *
 *
 *
 * @method     ChildProyectoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildProyectoQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method     ChildProyectoQuery orderByDescripcion($order = Criteria::ASC) Order by the descripcion column
 * @method     ChildProyectoQuery orderByContacto($order = Criteria::ASC) Order by the contacto column
 * @method     ChildProyectoQuery orderByTelefono($order = Criteria::ASC) Order by the telefono column
 * @method     ChildProyectoQuery orderByCorreoElectronico($order = Criteria::ASC) Order by the correo_electronico column
 * @method     ChildProyectoQuery orderByFechaAlta($order = Criteria::ASC) Order by the fecha_alta column
 * @method     ChildProyectoQuery orderByFechaInicio($order = Criteria::ASC) Order by the fecha_inicio column
 * @method     ChildProyectoQuery orderByFechaFin($order = Criteria::ASC) Order by the fecha_fin column
 * @method     ChildProyectoQuery orderByFkAsociacion($order = Criteria::ASC) Order by the fk_asociacion column
 *
 * @method     ChildProyectoQuery groupById() Group by the id column
 * @method     ChildProyectoQuery groupByNombre() Group by the nombre column
 * @method     ChildProyectoQuery groupByDescripcion() Group by the descripcion column
 * @method     ChildProyectoQuery groupByContacto() Group by the contacto column
 * @method     ChildProyectoQuery groupByTelefono() Group by the telefono column
 * @method     ChildProyectoQuery groupByCorreoElectronico() Group by the correo_electronico column
 * @method     ChildProyectoQuery groupByFechaAlta() Group by the fecha_alta column
 * @method     ChildProyectoQuery groupByFechaInicio() Group by the fecha_inicio column
 * @method     ChildProyectoQuery groupByFechaFin() Group by the fecha_fin column
 * @method     ChildProyectoQuery groupByFkAsociacion() Group by the fk_asociacion column
 *
 * @method     ChildProyectoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProyectoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProyectoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProyectoQuery leftJoinAsociacion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Asociacion relation
 * @method     ChildProyectoQuery rightJoinAsociacion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Asociacion relation
 * @method     ChildProyectoQuery innerJoinAsociacion($relationAlias = null) Adds a INNER JOIN clause to the query using the Asociacion relation
 *
 * @method     ChildProyectoQuery leftJoinIntegranteProyecto($relationAlias = null) Adds a LEFT JOIN clause to the query using the IntegranteProyecto relation
 * @method     ChildProyectoQuery rightJoinIntegranteProyecto($relationAlias = null) Adds a RIGHT JOIN clause to the query using the IntegranteProyecto relation
 * @method     ChildProyectoQuery innerJoinIntegranteProyecto($relationAlias = null) Adds a INNER JOIN clause to the query using the IntegranteProyecto relation
 *
 * @method     ChildProyectoQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildProyectoQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildProyectoQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     \AsociacionQuery|\IntegranteProyectoQuery|\ItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildProyecto findOne(ConnectionInterface $con = null) Return the first ChildProyecto matching the query
 * @method     ChildProyecto findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProyecto matching the query, or a new ChildProyecto object populated from the query conditions when no match is found
 *
 * @method     ChildProyecto findOneById(int $id) Return the first ChildProyecto filtered by the id column
 * @method     ChildProyecto findOneByNombre(string $nombre) Return the first ChildProyecto filtered by the nombre column
 * @method     ChildProyecto findOneByDescripcion(string $descripcion) Return the first ChildProyecto filtered by the descripcion column
 * @method     ChildProyecto findOneByContacto(string $contacto) Return the first ChildProyecto filtered by the contacto column
 * @method     ChildProyecto findOneByTelefono(string $telefono) Return the first ChildProyecto filtered by the telefono column
 * @method     ChildProyecto findOneByCorreoElectronico(string $correo_electronico) Return the first ChildProyecto filtered by the correo_electronico column
 * @method     ChildProyecto findOneByFechaAlta(string $fecha_alta) Return the first ChildProyecto filtered by the fecha_alta column
 * @method     ChildProyecto findOneByFechaInicio(string $fecha_inicio) Return the first ChildProyecto filtered by the fecha_inicio column
 * @method     ChildProyecto findOneByFechaFin(string $fecha_fin) Return the first ChildProyecto filtered by the fecha_fin column
 * @method     ChildProyecto findOneByFkAsociacion(int $fk_asociacion) Return the first ChildProyecto filtered by the fk_asociacion column
 *
 * @method     ChildProyecto[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildProyecto objects based on current ModelCriteria
 * @method     ChildProyecto[]|ObjectCollection findById(int $id) Return ChildProyecto objects filtered by the id column
 * @method     ChildProyecto[]|ObjectCollection findByNombre(string $nombre) Return ChildProyecto objects filtered by the nombre column
 * @method     ChildProyecto[]|ObjectCollection findByDescripcion(string $descripcion) Return ChildProyecto objects filtered by the descripcion column
 * @method     ChildProyecto[]|ObjectCollection findByContacto(string $contacto) Return ChildProyecto objects filtered by the contacto column
 * @method     ChildProyecto[]|ObjectCollection findByTelefono(string $telefono) Return ChildProyecto objects filtered by the telefono column
 * @method     ChildProyecto[]|ObjectCollection findByCorreoElectronico(string $correo_electronico) Return ChildProyecto objects filtered by the correo_electronico column
 * @method     ChildProyecto[]|ObjectCollection findByFechaAlta(string $fecha_alta) Return ChildProyecto objects filtered by the fecha_alta column
 * @method     ChildProyecto[]|ObjectCollection findByFechaInicio(string $fecha_inicio) Return ChildProyecto objects filtered by the fecha_inicio column
 * @method     ChildProyecto[]|ObjectCollection findByFechaFin(string $fecha_fin) Return ChildProyecto objects filtered by the fecha_fin column
 * @method     ChildProyecto[]|ObjectCollection findByFkAsociacion(int $fk_asociacion) Return ChildProyecto objects filtered by the fk_asociacion column
 * @method     ChildProyecto[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ProyectoQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\ProyectoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Proyecto', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProyectoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProyectoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildProyectoQuery) {
            return $criteria;
        }
        $query = new ChildProyectoQuery();
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
     * @return ChildProyecto|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProyectoTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProyectoTableMap::DATABASE_NAME);
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
     * @return ChildProyecto A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, nombre, descripcion, contacto, telefono, correo_electronico, fecha_alta, fecha_inicio, fecha_fin, fk_asociacion FROM proyecto WHERE id = :p0';
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
            /** @var ChildProyecto $obj */
            $obj = new ChildProyecto();
            $obj->hydrate($row);
            ProyectoTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildProyecto|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildProyectoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProyectoTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildProyectoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProyectoTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildProyectoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProyectoTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProyectoTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProyectoTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildProyectoQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProyectoTableMap::COL_NOMBRE, $nombre, $comparison);
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
     * @return $this|ChildProyectoQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProyectoTableMap::COL_DESCRIPCION, $descripcion, $comparison);
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
     * @return $this|ChildProyectoQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProyectoTableMap::COL_CONTACTO, $contacto, $comparison);
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
     * @return $this|ChildProyectoQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProyectoTableMap::COL_TELEFONO, $telefono, $comparison);
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
     * @return $this|ChildProyectoQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProyectoTableMap::COL_CORREO_ELECTRONICO, $correoElectronico, $comparison);
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
     * @return $this|ChildProyectoQuery The current query, for fluid interface
     */
    public function filterByFechaAlta($fechaAlta = null, $comparison = null)
    {
        if (is_array($fechaAlta)) {
            $useMinMax = false;
            if (isset($fechaAlta['min'])) {
                $this->addUsingAlias(ProyectoTableMap::COL_FECHA_ALTA, $fechaAlta['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechaAlta['max'])) {
                $this->addUsingAlias(ProyectoTableMap::COL_FECHA_ALTA, $fechaAlta['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProyectoTableMap::COL_FECHA_ALTA, $fechaAlta, $comparison);
    }

    /**
     * Filter the query on the fecha_inicio column
     *
     * Example usage:
     * <code>
     * $query->filterByFechaInicio('2011-03-14'); // WHERE fecha_inicio = '2011-03-14'
     * $query->filterByFechaInicio('now'); // WHERE fecha_inicio = '2011-03-14'
     * $query->filterByFechaInicio(array('max' => 'yesterday')); // WHERE fecha_inicio > '2011-03-13'
     * </code>
     *
     * @param     mixed $fechaInicio The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProyectoQuery The current query, for fluid interface
     */
    public function filterByFechaInicio($fechaInicio = null, $comparison = null)
    {
        if (is_array($fechaInicio)) {
            $useMinMax = false;
            if (isset($fechaInicio['min'])) {
                $this->addUsingAlias(ProyectoTableMap::COL_FECHA_INICIO, $fechaInicio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechaInicio['max'])) {
                $this->addUsingAlias(ProyectoTableMap::COL_FECHA_INICIO, $fechaInicio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProyectoTableMap::COL_FECHA_INICIO, $fechaInicio, $comparison);
    }

    /**
     * Filter the query on the fecha_fin column
     *
     * Example usage:
     * <code>
     * $query->filterByFechaFin('2011-03-14'); // WHERE fecha_fin = '2011-03-14'
     * $query->filterByFechaFin('now'); // WHERE fecha_fin = '2011-03-14'
     * $query->filterByFechaFin(array('max' => 'yesterday')); // WHERE fecha_fin > '2011-03-13'
     * </code>
     *
     * @param     mixed $fechaFin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProyectoQuery The current query, for fluid interface
     */
    public function filterByFechaFin($fechaFin = null, $comparison = null)
    {
        if (is_array($fechaFin)) {
            $useMinMax = false;
            if (isset($fechaFin['min'])) {
                $this->addUsingAlias(ProyectoTableMap::COL_FECHA_FIN, $fechaFin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechaFin['max'])) {
                $this->addUsingAlias(ProyectoTableMap::COL_FECHA_FIN, $fechaFin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProyectoTableMap::COL_FECHA_FIN, $fechaFin, $comparison);
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
     * @return $this|ChildProyectoQuery The current query, for fluid interface
     */
    public function filterByFkAsociacion($fkAsociacion = null, $comparison = null)
    {
        if (is_array($fkAsociacion)) {
            $useMinMax = false;
            if (isset($fkAsociacion['min'])) {
                $this->addUsingAlias(ProyectoTableMap::COL_FK_ASOCIACION, $fkAsociacion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fkAsociacion['max'])) {
                $this->addUsingAlias(ProyectoTableMap::COL_FK_ASOCIACION, $fkAsociacion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProyectoTableMap::COL_FK_ASOCIACION, $fkAsociacion, $comparison);
    }

    /**
     * Filter the query by a related \Asociacion object
     *
     * @param \Asociacion|ObjectCollection $asociacion The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildProyectoQuery The current query, for fluid interface
     */
    public function filterByAsociacion($asociacion, $comparison = null)
    {
        if ($asociacion instanceof \Asociacion) {
            return $this
                ->addUsingAlias(ProyectoTableMap::COL_FK_ASOCIACION, $asociacion->getId(), $comparison);
        } elseif ($asociacion instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProyectoTableMap::COL_FK_ASOCIACION, $asociacion->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildProyectoQuery The current query, for fluid interface
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
     * Filter the query by a related \IntegranteProyecto object
     *
     * @param \IntegranteProyecto|ObjectCollection $integranteProyecto  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProyectoQuery The current query, for fluid interface
     */
    public function filterByIntegranteProyecto($integranteProyecto, $comparison = null)
    {
        if ($integranteProyecto instanceof \IntegranteProyecto) {
            return $this
                ->addUsingAlias(ProyectoTableMap::COL_ID, $integranteProyecto->getFkProyecto(), $comparison);
        } elseif ($integranteProyecto instanceof ObjectCollection) {
            return $this
                ->useIntegranteProyectoQuery()
                ->filterByPrimaryKeys($integranteProyecto->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByIntegranteProyecto() only accepts arguments of type \IntegranteProyecto or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the IntegranteProyecto relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProyectoQuery The current query, for fluid interface
     */
    public function joinIntegranteProyecto($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('IntegranteProyecto');

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
            $this->addJoinObject($join, 'IntegranteProyecto');
        }

        return $this;
    }

    /**
     * Use the IntegranteProyecto relation IntegranteProyecto object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \IntegranteProyectoQuery A secondary query class using the current class as primary query
     */
    public function useIntegranteProyectoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinIntegranteProyecto($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'IntegranteProyecto', '\IntegranteProyectoQuery');
    }

    /**
     * Filter the query by a related \Item object
     *
     * @param \Item|ObjectCollection $item  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProyectoQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \Item) {
            return $this
                ->addUsingAlias(ProyectoTableMap::COL_ID, $item->getFkProyecto(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            return $this
                ->useItemQuery()
                ->filterByPrimaryKeys($item->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildProyectoQuery The current query, for fluid interface
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
     * @param   ChildProyecto $proyecto Object to remove from the list of results
     *
     * @return $this|ChildProyectoQuery The current query, for fluid interface
     */
    public function prune($proyecto = null)
    {
        if ($proyecto) {
            $this->addUsingAlias(ProyectoTableMap::COL_ID, $proyecto->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the proyecto table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProyectoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProyectoTableMap::clearInstancePool();
            ProyectoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ProyectoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProyectoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ProyectoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProyectoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ProyectoQuery
