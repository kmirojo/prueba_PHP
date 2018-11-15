<?php

require_once 'vendor/autoload.php';
use App\Models\{Job, Project};


// ============================================================
// --- ↓↓ Trabajos ↓↓ -----------------------------------------
// ============================================================
//Trae todas las filas halladas en la tabla 'jobs'(DB)
$jobs = Job::all();

// ============================================================
// --- ↓↓ Proyectos ↓↓ ----------------------------------------
// ============================================================
//Trae todas las filas halladas en la tabla 'projects'(DB)
$projects = Project::all();


function printElement($job){
    // if($job->visible == false){
    //     return;
    // }
    
    echo '<li class="work-position">';
    echo '<h5>' . $job->title . '</h5>';
    echo '<p>' . $job->description . '</p>';
    echo '<p>' . $job->getDurationAsString() . '</p>';
    echo '<strong>Achievements:</strong>';
    echo '<ul>';
    echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
    echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
    echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
    echo '</ul>';
    echo '</li>';   
}
