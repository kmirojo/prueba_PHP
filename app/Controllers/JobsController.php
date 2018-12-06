<?php
namespace App\Controllers;

class JobsController {

    // ↓↓ Acción para generar un "Job"
    public function getAddJobAction(){
        if(!empty($_POST)){
            $job = new Job();
            $job->title = $_POST['title'];
            $job->description = $_POST['description'];
            $job->save();
        }

        include '../views/addJob.php';
    }
}