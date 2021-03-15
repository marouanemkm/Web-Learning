<?php
    require '../database.php';

    if(!empty($_GET['id'])){
        $id = checkInput($_GET['id']);
    }

    session_start();

    $id_user = $_SESSION['id'];

    $note = 4;

    $db = Database::connect();

    $statement1 = $db->prepare('SELECT * FROM notes WHERE id_user = ? AND id_cours = ?');
    $statement1->execute(array($id_user, $id));

    if($statement1->fetch()){
        header("Location: erreur.php");
    }
    else{
        $statement2 = $db->prepare('INSERT INTO notes (id_user, id_cours, note) VALUES (?, ?, ?)');
        $statement2->execute(array($id_user, $id, $note));
        header("Location: ../index.php");
    }

    Database::disconnect();


    function checkInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>