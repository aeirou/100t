<?php
require_once 'includes/connect.inc';
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $user_id = $_SESSION['id'];
    
    // check if item exists
	$q = "SELECT * FROM `product` WHERE (`id` = $product_id)";
	$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

    // checks if the item is in the cart
    // queries the item in the cart that is in the user's basket and is the current product's id
	$q = "SELECT * FROM `cart_item` WHERE (`cart_id` = '" . $_SESSION['cart']['id'] . "' AND `product_id` = $product_id)";
	$r =  mysqli_query($conn, $q);

    // if item is in the cart:
	if (mysqli_num_rows($r) > 0) {
		// update quantity
		if ($quantity > 0) {
			$row = mysqli_fetch_assoc($r);
			$q = "UPDATE `cart_item` SET `quantity` = '$quantity', `modified_at` = NOW() WHERE (`cart_id` = '" . $_SESSION['cart']['id'] . "' AND `product_id` = $product_id)";
			$r =  mysqli_query($conn, $q);
		} else { // delete item
			$q = "DELETE FROM `cart_item` WHERE (`cart_id` = '" . $_SESSION['cart']['id'] . "' AND `product_id` = '$product_id')";
			$r =  mysqli_query($conn, $q);
		}
	}

    $cart_id = $_SESSION['cart']['id'];

    // update the total price of the user's item in the cart
    $q = "SELECT * FROM `cart_item`
    LEFT JOIN `product` ON cart_item.product_id = product.id
    LEFT JOIN `cart` ON cart_item.cart_id = cart.id
    WHERE cart_item.cart_id = $cart_id
    ORDER BY `cart_item`.`created_at` DESC;";
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


