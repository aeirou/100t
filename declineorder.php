<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

// if user is not an admin, user is redirected to page invalid.
if (isset($_SESSION['login']) || !isset($_SESSION['login'])) {
    if ($_SESSION['admin'] == 0) {
        header("Location:errordocs/invalid.html");
        exit();
    }
}

if (isset($_GET['id'])) {
    // gets the id through GET method
    $id = $_GET['id']; 

    $q = "UPDATE `cart` SET `pending` = NULL, `approved` = NULL WHERE `id` = $id";
    $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
    header("Location:viewcarts.php?d=" . $id ."");
    exit();
}