<?php
//index.php

// start the session
session_start();

// include the database class
include "database.php";

// include the field_validation class
include "field_validation.php";

// $title contains the title for the page
$title = "Login";

// this inserts the header and the navbar
require_once('header.php');  

// start a new db connection
$db = new DB('localhost', 'root', '', 'project1', 'utf8');

// if $_POST["login"] is set then check if $_POST["email"] or $_POST["password"] is set or empty, 
// if they arent set, set the $message with msg All fields are required
// if they arent empty and are set then create a new validation class instance and run the validateLogin function
if (isset($_POST["login"])) {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $message = '<label>All fields are required</label>';
    } else {
        $validation = new Validation();
        $validation->validateLogin();
    }
}

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
        <h3>PHP Login Pagina</h3><br>
        <form action="" method="post">

            <label for="Email">Email</label>
            <input type="text" name="email" class="form-control">
            <br>

            <label for="Password">Password</label>
            <input type="password" name="password" class="form-control">
            <br>

            <input type="submit" name="login" class="btn btn-info" value="Login">
            <a href="signup.php" class="btn btn-link" role="button">Registreren?</a>
        </form>
    </div>
</body>

</html>