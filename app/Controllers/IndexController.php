<?php

namespace App\Controllers;
use App\Models\{Job, Project};

class IndexController {
    public function indexAction(){
        // --- ↓↓ Trabajos ↓↓ -----------------------------------------
        //Trae todas las filas halladas en la tabla 'jobs'(DB)
        $jobs = Job::all();

        // --- ↓↓ Proyectos ↓↓ ----------------------------------------
        //Trae todas las filas halladas en la tabla 'projects'(DB)
        $projects = Project::all();

        $name = 'Juan Rojas';
        $limitMonths = 2000;

        include '../../views/index.php';

    }
}