<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// variable that holds a list - list of errors/success messages
$errors = [];
$success = [];

$q = "SELECT * FROM product WHERE `id` = $id";    
$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));


?>

<head>
    <title>Cart - 100thCAS</title>
</head>

<body>

    <?php
    require'header.php';
    
    ?>

<div class="row">
    <div class="col-md-7">
        <div class="cart card">
            <div class="card-body">
                <div class="card_title">
                    <h1><strong><?php echo $_SESSION['fname'] ?>'s Cart</strong></h1>

                    

                </div>                
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="checkout card">
            <div class="card-body">
                <div class="card_title">
                    <h1><strong>Checkout</strong></h1>
                </div>                
            </div>
        </div>
    </div>
</div>

</body>
<?php
require_once'footer.php';