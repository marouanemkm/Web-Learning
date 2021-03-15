<?php
    require '../database.php';
    $nameError = $descriptionError = $videoLinkError = $name = $description = $videoLink = "";

    if(!empty($_GET['id'])){
        $getId = checkInput($_GET['id']); 
    }
    
    if(!empty($_POST)){
        $name = checkInput($_POST['name']);
        $description = checkInput($_POST['description']);
        $videoLink = checkInput($_POST['video']);

        var_dump($name);
        var_dump($description);
        var_dump($videoLink);

        $isSuccess = true;

        if(empty($name)){
            $nameError = 'Tu dois remplir ce champ';
            $isSuccess = false;
        }
        if(empty($description)){
            $descriptionError = 'Tu dois remplir ce champ';
            $isSuccess = false;
        }

        if(empty($videoLink)){
            $videoLinkError = 'Tu dois remplir ce champ';
            $isSuccess = false;
        }

        if($isSuccess){
            $db = Database::connect();
            $statement = $db->prepare('UPDATE cours SET name = ?, description = ?, video = ? WHERE id = ?');
            $statement->execute(array($name, $description, $videoLink, $getId));
            Database::disconnect();
            header("Location: index.php");
        }
    }
    else{
        $db = Database::connect();
        $statement = $db->prepare('SELECT * FROM cours WHERE id = ?');
        $statement->execute(array($getId));
        $item = $statement->fetch();
        $name = $item['name'];
        $description = $item['description'];
        $videoLink = $item['video'];
        Database::disconnect();
    }


    function checkInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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
        
        <div class="container admin">
            <div class="row">

                <h1 style="text-align:center;"><strong>Modifier le cours <?php echo $name ?> </strong></h1>
                <br>
                <form class="form" role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nom du cours :</label>
                        <input type="text" class="form form-control" id="name" name="name" placeholder="nom du cours" value="<?php echo $name; ?>">
                        <span class="msgerror"><?php echo $nameError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="description">Description du cours :</label>
                        <input type="text" class="form form-control" id="description" name="description" placeholder="description du cours" value="<?php echo $description; ?>">
                        <span class="msgerror"><?php echo $descriptionError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="text">Lien de la vidéo</label>
                        <input type="text" class="form form-control" id="video" name="video" placeholder="lien de la video" value="<?php echo $videoLink; ?>">
                        <span class="msgerror"><?php echo $videoLinkError; ?></span>
                    </div>
                    
                    
                    <div class="form-actions" style="text-align:center;">                        
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour à la page de gestion</a>
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                    </div>
                </form>

                

            </div>
        </div>
    </body>
</html>