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
// --- ↓↓ Eloquent (Paquete de Laravel) ↓↓ -----------------------------------------
// ---------------------------------------------------------------------------------
use Illuminate\Database\Capsule\Manager as Capsule; 

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
// --- ↓↓ Request (Diactoros) ↓↓ ---------------------------------------------------
// ---------------------------------------------------------------------------------
// ↓↓ Este "Request" me devuelve la ruta a la que estoy accediendo
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);
var_dump($request->getUri()->getPath());