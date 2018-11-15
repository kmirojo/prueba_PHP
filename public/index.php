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
// --- ↓↓ Route Templates ↓↓ -------------------------------------------------------
// ---------------------------------------------------------------------------------
$route = $_GET['route'] ?? '/'; // Definir valor de $route

if($route == '/'){
    require '../index.php';
} else if ($route == 'addJob') {
    require '../addJob.php';
}