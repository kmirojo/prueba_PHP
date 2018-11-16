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
// --- ↓↓ Sección "Use" ↓↓ -----------------------------------------------------------
// ---------------------------------------------------------------------------------
use Illuminate\Database\Capsule\Manager as Capsule; // Eloquent (Paquete de Laravel)
use Aura\Router\RouterContainer; // Aura Router

// ↓↓ Incialización de "Eloquent" para la 
// conexión con la base de datos ↓↓
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'pruebaphp',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// ↓↓ Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// ↓↓ Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

// ---------------------------------------------------------------------------------
// --- ↓↓ Request (Diactoros) | Router (Aura Router) ↓↓ ----------------------------
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
        'action' => 'getAddJobAction'
    ]);
} else {
    $map->get('index', '/prueba_PHP/', [
        'controller' => 'App\Controllers\IndexController',
        'action' => 'indexAction'
    ]);
    $map->get('addJobs', '/prueba_PHP/jobs/add', [
        'controller' => 'App\Controllers\JobsController',
        'action' => 'getAddJobAction'
    ]);
}

// ↓↓ Matcher → Objeto que compara el request con el mapa
$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

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

if(!$route){
    echo 'No route ';
} else {
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];

    $controller = new $controllerName;
    $controller->$actionName();
    // require $route->handler; // Me trae el 'último' parametro de la ruta
    // var_dump($route->handler);
}

