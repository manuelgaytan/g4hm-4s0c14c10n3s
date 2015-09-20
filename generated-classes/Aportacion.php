<?php

use Base\Aportacion as BaseAportacion;

/**
 * Skeleton subclass for representing a row from the 'aportacion' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Aportacion extends BaseAportacion
{
    public function getFecha($format = NULL)
    {
        if( parent::getFecha() != null ){
            return parent::getFecha()->format("Y-m-d");
        }
    }
}
