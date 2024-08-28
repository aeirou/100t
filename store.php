<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// query all the item in the database
$q = "SELECT `id`, `img` ,`name`, `SKU`, `category`, `price`, `created_at`, `modified_at` FROM product"; 

$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

// for error
if (!$r) {
    echo "Error fetching products: " . mysqli_error($conn);
    exit();
}

$num_rows = mysqli_num_rows($r);

?>

<head>
    <title>Store - 100thCAS</title>
</head>

<body>
    <?php
    require_once'header.php';
    ?>

    <div class="products p-5 py-3 d-flex justify-content-center">
        <?php                 
        if ($num_rows > 0) {

            echo '<div class="row pt-5">'; 

            while ($row = mysqli_fetch_assoc($r) ) { 
                echo '<div class="box_product col-3 p-3">'; 
                echo'
                <a class="text-decoration-none text-black" href="product.php?id=' . $row['id'] .' ">                                                                             
                    <div class="container-fluid">
                        <div class="single_product">
                            <img style="width: 200px; height: 200px;" class="mw-50" src="/100thCAS/img/' . $row['img'] . '" alt="img"/>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-start text-muted px-3">' . $row['category'] . '</small>
                                </div>
                                <div class="col-6">
                                    <small class="text-end text-muted px-2">Stocks: ' . $row['SKU'] . '</small>                                    
                                </div>
                            </div>
                            <h6 class="p-4">' . $row['name'] . '</h6>
                            <p class="price">$' . $row['price'] . '</p>                                        
                        </div>                                   
                    </div>
                </a> 
                ';
                echo '</div>';
                }

            echo '</div>';             
        } else {
            echo 'No items found.';
        }        
        ?>
    </div>
</body>
