<?php

use Base\Usuario as BaseUsuario;

/**
 * Skeleton subclass for representing a row from the 'Usuario' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Usuario extends BaseUsuario
{
    public function getFechaUltimoAcceso($format = NULL)
    {
        if( parent::getFechaUltimoAcceso() != null ){
            return parent::getFechaUltimoAcceso()->format("Y-m-d, h:m");
        }
    }
}
