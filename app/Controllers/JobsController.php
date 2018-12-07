<?php
namespace App\Controllers;
use App\Models\Job; // Objeto BD
use Respect\Validation\Validator as v; //Respect/Validation → Packagist

class JobsController extends BaseController{

    // ↓↓ Acción para generar un "Job"
    public function getAddJobAction($request){
        $responseMessage = null;

        if($request->getMethod() == 'POST'){
            $postData = $request->getParsedBody();
            // ↓↓ Respect/Validation → Packagist
            $jobValidator = v::key('title', v::stringType()->notEmpty())
                ->key('description', v::stringType()->notEmpty());

            try {
                $jobValidator->assert($postData); // Valida el tipo de información traida
                $postData = $request->getParsedBody(); // Para tener el "arreglo" asociativo armado del request (Elementos enviados | PSR7)

                $files = $request->getUploadedFiles();
                $logo = $files['logo'];

                // ↓↓ Si estuvo bien la subida del archivo ↓↓
                if($logo->getError() == UPLOAD_ERR_OK){
                    $fileName = $logo->getClientFilename();// Ver PSR7 (Para varia funciones del request)
                    $routeFileName = "uploads/$fileName";
                    // $logo->moveTo("uploads/$filename"); // No sé porque no funciona (:()
                    $logo->moveTo($routeFileName);
                }
                
                $job = new Job();
                $job->title = $postData['title'];
                $job->description = $postData['description'];
                $job->save();

                $responseMessage = 'Saved';
            } catch (\Exception $e) {
                $responseMessage = $e->getMessage();
            }

        }

        $action = $_SERVER['REQUEST_URI']; // Variable creada para el 'action' del FORM

        return $this->renderHTML('addJob.twig', [
            'action' => $action,
            'responseMessage' => $responseMessage
        ]);
    }
}