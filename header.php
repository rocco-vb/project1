<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="exportExcel/tableexport.min.css" type="text/css">
    <style>
        caption.btn-toolbar.bottom{
            display: none;
        }
    </style>    
    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>

<div class="bs-example">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a href="#" class="navbar-brand">Flowerpower</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="#" class="nav-item nav-link">About</a>
                <a href="#" class="nav-item nav-link">Products</a>
            </div>
            <form class="form-inline ml-auto">
                <div class="navbar-nav">
                    <!-- if the $_SESSION["email"] variable is set then echo the logout link in the nav and the admin page link or user page link-->
                    <?php 
                    if(isset($_SESSION["email"])){
                        echo '<a href="logout.php" class="nav-item nav-link">Logout</a>';
                        if($role == "Admin"){
                            echo '<a href="login_admin.php" class="nav-item nav-link">'.$_SESSION["email"].'</a>';
                        }else{
                            echo '<a href="login_user.php" class="nav-item nav-link">'.$_SESSION["email"].'</a>';
                        }   
                    }else{
                        // if the user is not logged in echo the login page link inside the nav
                        echo '<a href="login.php" class="nav-item nav-link">Login</a>';
                    }
                    ?>
                </div>
            </form>
        </div>
    </nav>
</div>