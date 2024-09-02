<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

// variable that holds a list - list of errors/success messages
$errors = [];
$success = [];

// id of user
$user_id = $_SESSION['id'];

$total_price = 0;

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
$cart_id = $_SESSION['cart']['id'];


// quering the cart of the user
$q = "SELECT product.id, product.name, product.price, product.img, product.SKU, cart.total_price, cart_item.quantity  FROM `cart_item`
LEFT JOIN `product` ON cart_item.product_id = product.id
LEFT JOIN `cart` ON cart_item.cart_id = cart.id
WHERE cart_item.cart_id = $cart_id
ORDER BY `cart_item`.`created_at` DESC;";
$r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));


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
                <h1><strong><?php echo $_SESSION['fname'] ?>'s Cart</strong></h1>
                <table id="cart_table" class="table table-striped">
                    <?php
                    if (mysqli_num_rows($r) == 0) {   
                        echo '<p>You do not have anything in your cart!</p>';
                    } else {
                        echo'  
                        <thead>
                            <th scope="col"></th>
                            <th scope="col" class="name">Name:</th>
                            <th scope="col">QTY:</th>
                            <th scope="col">Price:</th>
                            <th scope="col">Total Price:</th>
                        </thead>
                    '; 
                    }
                    ?>

                    <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($r)) {
                        if (mysqli_num_rows($r) == 0) {
                            echo '<p>You do not have anything in your cart!</p>';                            
                        } else {
                            // if row is 0                          
                            $total_item_price = 0;
                            $total_item_price += $row['quantity'] * $row['price'];  
                            $total_price += $total_item_price;                      
                            echo '                            
                                <td><img style="width: 100px; height: 100px;" class="mw-50" src="/100thCAS/img/' . $row['img'] . '" alt="img"/></td>
                                <td>'. $row["name"] . '</td>
                                <td>
                                    <span class="minus">-</span>
                                    <input class="qty" id="qty" name="qty" data-product-id="' . $row['id'] . '" type="text" value="' . $row["quantity"] . '"></input>
                                    <span class="plus">+</span>
                                </td>
                                <td>$'. $row["price"] . '</td>
                                <td>$'. $total_item_price . '</td>
                            </tr>                            
                            ';                            
                        }
                    }                   
                    ?>      
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="checkout card">
            <div class="card-body checkout_body">
                <h1><strong>Checkout</strong></h1>  
                <div class="checkout_info">  

                    <div class="row">
                        <div class="col-md-7">
                            <p class="px-3"><strong>TYPE OF PAYMENT:</strong></p>
                        </div>
                        <div class="col-sm-5">
                            <p class="text-end px-3"><strong>IN VENUE</strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <p class="px-3"><strong>ESTIMATED PRICE:</strong></p>
                        </div>
                        <div class="col-sm-5">
                            <p class="text-end px-3"><strong>NZD $<?php echo $total_price; ?></strong></p>
                        </div>
                    </div>
                    
                    <?php
                     if (mysqli_num_rows($r) == 0) {
                        echo '<a href="store.php">
                                <button type="button" name="pre_order" value="pre_order" class="cart_btn btn btn-m" id="btn" disabled>Pre order</button>
                            </a>';
                    } else {
                        echo '<a href="confirmorder.php?id=<?php echo $cart_id; ?>">
                                <button type="button" name="pre_order" value="pre_order" class="cart_btn btn btn-m" id="btn">Pre order</button>
                            </a>';
                    }
                    ?>                    
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<?php
require_once'footer.php';