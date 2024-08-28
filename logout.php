<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
include'stylesheets/script.js';
session_start();

// when user is not logged in
if (!isset($_SESSION['login'])) {
    // define url and redirect user
    ob_end_clean();
    // delete the buffer
    header("Location:index.php");
    exit();

} else {
    // stores all session data into array
    $_SESSION = array();
    // destroys the array
    session_destroy();
    // '?' ends the url and is a seperator from the queries after the symbol in the url
    header("Location:index.php?l=loggedout");
    

}


