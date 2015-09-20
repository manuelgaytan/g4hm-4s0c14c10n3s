<?php

namespace Base;

use \Aportacion as ChildAportacion;
use \AportacionQuery as ChildAportacionQuery;
use \Integrante as ChildIntegrante;
use \IntegranteAsociacion as ChildIntegranteAsociacion;
use \IntegranteAsociacionQuery as ChildIntegranteAsociacionQuery;
use \IntegranteProyecto as ChildIntegranteProyecto;
use \IntegranteProyectoQuery as ChildIntegranteProyectoQuery;
use \IntegranteQuery as ChildIntegranteQuery;
use \Usuario as ChildUsuario;
use \UsuarioQuery as ChildUsuarioQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\IntegranteTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'integrante' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Integrante implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\IntegranteTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the fk_usuario field.
     * @var        int
     */
    protected $fk_usuario;

    /**
     * The value for the nombre field.
     * @var        string
     */
    protected $nombre;

    /**
     * The value for the apellido_paterno field.
     * @var        string
     */
    protected $apellido_paterno;

    /**
     * The value for the apellido_materno field.
     * @var        string
     */
    protected $apellido_materno;

    /**
     * The value for the fecha_nacimiento field.
     * @var        \DateTime
     */
    protected $fecha_nacimiento;

    /**
     * The value for the rfc field.
     * @var        string
     */
    protected $rfc;

    /**
     * The value for the curp field.
     * @var        string
     */
    protected $curp;

    /**
     * The value for the domicilio field.
     * @var        string
     */
    protected $domicilio;

    /**
     * The value for the estado_civil field.
     * @var        string
     */
    protected $estado_civil;

    /**
     * The value for the correo_electronico field.
     * @var        string
     */
    protected $correo_electronico;

    /**
     * The value for the ocupacion field.
     * @var        string
     */
    protected $ocupacion;

    /**
     * The value for the quien_recomienda field.
     * @var        string
     */
    protected $quien_recomienda;

    /**
     * The value for the observaciones field.
     * @var        string
     */
    protected $observaciones;

    /**
     * @var        ChildUsuario
     */
    protected $aUsuario;

    /**
     * @var        ObjectCollection|ChildAportacion[] Collection to store aggregation of ChildAportacion objects.
     */
    protected $collAportacions;
    protected $collAportacionsPartial;

    /**
     * @var        ObjectCollection|ChildIntegranteAsociacion[] Collection to store aggregation of ChildIntegranteAsociacion objects.
     */
    protected $collIntegranteAsociacions;
    protected $collIntegranteAsociacionsPartial;

    /**
     * @var        ObjectCollection|ChildIntegranteProyecto[] Collection to store aggregation of ChildIntegranteProyecto objects.
     */
    protected $collIntegranteProyectos;
    protected $collIntegranteProyectosPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAportacion[]
     */
    protected $aportacionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIntegranteAsociacion[]
     */
    protected $integranteAsociacionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIntegranteProyecto[]
     */
    protected $integranteProyectosScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Integrante object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Integrante</code> instance.  If
     * <code>obj</code> is an instance of <code>Integrante</code>, delegates to
     * <code>equals(Integrante)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Integrante The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [fk_usuario] column value.
     *
     * @return int
     */
    public function getFkUsuario()
    {
        return $this->fk_usuario;
    }

    /**
     * Get the [nombre] column value.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the [apellido_paterno] column value.
     *
     * @return string
     */
    public function getApellidoPaterno()
    {
        return $this->apellido_paterno;
    }

    /**
     * Get the [apellido_materno] column value.
     *
     * @return string
     */
    public function getApellidoMaterno()
    {
        return $this->apellido_materno;
    }

    /**
     * Get the [optionally formatted] temporal [fecha_nacimiento] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFechaNacimiento($format = NULL)
    {
        if ($format === null) {
            return $this->fecha_nacimiento;
        } else {
            return $this->fecha_nacimiento instanceof \DateTime ? $this->fecha_nacimiento->format($format) : null;
        }
    }

    /**
     * Get the [rfc] column value.
     *
     * @return string
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * Get the [curp] column value.
     *
     * @return string
     */
    public function getCurp()
    {
        return $this->curp;
    }

    /**
     * Get the [domicilio] column value.
     *
     * @return string
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Get the [estado_civil] column value.
     *
     * @return string
     */
    public function getEstadoCivil()
    {
        return $this->estado_civil;
    }

    /**
     * Get the [correo_electronico] column value.
     *
     * @return string
     */
    public function getCorreoElectronico()
    {
        return $this->correo_electronico;
    }

    /**
     * Get the [ocupacion] column value.
     *
     * @return string
     */
    public function getOcupacion()
    {
        return $this->ocupacion;
    }

    /**
     * Get the [quien_recomienda] column value.
     *
     * @return string
     */
    public function getQuienRecomienda()
    {
        return $this->quien_recomienda;
    }

    /**
     * Get the [observaciones] column value.
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[IntegranteTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [fk_usuario] column.
     *
     * @param  int $v new value
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setFkUsuario($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->fk_usuario !== $v) {
            $this->fk_usuario = $v;
            $this->modifiedColumns[IntegranteTableMap::COL_FK_USUARIO] = true;
        }

        if ($this->aUsuario !== null && $this->aUsuario->getId() !== $v) {
            $this->aUsuario = null;
        }

        return $this;
    } // setFkUsuario()

    /**
     * Set the value of [nombre] column.
     *
     * @param  string $v new value
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setNombre($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nombre !== $v) {
            $this->nombre = $v;
            $this->modifiedColumns[IntegranteTableMap::COL_NOMBRE] = true;
        }

        return $this;
    } // setNombre()

    /**
     * Set the value of [apellido_paterno] column.
     *
     * @param  string $v new value
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setApellidoPaterno($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->apellido_paterno !== $v) {
            $this->apellido_paterno = $v;
            $this->modifiedColumns[IntegranteTableMap::COL_APELLIDO_PATERNO] = true;
        }

        return $this;
    } // setApellidoPaterno()

    /**
     * Set the value of [apellido_materno] column.
     *
     * @param  string $v new value
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setApellidoMaterno($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->apellido_materno !== $v) {
            $this->apellido_materno = $v;
            $this->modifiedColumns[IntegranteTableMap::COL_APELLIDO_MATERNO] = true;
        }

        return $this;
    } // setApellidoMaterno()

    /**
     * Sets the value of [fecha_nacimiento] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setFechaNacimiento($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fecha_nacimiento !== null || $dt !== null) {
            if ($dt !== $this->fecha_nacimiento) {
                $this->fecha_nacimiento = $dt;
                $this->modifiedColumns[IntegranteTableMap::COL_FECHA_NACIMIENTO] = true;
            }
        } // if either are not null

        return $this;
    } // setFechaNacimiento()

    /**
     * Set the value of [rfc] column.
     *
     * @param  string $v new value
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setRfc($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->rfc !== $v) {
            $this->rfc = $v;
            $this->modifiedColumns[IntegranteTableMap::COL_RFC] = true;
        }

        return $this;
    } // setRfc()

    /**
     * Set the value of [curp] column.
     *
     * @param  string $v new value
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setCurp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->curp !== $v) {
            $this->curp = $v;
            $this->modifiedColumns[IntegranteTableMap::COL_CURP] = true;
        }

        return $this;
    } // setCurp()

    /**
     * Set the value of [domicilio] column.
     *
     * @param  string $v new value
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setDomicilio($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->domicilio !== $v) {
            $this->domicilio = $v;
            $this->modifiedColumns[IntegranteTableMap::COL_DOMICILIO] = true;
        }

        return $this;
    } // setDomicilio()

    /**
     * Set the value of [estado_civil] column.
     *
     * @param  string $v new value
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setEstadoCivil($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->estado_civil !== $v) {
            $this->estado_civil = $v;
            $this->modifiedColumns[IntegranteTableMap::COL_ESTADO_CIVIL] = true;
        }

        return $this;
    } // setEstadoCivil()

    /**
     * Set the value of [correo_electronico] column.
     *
     * @param  string $v new value
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setCorreoElectronico($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->correo_electronico !== $v) {
            $this->correo_electronico = $v;
            $this->modifiedColumns[IntegranteTableMap::COL_CORREO_ELECTRONICO] = true;
        }

        return $this;
    } // setCorreoElectronico()

    /**
     * Set the value of [ocupacion] column.
     *
     * @param  string $v new value
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setOcupacion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ocupacion !== $v) {
            $this->ocupacion = $v;
            $this->modifiedColumns[IntegranteTableMap::COL_OCUPACION] = true;
        }

        return $this;
    } // setOcupacion()

    /**
     * Set the value of [quien_recomienda] column.
     *
     * @param  string $v new value
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setQuienRecomienda($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->quien_recomienda !== $v) {
            $this->quien_recomienda = $v;
            $this->modifiedColumns[IntegranteTableMap::COL_QUIEN_RECOMIENDA] = true;
        }

        return $this;
    } // setQuienRecomienda()

    /**
     * Set the value of [observaciones] column.
     *
     * @param  string $v new value
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function setObservaciones($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->observaciones !== $v) {
            $this->observaciones = $v;
            $this->modifiedColumns[IntegranteTableMap::COL_OBSERVACIONES] = true;
        }

        return $this;
    } // setObservaciones()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : IntegranteTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : IntegranteTableMap::translateFieldName('FkUsuario', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fk_usuario = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : IntegranteTableMap::translateFieldName('Nombre', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nombre = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : IntegranteTableMap::translateFieldName('ApellidoPaterno', TableMap::TYPE_PHPNAME, $indexType)];
            $this->apellido_paterno = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : IntegranteTableMap::translateFieldName('ApellidoMaterno', TableMap::TYPE_PHPNAME, $indexType)];
            $this->apellido_materno = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : IntegranteTableMap::translateFieldName('FechaNacimiento', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->fecha_nacimiento = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : IntegranteTableMap::translateFieldName('Rfc', TableMap::TYPE_PHPNAME, $indexType)];
            $this->rfc = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : IntegranteTableMap::translateFieldName('Curp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->curp = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : IntegranteTableMap::translateFieldName('Domicilio', TableMap::TYPE_PHPNAME, $indexType)];
            $this->domicilio = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : IntegranteTableMap::translateFieldName('EstadoCivil', TableMap::TYPE_PHPNAME, $indexType)];
            $this->estado_civil = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : IntegranteTableMap::translateFieldName('CorreoElectronico', TableMap::TYPE_PHPNAME, $indexType)];
            $this->correo_electronico = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : IntegranteTableMap::translateFieldName('Ocupacion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ocupacion = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : IntegranteTableMap::translateFieldName('QuienRecomienda', TableMap::TYPE_PHPNAME, $indexType)];
            $this->quien_recomienda = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : IntegranteTableMap::translateFieldName('Observaciones', TableMap::TYPE_PHPNAME, $indexType)];
            $this->observaciones = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 14; // 14 = IntegranteTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Integrante'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aUsuario !== null && $this->fk_usuario !== $this->aUsuario->getId()) {
            $this->aUsuario = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(IntegranteTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildIntegranteQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUsuario = null;
            $this->collAportacions = null;

            $this->collIntegranteAsociacions = null;

            $this->collIntegranteProyectos = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Integrante::setDeleted()
     * @see Integrante::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(IntegranteTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildIntegranteQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(IntegranteTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                IntegranteTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUsuario !== null) {
                if ($this->aUsuario->isModified() || $this->aUsuario->isNew()) {
                    $affectedRows += $this->aUsuario->save($con);
                }
                $this->setUsuario($this->aUsuario);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->aportacionsScheduledForDeletion !== null) {
                if (!$this->aportacionsScheduledForDeletion->isEmpty()) {
                    \AportacionQuery::create()
                        ->filterByPrimaryKeys($this->aportacionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->aportacionsScheduledForDeletion = null;
                }
            }

            if ($this->collAportacions !== null) {
                foreach ($this->collAportacions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->integranteAsociacionsScheduledForDeletion !== null) {
                if (!$this->integranteAsociacionsScheduledForDeletion->isEmpty()) {
                    \IntegranteAsociacionQuery::create()
                        ->filterByPrimaryKeys($this->integranteAsociacionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->integranteAsociacionsScheduledForDeletion = null;
                }
            }

            if ($this->collIntegranteAsociacions !== null) {
                foreach ($this->collIntegranteAsociacions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->integranteProyectosScheduledForDeletion !== null) {
                if (!$this->integranteProyectosScheduledForDeletion->isEmpty()) {
                    \IntegranteProyectoQuery::create()
                        ->filterByPrimaryKeys($this->integranteProyectosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->integranteProyectosScheduledForDeletion = null;
                }
            }

            if ($this->collIntegranteProyectos !== null) {
                foreach ($this->collIntegranteProyectos as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[IntegranteTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . IntegranteTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(IntegranteTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_FK_USUARIO)) {
            $modifiedColumns[':p' . $index++]  = 'fk_usuario';
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_NOMBRE)) {
            $modifiedColumns[':p' . $index++]  = 'nombre';
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_APELLIDO_PATERNO)) {
            $modifiedColumns[':p' . $index++]  = 'apellido_paterno';
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_APELLIDO_MATERNO)) {
            $modifiedColumns[':p' . $index++]  = 'apellido_materno';
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_FECHA_NACIMIENTO)) {
            $modifiedColumns[':p' . $index++]  = 'fecha_nacimiento';
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_RFC)) {
            $modifiedColumns[':p' . $index++]  = 'rfc';
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_CURP)) {
            $modifiedColumns[':p' . $index++]  = 'curp';
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_DOMICILIO)) {
            $modifiedColumns[':p' . $index++]  = 'domicilio';
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_ESTADO_CIVIL)) {
            $modifiedColumns[':p' . $index++]  = 'estado_civil';
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_CORREO_ELECTRONICO)) {
            $modifiedColumns[':p' . $index++]  = 'correo_electronico';
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_OCUPACION)) {
            $modifiedColumns[':p' . $index++]  = 'ocupacion';
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_QUIEN_RECOMIENDA)) {
            $modifiedColumns[':p' . $index++]  = 'quien_recomienda';
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_OBSERVACIONES)) {
            $modifiedColumns[':p' . $index++]  = 'observaciones';
        }

        $sql = sprintf(
            'INSERT INTO integrante (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'fk_usuario':
                        $stmt->bindValue($identifier, $this->fk_usuario, PDO::PARAM_INT);
                        break;
                    case 'nombre':
                        $stmt->bindValue($identifier, $this->nombre, PDO::PARAM_STR);
                        break;
                    case 'apellido_paterno':
                        $stmt->bindValue($identifier, $this->apellido_paterno, PDO::PARAM_STR);
                        break;
                    case 'apellido_materno':
                        $stmt->bindValue($identifier, $this->apellido_materno, PDO::PARAM_STR);
                        break;
                    case 'fecha_nacimiento':
                        $stmt->bindValue($identifier, $this->fecha_nacimiento ? $this->fecha_nacimiento->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'rfc':
                        $stmt->bindValue($identifier, $this->rfc, PDO::PARAM_STR);
                        break;
                    case 'curp':
                        $stmt->bindValue($identifier, $this->curp, PDO::PARAM_STR);
                        break;
                    case 'domicilio':
                        $stmt->bindValue($identifier, $this->domicilio, PDO::PARAM_STR);
                        break;
                    case 'estado_civil':
                        $stmt->bindValue($identifier, $this->estado_civil, PDO::PARAM_STR);
                        break;
                    case 'correo_electronico':
                        $stmt->bindValue($identifier, $this->correo_electronico, PDO::PARAM_STR);
                        break;
                    case 'ocupacion':
                        $stmt->bindValue($identifier, $this->ocupacion, PDO::PARAM_STR);
                        break;
                    case 'quien_recomienda':
                        $stmt->bindValue($identifier, $this->quien_recomienda, PDO::PARAM_STR);
                        break;
                    case 'observaciones':
                        $stmt->bindValue($identifier, $this->observaciones, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = IntegranteTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getFkUsuario();
                break;
            case 2:
                return $this->getNombre();
                break;
            case 3:
                return $this->getApellidoPaterno();
                break;
            case 4:
                return $this->getApellidoMaterno();
                break;
            case 5:
                return $this->getFechaNacimiento();
                break;
            case 6:
                return $this->getRfc();
                break;
            case 7:
                return $this->getCurp();
                break;
            case 8:
                return $this->getDomicilio();
                break;
            case 9:
                return $this->getEstadoCivil();
                break;
            case 10:
                return $this->getCorreoElectronico();
                break;
            case 11:
                return $this->getOcupacion();
                break;
            case 12:
                return $this->getQuienRecomienda();
                break;
            case 13:
                return $this->getObservaciones();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Integrante'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Integrante'][$this->hashCode()] = true;
        $keys = IntegranteTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFkUsuario(),
            $keys[2] => $this->getNombre(),
            $keys[3] => $this->getApellidoPaterno(),
            $keys[4] => $this->getApellidoMaterno(),
            $keys[5] => $this->getFechaNacimiento(),
            $keys[6] => $this->getRfc(),
            $keys[7] => $this->getCurp(),
            $keys[8] => $this->getDomicilio(),
            $keys[9] => $this->getEstadoCivil(),
            $keys[10] => $this->getCorreoElectronico(),
            $keys[11] => $this->getOcupacion(),
            $keys[12] => $this->getQuienRecomienda(),
            $keys[13] => $this->getObservaciones(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUsuario) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'usuario';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'usuario';
                        break;
                    default:
                        $key = 'Usuario';
                }

                $result[$key] = $this->aUsuario->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAportacions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'aportacions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'aportacions';
                        break;
                    default:
                        $key = 'Aportacions';
                }

                $result[$key] = $this->collAportacions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collIntegranteAsociacions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'integranteAsociacions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'integrante_asociacions';
                        break;
                    default:
                        $key = 'IntegranteAsociacions';
                }

                $result[$key] = $this->collIntegranteAsociacions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collIntegranteProyectos) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'integranteProyectos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'integrante_proyectos';
                        break;
                    default:
                        $key = 'IntegranteProyectos';
                }

                $result[$key] = $this->collIntegranteProyectos->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Integrante
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = IntegranteTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Integrante
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setFkUsuario($value);
                break;
            case 2:
                $this->setNombre($value);
                break;
            case 3:
                $this->setApellidoPaterno($value);
                break;
            case 4:
                $this->setApellidoMaterno($value);
                break;
            case 5:
                $this->setFechaNacimiento($value);
                break;
            case 6:
                $this->setRfc($value);
                break;
            case 7:
                $this->setCurp($value);
                break;
            case 8:
                $this->setDomicilio($value);
                break;
            case 9:
                $this->setEstadoCivil($value);
                break;
            case 10:
                $this->setCorreoElectronico($value);
                break;
            case 11:
                $this->setOcupacion($value);
                break;
            case 12:
                $this->setQuienRecomienda($value);
                break;
            case 13:
                $this->setObservaciones($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = IntegranteTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setFkUsuario($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNombre($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setApellidoPaterno($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setApellidoMaterno($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setFechaNacimiento($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setRfc($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setCurp($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setDomicilio($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setEstadoCivil($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setCorreoElectronico($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setOcupacion($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setQuienRecomienda($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setObservaciones($arr[$keys[13]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Integrante The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(IntegranteTableMap::DATABASE_NAME);

        if ($this->isColumnModified(IntegranteTableMap::COL_ID)) {
            $criteria->add(IntegranteTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_FK_USUARIO)) {
            $criteria->add(IntegranteTableMap::COL_FK_USUARIO, $this->fk_usuario);
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_NOMBRE)) {
            $criteria->add(IntegranteTableMap::COL_NOMBRE, $this->nombre);
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_APELLIDO_PATERNO)) {
            $criteria->add(IntegranteTableMap::COL_APELLIDO_PATERNO, $this->apellido_paterno);
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_APELLIDO_MATERNO)) {
            $criteria->add(IntegranteTableMap::COL_APELLIDO_MATERNO, $this->apellido_materno);
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_FECHA_NACIMIENTO)) {
            $criteria->add(IntegranteTableMap::COL_FECHA_NACIMIENTO, $this->fecha_nacimiento);
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_RFC)) {
            $criteria->add(IntegranteTableMap::COL_RFC, $this->rfc);
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_CURP)) {
            $criteria->add(IntegranteTableMap::COL_CURP, $this->curp);
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_DOMICILIO)) {
            $criteria->add(IntegranteTableMap::COL_DOMICILIO, $this->domicilio);
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_ESTADO_CIVIL)) {
            $criteria->add(IntegranteTableMap::COL_ESTADO_CIVIL, $this->estado_civil);
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_CORREO_ELECTRONICO)) {
            $criteria->add(IntegranteTableMap::COL_CORREO_ELECTRONICO, $this->correo_electronico);
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_OCUPACION)) {
            $criteria->add(IntegranteTableMap::COL_OCUPACION, $this->ocupacion);
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_QUIEN_RECOMIENDA)) {
            $criteria->add(IntegranteTableMap::COL_QUIEN_RECOMIENDA, $this->quien_recomienda);
        }
        if ($this->isColumnModified(IntegranteTableMap::COL_OBSERVACIONES)) {
            $criteria->add(IntegranteTableMap::COL_OBSERVACIONES, $this->observaciones);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildIntegranteQuery::create();
        $criteria->add(IntegranteTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Integrante (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFkUsuario($this->getFkUsuario());
        $copyObj->setNombre($this->getNombre());
        $copyObj->setApellidoPaterno($this->getApellidoPaterno());
        $copyObj->setApellidoMaterno($this->getApellidoMaterno());
        $copyObj->setFechaNacimiento($this->getFechaNacimiento());
        $copyObj->setRfc($this->getRfc());
        $copyObj->setCurp($this->getCurp());
        $copyObj->setDomicilio($this->getDomicilio());
        $copyObj->setEstadoCivil($this->getEstadoCivil());
        $copyObj->setCorreoElectronico($this->getCorreoElectronico());
        $copyObj->setOcupacion($this->getOcupacion());
        $copyObj->setQuienRecomienda($this->getQuienRecomienda());
        $copyObj->setObservaciones($this->getObservaciones());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAportacions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAportacion($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getIntegranteAsociacions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addIntegranteAsociacion($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getIntegranteProyectos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addIntegranteProyecto($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Integrante Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildUsuario object.
     *
     * @param  ChildUsuario $v
     * @return $this|\Integrante The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUsuario(ChildUsuario $v = null)
    {
        if ($v === null) {
            $this->setFkUsuario(NULL);
        } else {
            $this->setFkUsuario($v->getId());
        }

        $this->aUsuario = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUsuario object, it will not be re-added.
        if ($v !== null) {
            $v->addIntegrante($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUsuario object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUsuario The associated ChildUsuario object.
     * @throws PropelException
     */
    public function getUsuario(ConnectionInterface $con = null)
    {
        if ($this->aUsuario === null && ($this->fk_usuario !== null)) {
            $this->aUsuario = ChildUsuarioQuery::create()->findPk($this->fk_usuario, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUsuario->addIntegrantes($this);
             */
        }

        return $this->aUsuario;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Aportacion' == $relationName) {
            return $this->initAportacions();
        }
        if ('IntegranteAsociacion' == $relationName) {
            return $this->initIntegranteAsociacions();
        }
        if ('IntegranteProyecto' == $relationName) {
            return $this->initIntegranteProyectos();
        }
    }

    /**
     * Clears out the collAportacions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAportacions()
     */
    public function clearAportacions()
    {
        $this->collAportacions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAportacions collection loaded partially.
     */
    public function resetPartialAportacions($v = true)
    {
        $this->collAportacionsPartial = $v;
    }

    /**
     * Initializes the collAportacions collection.
     *
     * By default this just sets the collAportacions collection to an empty array (like clearcollAportacions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAportacions($overrideExisting = true)
    {
        if (null !== $this->collAportacions && !$overrideExisting) {
            return;
        }
        $this->collAportacions = new ObjectCollection();
        $this->collAportacions->setModel('\Aportacion');
    }

    /**
     * Gets an array of ChildAportacion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildIntegrante is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAportacion[] List of ChildAportacion objects
     * @throws PropelException
     */
    public function getAportacions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAportacionsPartial && !$this->isNew();
        if (null === $this->collAportacions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAportacions) {
                // return empty collection
                $this->initAportacions();
            } else {
                $collAportacions = ChildAportacionQuery::create(null, $criteria)
                    ->filterByIntegrante($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAportacionsPartial && count($collAportacions)) {
                        $this->initAportacions(false);

                        foreach ($collAportacions as $obj) {
                            if (false == $this->collAportacions->contains($obj)) {
                                $this->collAportacions->append($obj);
                            }
                        }

                        $this->collAportacionsPartial = true;
                    }

                    return $collAportacions;
                }

                if ($partial && $this->collAportacions) {
                    foreach ($this->collAportacions as $obj) {
                        if ($obj->isNew()) {
                            $collAportacions[] = $obj;
                        }
                    }
                }

                $this->collAportacions = $collAportacions;
                $this->collAportacionsPartial = false;
            }
        }

        return $this->collAportacions;
    }

    /**
     * Sets a collection of ChildAportacion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $aportacions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildIntegrante The current object (for fluent API support)
     */
    public function setAportacions(Collection $aportacions, ConnectionInterface $con = null)
    {
        /** @var ChildAportacion[] $aportacionsToDelete */
        $aportacionsToDelete = $this->getAportacions(new Criteria(), $con)->diff($aportacions);


        $this->aportacionsScheduledForDeletion = $aportacionsToDelete;

        foreach ($aportacionsToDelete as $aportacionRemoved) {
            $aportacionRemoved->setIntegrante(null);
        }

        $this->collAportacions = null;
        foreach ($aportacions as $aportacion) {
            $this->addAportacion($aportacion);
        }

        $this->collAportacions = $aportacions;
        $this->collAportacionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Aportacion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Aportacion objects.
     * @throws PropelException
     */
    public function countAportacions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAportacionsPartial && !$this->isNew();
        if (null === $this->collAportacions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAportacions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAportacions());
            }

            $query = ChildAportacionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByIntegrante($this)
                ->count($con);
        }

        return count($this->collAportacions);
    }

    /**
     * Method called to associate a ChildAportacion object to this object
     * through the ChildAportacion foreign key attribute.
     *
     * @param  ChildAportacion $l ChildAportacion
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function addAportacion(ChildAportacion $l)
    {
        if ($this->collAportacions === null) {
            $this->initAportacions();
            $this->collAportacionsPartial = true;
        }

        if (!$this->collAportacions->contains($l)) {
            $this->doAddAportacion($l);
        }

        return $this;
    }

    /**
     * @param ChildAportacion $aportacion The ChildAportacion object to add.
     */
    protected function doAddAportacion(ChildAportacion $aportacion)
    {
        $this->collAportacions[]= $aportacion;
        $aportacion->setIntegrante($this);
    }

    /**
     * @param  ChildAportacion $aportacion The ChildAportacion object to remove.
     * @return $this|ChildIntegrante The current object (for fluent API support)
     */
    public function removeAportacion(ChildAportacion $aportacion)
    {
        if ($this->getAportacions()->contains($aportacion)) {
            $pos = $this->collAportacions->search($aportacion);
            $this->collAportacions->remove($pos);
            if (null === $this->aportacionsScheduledForDeletion) {
                $this->aportacionsScheduledForDeletion = clone $this->collAportacions;
                $this->aportacionsScheduledForDeletion->clear();
            }
            $this->aportacionsScheduledForDeletion[]= clone $aportacion;
            $aportacion->setIntegrante(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Integrante is new, it will return
     * an empty collection; or if this Integrante has previously
     * been saved, it will retrieve related Aportacions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Integrante.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAportacion[] List of ChildAportacion objects
     */
    public function getAportacionsJoinItem(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAportacionQuery::create(null, $criteria);
        $query->joinWith('Item', $joinBehavior);

        return $this->getAportacions($query, $con);
    }

    /**
     * Clears out the collIntegranteAsociacions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIntegranteAsociacions()
     */
    public function clearIntegranteAsociacions()
    {
        $this->collIntegranteAsociacions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collIntegranteAsociacions collection loaded partially.
     */
    public function resetPartialIntegranteAsociacions($v = true)
    {
        $this->collIntegranteAsociacionsPartial = $v;
    }

    /**
     * Initializes the collIntegranteAsociacions collection.
     *
     * By default this just sets the collIntegranteAsociacions collection to an empty array (like clearcollIntegranteAsociacions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initIntegranteAsociacions($overrideExisting = true)
    {
        if (null !== $this->collIntegranteAsociacions && !$overrideExisting) {
            return;
        }
        $this->collIntegranteAsociacions = new ObjectCollection();
        $this->collIntegranteAsociacions->setModel('\IntegranteAsociacion');
    }

    /**
     * Gets an array of ChildIntegranteAsociacion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildIntegrante is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildIntegranteAsociacion[] List of ChildIntegranteAsociacion objects
     * @throws PropelException
     */
    public function getIntegranteAsociacions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIntegranteAsociacionsPartial && !$this->isNew();
        if (null === $this->collIntegranteAsociacions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collIntegranteAsociacions) {
                // return empty collection
                $this->initIntegranteAsociacions();
            } else {
                $collIntegranteAsociacions = ChildIntegranteAsociacionQuery::create(null, $criteria)
                    ->filterByIntegrante($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collIntegranteAsociacionsPartial && count($collIntegranteAsociacions)) {
                        $this->initIntegranteAsociacions(false);

                        foreach ($collIntegranteAsociacions as $obj) {
                            if (false == $this->collIntegranteAsociacions->contains($obj)) {
                                $this->collIntegranteAsociacions->append($obj);
                            }
                        }

                        $this->collIntegranteAsociacionsPartial = true;
                    }

                    return $collIntegranteAsociacions;
                }

                if ($partial && $this->collIntegranteAsociacions) {
                    foreach ($this->collIntegranteAsociacions as $obj) {
                        if ($obj->isNew()) {
                            $collIntegranteAsociacions[] = $obj;
                        }
                    }
                }

                $this->collIntegranteAsociacions = $collIntegranteAsociacions;
                $this->collIntegranteAsociacionsPartial = false;
            }
        }

        return $this->collIntegranteAsociacions;
    }

    /**
     * Sets a collection of ChildIntegranteAsociacion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $integranteAsociacions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildIntegrante The current object (for fluent API support)
     */
    public function setIntegranteAsociacions(Collection $integranteAsociacions, ConnectionInterface $con = null)
    {
        /** @var ChildIntegranteAsociacion[] $integranteAsociacionsToDelete */
        $integranteAsociacionsToDelete = $this->getIntegranteAsociacions(new Criteria(), $con)->diff($integranteAsociacions);


        $this->integranteAsociacionsScheduledForDeletion = $integranteAsociacionsToDelete;

        foreach ($integranteAsociacionsToDelete as $integranteAsociacionRemoved) {
            $integranteAsociacionRemoved->setIntegrante(null);
        }

        $this->collIntegranteAsociacions = null;
        foreach ($integranteAsociacions as $integranteAsociacion) {
            $this->addIntegranteAsociacion($integranteAsociacion);
        }

        $this->collIntegranteAsociacions = $integranteAsociacions;
        $this->collIntegranteAsociacionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related IntegranteAsociacion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related IntegranteAsociacion objects.
     * @throws PropelException
     */
    public function countIntegranteAsociacions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIntegranteAsociacionsPartial && !$this->isNew();
        if (null === $this->collIntegranteAsociacions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIntegranteAsociacions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getIntegranteAsociacions());
            }

            $query = ChildIntegranteAsociacionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByIntegrante($this)
                ->count($con);
        }

        return count($this->collIntegranteAsociacions);
    }

    /**
     * Method called to associate a ChildIntegranteAsociacion object to this object
     * through the ChildIntegranteAsociacion foreign key attribute.
     *
     * @param  ChildIntegranteAsociacion $l ChildIntegranteAsociacion
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function addIntegranteAsociacion(ChildIntegranteAsociacion $l)
    {
        if ($this->collIntegranteAsociacions === null) {
            $this->initIntegranteAsociacions();
            $this->collIntegranteAsociacionsPartial = true;
        }

        if (!$this->collIntegranteAsociacions->contains($l)) {
            $this->doAddIntegranteAsociacion($l);
        }

        return $this;
    }

    /**
     * @param ChildIntegranteAsociacion $integranteAsociacion The ChildIntegranteAsociacion object to add.
     */
    protected function doAddIntegranteAsociacion(ChildIntegranteAsociacion $integranteAsociacion)
    {
        $this->collIntegranteAsociacions[]= $integranteAsociacion;
        $integranteAsociacion->setIntegrante($this);
    }

    /**
     * @param  ChildIntegranteAsociacion $integranteAsociacion The ChildIntegranteAsociacion object to remove.
     * @return $this|ChildIntegrante The current object (for fluent API support)
     */
    public function removeIntegranteAsociacion(ChildIntegranteAsociacion $integranteAsociacion)
    {
        if ($this->getIntegranteAsociacions()->contains($integranteAsociacion)) {
            $pos = $this->collIntegranteAsociacions->search($integranteAsociacion);
            $this->collIntegranteAsociacions->remove($pos);
            if (null === $this->integranteAsociacionsScheduledForDeletion) {
                $this->integranteAsociacionsScheduledForDeletion = clone $this->collIntegranteAsociacions;
                $this->integranteAsociacionsScheduledForDeletion->clear();
            }
            $this->integranteAsociacionsScheduledForDeletion[]= clone $integranteAsociacion;
            $integranteAsociacion->setIntegrante(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Integrante is new, it will return
     * an empty collection; or if this Integrante has previously
     * been saved, it will retrieve related IntegranteAsociacions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Integrante.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildIntegranteAsociacion[] List of ChildIntegranteAsociacion objects
     */
    public function getIntegranteAsociacionsJoinAsociacion(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildIntegranteAsociacionQuery::create(null, $criteria);
        $query->joinWith('Asociacion', $joinBehavior);

        return $this->getIntegranteAsociacions($query, $con);
    }

    /**
     * Clears out the collIntegranteProyectos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIntegranteProyectos()
     */
    public function clearIntegranteProyectos()
    {
        $this->collIntegranteProyectos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collIntegranteProyectos collection loaded partially.
     */
    public function resetPartialIntegranteProyectos($v = true)
    {
        $this->collIntegranteProyectosPartial = $v;
    }

    /**
     * Initializes the collIntegranteProyectos collection.
     *
     * By default this just sets the collIntegranteProyectos collection to an empty array (like clearcollIntegranteProyectos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initIntegranteProyectos($overrideExisting = true)
    {
        if (null !== $this->collIntegranteProyectos && !$overrideExisting) {
            return;
        }
        $this->collIntegranteProyectos = new ObjectCollection();
        $this->collIntegranteProyectos->setModel('\IntegranteProyecto');
    }

    /**
     * Gets an array of ChildIntegranteProyecto objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildIntegrante is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildIntegranteProyecto[] List of ChildIntegranteProyecto objects
     * @throws PropelException
     */
    public function getIntegranteProyectos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIntegranteProyectosPartial && !$this->isNew();
        if (null === $this->collIntegranteProyectos || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collIntegranteProyectos) {
                // return empty collection
                $this->initIntegranteProyectos();
            } else {
                $collIntegranteProyectos = ChildIntegranteProyectoQuery::create(null, $criteria)
                    ->filterByIntegrante($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collIntegranteProyectosPartial && count($collIntegranteProyectos)) {
                        $this->initIntegranteProyectos(false);

                        foreach ($collIntegranteProyectos as $obj) {
                            if (false == $this->collIntegranteProyectos->contains($obj)) {
                                $this->collIntegranteProyectos->append($obj);
                            }
                        }

                        $this->collIntegranteProyectosPartial = true;
                    }

                    return $collIntegranteProyectos;
                }

                if ($partial && $this->collIntegranteProyectos) {
                    foreach ($this->collIntegranteProyectos as $obj) {
                        if ($obj->isNew()) {
                            $collIntegranteProyectos[] = $obj;
                        }
                    }
                }

                $this->collIntegranteProyectos = $collIntegranteProyectos;
                $this->collIntegranteProyectosPartial = false;
            }
        }

        return $this->collIntegranteProyectos;
    }

    /**
     * Sets a collection of ChildIntegranteProyecto objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $integranteProyectos A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildIntegrante The current object (for fluent API support)
     */
    public function setIntegranteProyectos(Collection $integranteProyectos, ConnectionInterface $con = null)
    {
        /** @var ChildIntegranteProyecto[] $integranteProyectosToDelete */
        $integranteProyectosToDelete = $this->getIntegranteProyectos(new Criteria(), $con)->diff($integranteProyectos);


        $this->integranteProyectosScheduledForDeletion = $integranteProyectosToDelete;

        foreach ($integranteProyectosToDelete as $integranteProyectoRemoved) {
            $integranteProyectoRemoved->setIntegrante(null);
        }

        $this->collIntegranteProyectos = null;
        foreach ($integranteProyectos as $integranteProyecto) {
            $this->addIntegranteProyecto($integranteProyecto);
        }

        $this->collIntegranteProyectos = $integranteProyectos;
        $this->collIntegranteProyectosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related IntegranteProyecto objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related IntegranteProyecto objects.
     * @throws PropelException
     */
    public function countIntegranteProyectos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIntegranteProyectosPartial && !$this->isNew();
        if (null === $this->collIntegranteProyectos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIntegranteProyectos) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getIntegranteProyectos());
            }

            $query = ChildIntegranteProyectoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByIntegrante($this)
                ->count($con);
        }

        return count($this->collIntegranteProyectos);
    }

    /**
     * Method called to associate a ChildIntegranteProyecto object to this object
     * through the ChildIntegranteProyecto foreign key attribute.
     *
     * @param  ChildIntegranteProyecto $l ChildIntegranteProyecto
     * @return $this|\Integrante The current object (for fluent API support)
     */
    public function addIntegranteProyecto(ChildIntegranteProyecto $l)
    {
        if ($this->collIntegranteProyectos === null) {
            $this->initIntegranteProyectos();
            $this->collIntegranteProyectosPartial = true;
        }

        if (!$this->collIntegranteProyectos->contains($l)) {
            $this->doAddIntegranteProyecto($l);
        }

        return $this;
    }

    /**
     * @param ChildIntegranteProyecto $integranteProyecto The ChildIntegranteProyecto object to add.
     */
    protected function doAddIntegranteProyecto(ChildIntegranteProyecto $integranteProyecto)
    {
        $this->collIntegranteProyectos[]= $integranteProyecto;
        $integranteProyecto->setIntegrante($this);
    }

    /**
     * @param  ChildIntegranteProyecto $integranteProyecto The ChildIntegranteProyecto object to remove.
     * @return $this|ChildIntegrante The current object (for fluent API support)
     */
    public function removeIntegranteProyecto(ChildIntegranteProyecto $integranteProyecto)
    {
        if ($this->getIntegranteProyectos()->contains($integranteProyecto)) {
            $pos = $this->collIntegranteProyectos->search($integranteProyecto);
            $this->collIntegranteProyectos->remove($pos);
            if (null === $this->integranteProyectosScheduledForDeletion) {
                $this->integranteProyectosScheduledForDeletion = clone $this->collIntegranteProyectos;
                $this->integranteProyectosScheduledForDeletion->clear();
            }
            $this->integranteProyectosScheduledForDeletion[]= clone $integranteProyecto;
            $integranteProyecto->setIntegrante(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Integrante is new, it will return
     * an empty collection; or if this Integrante has previously
     * been saved, it will retrieve related IntegranteProyectos from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Integrante.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildIntegranteProyecto[] List of ChildIntegranteProyecto objects
     */
    public function getIntegranteProyectosJoinProyecto(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildIntegranteProyectoQuery::create(null, $criteria);
        $query->joinWith('Proyecto', $joinBehavior);

        return $this->getIntegranteProyectos($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUsuario) {
            $this->aUsuario->removeIntegrante($this);
        }
        $this->id = null;
        $this->fk_usuario = null;
        $this->nombre = null;
        $this->apellido_paterno = null;
        $this->apellido_materno = null;
        $this->fecha_nacimiento = null;
        $this->rfc = null;
        $this->curp = null;
        $this->domicilio = null;
        $this->estado_civil = null;
        $this->correo_electronico = null;
        $this->ocupacion = null;
        $this->quien_recomienda = null;
        $this->observaciones = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collAportacions) {
                foreach ($this->collAportacions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIntegranteAsociacions) {
                foreach ($this->collIntegranteAsociacions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIntegranteProyectos) {
                foreach ($this->collIntegranteProyectos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAportacions = null;
        $this->collIntegranteAsociacions = null;
        $this->collIntegranteProyectos = null;
        $this->aUsuario = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(IntegranteTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
