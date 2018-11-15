<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Por medio de ORM "abstraigo" la tabla Jobs en la 
 * clase Job para que pueda ser accedida desde la 
 * programación directamente
 * */
class Project extends Model {
    protected $table = 'projects';// => DB Table

    public function getDurationAsString() {
        return "Prueba Project";
    }
    
}