<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

// if user is not an admin, user is redirected to page invalid.
if (!isset($_SESSION['login'])) {    
    header("Location:errordocs/invalid.html");
    exit();
}

// variable that holds a list - list of errors/success messages
$errors = [];
$success = [];

// if the id is set
if (isset($_GET['id'])) {

    // user id
    $user_id = $_SESSION['id'];

    $cart_id = $_GET['id'];

    $q = "SELECT *  FROM `user`
    LEFT JOIN `cart` ON cart.user_id = user.id
    WHERE cart.user_id = $user_id";
    $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
    $row = mysqli_fetch_assoc($r);   
    
    $n = $row['fname'];
    $l = $row['lname'];
    $pending = $row['pending'];
    $approved = $row['approved'];

    if (isset($_POST["confirm"])) {    

        // trim of all white space 
        $trimmed = array_map('trim',$_POST);  

        // if fields are empty
        if (empty($_POST['first_name'] || $_POST['last_name'])) {            
            array_push($errors, "Please enter your full name!");

        } 

         // name validation
         $re = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžæÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{0,11}+$/u";

         // checks for first name
         if (preg_match($re, $trimmed['first_name'])) {
             $fn = mysqli_real_escape_string($conn, $trimmed['first_name']);
         } else {
             array_push($errors, "Please enter a valid name!");
         }
 
         // checks for last name
         if (preg_match($re, $trimmed['last_name'])) {
             $ln = mysqli_real_escape_string($conn, $trimmed['last_name']);
         } else {
             array_push($errors, "Please enter a valid name!");
         }
        
        if ($fn&&$ln) {
            
            $true = 1;            

            if ($pending == $true OR $approved == $true) {
                array_push($errors, "This cart is already pending or has been approved!");                    
            } else {
                
                if ($fn == $n AND $ln == $l) {            
                
                    $cart_q = "UPDATE `cart` SET `pending` = $true, `modified_at` = NOW() WHERE `user_id` = $user_id";
                    $cart_r = mysqli_query($conn, $cart_q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
                    if ($cart_r) {
                        array_push($success, "Your cart has been sent to us. Please wait for your confirmation");
                    } else {
                        array_push($errors, "There has been an error to your cart. Please try again later.");
                    }
    
                } else {
                    $q = "UPDATE `user` SET `fname` = '$fn', `lname` = '$ln', `modified_at` = NOW() WHERE `id` = $user_id";
                    $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
    
                    $cart_q = "UPDATE `cart` SET `pending` = $true, `modified_at` = NOW()";
                    $cart_r = mysqli_query($conn, $cart_q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
                    if ($cart_r) {
                        array_push($success, "Your cart has been sent to us. Please wait for your confirmation");
                    } else {
                        array_push($errors, "There has been an error to your cart. Please try again later.");
                    }
                }
            }             

        }

    }
}
?>

<head>
    <title>Remove - 100thCAS</title>
</head>

<?php
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


<body class="reg_bg">

    <?php
    // require_once'header.php';
    ?>

    <div class="col-xl py-2 pt-3 text-center">                            
        <img src="static/backgroundlogo.svg" class="img-fluid"
            style="width:100px;"/>
    </div>

    <form action="confirmorder.php?id=<?php echo $cart_id; ?>" method="POST" class="form">
        <div class="container h-60">
            <div class="card card-registration my-4">          
                <div class="card-body p-md-5 text-black">
                    <h3 class="mb-5 text-uppercase text-info"><strong>Confirm Order</strong></h3>   
                                                            
                    <p class="py-3">Please confirm your details below.</p>

                    <div class="row">

                        <div class="col-md-6 mb-4">

                            <div data-mdb-input-init class="form-outline">  <!--for attribute is to link the label and input together.-->
                                <label class="required-field form-label" for="first_name">First name (11 chars max) </label>
                                <input type="text" id="first_name" name="first_name" class="form-control form-control-md" autocomplete="given-name" placeholder="First Name" 
                                value="<?php echo $row['fname']; ?>">                                                                                        
                            </div>

                        </div>

                        <div class="col-md-6 mb-4">

                            <div data-mdb-input-init class="form-outline">
                                <label class="required-field form-label" for="last_name">Last name </label>
                                <input type="text" id="last_name" name="last_name" class="form-control form-control-md" autocomplete="family-name" placeholder="Last Name" 
                                value="<?php echo $row['lname']; ?>">
                            </div>                                            

                        </div>                                    

                    </div>    

                    <div class="row">

                        <div class=" mb-4">                            
                            <div data-mdb-input-init class="form-outline">
                                <label  for="email">Email </label>
                                <input type="text" name="email" id="email" class="form-control form-control-md" autocomplete="off" placeholder="example@gmail.com" 
                                value="<?php echo $row['email']; ?>" disabled>                                                
                                <small class="form-text text-muted">This cannot be changed at this time.</small>
                            </div>

                        </div>

                    </div>             

                    <div class="row">

                        <div class="col-sm-3">

                            <div class="d-flex justify-content-sm-start pt-3"> 
                                <a href="cart.php">
                                    <button class="btn btn-danger btn-lg ms-2" type="button">Back to Cart</button>
                                </a>                                                 
                            </div>

                        </div>

                        <div class="col-sm-9">

                            <div class="d-flex justify-content-sm-end pt-3">
                                <button class="btn btn-warning btn-lg ms-2" name="confirm" type="submit" value="confirm">Confirm Order</button>
                            </div>                            

                        </div>                    

                    </div>
                    
                </div>
                
                <div class="d-flex justify-content-center">
                    <small class="text-muted fs-10 pb-3">© Copyright 2024 - Christchurch Adventist School</small>
                </div>   

            </div>
        </div>
    </form>
</body>


<?php
include'footer.php';