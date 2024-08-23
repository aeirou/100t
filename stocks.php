<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

// if user is not an admin, user is redirected to page invalid.
if (isset($_SESSION['login']) || !isset($_SESSION['login'])) {
    if (isset($_SESSION['admin']) == 0) {
        header("Location:errordocs/invalid.php");
        exit();
    }
}

// for errors
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$result = array();

// query all the item in the database
$q = "SELECT `id`, `name`, `SKU`, `category`, `price`, `created_at`, `modified_at` FROM product"; 

$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

// for error
if (!$r) {
    echo "Error fetching products: " . mysqli_error($conn);
    exit();
}
?>

<head>
    <title>Inventory - 100thCAS</title>
</head>

<body>
        <p class="h1 display-4 p-5">Inventory list</p>

        <a href="addstock.php">
            <button class="btn btn-info btn-lg ms-2" type="button">Add Stock</button>
        </a> 

        <table class="table table-striped table-bordered table-hover border-info">
            <thead class="thead-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Number of Stocks</th>                
                    <th scope="col">Category</th>
                    <th scope="col">Price</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Modified at</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($r)) {

                    echo'
                    <tr>
                        <th scope="row">' . $row['id'] . '</th>
                        <td>' . $row['name'] .' <br> <a href="editstock.php?id=' . $row['id'] . '" class="text-info text-decoration-none">Edit</a> 
                        <a href="removestock.php?id=' . $row['id'] . '" class="text-danger text-decoration-none">Remove</a> </td>
                        <td>' . $row['SKU'] .'</td>
                        <td>' . $row['category'] .'</td>
                        <td>$' . $row['price'] .'</td>
                        <td>' . $row['created_at'] .'</td>
                        <td>' . $row['modified_at'] .'</td>                    
                    </tr>                                        
                    ';
                }
                ?>
            </tbody>
        </table>
</body>


<?php
include'footer.php';