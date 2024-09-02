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

// variable that holds a list - list of errors/success messages
$errors = [];
$success = [];

// if the id is set
if (isset($_GET['id'])) {

    // gets the id through GET method
    $id = $_GET['id']; 
    // query action
    $q = "SELECT * FROM `product` WHERE `id` = $id";
    // using the query variable to actually query
    $r = mysqli_query($conn, $q);
    // fetches all the rows the matches the query
    $row = mysqli_fetch_assoc($r);

    $product_name = $row['name'];
    
    $n = FALSE;

    if (isset($_POST["remove"])) {    

        // trim of all white space 
        $trimmed = array_map('trim',$_POST);        

        // if fields are empty
        if (empty($_POST['stock_name'])) {            
            array_push($errors, "Please enter an item name!");

        } else {

            if ($_POST['stock_name'] !== $product_name) {
                array_push($errors, "The your name input does not match the item name. Please try again.");
            } else {
                $n = mysqli_real_escape_string($conn, $trimmed['stock_name']);
            }
        }
        
        if ($n) {
            // First, delete any rows in `cart_item` that reference the product
            $q = "DELETE FROM cart_item WHERE `product_id` = $id;";
            $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));    

            // Then, delete the product itself
            $q = "DELETE FROM product WHERE `id` = $id;";
            $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));          
            
            if ($r) {
                array_push($success, "Item has been removed!");
            } else {
                array_push($errors, "There was an error. Please try again later.");
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

    <div class="col-xl py-2 pt-3 text-center">                            
        <img src="static/backgroundlogo.svg" class="img-fluid"
            style="width:100px;"/>
    </div>

    <form action="removestock.php?id=<?php echo $row['id']; ?>" method="POST" class="form">
        <div class="container h-60">
            <div class="card card-registration my-4">          
                <div class="card-body p-md-5 text-black">
                    <h3 class="mb-5 text-uppercase text-danger"><strong>Remove Stocks</strong></h3>   
                    
                    <strong class="text-danger pb-3"><mark class="text-danger"><em>THIS ACTION CANNOT BE UNDONE,</em></mark> THEREFORE, MAY RESULT IN THE LOSS OF DATA. PROCEED WITH CAUTION.</strong>
                    <br>                    
                    <h6 class="py-3"><strong>ITEM NAME: <em class="text-info"><?php echo $row['name'] ?></em></strong></h6>

                    <div class="row">                    

                        <div class="col-6 mb-4">

                            <div data-mdb-input-init class="form-outline">
                                <label class="required-field form-label" class="form-label" for="stock_name">Name of item </label>
                                <input type="text" name="stock_name" id="stock_name" class="form-control form-control-md" placeholder="CAS Mug">
                                <small class="form-text text-muted">Please type the name of the item you want removed to confirm the removal of the item.</small>                                                
                            </div>

                        </div>                        

                    </div>

                    <div class="row">

                        <div class="col-sm-3">

                            <div class="d-flex justify-content-sm-start pt-3"> 
                                <a href="dashboard.php">
                                    <button class="btn btn-info btn-lg ms-2" type="button">View Stocks</button>
                                </a>                                                 
                            </div>

                        </div>

                        <div class="col-sm-9">

                            <div class="d-flex justify-content-sm-end pt-3">
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="remove" type="submit" value="remove">Remove Item</button>
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