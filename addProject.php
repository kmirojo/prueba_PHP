<?php
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule; //Paquete de Laravel "Illumintae - Eloquent"
use App\Models\Project;

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

if(!empty($_POST)){
    $project = new Project();
    $project->title = $_POST['title'];
    $project->description = $_POST['description'];
    $project->save();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Project</title>
</head>
<body>
    <h1>Add Project</h1>
    <form action="addProject.php" method="POST">
        <p>
            <label for="">
                Title
            </label>
            <input type="text" name="title">
        </p>
        <p>
            <label for="">
                Description
            </label>
            <input type="text" name="description">
        </p>

        <button type="submit">Save</button>
    </form>
</body>
</html>