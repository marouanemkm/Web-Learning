<?php
    require 'database.php';
    session_start();

    if(!isset($_SESSION['id']))
    {
        header("Location: ../index.php");
    }

    $db = Database::connect();
    $requeteRank = $db->query('UPDATE cours SET rank = (vues + likes + commentaires) / 3');
    Database::disconnect();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/style.css">
        <title>Espace Membre</title>
    </head>

    <body>

        <!-- NAVBAR -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">Web Learning</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="disconnect.php">Se deconnecter</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <h1>Bonjour <?php echo $_SESSION['name'] ?></h1>

        <table class="table table-striped table-bordered" style="width:90%;margin:0 auto;">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Page du cours</th>
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
                        echo '</td>';
                        echo '</tr>';
                    }
                    Database::disconnect();
                ?>
            </tbody>
        </table>
        
        <?php
            if($_SESSION['admin'] == 1){
                echo '<a class="admin-link" href="admin/index.php">Accéder à l\'administration</a>';
            }
        ?>

    </body>
</html>