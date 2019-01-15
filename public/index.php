<?php

// ---------------------------------------------------------------------------------
/* --- ↓↓ Despliegue de errores ↓↓ -------------------------------------------------
* Solamente se utiliza en "Modo desarrollo", si la aplicación
* se encuentra en vivo lo ideal sería no hacer ningún
* despliegue de errores ↓↓↓ ------------------------------------------------------ */
ini_set('display_errors', 1); // → Mostrar Errores
ini_set('display_startup_error', 1); // → "Encender" Errores
error_reporting(E_ALL); // → reporte de todos los errores

// ---------------------------------------------------------------------------------
// --- ↓↓ Auto Load | Busqueda de las clases ↓↓ ------------------------------------
// ---------------------------------------------------------------------------------
require_once '../vendor/autoload.php';

// ---------------------------------------------------------------------------------
// --- ↓↓ Inicialización de sesion ↓↓ ----------------------------------------------
// ---------------------------------------------------------------------------------
session_start();

// ---------------------------------------------------------------------------------
// --- ↓↓ Variables de Entorno ↓↓ --------------------------------------------------
// ---------------------------------------------------------------------------------
/**
 * asigno la instancia del "loader" de "Dotenv" (.env) en la carpeta superior
 * a donde estoy ubicado (public/index.php)
 * __DIR__ → Directorio Actual
 * '/..'   → Directorio Superior
 * getenv  → Captura Variables de entorno
 * */
$dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
$dotenv->load();

// ---------------------------------------------------------------------------------
// --- ↓↓ Formato y seguridad de Acceso ↓↓ -----------------------------------------
// ---------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------
// --- ↓↓ Sección "Use" ↓↓ -----------------------------------------------------------
// ---------------------------------------------------------------------------------
use Illuminate\Database\Capsule\Manager as Capsule; // Eloquent (Paquete de Laravel)
use Aura\Router\RouterContainer; // Aura Router

// ↓↓ Incialización de "Eloquent" para la 
// conexión con la base de datos ↓↓
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_NAME'),
    'username'  => getenv('DB_USER'),
    'password'  => getenv('DB_PASS'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// ↓↓ Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// ↓↓ Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

// ---------------------------------------------------------------------------------
// --- ↓↓ Request (Diactoros | PSR7) | Router (Aura Router) ↓↓ ---------------------
// ---------------------------------------------------------------------------------
// ↓↓ Este "Request" me devuelve la ruta a la que estoy accediendo
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

// ↓↓ Inicializador del "contenedor" de la ruta que me da "Aura Router"
$routerContainer = new RouterContainer();
// ↓↓ Mapa de la rutas → Estructura que va a ir definiendo que ruta corresponde a que archivo
$map = $routerContainer->getMap();

// ↓↓ Rutas | (Nombre ruta, Ruta principal, "Handler")
if($_SERVER['SERVER_NAME'] !== '127.0.0.1'){ // Verificar si las rutas las hago en localhost o en la nube
    $map->get('index', '/', [
        'controller' => 'App\Controllers\IndexController',
        'action' => 'indexAction'
    ]);
    $map->get('addJobs', '/jobs/add', [
        'controller' => 'App\Controllers\JobsController',
        'action' => 'getAddJobAction',
        'auth' => true
    ]);
    $map->post('saveJobs', '/jobs/add', [
        'controller' => 'App\Controllers\JobsController',
        'action' => 'getAddJobAction',
        'auth' => true
    ]);
    $map->get('addUser', '/user/add', [
        'controller' => 'App\Controllers\UsersController',
        'action' => 'getAddUser',
        'auth' => true
    ]);
    $map->post('saveUser', '/users/save', [
        'controller' => 'App\Controllers\UsersController',
        'action' => 'postSaveUser',
        'auth' => true
    ]);
    $map->get('loginForm', '/login', [
        'controller' => 'App\Controllers\AuthController',
        'action' => 'getLogin'
    ]);
    $map->post('auth', '/auth', [
        'controller' => 'App\Controllers\AuthController',
        'action' => 'postLogin'
    ]);
    $map->get('admin', '/admin', [
        'controller' => 'App\Controllers\AdminController',
        'action' => 'getIndex',
        'auth' => true
    ]);
    $map->get('logout', '/logout', [
        'controller' => 'App\Controllers\AuthController',
        'action' => 'getLogout',
        'auth' => true
    ]);
} else { // Si estoy en LocalHost =====================================
    $map->get('index', '/prueba_PHP/', [
        'controller' => 'App\Controllers\IndexController',
        'action' => 'indexAction'
    ]);
    $map->get('addJobs', '/prueba_PHP/jobs/add', [
        'controller' => 'App\Controllers\JobsController',
        'action' => 'getAddJobAction',
        'auth' => true
    ]);
    $map->post('saveJobs', '/prueba_PHP/jobs/add', [
        'controller' => 'App\Controllers\JobsController',
        'action' => 'getAddJobAction',
        'auth' => true
    ]);
    $map->get('addUser', '/prueba_PHP/user/add', [
        'controller' => 'App\Controllers\UsersController',
        'action' => 'getAddUser',
        'auth' => true
    ]);
    $map->post('saveUser', '/prueba_PHP/users/save', [
        'controller' => 'App\Controllers\UsersController',
        'action' => 'postSaveUser',
        'auth' => true
    ]);
    $map->get('loginForm', '/prueba_PHP/login', [
        'controller' => 'App\Controllers\AuthController',
        'action' => 'getLogin'
    ]);
    $map->post('auth', '/prueba_PHP/auth', [
        'controller' => 'App\Controllers\AuthController',
        'action' => 'postLogin'
    ]);
    $map->get('admin', '/prueba_PHP/admin', [
        'controller' => 'App\Controllers\AdminController',
        'action' => 'getIndex',
        'auth' => true
    ]);
    $map->get('logout', '/prueba_PHP/logout', [
        'controller' => 'App\Controllers\AuthController',
        'action' => 'getLogout',
        'auth' => true
    ]);
}

// ↓↓ Matcher → Objeto que compara el request con el mapa
$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

// ↓↓ Impresión de contenido de la BD en la vista
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

// ↓↓ Enrutador ---------------------------------------
if(!$route){
    // echo "No route => $request";
    // var_dump($request);
    echo "No route";
} else {
    // print_r($request);
    
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];
    $needsAuth = $handlerData['auth'] ?? false; // requerimiento de autenticación

    $sessionUserId = $_SESSION['userId'] ?? null; // Id del usuario de la sesión(AuthController.php)
        /**
     * Si necesita autenticación y
     * NO está definido el mensaje
     * ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
     */
    if($needsAuth && !$sessionUserId){
        echo 'Protected Route';
        die;
    }
    
    $controller = new $controllerName;
    $response = $controller->$actionName($request);// Traemos la acción dentro del controlador
    
    // Traigo los "Headers" de mi Response
    foreach($response->getHeaders() as $name => $values){

        // "Headers" de nuestras respuestas que no pueden tener más de un valor al imprimir,
        // por lo tanto si viene con valores adicionales, debemos imprimirlos la misma cantidad
        // de veces, para eso es el segúndo Bucle.
        foreach($values as $value) {
            // Remplazamos valores (%s), por los valores siguientes.
            header(sprintf('%s: %s', $name, $value), false);
        }
    }

    http_response_code($response->getStatusCode());
    echo $response->getBody();
    // require $route->handler; // Me trae el 'último' parametro de la ruta
    // var_dump($route->handler);
}

