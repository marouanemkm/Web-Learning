<?php
require '../database.php';
session_start();

if(!empty($_GET['id'])){
    $getId = checkInput($_GET['id']); 
}

$db = Database::connect();
$statement = $db->prepare('SELECT * FROM cours WHERE id = ?');
$statement->execute(array($getId));
$item = $statement->fetch();
Database::disconnect();

function checkInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$statement = $db->prepare('SELECT * FROM users WHERE id = ?');
$statement->execute(array($_SESSION['id']));


if(!empty($_POST['supcom']))
    {
        $db = Database::connect();
        $id = checkInput($_POST['supcom']);
        $statement = $db->prepare('DELETE FROM commentaires WHERE id = ?');
        $statement->execute(array($id));
        Database::disconnect();
        header("Location: index.php");
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
        <title>Espace Membre</title>
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

        <div class="container admin">
            <div class="row">

<!-- SECTION VIDEO -->
                <h1 style="text-align:center;"><strong>Page du cours :</strong><?php echo ' ' . $item['name']; ?></h1>
                <br>
                <div id="video">
                    <iframe width="860" height="515" src="<?php echo $item['video'] ?>" 
                    frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen></iframe>
                </div>
                

<!-- SECTION DESCRIPTION-->
                <div class="">
                    <form>
                        <div class="form-group">
                            <label>Descritpion :</label><?php echo ' ' . $item['description']; ?>
                        </div>
                    </form>

<!-- SECTION COMMENTAIRES -->
                    <?php
                        $db = Database::connect();
                        echo '<table class="table table-bordered">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>Nom</th>';
                        echo '<th>Commentaires</th>';
                        echo '<th>Action</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        $statement = $db->prepare('SELECT commentaires.id, commentaires.cours_id, users.name AS nameuser, commentaires.commentaire FROM commentaires LEFT JOIN users ON commentaires.user_id = users.id WHERE cours_id = ?');
                        $statement->execute(array($getId));
                        while($item = $statement->fetch())
                        {
                        echo '<tr>';
                        echo '<td>'. $item['nameuser'] . '</td>';
                        echo '<td>'. $item['commentaire'] . '</td>';
                        echo '<form class="form" role="form" action="view.php" method="post">';
                        echo '<input type="hidden" name="supcom" value="'. $item['id'] .'"/>';
                        echo '<td><button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-ok"></span> Supprimer</button></td>';
                        echo '</form>';
                        echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        Database::disconnect();
                    ?>


                    <!-- <form method="post" action="">
                        <input class="form-control" name="comment" id="comment" placeholder="Écrivez votre commentaire">
                        <br>
                        <button type="submit" class="btn btn-default">Poster son comentaire</button>
                    </form> -->

                    <div class="form-actions" style="text-align:center;">
                        <a class="btn btn-primary button" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>
                </div>

                

            </div>
        </div>

    </body>
</html>