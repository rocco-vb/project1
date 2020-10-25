<?php
//registreren.php

// include the database class 
include "database.php";

// include the field_validation class 
include "field_validation.php";

// $title contains the title for the page
$title = "Registreren";

// this inserts the header and the navbar
require_once('header.php');  

//create a new validation class instance and run the validateSignup function
$validation = new Validation();
$validation->validateSignup();

?>

<body>
    <br>
    <?php
        // if $message is set then echo it
        if(isset($message)){
            echo '<label class="test-danger">' . $message . '</label>';
        }
    ?>
    <div class="container" style="width: 500px;">
        <h3>PHP Registratie Pagina</h3><br>
        <form action="" method="post">

            <label for="Voornaam">Voornaam</label>
            <input type="text" name="voornaam" class="form-control" >
            <br>

            <label for="Tussenvoegsel">Tussenvoegsel</label>
            <input type="text" name="tussenvoegsel" class="form-control">
            <br>

            <label for="Achternaam">Achternaam</label>
            <input type="text" name="achternaam" class="form-control" >
            <br>

            <label for="E-mail">E-mail</label>
            <input type="text" name="email" class="form-control" >
            <br>

            <label for="Username">Username</label>
            <input type="text" name="username" class="form-control" >
            <br>

            <label for="Wachtwoord">Wachtwoord</label>
            <input type="password" name="wachtwoord" class="form-control" >
            <br>

            <label for="Password">Herhaal Wachtwoord</label>
            <input type="password" name="herhaal-wachtwoord" class="form-control" >
            <br>

            <input type="submit" name="Registreren" class="btn btn-info" value="Registreren">
            <a href="index.php" class="btn btn-link" role="button">Login?</a>
            <a href="lostpsw.php" class="btn btn-link" role="button">Wachtwoord vergeten?</a>
        </form>
        <br>
    </div>
</body>

</html>