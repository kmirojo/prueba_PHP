<?php
namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator as v;

class UsersController extends BaseController {
    public function getAddUser(){
        return $this->renderHTML('addUser.twig');
    }

    public function postSaveUser($request) {
        $postData = $request->getParsedBody(); // Para tener el "arreglo" asociativo armado del request (Elementos enviados | PSR7)

        $user = new User();
        $user->name = $postData['name'];
        $user->email = $postData['email'];
        $user->password = password_hash($postData['password'], PASSWORD_DEFAULT); // Password encriptado
        $user->save();

        $action = '/users/save'; // Variable creada para el 'action' del FORM

        return $this->renderHTML('addUser.twig');
    }
}