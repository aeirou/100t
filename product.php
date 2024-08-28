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

$user_id = $_SESSION['id'];

// gets the product id
$id = $_GET['id']; 
// query all the item in the database
$q = "SELECT `id`, `img` ,`name`, `desc`,`SKU`, `category`, `price`, `created_at`, `modified_at` FROM product WHERE `id` = $id";    
$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

// for error
if (!$r) {
    echo "Error fetching products: " . mysqli_error($conn);
    exit();
}

while ($row = mysqli_fetch_assoc($r)) { 
    $img = $row['img'];   
    $n = $row['name'];
    $d = $row['desc'];
    $s = $row['SKU']; // num of stocks
    $c = $row['category'];   
    $p = $row['price'];   
} 

// when user clicks submit (add to cart)
if (isset($_POST['add_cart'])) {     

    // if the id is set
    if (isset($_GET['id'], $_POST['qty'])) {
        
        // gets the quantity user wants
        $qty = $_POST['qty']; 

        // looks for the user's cart
        $q = "SELECT * FROM `cart` WHERE `user_id` = $user_id";
        $r_cart =  mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
        
        // if user does not have a cart - cannot find the cart
        if (mysqli_num_rows($r_cart) == 0) {        
            // creates the cart by assigning the user one
            $q = "INSERT INTO `cart` (`user_id`, `created_at`) VALUES ($user_id, NOW())";
            $r =  mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
            
            
            // selects the cart of the user
            $q_cart = "SELECT * FROM `cart` WHERE `user_id` = $user_id";
            $r_cart = mysqli_query($conn, $q_cart) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
        }
        // sets the session variable to fetch the user of the cart 
        $_SESSION['cart'] = mysqli_fetch_array($r_cart, MYSQLI_ASSOC);         
    }

    // checks the cart if the product is already in the cart
    // if the query finds the same product id and cart in of an item, it returns > 0.
    $q = "SELECT * FROM `cart_item` WHERE (`cart_id` = " . $_SESSION["cart"]["id"] . " AND `product_id` = $id)";
    $result = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

    // if item is not unique in the cart
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {   
            // if user enters numbers below 0   
            if ($qty < 1) {
                array_push($errors, 'Please enter a number greater than 1.');
            } else {
                // if ok
                $qty = $_POST['qty'];  
                // new quantity added from the original quantity the user wanted
                $new_qty = $row['quantity']+$qty;        
                $q = "UPDATE `cart_item` SET `quantity` = $new_qty, `modified_at` = NOW() WHERE `cart_id` = " . $_SESSION["cart"]["id"] . " AND `product_id` = $id";
                $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

                array_push($success, "You have added " . $qty . " more of '" . $n . "' in your cart!");
            }
        }        
    } else {
        // if user enters numbers below 0 
        if ($qty < 1) {
            array_push($errors, 'Please enter a number greater than 1.');
        } else {
            // if unique
            $q = "INSERT INTO `cart_item` (`product_id`, `cart_id`, `quantity`, `created_at`) 
            VALUES ($id, " . $_SESSION['cart']['id'] . ", $qty, NOW())";
            $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

            array_push($success, 'You have added' . $n . ' in your cart!');
        }
    }

    $cart_id = $_SESSION['cart']['id'];

    // update the total price of the user's item in the cart
    $q = "SELECT * FROM `cart_item`
        LEFT JOIN `product` ON cart_item.product_id = product.id
        LEFT JOIN `cart` ON cart_item.cart_id = cart.id
        WHERE cart_item.cart_id = $cart_id
        ORDER BY `cart_item`.`modified_at` DESC;";
    $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

    $total_price = 0;

    while ($row = mysqli_fetch_assoc($r)) { 
        $total_item_price = 0;
        $p = $row['price'];
        $qty = $row['quantity'];

        $total_item_price += $p * $qty;
        $total_price += $total_item_price;
    } 

    // updates the total price column
    $q = "UPDATE `cart` SET `total_price` = $total_price, `modified_at` = NOW() WHERE `id` = $cart_id";
    $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
    mysqli_close($conn);
}

?>

<head>
    <title><?php echo $n ?> - 100thCAS</title>
</head>

<body>
    <?php
    require_once'header.php';

    if ($errors) {
        echo "<div class='alert alert-warning alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
        echo array_values($errors)[0];
        echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
            </div>";
    };
    
    if ($success) {
        echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
        echo array_values($success)[0];    
        echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
            </div>";
    }
    ?>
    <div class="row">

        <div class="col-md-5">
            <img class="prod_img" src="/100thCAS/img/<?php echo $img ?>" alt="">
        </div>

        <div class="col-md-7"> 
            <div class="prod_info">
                <div class="card_whole card">
                    <div class="card-body">

                        <small><p class="text-warning px-3"><?php echo $c ?></p></small>   
                        <strong><h1 class="px-3"><?php echo $n ?></strong></strong></h1>
                        <small><p class="prod_desc text-muted px-3"><?php echo $d ?></p></small>   
                        <small><p class="prod_price px-3">$<?php echo $p ?></p></small>                        

                        <small><p class="qty_p text-muted px-3">QTY:</p></small>                        
                        <div class="quantity_int">
                            <form action='product.php?id=<?php echo $id ?>' method='post'>
                                <span class="minus">-</span>
                                <input class="qty" id="qty" name="qty" type="text" value="1" min="1"></input>
                                <span class="plus">+</span>
                                <br>
                                <?php
                                if (isset($_SESSION['login'])) {                        
                                    echo '<button type="submit" name="add_cart" value="add_cart" class="cart_btn btn btn-m text-start" id="btn">Add to cart</button>';                                    
                                    if ($s == 0) {
                                        echo '<button type="submit" name="add_cart" value="add_cart" class="cart_btn btn btn-m text-start" id="btn" disabled>Out of Stock!</button>';
                                    }
                                } else {
                                    echo '
                                    <a href="login.php">
                                        <button type="button" name="add_cart" value="add_cart" class="cart_btn btn btn-m text-start" id="btn">Log in to add to cart</button>
                                    </a>
                                    ';
                                }                        
                                ?>                            
                            </form>                            
                        </div>

                    </div>
                </div>
            </div>        
        </div>

    </div>
</body>
<?php
require_once'footer.php';