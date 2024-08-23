<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

// if user is not an admin, user is redirected to page invalid.
if (isset($_SESSION['login']) || !isset($_SESSION['login'])) {
    if (isset($_SESSION['admin']) == 0) {
        header("Location:errordocs/invalid.php");
        exit();
    }
}

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// variable that holds a list - list of errors/success messages
$errors = [];
$success = [];

// gets the id of the product
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
            // updates item to the db
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
	echo "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
    <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
    </svg>";

	echo array_values($errors)[0];

	echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";
};

if ($success) {
    echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
    echo "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='check-circle-fill me-2' fill='currentColor' viewBox='0 0 16 16' flex-shrink-0>
    <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
    </svg>";

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
                                <a href="stocks.php">
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