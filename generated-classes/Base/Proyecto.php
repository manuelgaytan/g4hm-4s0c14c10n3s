<?php

namespace Base;

use \Asociacion as ChildAsociacion;
use \AsociacionQuery as ChildAsociacionQuery;
use \IntegranteProyecto as ChildIntegranteProyecto;
use \IntegranteProyectoQuery as ChildIntegranteProyectoQuery;
use \Item as ChildItem;
use \ItemQuery as ChildItemQuery;
use \Proyecto as ChildProyecto;
use \ProyectoQuery as ChildProyectoQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\ProyectoTableMap;
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
 * Base class that represents a row from the 'proyecto' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Proyecto implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ProyectoTableMap';


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
     * The value for the nombre field.
     * @var        string
     */
    protected $nombre;

    /**
     * The value for the descripcion field.
     * @var        string
     */
    protected $descripcion;

    /**
     * The value for the contacto field.
     * @var        string
     */
    protected $contacto;

    /**
     * The value for the telefono field.
     * @var        string
     */
    protected $telefono;

    /**
     * The value for the correo_electronico field.
     * @var        string
     */
    protected $correo_electronico;

    /**
     * The value for the fecha_alta field.
     * @var        \DateTime
     */
    protected $fecha_alta;

    /**
     * The value for the fecha_inicio field.
     * @var        \DateTime
     */
    protected $fecha_inicio;

    /**
     * The value for the fecha_fin field.
     * @var        \DateTime
     */
    protected $fecha_fin;

    /**
     * The value for the fk_asociacion field.
     * @var        int
     */
    protected $fk_asociacion;

    /**
     * @var        ChildAsociacion
     */
    protected $aAsociacion;

    /**
     * @var        ObjectCollection|ChildIntegranteProyecto[] Collection to store aggregation of ChildIntegranteProyecto objects.
     */
    protected $collIntegranteProyectos;
    protected $collIntegranteProyectosPartial;

    /**
     * @var        ObjectCollection|ChildItem[] Collection to store aggregation of ChildItem objects.
     */
    protected $collItems;
    protected $collItemsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIntegranteProyecto[]
     */
    protected $integranteProyectosScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildItem[]
     */
    protected $itemsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Proyecto object.
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
     * Compares this with another <code>Proyecto</code> instance.  If
     * <code>obj</code> is an instance of <code>Proyecto</code>, delegates to
     * <code>equals(Proyecto)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Proyecto The current object, for fluid interface
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
     * Get the [nombre] column value.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the [descripcion] column value.
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Get the [contacto] column value.
     *
     * @return string
     */
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
     * Get the [telefono] column value.
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
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
     * Get the [optionally formatted] temporal [fecha_alta] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFechaAlta($format = NULL)
    {
        if ($format === null) {
            return $this->fecha_alta;
        } else {
            return $this->fecha_alta instanceof \DateTime ? $this->fecha_alta->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [fecha_inicio] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFechaInicio($format = NULL)
    {
        if ($format === null) {
            return $this->fecha_inicio;
        } else {
            return $this->fecha_inicio instanceof \DateTime ? $this->fecha_inicio->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [fecha_fin] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFechaFin($format = NULL)
    {
        if ($format === null) {
            return $this->fecha_fin;
        } else {
            return $this->fecha_fin instanceof \DateTime ? $this->fecha_fin->format($format) : null;
        }
    }

    /**
     * Get the [fk_asociacion] column value.
     *
     * @return int
     */
    public function getFkAsociacion()
    {
        return $this->fk_asociacion;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return $this|\Proyecto The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ProyectoTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [nombre] column.
     *
     * @param  string $v new value
     * @return $this|\Proyecto The current object (for fluent API support)
     */
    public function setNombre($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nombre !== $v) {
            $this->nombre = $v;
            $this->modifiedColumns[ProyectoTableMap::COL_NOMBRE] = true;
        }

        return $this;
    } // setNombre()

    /**
     * Set the value of [descripcion] column.
     *
     * @param  string $v new value
     * @return $this|\Proyecto The current object (for fluent API support)
     */
    public function setDescripcion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->descripcion !== $v) {
            $this->descripcion = $v;
            $this->modifiedColumns[ProyectoTableMap::COL_DESCRIPCION] = true;
        }

        return $this;
    } // setDescripcion()

    /**
     * Set the value of [contacto] column.
     *
     * @param  string $v new value
     * @return $this|\Proyecto The current object (for fluent API support)
     */
    public function setContacto($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->contacto !== $v) {
            $this->contacto = $v;
            $this->modifiedColumns[ProyectoTableMap::COL_CONTACTO] = true;
        }

        return $this;
    } // setContacto()

    /**
     * Set the value of [telefono] column.
     *
     * @param  string $v new value
     * @return $this|\Proyecto The current object (for fluent API support)
     */
    public function setTelefono($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->telefono !== $v) {
            $this->telefono = $v;
            $this->modifiedColumns[ProyectoTableMap::COL_TELEFONO] = true;
        }

        return $this;
    } // setTelefono()

    /**
     * Set the value of [correo_electronico] column.
     *
     * @param  string $v new value
     * @return $this|\Proyecto The current object (for fluent API support)
     */
    public function setCorreoElectronico($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->correo_electronico !== $v) {
            $this->correo_electronico = $v;
            $this->modifiedColumns[ProyectoTableMap::COL_CORREO_ELECTRONICO] = true;
        }

        return $this;
    } // setCorreoElectronico()

    /**
     * Sets the value of [fecha_alta] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Proyecto The current object (for fluent API support)
     */
    public function setFechaAlta($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fecha_alta !== null || $dt !== null) {
            if ($dt !== $this->fecha_alta) {
                $this->fecha_alta = $dt;
                $this->modifiedColumns[ProyectoTableMap::COL_FECHA_ALTA] = true;
            }
        } // if either are not null

        return $this;
    } // setFechaAlta()

    /**
     * Sets the value of [fecha_inicio] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Proyecto The current object (for fluent API support)
     */
    public function setFechaInicio($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fecha_inicio !== null || $dt !== null) {
            if ($dt !== $this->fecha_inicio) {
                $this->fecha_inicio = $dt;
                $this->modifiedColumns[ProyectoTableMap::COL_FECHA_INICIO] = true;
            }
        } // if either are not null

        return $this;
    } // setFechaInicio()

    /**
     * Sets the value of [fecha_fin] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Proyecto The current object (for fluent API support)
     */
    public function setFechaFin($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fecha_fin !== null || $dt !== null) {
            if ($dt !== $this->fecha_fin) {
                $this->fecha_fin = $dt;
                $this->modifiedColumns[ProyectoTableMap::COL_FECHA_FIN] = true;
            }
        } // if either are not null

        return $this;
    } // setFechaFin()

    /**
     * Set the value of [fk_asociacion] column.
     *
     * @param  int $v new value
     * @return $this|\Proyecto The current object (for fluent API support)
     */
    public function setFkAsociacion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->fk_asociacion !== $v) {
            $this->fk_asociacion = $v;
            $this->modifiedColumns[ProyectoTableMap::COL_FK_ASOCIACION] = true;
        }

        if ($this->aAsociacion !== null && $this->aAsociacion->getId() !== $v) {
            $this->aAsociacion = null;
        }

        return $this;
    } // setFkAsociacion()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ProyectoTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ProyectoTableMap::translateFieldName('Nombre', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nombre = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ProyectoTableMap::translateFieldName('Descripcion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->descripcion = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ProyectoTableMap::translateFieldName('Contacto', TableMap::TYPE_PHPNAME, $indexType)];
            $this->contacto = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ProyectoTableMap::translateFieldName('Telefono', TableMap::TYPE_PHPNAME, $indexType)];
            $this->telefono = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ProyectoTableMap::translateFieldName('CorreoElectronico', TableMap::TYPE_PHPNAME, $indexType)];
            $this->correo_electronico = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ProyectoTableMap::translateFieldName('FechaAlta', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->fecha_alta = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ProyectoTableMap::translateFieldName('FechaInicio', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->fecha_inicio = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ProyectoTableMap::translateFieldName('FechaFin', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->fecha_fin = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ProyectoTableMap::translateFieldName('FkAsociacion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fk_asociacion = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = ProyectoTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Proyecto'), 0, $e);
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
        if ($this->aAsociacion !== null && $this->fk_asociacion !== $this->aAsociacion->getId()) {
            $this->aAsociacion = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(ProyectoTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildProyectoQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAsociacion = null;
            $this->collIntegranteProyectos = null;

            $this->collItems = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Proyecto::setDeleted()
     * @see Proyecto::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProyectoTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildProyectoQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProyectoTableMap::DATABASE_NAME);
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
                ProyectoTableMap::addInstanceToPool($this);
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

            if ($this->aAsociacion !== null) {
                if ($this->aAsociacion->isModified() || $this->aAsociacion->isNew()) {
                    $affectedRows += $this->aAsociacion->save($con);
                }
                $this->setAsociacion($this->aAsociacion);
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

            if ($this->itemsScheduledForDeletion !== null) {
                if (!$this->itemsScheduledForDeletion->isEmpty()) {
                    \ItemQuery::create()
                        ->filterByPrimaryKeys($this->itemsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->itemsScheduledForDeletion = null;
                }
            }

            if ($this->collItems !== null) {
                foreach ($this->collItems as $referrerFK) {
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

        $this->modifiedColumns[ProyectoTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProyectoTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProyectoTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_NOMBRE)) {
            $modifiedColumns[':p' . $index++]  = 'nombre';
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_DESCRIPCION)) {
            $modifiedColumns[':p' . $index++]  = 'descripcion';
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_CONTACTO)) {
            $modifiedColumns[':p' . $index++]  = 'contacto';
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_TELEFONO)) {
            $modifiedColumns[':p' . $index++]  = 'telefono';
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_CORREO_ELECTRONICO)) {
            $modifiedColumns[':p' . $index++]  = 'correo_electronico';
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_FECHA_ALTA)) {
            $modifiedColumns[':p' . $index++]  = 'fecha_alta';
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_FECHA_INICIO)) {
            $modifiedColumns[':p' . $index++]  = 'fecha_inicio';
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_FECHA_FIN)) {
            $modifiedColumns[':p' . $index++]  = 'fecha_fin';
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_FK_ASOCIACION)) {
            $modifiedColumns[':p' . $index++]  = 'fk_asociacion';
        }

        $sql = sprintf(
            'INSERT INTO proyecto (%s) VALUES (%s)',
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
                    case 'nombre':
                        $stmt->bindValue($identifier, $this->nombre, PDO::PARAM_STR);
                        break;
                    case 'descripcion':
                        $stmt->bindValue($identifier, $this->descripcion, PDO::PARAM_STR);
                        break;
                    case 'contacto':
                        $stmt->bindValue($identifier, $this->contacto, PDO::PARAM_STR);
                        break;
                    case 'telefono':
                        $stmt->bindValue($identifier, $this->telefono, PDO::PARAM_STR);
                        break;
                    case 'correo_electronico':
                        $stmt->bindValue($identifier, $this->correo_electronico, PDO::PARAM_STR);
                        break;
                    case 'fecha_alta':
                        $stmt->bindValue($identifier, $this->fecha_alta ? $this->fecha_alta->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'fecha_inicio':
                        $stmt->bindValue($identifier, $this->fecha_inicio ? $this->fecha_inicio->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'fecha_fin':
                        $stmt->bindValue($identifier, $this->fecha_fin ? $this->fecha_fin->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'fk_asociacion':
                        $stmt->bindValue($identifier, $this->fk_asociacion, PDO::PARAM_INT);
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
        $pos = ProyectoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getNombre();
                break;
            case 2:
                return $this->getDescripcion();
                break;
            case 3:
                return $this->getContacto();
                break;
            case 4:
                return $this->getTelefono();
                break;
            case 5:
                return $this->getCorreoElectronico();
                break;
            case 6:
                return $this->getFechaAlta();
                break;
            case 7:
                return $this->getFechaInicio();
                break;
            case 8:
                return $this->getFechaFin();
                break;
            case 9:
                return $this->getFkAsociacion();
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

        if (isset($alreadyDumpedObjects['Proyecto'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Proyecto'][$this->hashCode()] = true;
        $keys = ProyectoTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getNombre(),
            $keys[2] => $this->getDescripcion(),
            $keys[3] => $this->getContacto(),
            $keys[4] => $this->getTelefono(),
            $keys[5] => $this->getCorreoElectronico(),
            $keys[6] => $this->getFechaAlta(),
            $keys[7] => $this->getFechaInicio(),
            $keys[8] => $this->getFechaFin(),
            $keys[9] => $this->getFkAsociacion(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAsociacion) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'asociacion';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'asociacion';
                        break;
                    default:
                        $key = 'Asociacion';
                }

                $result[$key] = $this->aAsociacion->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collItems) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'items';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'items';
                        break;
                    default:
                        $key = 'Items';
                }

                $result[$key] = $this->collItems->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Proyecto
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ProyectoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Proyecto
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setNombre($value);
                break;
            case 2:
                $this->setDescripcion($value);
                break;
            case 3:
                $this->setContacto($value);
                break;
            case 4:
                $this->setTelefono($value);
                break;
            case 5:
                $this->setCorreoElectronico($value);
                break;
            case 6:
                $this->setFechaAlta($value);
                break;
            case 7:
                $this->setFechaInicio($value);
                break;
            case 8:
                $this->setFechaFin($value);
                break;
            case 9:
                $this->setFkAsociacion($value);
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
        $keys = ProyectoTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setNombre($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDescripcion($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setContacto($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTelefono($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCorreoElectronico($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setFechaAlta($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setFechaInicio($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setFechaFin($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setFkAsociacion($arr[$keys[9]]);
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
     * @return $this|\Proyecto The current object, for fluid interface
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
        $criteria = new Criteria(ProyectoTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ProyectoTableMap::COL_ID)) {
            $criteria->add(ProyectoTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_NOMBRE)) {
            $criteria->add(ProyectoTableMap::COL_NOMBRE, $this->nombre);
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_DESCRIPCION)) {
            $criteria->add(ProyectoTableMap::COL_DESCRIPCION, $this->descripcion);
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_CONTACTO)) {
            $criteria->add(ProyectoTableMap::COL_CONTACTO, $this->contacto);
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_TELEFONO)) {
            $criteria->add(ProyectoTableMap::COL_TELEFONO, $this->telefono);
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_CORREO_ELECTRONICO)) {
            $criteria->add(ProyectoTableMap::COL_CORREO_ELECTRONICO, $this->correo_electronico);
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_FECHA_ALTA)) {
            $criteria->add(ProyectoTableMap::COL_FECHA_ALTA, $this->fecha_alta);
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_FECHA_INICIO)) {
            $criteria->add(ProyectoTableMap::COL_FECHA_INICIO, $this->fecha_inicio);
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_FECHA_FIN)) {
            $criteria->add(ProyectoTableMap::COL_FECHA_FIN, $this->fecha_fin);
        }
        if ($this->isColumnModified(ProyectoTableMap::COL_FK_ASOCIACION)) {
            $criteria->add(ProyectoTableMap::COL_FK_ASOCIACION, $this->fk_asociacion);
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
        $criteria = ChildProyectoQuery::create();
        $criteria->add(ProyectoTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Proyecto (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setNombre($this->getNombre());
        $copyObj->setDescripcion($this->getDescripcion());
        $copyObj->setContacto($this->getContacto());
        $copyObj->setTelefono($this->getTelefono());
        $copyObj->setCorreoElectronico($this->getCorreoElectronico());
        $copyObj->setFechaAlta($this->getFechaAlta());
        $copyObj->setFechaInicio($this->getFechaInicio());
        $copyObj->setFechaFin($this->getFechaFin());
        $copyObj->setFkAsociacion($this->getFkAsociacion());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getIntegranteProyectos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addIntegranteProyecto($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getItems() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addItem($relObj->copy($deepCopy));
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
     * @return \Proyecto Clone of current object.
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
     * Declares an association between this object and a ChildAsociacion object.
     *
     * @param  ChildAsociacion $v
     * @return $this|\Proyecto The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAsociacion(ChildAsociacion $v = null)
    {
        if ($v === null) {
            $this->setFkAsociacion(NULL);
        } else {
            $this->setFkAsociacion($v->getId());
        }

        $this->aAsociacion = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAsociacion object, it will not be re-added.
        if ($v !== null) {
            $v->addProyecto($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAsociacion object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAsociacion The associated ChildAsociacion object.
     * @throws PropelException
     */
    public function getAsociacion(ConnectionInterface $con = null)
    {
        if ($this->aAsociacion === null && ($this->fk_asociacion !== null)) {
            $this->aAsociacion = ChildAsociacionQuery::create()->findPk($this->fk_asociacion, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAsociacion->addProyectos($this);
             */
        }

        return $this->aAsociacion;
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
        if ('IntegranteProyecto' == $relationName) {
            return $this->initIntegranteProyectos();
        }
        if ('Item' == $relationName) {
            return $this->initItems();
        }
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
     * If this ChildProyecto is new, it will return
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
                    ->filterByProyecto($this)
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
     * @return $this|ChildProyecto The current object (for fluent API support)
     */
    public function setIntegranteProyectos(Collection $integranteProyectos, ConnectionInterface $con = null)
    {
        /** @var ChildIntegranteProyecto[] $integranteProyectosToDelete */
        $integranteProyectosToDelete = $this->getIntegranteProyectos(new Criteria(), $con)->diff($integranteProyectos);


        $this->integranteProyectosScheduledForDeletion = $integranteProyectosToDelete;

        foreach ($integranteProyectosToDelete as $integranteProyectoRemoved) {
            $integranteProyectoRemoved->setProyecto(null);
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
                ->filterByProyecto($this)
                ->count($con);
        }

        return count($this->collIntegranteProyectos);
    }

    /**
     * Method called to associate a ChildIntegranteProyecto object to this object
     * through the ChildIntegranteProyecto foreign key attribute.
     *
     * @param  ChildIntegranteProyecto $l ChildIntegranteProyecto
     * @return $this|\Proyecto The current object (for fluent API support)
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
        $integranteProyecto->setProyecto($this);
    }

    /**
     * @param  ChildIntegranteProyecto $integranteProyecto The ChildIntegranteProyecto object to remove.
     * @return $this|ChildProyecto The current object (for fluent API support)
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
            $integranteProyecto->setProyecto(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Proyecto is new, it will return
     * an empty collection; or if this Proyecto has previously
     * been saved, it will retrieve related IntegranteProyectos from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Proyecto.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildIntegranteProyecto[] List of ChildIntegranteProyecto objects
     */
    public function getIntegranteProyectosJoinIntegrante(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildIntegranteProyectoQuery::create(null, $criteria);
        $query->joinWith('Integrante', $joinBehavior);

        return $this->getIntegranteProyectos($query, $con);
    }

    /**
     * Clears out the collItems collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addItems()
     */
    public function clearItems()
    {
        $this->collItems = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collItems collection loaded partially.
     */
    public function resetPartialItems($v = true)
    {
        $this->collItemsPartial = $v;
    }

    /**
     * Initializes the collItems collection.
     *
     * By default this just sets the collItems collection to an empty array (like clearcollItems());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initItems($overrideExisting = true)
    {
        if (null !== $this->collItems && !$overrideExisting) {
            return;
        }
        $this->collItems = new ObjectCollection();
        $this->collItems->setModel('\Item');
    }

    /**
     * Gets an array of ChildItem objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProyecto is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildItem[] List of ChildItem objects
     * @throws PropelException
     */
    public function getItems(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collItemsPartial && !$this->isNew();
        if (null === $this->collItems || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collItems) {
                // return empty collection
                $this->initItems();
            } else {
                $collItems = ChildItemQuery::create(null, $criteria)
                    ->filterByProyecto($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collItemsPartial && count($collItems)) {
                        $this->initItems(false);

                        foreach ($collItems as $obj) {
                            if (false == $this->collItems->contains($obj)) {
                                $this->collItems->append($obj);
                            }
                        }

                        $this->collItemsPartial = true;
                    }

                    return $collItems;
                }

                if ($partial && $this->collItems) {
                    foreach ($this->collItems as $obj) {
                        if ($obj->isNew()) {
                            $collItems[] = $obj;
                        }
                    }
                }

                $this->collItems = $collItems;
                $this->collItemsPartial = false;
            }
        }

        return $this->collItems;
    }

    /**
     * Sets a collection of ChildItem objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $items A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildProyecto The current object (for fluent API support)
     */
    public function setItems(Collection $items, ConnectionInterface $con = null)
    {
        /** @var ChildItem[] $itemsToDelete */
        $itemsToDelete = $this->getItems(new Criteria(), $con)->diff($items);


        $this->itemsScheduledForDeletion = $itemsToDelete;

        foreach ($itemsToDelete as $itemRemoved) {
            $itemRemoved->setProyecto(null);
        }

        $this->collItems = null;
        foreach ($items as $item) {
            $this->addItem($item);
        }

        $this->collItems = $items;
        $this->collItemsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Item objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Item objects.
     * @throws PropelException
     */
    public function countItems(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collItemsPartial && !$this->isNew();
        if (null === $this->collItems || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collItems) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getItems());
            }

            $query = ChildItemQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProyecto($this)
                ->count($con);
        }

        return count($this->collItems);
    }

    /**
     * Method called to associate a ChildItem object to this object
     * through the ChildItem foreign key attribute.
     *
     * @param  ChildItem $l ChildItem
     * @return $this|\Proyecto The current object (for fluent API support)
     */
    public function addItem(ChildItem $l)
    {
        if ($this->collItems === null) {
            $this->initItems();
            $this->collItemsPartial = true;
        }

        if (!$this->collItems->contains($l)) {
            $this->doAddItem($l);
        }

        return $this;
    }

    /**
     * @param ChildItem $item The ChildItem object to add.
     */
    protected function doAddItem(ChildItem $item)
    {
        $this->collItems[]= $item;
        $item->setProyecto($this);
    }

    /**
     * @param  ChildItem $item The ChildItem object to remove.
     * @return $this|ChildProyecto The current object (for fluent API support)
     */
    public function removeItem(ChildItem $item)
    {
        if ($this->getItems()->contains($item)) {
            $pos = $this->collItems->search($item);
            $this->collItems->remove($pos);
            if (null === $this->itemsScheduledForDeletion) {
                $this->itemsScheduledForDeletion = clone $this->collItems;
                $this->itemsScheduledForDeletion->clear();
            }
            $this->itemsScheduledForDeletion[]= clone $item;
            $item->setProyecto(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Proyecto is new, it will return
     * an empty collection; or if this Proyecto has previously
     * been saved, it will retrieve related Items from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Proyecto.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildItem[] List of ChildItem objects
     */
    public function getItemsJoinItemAportacion(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildItemQuery::create(null, $criteria);
        $query->joinWith('ItemAportacion', $joinBehavior);

        return $this->getItems($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aAsociacion) {
            $this->aAsociacion->removeProyecto($this);
        }
        $this->id = null;
        $this->nombre = null;
        $this->descripcion = null;
        $this->contacto = null;
        $this->telefono = null;
        $this->correo_electronico = null;
        $this->fecha_alta = null;
        $this->fecha_inicio = null;
        $this->fecha_fin = null;
        $this->fk_asociacion = null;
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
            if ($this->collIntegranteProyectos) {
                foreach ($this->collIntegranteProyectos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collItems) {
                foreach ($this->collItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collIntegranteProyectos = null;
        $this->collItems = null;
        $this->aAsociacion = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProyectoTableMap::DEFAULT_STRING_FORMAT);
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
