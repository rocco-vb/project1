<?php
//Field Validation

class Validation{
    // validate function to check if the user can be signed up
    public function validateSignup(){
        // store fieldnames inside the $fieldnames variable
        $fieldnames = ['voornaam', 'achternaam', 'email', 'username', 'wachtwoord', 'herhaal-wachtwoord'];

        // initialize $error variable and set it as FALSE
        $error = FALSE;
        
        // for each $fieldname, check if its set or empty, if the fieldname is not set or empty then set $error as TRUE
        foreach($fieldnames as $fieldname){
            if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){
                $error = TRUE;
            }
        }

        // if $error is FALSE
        if(!$error){
            // create variables with $_POST data
            $voornaam = $_POST["voornaam"];
            $tussenvoegsel = $_POST["tussenvoegsel"];
            $achternaam = $_POST["achternaam"];
            $email = $_POST["email"];
            $username = $_POST["username"];
            $wachtwoord = $_POST["wachtwoord"];
            $herhaalwachtwoord = $_POST["herhaal-wachtwoord"];

            // if password is equal to repeat-password then do the next
            if($wachtwoord == $herhaalwachtwoord){
                // create new db connection
                $db = new Db('localhost', 'root', '', 'project1', 'utf8');
                // if the email already exists inside the db then output error label, else signup new user
                if($db->alreadyexists($email)){
                    echo '<label>Deze email bestaat al in onze database!</label>';
                }else{
                    // register the new user
                    $db->registreer($voornaam, $tussenvoegsel, $achternaam, $email, $username, $wachtwoord);
                }
            } else{
                // if $error is equal to TRUE then echo Wachtwoorden komen niet overeen!
                echo '<label>Wachtwoorden komen niet overeen!</label>';
            }
        }
    }

    // validate function to check if the user can be logged in
    public function validateLogin(){
        // store fieldnames inside the $fieldnames variable
        $fieldnames = ['email', 'password'];

        // initialize $error variable and set it as FALSE
        $error = FALSE;

        // for each $fieldname, check if its set or empty, if the fieldname is not set or empty then set $error as TRUE
        foreach($fieldnames as $fieldname){
            if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){
                $error = TRUE;
            }
        }

        // if $error is FALSE
        if(!$error){
            // create variables with $_POST data
            $email = $_POST["email"];
            $wachtwoord = $_POST["password"];

            // create new db connection 
            $db = new Db('localhost', 'root', '', 'project1', 'utf8');

            // login the user
            $db->login($email, $wachtwoord);
        } else{
            // if $error is equal to TRUE then echo Verkeerd wachtwoord of username
            echo '<label>Verkeerd wachtwoord of username</label>';
        }
    }
}
