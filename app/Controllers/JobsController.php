<?php
namespace App\Controllers;
use App\Models\Job; // Objeto BD

class JobsController extends BaseController{

    // ↓↓ Acción para generar un "Job"
    public function getAddJobAction($request){
        // var_dump($request->getBody());
        // var_dump($request->getParsedBody());

        if($request->getMethod() == 'POST'){
            $postData = $request->getParsedBody(); //para tener el "arreglo" asociativo armado del request
            $job = new Job();
            $job->title = $postData['title'];
            $job->description = $postData['description'];
            $job->save();
        }

        $action = $_SERVER['REQUEST_URI']; // Variable creada para el 'action' del FORM

        echo $this->renderHTML('addJob.twig');
    }
}