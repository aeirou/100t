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

// query all the item in the database
$q = "SELECT `id`, `img`, `name`, `SKU`, `category`, `price`, `created_at`, `modified_at` FROM product"; 

$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

// for error
if (!$r) {
    echo "Error fetching products: " . mysqli_error($conn);
    exit();
}
?>

<head>
    <title>Dashboard - 100thCAS</title>
</head>

<body class="dash">

    <?php
    require_once'header.php';
    ?>

    <p class="h1 fw-bold px-5">Dashboard</p>
    
    <div class="dash_btn">
        <a href="addstock.php" class="text-decoration-none">
            <button class="btn btn-add">Add Item</button>
        </a>
        <a href="attendees.php" class="text-decoration-none">
            <button class="btn btn-view">View Attendees</button>
        </a>
        <a href="viewcarts.php" class="text-decoration-none">
            <button class="btn btn-view-cart">View Carts</button>
        </a>
    </div>      

    <table class="table table-striped table-bordered table-hover border-info">
        <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col"># of Stocks</th>                
                <th scope="col">Category</th>
                <th scope="col">Price</th>
                <th scope="col">Created at</th>
                <th scope="col">Last modified at</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($r)) {
                echo'
                <tr>
                    <th scope="row">' . $row['id'] . '</th>
                    <td><img style="width: 200px; height: 200px;" class="mw-50" src="/100thCAS/img/' . $row['img'] . '" alt="img"/></td>
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