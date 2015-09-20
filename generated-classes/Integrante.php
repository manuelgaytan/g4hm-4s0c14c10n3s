<?php

use Base\Integrante as BaseIntegrante;

/**
 * Skeleton subclass for representing a row from the 'Integrante' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Integrante extends BaseIntegrante
{
    public function getFechaNacimiento($format = NULL)
    {
        if( parent::getFechaNacimiento() != null ){
            return parent::getFechaNacimiento()->format("Y-m-d");
        }
    }
}
