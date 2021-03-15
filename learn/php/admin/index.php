<?php
    require '../database.php';

    session_start();

    if($_SESSION['admin'] != 1){
        header("Location: ../index.php");
    }


?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../../css/style.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <title>Admin</title>
    </head>

    <body>

        <!-- NAVBAR -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="../index.php">Web Learning</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="../disconnect.php">Se deconnecter</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <h1>Interface de gestion</h1>
        <br>
        <br>
        <h5><a href="insert.php">Ajouter un cours </a></h5>

        <table class="table table-striped table-bordered" style="width:90%;margin:0 auto;">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Interactions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $db = Database::connect();

                    $statement = $db->query('SELECT * FROM cours ORDER BY rank DESC');
                    while($item = $statement->fetch()) 
                    {
                        echo '<tr>';
                        echo '<td>'. $item['name'] . '</td>';
                        echo '<td>'. $item['description'] . '</td>';
                        echo '<td width=300>';
                        echo '<a class="btn btn-default" href="view.php?id='.$item['id'].'"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                        echo ' ';
                        echo '<a class="btn btn-primary" href="update.php?id='.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                        echo ' ';
                        echo '<a class="btn btn-danger" href="delete.php?id='.$item['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    Database::disconnect();
                    
                ?>
            </tbody>
        </table>
