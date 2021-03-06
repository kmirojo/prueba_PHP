<?php

namespace App\Controllers;

use App\Models\{Job, Project};
// use App\Models\{Job, Project};

class IndexController extends BaseController{
    public function indexAction(){
        // --- ↓↓ Trabajos ↓↓ -----------------------------------------
        //Trae todas las filas halladas en la tabla 'jobs'(DB)
        $jobs = Job::all(); // fetch tabla

        // --- ↓↓ Proyectos ↓↓ ----------------------------------------
        //Trae todas las filas halladas en la tabla 'projects'(DB)
        $projects = Project::all(); // fetch tabla

        $name = 'Juan Rojas';
        $limitMonths = 2000;

        // --- ↓↓ Vista ↓↓ --------------------------------------------
        //Trae la vista para que se visualice al cargar la funsión
        return $this->renderHTML('index.twig', [
            'name' => $name,
            'jobs' => $jobs
        ]);

    }
}