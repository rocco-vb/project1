<?php
//edit_user.php

// start the session
session_start();
include "database.php";

// $title contains the title for the page
$title = "Edit";

// start a new db connection
$db = new DB('localhost', 'root', '', 'project1', 'utf8');

// if the $_SESSION["email"] variable is not set then redirect to the index page
if (!isset($_SESSION["email"])) {
    header("location:index.php"); 
}

// check the user role
if(isset($_SESSION["email"])){
    $role = $db->checkRole();
}

// this creates the $person variable for use in the form
$person = $db->editPerson($_GET['id']);

// store the id from the $person for later use
$acc_id = $person['id'];

// store the voornaam from the person in $voornaam for later use
$voornaam = $person['voornaam'];

// store the tussenvoegsel from the person in $tussenvoegsel for later use
$tussenvoegsel = $person['tussenvoegsel'];

// store the achternaam from the person in $achternaam for later use
$achternaam = $person['achternaam'];

// this creates the $person variable for use in the form
$person_account = $db->editAccount($_GET['id']);

// store the id from the $person for later use
$id = $person_account['id'];

// store the tussenvoegsel from the person in $tussenvoegsel for later use
$email = $person_account['email'];

// store the achternaam from the person in $achternaam for later use
$password = $person_account['password'];

// this inserts the header and the navbar
require_once('header.php');  

?>

<body>

    <form action="user.process.php?acc_id=<?= $acc_id?>&id=<?= $id?>" method="POST">
        <div class="form-group">
            <label>Voornaam: </label>
            <input class="form-control" name="person-voornaam" type="text" value="<?= $voornaam ?>" required>
        </div>
        <div class="form-group">
            <label>Tussenvoegsel: </label>
            <textarea class="form-control" name="person-tussenvoegsel" type="text" required><?= $tussenvoegsel ?></textarea>
        </div>
        <div class="form-group">
            <label>Achternaam: </label>
            <input class="form-control" name="person-achternaam" type="text" value="<?= $achternaam ?>" required>
        </div>
        <div class="form-group">
            <label>Email: </label>
            <input class="form-control" name="account-email" type="text" value="<?= $email ?>" required>
        </div>
        <div class="form-group">
            <label>Password: </label>
            <input class="form-control" name="account-password" type="text" value="<?= $password ?>" required>
        </div>
        <a href="login_user.php" type="button" class="btn btn-danger">Return</a>
        <button type="submit" name="update" class="btn btn-success">Update Post</button>
    </form>

    <?= date("Y-m-d H:i:s",time())?>
    <br>

</body>