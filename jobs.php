<?php

require_once('app/Models/Job.php');
require_once('app/Models/Project.php');
require_once('app/Models/Printable.php');

// ============================================================
// --- ↓↓ Trabajos ↓↓ -----------------------------------------
// ============================================================
$job1 = new Job('PHP Developer', 'This is an awesome job!!!');
// $job1->setTitle('PHP Developer');
// $job1->description = 'This is an awesome job!!!';
// $job1->visible = true;
$job1->months = 16;

$job2 = new Job('Python Developer', 'This is an awesome job!!!');
$job2->months = 24;

$job3 = new Job('Devops', 'This is an awesome job!!!');
$job3->months = 24;

$jobs = [
    $job1,
    $job2,
    $job3
];

// ============================================================
// --- ↓↓ Proyectos ↓↓ ----------------------------------------
// ============================================================
$project1 = new Project('Project 1', 'Description 1');

$projects = [
    $project1
];


function printElement(Printable $job){
    if($job->visible == false){
        return;
    }
    
    echo '<li class="work-position">';
    echo '<h5>' . $job->getTitle() . '</h5>';
    echo '<p>' . $job->getDescription() . '</p>';
    echo '<p>' . $job->getDurationAsString() . '</p>';
    echo '<strong>Achievements:</strong>';
    echo '<ul>';
    echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
    echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
    echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
    echo '</ul>';
    echo '</li>';   
}
