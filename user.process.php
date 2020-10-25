<?php
    // start the session
    session_start();
    
    // include the database class
    include "database.php";

    // start a new db connection
    $db = new DB('localhost', 'root', '', 'project1', 'utf8');

    // if the $_POST["update"] is set then set variables with $_GET and $_POST variables and use the updatePerson function, after that redirect to login_user page
    // if the $_GET["send"] equal is to del then set variable with $_GET data and use the deletePerson function, after that redirect to login_user page
    if(isset($_POST['update'])){
        $acc_id = $_GET['acc_id'];
        $id = $_GET['id'];
        $voornaam = $_POST['person-voornaam'];
        $tussenvoegsel= $_POST['person-tussenvoegsel'];
        $achternaam = $_POST['person-achternaam'];
        $email = $_POST['account-email'];
        $password = $_POST['account-password'];

        $db->updatePerson($voornaam, $tussenvoegsel, $achternaam, $acc_id);
        $db->updateAccount($email, $password, $id);

        if($db->checkRole() == "Admin"){
            header("Location: login_admin.php");
        }else{
            header("Location: login_user.php");
        }
        

    }else if($_GET['send'] === 'del'){
        $id = $_GET['id'];
        
        $db->deletePerson($id);
        header("Location: login_user.php");
    }