<?php
    // start the session
    session_start();

    // $title contains the title for the page
    $title = "Home";

    // include the database class
    include "database.php";

    // start a new db connection
    $db = new DB('localhost', 'root', '', 'project1', 'utf8');

    // check the user role
    if(isset($_SESSION["email"])){
        $role = $db->checkRole();
    }
    
    // this inserts the header and the navbar
    require_once('header.php');  
?>

<body>
    <div class="header">
        <img src="./images/flowerpower.png" class="img-fluid" alt="Responsive image">
    </div>

    <div class="products mt-2">
        <h4 class="text-center">Products</h4>
        <div class="container">
            <div class="row">
                <div class="col">
                    <img src="./images/flowers1.jpg" class="img-fluid" alt="Responsive image">
                </div>
                <div class="col">
                    <img src="./images/flowers2.jpg" class="img-fluid" alt="Responsive image">
                </div>
                <div class="col">
                    <img src="./images/flowers3.jpg" class="img-fluid" alt="Responsive image">
                </div>
                <div class="col mb-4">
                    <img src="./images/flowers4.jpg" class="img-fluid" alt="Responsive image">
                </div>
            </div>
        </div>
    </div>
</body>