<?php

use Base\Proyecto as BaseProyecto;

/**
 * Skeleton subclass for representing a row from the 'Proyecto' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Proyecto extends BaseProyecto
{
    public function getFechaAlta($format = NULL)
    {
        if( parent::getFechaAlta() != null ){
            return parent::getFechaAlta()->format("Y-m-d");
        }
    }
    
    public function getFechaInicio($format = NULL)
    {
        if( parent::getFechaInicio() != null ){
            return parent::getFechaInicio()->format("Y-m-d");
        }
    }
    
    public function getFechaFin($format = NULL)
    {
        if( parent::getFechaFin() != null ){
            return parent::getFechaFin()->format("Y-m-d");
        }
    }
}
