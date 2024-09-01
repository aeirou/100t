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

// for errors
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$true = 1;

$q = "SELECT cart.id AS cart_id, cart.total_price, cart.pending, cart.approved, cart.modified_at, user.email, user.id AS user_id FROM `cart`
    LEFT JOIN `user` ON cart.user_id = user.id
    WHERE cart.pending = $true OR cart.approved = $true";
$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn)); 

?>

<head>
    <title>Dashboard - 100thCAS</title>
</head>

<body class="dash">

    <?php
    require_once'header.php';
    ?>

<p class="h1 fw-bold px-5 pb-4">Cart List</p>

    <div class="dash_btn">
        <a href="dashboard.php" class="text-decoration-none">
            <button class="btn btn-add">Go Back</button>
        </a>        
    </div>  

    <table class="table table-striped table-bordered table-hover border-info">
        <thead class="thead-light">
            <tr>
                <th scope="col">Cart ID</th>
                <th scope="col">Email</th>                
                <th scope="col">User Id</th>
                <th scope="col">Total $</th>
                <th scope="col">Pending</th>
                <th scope="col">Approved</th>
                <th scope="col">Last modified at</th>
                <th scope="col">Action Buttons</th>                
            </tr>
        </thead>
        <tbody>
            <?php            
            
            while ($row = mysqli_fetch_assoc($r)) {  
                if (isset($_GET['a'])) {

                    $alert_id = $_GET['a'];


                    echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";

                    echo 'You have approved cart #' . $alert_id . '!';

                    echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
                    </div>";

                } elseif (isset($_GET['d'])) {
                    
                    $alert_id = $_GET['d'];                
                    
                    echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";

                    echo 'You have declined cart #' . $alert_id . '!';

                    echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
                    </div>";
                }                               

                echo'
                <tr>
                    <th scope="row">' . $row['cart_id'] . '</th>
                    <td>' . $row['email'] . '</td>
                    <td>' . $row['user_id'] .'</td>
                    <td>$' . $row['total_price'] . '</td>';                    

                if (isset($row['pending']) == $true){
                   echo '
                    <td>Pending</td>';                
                } else {
                    echo '<td>N/A</td>';
                }

                if (isset($row['approved']) == $true) {
                    echo '
                    <td>Approved</td>';
                } else {
                    echo '<td>N/A</td>';
                }
                echo'
                    <td>' . $row['modified_at'] .'</td>';


                if (isset($row['pending']) == $true) {
                    echo '<td>  
                            <a href="viewcartitems.php?id=' . $row['cart_id'] . '" class="text-decoration-none">
                                <button class="btn btn-view-items btn-m">View Items</button>
                            </a>    
                            <a href="declineorder.php?id=' . $row['cart_id'] . '" class="text-decoration-none">
                                <button class="btn btn-decline">Decline</button>
                            </a>                    
                            <a href="approveorder.php?id=' . $row['cart_id'] . '" class="text-decoration-none">
                                <button class="btn btn-approve btn-m">Approve</button>
                            </a>                                                                          
                    </td>
                </tr>   ';
                } else {
                    echo '<td>  
                            <a href="viewcartitems.php?id=' . $row['cart_id'] . '" class="text-decoration-none">
                                <button class="btn btn-view-items btn-m">View Items</button>
                            </a>    
                            <a href="declineorder.php?id=' . $row['cart_id'] . '" class="text-decoration-none">
                                <button class="btn btn-decline">Decline</button>
                            </a>                                                    
                    </td>
                </tr>   ';
                }                                                          
            }

            ?>
        </tbody>
    </table>    
</body>

<?php
include'footer.php';