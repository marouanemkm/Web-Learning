<?php
    require 'php/database.php';
 
    $email = $name = $pass = $emailError = $nameError = $passError = "";
    $isSuccess = true;


    session_start();
    
    if(!isset($_SESSION['id']))
    {
        if(!empty($_POST)) 
        {
            $email = checkInput($_POST['email']);
            $name  = checkInput($_POST['name']);
            $pass  = checkInput($_POST['pass']);
        
            if(empty($email)) 
            {
                $emailError = 'Ce champ ne peut pas être vide';
                $isSuccess = false;
            }
            if(empty($name)) 
            {
                $nameError = 'Ce champ ne peut pas être vide';
                $isSuccess = false;
            } 
            if(empty($pass)) 
            {
                $passError = 'Ce champ ne peut pas être vide';
                $isSuccess = false;
            } 
            

            if($isSuccess) 
            {
                $db = Database::connect();

                $statement = $db->prepare("INSERT INTO users (email, name, pass) VALUES(?, ?, ?)");
                $statement->execute(array($email, $name, $pass));

                $resultats = $db->prepare("SELECT * FROM users WHERE email = ?");
                $resultats->execute(array($email));
                $resultats = $resultats->fetch();
                
                Database::disconnect();

                session_start();
                $_SESSION['id'] = $resultats['id'];
                $_SESSION['name'] = $resultats['name'];
                $_SESSION['email'] = $resultats['email'];
                $_SESSION['admin'] = $resultats['admin'];
                header("Location: php/index.php");
            }
        }
    }
    else
    {
        header("Location: php/index.php");
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
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
                        <li><a href="index.php">Se Connecter</a></li>
                        <li><a href="inscription.php">S'inscrire</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- FORMULAIRE -->
        <h1>Inscription</h1>
        <form method="post" class="form-horizontal" action="">
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email :</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Votre email" value="<?php echo $email ?>">
                </div>
                <span class="error"><?php echo $emailError ?></span>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Nom :</label>
                <div class="col-sm-10">
                    <input type="name" class="form-control" id="name" name="name" placeholder="Votre nom" value="<?php echo $name ?>">
                </div>
                <span class="error"><?php echo $nameError ?></span>
            </div>

            <div class="form-group">
                <label for="pass" class="col-sm-2 control-label">Mot de passe :</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Votre mot de passe">
                </div>
                <span class="error"><?php echo $passError ?></span>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">S'inscrire</button>
                </div>
                <p class="go-signup">Déjà inscrit ? <a href="index.php">Cliquez ici pour vous connecter</a></p>
            </div>

        </form>

    </body>
</html>