<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
include'stylesheets/script.js';
session_start();

if (!isset($_SESSION['login'])) {
    // define url and redirect user
    ob_end_clean();
    // delete the buffer
    header("Location:index.php");
    exit();

} else {
    // destroys the session variables
    $_SESSION = array();
    // destroys the session and all the info it stored
    session_destroy();
    // '?' ends the url and is a seperator from the queries after the symbol in a url.
    header("Location:index.php?l=loggedout");
    

}


