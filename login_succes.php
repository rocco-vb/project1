<?php
//login_succes.php


include "database.php";

session_start();
$db = new DB('localhost', 'root', '', 'project1', 'utf8');

if (isset($_SESSION["email"])) {
    echo '<h3>Login Succes, Welcome - ' . $_SESSION["email"] . '</h3>';
    // todo: 1) populate table account (=vullen met testdata)
    // todo: 2) maak een tabel en toon hier data in uit de database (uit account)
    // Wanneer admin inlogt, moet hij/zij data kunnen toevoegen/wijzigen of verwijderen.
    echo '<br><br><a href="logout.php">Logout</a>';
} else {
    header("location:index.php");
}

