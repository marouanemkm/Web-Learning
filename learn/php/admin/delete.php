<?php
    require '../database.php';

    if(isset($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }

    if(!empty($_POST['id']))
    {
        $db = Database::connect();
        $id = checkInput($_POST['id']);
        $statement = $db->prepare('DELETE FROM cours WHERE id = ?');
        $statement->execute(array($id));
        Database::disconnect();
        header("Location: index.php");
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

        <div class="container admin">
            <div class="row">

                <h1 style="text-align:center;"><strong>Supprimer un cours</strong></h1>
                <br>

                <form class="form" role="form" action="delete.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <p class="alert alert-warning">Êtes vous sur de vouloir supprimer le cours ? Cette action est irréversible.</p>
                    <div class="form-actions" style="text-align:center;">
                        <a class="btn btn-default" href="index.php"><span class="glyphicon glyphicon-remove"></span> Non</a>
                        <button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-ok"></span> Oui</button>
                    </div>
                </form>

            </div>
        </div>
    </body>
</html>