<?php
require 'database.php';
session_start();

if(!empty($_GET['id'])){
    $id = checkInput($_GET['id']);
}

if($_SERVER['HTTP_REFERER'] == "http://localhost/learnefrei/php/index.php"){
    $db = Database::connect();
    $requeteVues = $db->prepare('UPDATE cours SET vues = vues + 1 WHERE id = ?');
    $requeteVues->execute(array($id));
    $item = $requeteVues->fetch();
    Database::disconnect();
}

$db = Database::connect();
$statement3 = $db->prepare('SELECT AVG(note) AS note_moyenne FROM notes WHERE id_cours = ?');
$statement3->execute(array($id));
$req = $statement3->fetch();
$noteFinal = $req['note_moyenne'];


$statement4 = $db->prepare('UPDATE cours SET note = ? WHERE id = ?');
$statement4->execute(array($noteFinal, $id));



Database::disconnect();




$likeError = "";
$username = $_SESSION['id'];

$db = Database::connect();
$statement = $db->prepare('SELECT * FROM cours WHERE id = ?');
$statement->execute(array($id));
$item = $statement->fetch();
$numbersOfLikes = $item['likes'];
Database::disconnect();

function checkInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// $statement = $db->prepare('SELECT * FROM users WHERE id = ?');
// $statement->execute(array($_SESSION['id']));


$comment = '';

if(isset($_POST['comment'])){                                
    $db = Database::connect();
    $comment = checkInput($_POST['comment']);
    $requete = $db->prepare('INSERT INTO commentaires (user_id, cours_id, commentaire) VALUES (?, ?, ?)');
    $requete2 = $db->prepare('UPDATE cours SET commentaires = commentaires + 1 WHERE id = ?');
    $requete->execute(array($username,  $id, $comment));
    $requete2->execute(array($id));
    Database::disconnect();
}


if(isset($_POST['like'])){                                
    $db = Database::connect();
    $requete = $db->prepare('SELECT * FROM liked WHERE id_user = ? AND id_cours = ?');
    $requete->execute(array($username, $id));
    if($req = $requete->fetch()){
        $likeError = 'Vous avez déjà mis un like sur ce cours';
    }
    else{
        $like = checkInput($_POST['like']);
        $requete = $db->prepare('INSERT INTO liked(id_user, id_cours) VALUES(?, ?)');
        $requete2 = $db->prepare('UPDATE cours SET likes = likes + 1 WHERE id = ?');
        $requete3 = $db->prepare('SELECT * FROM cours WHERE id = ?');
        $requete->execute(array($username, $id));
        $requete2->execute(array($id));
        $requete3->execute(array($id));
        $item = $requete3->fetch();
        $numbersOfLikes = $item['likes'];
        Database::disconnect();
    }    
}                       
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/style.css">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
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
                    <a class="navbar-brand" href="index.php">Web Learning</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="disconnect.php">Se deconnecter</a></li>
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
                
<!-- SECTION VUES-->
                <div class="form-group">
                    <label>Nombres de vues :</label><?php echo ' ' . $item['vues']; ?>
                </div>

<!-- SECTION DESCRIPTION-->
                <div class="form-group">
                    <label>Descritpion :</label><?php echo ' ' . $item['description']; ?>
                </div>

<!-- SECTION NOTE -->
                <div class="form-group">
                    <label>Note du cours :<?php echo ' ' . $item['note']; ?> / 5</label>
                </div>

<!-- SECTION COMMENTAIRES -->
                    <?php
                        $db = Database::connect();
                        echo '<table class="table table-bordered">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>Nom</th>';
                        echo '<th>Commentaires</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        $statement = $db->prepare('SELECT commentaires.cours_id, users.name AS nameuser, commentaires.commentaire FROM commentaires LEFT JOIN users ON commentaires.user_id = users.id WHERE cours_id = ?');
                        $statement->execute(array($id));
                        while($item = $statement->fetch())
                        {
                        echo '<tr>';
                        echo '<td>'. $item['nameuser'] . '</td>';
                        echo '<td>'. $item['commentaire'] . '</td>';
                        echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        Database::disconnect();
                    ?>


                    <form method="post" action="">
                        <input class="form-control" name="comment" id="comment" placeholder="Écrivez votre commentaire">
                        <br>
                        <button type="submit" class="btn btn-default col-md-6">Poster son comentaire</button>
                    </form>

                    <form method="post" action="">
                        <input type="hidden" name="like" id="like" value="1">
                        <button type="submit" class="btn btn-default col-md-6" style="width:15%;margin-left:100px;"><span class="glyphicon glyphicon-thumbs-up"> <?php echo $numbersOfLikes ?></span></button>
                    </form>
                    <span class="msgerror"><?php echo $likeError; ?></span>

                    <?php
                        $statement = $db->prepare('SELECT * FROM cours WHERE id = ?');
                        $statement->execute(array($id));
                        $itemCours = $statement->fetch();
                    ?>

                    <div class="rating">
                        <a href="notes/5stars.php?id=<?php echo $itemCours['id'] ?>" title="Donner 5 étoiles">☆</a>
                        <a href="notes/4stars.php?id=<?php echo $itemCours['id'] ?>" title="Donner 4 étoiles">☆</a>
                        <a href="notes/3stars.php?id=<?php echo $itemCours['id'] ?>" title="Donner 3 étoiles">☆</a>
                        <a href="notes/2stars.php?id=<?php echo $itemCours['id'] ?>" title="Donner 2 étoiles">☆</a>
                        <a href="notes/1stars.php?id=<?php echo $itemCours['id'] ?>" title="Donner 1 étoile">☆</a>
                    </div>

                    <div class="form-actions" style="text-align:center;">
                        <a class="btn btn-primary button col-md-12" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>