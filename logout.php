<?php
//logout.php

// start the session
session_start();

// unset the session variables
session_unset();

// destroy and end the session
session_destroy();

// redirect to the index page
header("location:index.php");

// exit code and dont do any code after this
exit;
