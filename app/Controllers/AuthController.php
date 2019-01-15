<?php
namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator as v;
use Zend\Diactoros\Response\RedirectResponse;

class AuthController extends BaseController {
    // Traer el template del Login
    public function getLogin() {
        return $this->renderHTML('login.twig');
    }

    // Acción para hacer "Login"
    public function postLogin($request) {
        $postData = $request->getParsedBody(); // Para tener el "arreglo" asociativo armado del request (Elementos enviados | PSR7)
        $responseMessage = null;
        
        // Buscamos el PRIMER correo que encuentre que sea igual a el mail del FORM
        $user = User::where('email', $postData['email'])->first();
        
        // Verificación de la existencia del usuario por el "correo"
        if($user) {

            // Verificación del "password" del usuario
            if(password_verify($postData['password'], $user->password)){
                $_SESSION['userId'] = $user->id; // Inicio de la sesion

                return new RedirectResponse('admin'); // Redirección al acertar credenciales
            } else {
                $responseMessage = 'Bad credentials';
            }
        } else {
            $responseMessage = 'Bad credentials';
        }

        return $this->renderHTML('login.twig', [
            'responseMessage' => $responseMessage
        ]);
    }

    // Acción para hacer "Logout"
    public function getLogout(){
        unset($_SESSION['userId']); // Elimino el valor del "UserId" de la sesion
        return new RedirectResponse('login'); // Redirecciono al Login
    }
}
