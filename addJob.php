<?php

use App\Models\Job;

if(!empty($_POST)){
    $job = new Job();
    $job->title = $_POST['title'];
    $job->description = $_POST['description'];
    $job->save();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add job</title>
</head>
<body>
    <h1>Add Job</h1>
    <form action="addJob.php" method="POST">
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