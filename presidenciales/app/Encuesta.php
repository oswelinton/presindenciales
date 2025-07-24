<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Encuesta extends Model
{
    protected $table = "encuesta";

    protected $fillable = ['fecha_reg','calificacion','cedula','nombre','apellido','estado','telefono1','telefono2','tipo_personal','voto_movilizado','tipo_nomina','llamadas','edad'];

}
