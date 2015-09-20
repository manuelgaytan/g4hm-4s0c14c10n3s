<?php

use Base\Aviso as BaseAviso;

/**
 * Skeleton subclass for representing a row from the 'aviso' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Aviso extends BaseAviso
{
    public function getFechaAlta($format = NULL)
    {
        if( parent::getFechaAlta() != null ){
            return parent::getFechaAlta()->format("Y-m-d");
        }
    }
    
    public function getFechaVigencia($format = NULL)
    {
        if( parent::getFechaVigencia() != null ){
            return parent::getFechaVigencia()->format("Y-m-d");
        }
    }
}
