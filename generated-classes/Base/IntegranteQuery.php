<?php

namespace Base;

use \Integrante as ChildIntegrante;
use \IntegranteQuery as ChildIntegranteQuery;
use \Exception;
use \PDO;
use Map\IntegranteTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'integrante' table.
 *
 *
 *
 * @method     ChildIntegranteQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildIntegranteQuery orderByFkUsuario($order = Criteria::ASC) Order by the fk_usuario column
 * @method     ChildIntegranteQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method     ChildIntegranteQuery orderByApellidoPaterno($order = Criteria::ASC) Order by the apellido_paterno column
 * @method     ChildIntegranteQuery orderByApellidoMaterno($order = Criteria::ASC) Order by the apellido_materno column
 * @method     ChildIntegranteQuery orderByFechaNacimiento($order = Criteria::ASC) Order by the fecha_nacimiento column
 * @method     ChildIntegranteQuery orderByRfc($order = Criteria::ASC) Order by the rfc column
 * @method     ChildIntegranteQuery orderByCurp($order = Criteria::ASC) Order by the curp column
 * @method     ChildIntegranteQuery orderByDomicilio($order = Criteria::ASC) Order by the domicilio column
 * @method     ChildIntegranteQuery orderByEstadoCivil($order = Criteria::ASC) Order by the estado_civil column
 * @method     ChildIntegranteQuery orderByCorreoElectronico($order = Criteria::ASC) Order by the correo_electronico column
 * @method     ChildIntegranteQuery orderByOcupacion($order = Criteria::ASC) Order by the ocupacion column
 * @method     ChildIntegranteQuery orderByQuienRecomienda($order = Criteria::ASC) Order by the quien_recomienda column
 * @method     ChildIntegranteQuery orderByObservaciones($order = Criteria::ASC) Order by the observaciones column
 *
 * @method     ChildIntegranteQuery groupById() Group by the id column
 * @method     ChildIntegranteQuery groupByFkUsuario() Group by the fk_usuario column
 * @method     ChildIntegranteQuery groupByNombre() Group by the nombre column
 * @method     ChildIntegranteQuery groupByApellidoPaterno() Group by the apellido_paterno column
 * @method     ChildIntegranteQuery groupByApellidoMaterno() Group by the apellido_materno column
 * @method     ChildIntegranteQuery groupByFechaNacimiento() Group by the fecha_nacimiento column
 * @method     ChildIntegranteQuery groupByRfc() Group by the rfc column
 * @method     ChildIntegranteQuery groupByCurp() Group by the curp column
 * @method     ChildIntegranteQuery groupByDomicilio() Group by the domicilio column
 * @method     ChildIntegranteQuery groupByEstadoCivil() Group by the estado_civil column
 * @method     ChildIntegranteQuery groupByCorreoElectronico() Group by the correo_electronico column
 * @method     ChildIntegranteQuery groupByOcupacion() Group by the ocupacion column
 * @method     ChildIntegranteQuery groupByQuienRecomienda() Group by the quien_recomienda column
 * @method     ChildIntegranteQuery groupByObservaciones() Group by the observaciones column
 *
 * @method     ChildIntegranteQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildIntegranteQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildIntegranteQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildIntegranteQuery leftJoinUsuario($relationAlias = null) Adds a LEFT JOIN clause to the query using the Usuario relation
 * @method     ChildIntegranteQuery rightJoinUsuario($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Usuario relation
 * @method     ChildIntegranteQuery innerJoinUsuario($relationAlias = null) Adds a INNER JOIN clause to the query using the Usuario relation
 *
 * @method     ChildIntegranteQuery leftJoinAportacion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Aportacion relation
 * @method     ChildIntegranteQuery rightJoinAportacion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Aportacion relation
 * @method     ChildIntegranteQuery innerJoinAportacion($relationAlias = null) Adds a INNER JOIN clause to the query using the Aportacion relation
 *
 * @method     ChildIntegranteQuery leftJoinIntegranteAsociacion($relationAlias = null) Adds a LEFT JOIN clause to the query using the IntegranteAsociacion relation
 * @method     ChildIntegranteQuery rightJoinIntegranteAsociacion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the IntegranteAsociacion relation
 * @method     ChildIntegranteQuery innerJoinIntegranteAsociacion($relationAlias = null) Adds a INNER JOIN clause to the query using the IntegranteAsociacion relation
 *
 * @method     ChildIntegranteQuery leftJoinIntegranteProyecto($relationAlias = null) Adds a LEFT JOIN clause to the query using the IntegranteProyecto relation
 * @method     ChildIntegranteQuery rightJoinIntegranteProyecto($relationAlias = null) Adds a RIGHT JOIN clause to the query using the IntegranteProyecto relation
 * @method     ChildIntegranteQuery innerJoinIntegranteProyecto($relationAlias = null) Adds a INNER JOIN clause to the query using the IntegranteProyecto relation
 *
 * @method     \UsuarioQuery|\AportacionQuery|\IntegranteAsociacionQuery|\IntegranteProyectoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildIntegrante findOne(ConnectionInterface $con = null) Return the first ChildIntegrante matching the query
 * @method     ChildIntegrante findOneOrCreate(ConnectionInterface $con = null) Return the first ChildIntegrante matching the query, or a new ChildIntegrante object populated from the query conditions when no match is found
 *
 * @method     ChildIntegrante findOneById(int $id) Return the first ChildIntegrante filtered by the id column
 * @method     ChildIntegrante findOneByFkUsuario(int $fk_usuario) Return the first ChildIntegrante filtered by the fk_usuario column
 * @method     ChildIntegrante findOneByNombre(string $nombre) Return the first ChildIntegrante filtered by the nombre column
 * @method     ChildIntegrante findOneByApellidoPaterno(string $apellido_paterno) Return the first ChildIntegrante filtered by the apellido_paterno column
 * @method     ChildIntegrante findOneByApellidoMaterno(string $apellido_materno) Return the first ChildIntegrante filtered by the apellido_materno column
 * @method     ChildIntegrante findOneByFechaNacimiento(string $fecha_nacimiento) Return the first ChildIntegrante filtered by the fecha_nacimiento column
 * @method     ChildIntegrante findOneByRfc(string $rfc) Return the first ChildIntegrante filtered by the rfc column
 * @method     ChildIntegrante findOneByCurp(string $curp) Return the first ChildIntegrante filtered by the curp column
 * @method     ChildIntegrante findOneByDomicilio(string $domicilio) Return the first ChildIntegrante filtered by the domicilio column
 * @method     ChildIntegrante findOneByEstadoCivil(string $estado_civil) Return the first ChildIntegrante filtered by the estado_civil column
 * @method     ChildIntegrante findOneByCorreoElectronico(string $correo_electronico) Return the first ChildIntegrante filtered by the correo_electronico column
 * @method     ChildIntegrante findOneByOcupacion(string $ocupacion) Return the first ChildIntegrante filtered by the ocupacion column
 * @method     ChildIntegrante findOneByQuienRecomienda(string $quien_recomienda) Return the first ChildIntegrante filtered by the quien_recomienda column
 * @method     ChildIntegrante findOneByObservaciones(string $observaciones) Return the first ChildIntegrante filtered by the observaciones column
 *
 * @method     ChildIntegrante[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildIntegrante objects based on current ModelCriteria
 * @method     ChildIntegrante[]|ObjectCollection findById(int $id) Return ChildIntegrante objects filtered by the id column
 * @method     ChildIntegrante[]|ObjectCollection findByFkUsuario(int $fk_usuario) Return ChildIntegrante objects filtered by the fk_usuario column
 * @method     ChildIntegrante[]|ObjectCollection findByNombre(string $nombre) Return ChildIntegrante objects filtered by the nombre column
 * @method     ChildIntegrante[]|ObjectCollection findByApellidoPaterno(string $apellido_paterno) Return ChildIntegrante objects filtered by the apellido_paterno column
 * @method     ChildIntegrante[]|ObjectCollection findByApellidoMaterno(string $apellido_materno) Return ChildIntegrante objects filtered by the apellido_materno column
 * @method     ChildIntegrante[]|ObjectCollection findByFechaNacimiento(string $fecha_nacimiento) Return ChildIntegrante objects filtered by the fecha_nacimiento column
 * @method     ChildIntegrante[]|ObjectCollection findByRfc(string $rfc) Return ChildIntegrante objects filtered by the rfc column
 * @method     ChildIntegrante[]|ObjectCollection findByCurp(string $curp) Return ChildIntegrante objects filtered by the curp column
 * @method     ChildIntegrante[]|ObjectCollection findByDomicilio(string $domicilio) Return ChildIntegrante objects filtered by the domicilio column
 * @method     ChildIntegrante[]|ObjectCollection findByEstadoCivil(string $estado_civil) Return ChildIntegrante objects filtered by the estado_civil column
 * @method     ChildIntegrante[]|ObjectCollection findByCorreoElectronico(string $correo_electronico) Return ChildIntegrante objects filtered by the correo_electronico column
 * @method     ChildIntegrante[]|ObjectCollection findByOcupacion(string $ocupacion) Return ChildIntegrante objects filtered by the ocupacion column
 * @method     ChildIntegrante[]|ObjectCollection findByQuienRecomienda(string $quien_recomienda) Return ChildIntegrante objects filtered by the quien_recomienda column
 * @method     ChildIntegrante[]|ObjectCollection findByObservaciones(string $observaciones) Return ChildIntegrante objects filtered by the observaciones column
 * @method     ChildIntegrante[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class IntegranteQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\IntegranteQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Integrante', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildIntegranteQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildIntegranteQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildIntegranteQuery) {
            return $criteria;
        }
        $query = new ChildIntegranteQuery();
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
     * @return ChildIntegrante|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = IntegranteTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(IntegranteTableMap::DATABASE_NAME);
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
     * @return ChildIntegrante A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, fk_usuario, nombre, apellido_paterno, apellido_materno, fecha_nacimiento, rfc, curp, domicilio, estado_civil, correo_electronico, ocupacion, quien_recomienda, observaciones FROM integrante WHERE id = :p0';
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
            /** @var ChildIntegrante $obj */
            $obj = new ChildIntegrante();
            $obj->hydrate($row);
            IntegranteTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildIntegrante|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(IntegranteTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(IntegranteTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(IntegranteTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(IntegranteTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IntegranteTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the fk_usuario column
     *
     * Example usage:
     * <code>
     * $query->filterByFkUsuario(1234); // WHERE fk_usuario = 1234
     * $query->filterByFkUsuario(array(12, 34)); // WHERE fk_usuario IN (12, 34)
     * $query->filterByFkUsuario(array('min' => 12)); // WHERE fk_usuario > 12
     * </code>
     *
     * @see       filterByUsuario()
     *
     * @param     mixed $fkUsuario The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByFkUsuario($fkUsuario = null, $comparison = null)
    {
        if (is_array($fkUsuario)) {
            $useMinMax = false;
            if (isset($fkUsuario['min'])) {
                $this->addUsingAlias(IntegranteTableMap::COL_FK_USUARIO, $fkUsuario['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fkUsuario['max'])) {
                $this->addUsingAlias(IntegranteTableMap::COL_FK_USUARIO, $fkUsuario['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IntegranteTableMap::COL_FK_USUARIO, $fkUsuario, $comparison);
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
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
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

        return $this->addUsingAlias(IntegranteTableMap::COL_NOMBRE, $nombre, $comparison);
    }

    /**
     * Filter the query on the apellido_paterno column
     *
     * Example usage:
     * <code>
     * $query->filterByApellidoPaterno('fooValue');   // WHERE apellido_paterno = 'fooValue'
     * $query->filterByApellidoPaterno('%fooValue%'); // WHERE apellido_paterno LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apellidoPaterno The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByApellidoPaterno($apellidoPaterno = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apellidoPaterno)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apellidoPaterno)) {
                $apellidoPaterno = str_replace('*', '%', $apellidoPaterno);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IntegranteTableMap::COL_APELLIDO_PATERNO, $apellidoPaterno, $comparison);
    }

    /**
     * Filter the query on the apellido_materno column
     *
     * Example usage:
     * <code>
     * $query->filterByApellidoMaterno('fooValue');   // WHERE apellido_materno = 'fooValue'
     * $query->filterByApellidoMaterno('%fooValue%'); // WHERE apellido_materno LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apellidoMaterno The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByApellidoMaterno($apellidoMaterno = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apellidoMaterno)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apellidoMaterno)) {
                $apellidoMaterno = str_replace('*', '%', $apellidoMaterno);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IntegranteTableMap::COL_APELLIDO_MATERNO, $apellidoMaterno, $comparison);
    }

    /**
     * Filter the query on the fecha_nacimiento column
     *
     * Example usage:
     * <code>
     * $query->filterByFechaNacimiento('2011-03-14'); // WHERE fecha_nacimiento = '2011-03-14'
     * $query->filterByFechaNacimiento('now'); // WHERE fecha_nacimiento = '2011-03-14'
     * $query->filterByFechaNacimiento(array('max' => 'yesterday')); // WHERE fecha_nacimiento > '2011-03-13'
     * </code>
     *
     * @param     mixed $fechaNacimiento The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByFechaNacimiento($fechaNacimiento = null, $comparison = null)
    {
        if (is_array($fechaNacimiento)) {
            $useMinMax = false;
            if (isset($fechaNacimiento['min'])) {
                $this->addUsingAlias(IntegranteTableMap::COL_FECHA_NACIMIENTO, $fechaNacimiento['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechaNacimiento['max'])) {
                $this->addUsingAlias(IntegranteTableMap::COL_FECHA_NACIMIENTO, $fechaNacimiento['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IntegranteTableMap::COL_FECHA_NACIMIENTO, $fechaNacimiento, $comparison);
    }

    /**
     * Filter the query on the rfc column
     *
     * Example usage:
     * <code>
     * $query->filterByRfc('fooValue');   // WHERE rfc = 'fooValue'
     * $query->filterByRfc('%fooValue%'); // WHERE rfc LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rfc The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByRfc($rfc = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rfc)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rfc)) {
                $rfc = str_replace('*', '%', $rfc);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IntegranteTableMap::COL_RFC, $rfc, $comparison);
    }

    /**
     * Filter the query on the curp column
     *
     * Example usage:
     * <code>
     * $query->filterByCurp('fooValue');   // WHERE curp = 'fooValue'
     * $query->filterByCurp('%fooValue%'); // WHERE curp LIKE '%fooValue%'
     * </code>
     *
     * @param     string $curp The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByCurp($curp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($curp)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $curp)) {
                $curp = str_replace('*', '%', $curp);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IntegranteTableMap::COL_CURP, $curp, $comparison);
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
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
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

        return $this->addUsingAlias(IntegranteTableMap::COL_DOMICILIO, $domicilio, $comparison);
    }

    /**
     * Filter the query on the estado_civil column
     *
     * Example usage:
     * <code>
     * $query->filterByEstadoCivil('fooValue');   // WHERE estado_civil = 'fooValue'
     * $query->filterByEstadoCivil('%fooValue%'); // WHERE estado_civil LIKE '%fooValue%'
     * </code>
     *
     * @param     string $estadoCivil The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByEstadoCivil($estadoCivil = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($estadoCivil)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $estadoCivil)) {
                $estadoCivil = str_replace('*', '%', $estadoCivil);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IntegranteTableMap::COL_ESTADO_CIVIL, $estadoCivil, $comparison);
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
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
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

        return $this->addUsingAlias(IntegranteTableMap::COL_CORREO_ELECTRONICO, $correoElectronico, $comparison);
    }

    /**
     * Filter the query on the ocupacion column
     *
     * Example usage:
     * <code>
     * $query->filterByOcupacion('fooValue');   // WHERE ocupacion = 'fooValue'
     * $query->filterByOcupacion('%fooValue%'); // WHERE ocupacion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ocupacion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByOcupacion($ocupacion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ocupacion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ocupacion)) {
                $ocupacion = str_replace('*', '%', $ocupacion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IntegranteTableMap::COL_OCUPACION, $ocupacion, $comparison);
    }

    /**
     * Filter the query on the quien_recomienda column
     *
     * Example usage:
     * <code>
     * $query->filterByQuienRecomienda('fooValue');   // WHERE quien_recomienda = 'fooValue'
     * $query->filterByQuienRecomienda('%fooValue%'); // WHERE quien_recomienda LIKE '%fooValue%'
     * </code>
     *
     * @param     string $quienRecomienda The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByQuienRecomienda($quienRecomienda = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($quienRecomienda)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $quienRecomienda)) {
                $quienRecomienda = str_replace('*', '%', $quienRecomienda);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IntegranteTableMap::COL_QUIEN_RECOMIENDA, $quienRecomienda, $comparison);
    }

    /**
     * Filter the query on the observaciones column
     *
     * Example usage:
     * <code>
     * $query->filterByObservaciones('fooValue');   // WHERE observaciones = 'fooValue'
     * $query->filterByObservaciones('%fooValue%'); // WHERE observaciones LIKE '%fooValue%'
     * </code>
     *
     * @param     string $observaciones The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByObservaciones($observaciones = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($observaciones)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $observaciones)) {
                $observaciones = str_replace('*', '%', $observaciones);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(IntegranteTableMap::COL_OBSERVACIONES, $observaciones, $comparison);
    }

    /**
     * Filter the query by a related \Usuario object
     *
     * @param \Usuario|ObjectCollection $usuario The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByUsuario($usuario, $comparison = null)
    {
        if ($usuario instanceof \Usuario) {
            return $this
                ->addUsingAlias(IntegranteTableMap::COL_FK_USUARIO, $usuario->getId(), $comparison);
        } elseif ($usuario instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IntegranteTableMap::COL_FK_USUARIO, $usuario->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUsuario() only accepts arguments of type \Usuario or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Usuario relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function joinUsuario($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Usuario');

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
            $this->addJoinObject($join, 'Usuario');
        }

        return $this;
    }

    /**
     * Use the Usuario relation Usuario object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UsuarioQuery A secondary query class using the current class as primary query
     */
    public function useUsuarioQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUsuario($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Usuario', '\UsuarioQuery');
    }

    /**
     * Filter the query by a related \Aportacion object
     *
     * @param \Aportacion|ObjectCollection $aportacion  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByAportacion($aportacion, $comparison = null)
    {
        if ($aportacion instanceof \Aportacion) {
            return $this
                ->addUsingAlias(IntegranteTableMap::COL_ID, $aportacion->getFkIntegrante(), $comparison);
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
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
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
     * Filter the query by a related \IntegranteAsociacion object
     *
     * @param \IntegranteAsociacion|ObjectCollection $integranteAsociacion  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByIntegranteAsociacion($integranteAsociacion, $comparison = null)
    {
        if ($integranteAsociacion instanceof \IntegranteAsociacion) {
            return $this
                ->addUsingAlias(IntegranteTableMap::COL_ID, $integranteAsociacion->getFkIntegrante(), $comparison);
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
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
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
     * Filter the query by a related \IntegranteProyecto object
     *
     * @param \IntegranteProyecto|ObjectCollection $integranteProyecto  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIntegranteQuery The current query, for fluid interface
     */
    public function filterByIntegranteProyecto($integranteProyecto, $comparison = null)
    {
        if ($integranteProyecto instanceof \IntegranteProyecto) {
            return $this
                ->addUsingAlias(IntegranteTableMap::COL_ID, $integranteProyecto->getFkIntegrante(), $comparison);
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
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildIntegrante $integrante Object to remove from the list of results
     *
     * @return $this|ChildIntegranteQuery The current query, for fluid interface
     */
    public function prune($integrante = null)
    {
        if ($integrante) {
            $this->addUsingAlias(IntegranteTableMap::COL_ID, $integrante->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the integrante table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IntegranteTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            IntegranteTableMap::clearInstancePool();
            IntegranteTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(IntegranteTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(IntegranteTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            IntegranteTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            IntegranteTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // IntegranteQuery
