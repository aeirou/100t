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

    $cart_id = $_GET['id'];

    $q = "SELECT * FROM `cart_item`
    LEFT JOIN `product` ON cart_item.product_id = product.id
    LEFT JOIN `cart` ON cart_item.cart_id = cart.id
    WHERE cart_item.cart_id = $cart_id
    ORDER BY `cart_item`.`created_at` DESC;";
    $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
    

}
?>

<head>
    <title>Dashboard - 100thCAS</title>
</head>

<body class="dash">

    <?php
    require_once'header.php';
    ?>

    <p class="h1 fw-bold px-5">Items</p>
    
    <div class="dash_btn">
        <a href="viewcarts.php" class="text-decoration-none">
            <button class="btn btn-add">Go Back</button>
        </a>        
    </div>      

    <table class="table table-striped table-bordered table-hover border-info">
        <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Quantity</th>                
                <th scope="col">Category</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($r)) {
                echo'
                <tr>
                    <th scope="row">' . $row['product_id'] . '</th>
                    <td><img style="width: 200px; height: 200px;" class="mw-50" src="/100thCAS/img/' . $row['img'] . '" alt="img"/></td>
                    <td>' . $row['name'] .'</td>
                    <td>' . $row['quantity'] .'</td>
                    <td>' . $row['category'] .'</td>
                    <td>$' . $row['price'] .'</td>                  
                </tr>                                        
                ';      
            }

            ?>
        </tbody>
    </table>
</body>


<?php
include'footer.php';