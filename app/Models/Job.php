<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Por medio de ORM "abstraigo" la tabla Jobs en la 
 * clase Job para que pueda ser accedida desde la 
 * programación directamente
 * */
class Job extends Model {
    protected $table = 'jobs';// => DB Table

    public function getDurationAsString() {
        $years = floor($this->months / 12);
        $extraMonths = $this->months % 12;

        return "Job duration: $years years $extraMonths months";
    }
}