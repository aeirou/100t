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
    

    $n = $d = FALSE;

    if (isset($_POST["edit"])) {

        // trim of all white space 
        $trimmed = array_map('trim',$_POST);

        // if fields are empty
        if (empty($_POST['stock_name'] || $_POST['stock_desc'] || $_POST['stock_quantity'] || $_POST['stock_price'] || $_POST['stock_category'])) {
            array_push($errors, "Fields empty!");
        } else {

            // name validation
            $re_n = "/^[a-zA-Z\s]{1,10}+$/u";

            // product name validation
            if (preg_match($re_n, $trimmed['stock_name'])) {
                $n = mysqli_real_escape_string($conn, $trimmed['stock_name']);
            } else {
                array_push($errors, "Please enter a valid name!");
            }

            $re_d = "/^[a-zA-Z0-9\s,.'-]{1,100}+$/u";

            // desc validation
            if (preg_match($re_d, $trimmed['stock_desc'])) {
                $d = mysqli_real_escape_string($conn, $trimmed['stock_desc']);
            } else {
                array_push($errors, "Please enter a valid description!");
                } 
            
        }

        // if everthing is ok
        if ($n&&$d) {

            $c = mysqli_real_escape_string($conn, $trimmed['category']);
            $qt = mysqli_real_escape_string($conn, $trimmed['stock_quantity']);
            $p = mysqli_real_escape_string($conn, $trimmed['stock_price']);
        
            // updates item to the db
            $q = "UPDATE `product` SET `name` = '$n', `desc` = '$d', `SKU` = '$qt', `category` = '$c', price = '$p', `modified_at` = NOW() WHERE `id` = $id";
            $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));         
            
            if ($r) {
                array_push($success, "Item has been updated!");
            } else {
                array_push($errors, "There was an error. Please try again later.");
            }
        }
    }
}
?>

<head>
    <title>Edit - 100thCAS</title>
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

    <form action="editstock.php?id=<?php echo $row['id']; ?>" method="POST" class="form">
        <div class="container h-60">
            <div class="card card-registration my-4">          
                <div class="card-body p-md-5 text-black">
                    <h3 class="mb-5 text-uppercase text-info"><strong>Edit stocks</strong></h3>     
                    
                    <div class="row">

                        <div class="col-6 mb-4">

                            <div data-mdb-input-init class="form-outline">
                                <label class="required-field form-label" class="form-label" for="stock_name">Name of item </label>
                                <input type="text" name="stock_name" id="stock_name" class="form-control form-control-md" placeholder="CAS Mug">
                                <small class="form-text text-muted">Name of item should be less than 10 characters and without a special characters.</small>                                                
                            </div>

                        </div>                        

                    </div>

                    <div class="row">

                        <div class="col-6 mb-4">
                            <div data-mdb-input-init class="form-outline">
                                <label class="form-label" for="stock_desc">Description of the item </label>
                                <input type="desc" style="height:100px" name="stock_desc" id="stock_desc" class="form-control form-control-md" placeholder="CAS Mug">
                                <small class="form-text text-muted">Can be left NULL. Must be less than 100 characters.</small>                                                 
                            </div>
                        </div>

                    </div>
                    
                    <div class="row">

                        <div class="col-4 mb-4">

                            <div data-mdb-input-init class="form-outline">
                                <label class="required-field form-label" for="stock_quantity">Stocks available </label>
                                <input name="stock_quantity" id="stock_quantity" type="number" class="form-control form-control-md" value="1" max="500" min="1" step="1">
                                <small class="form-text text-muted">Maximum stocks is 500.</small>
                            </div>                                        

                        </div>

                        <div class="col-4 mb-4">

                            <div data-mdb-input-init class="form-outline">
                                <label class="required-field form-label" class="form-label" for="stock_price">Stock price </label>
                                <input type="number" name="stock_price" id="stock_price" class="form-control form-control-md" value="1" max="100" min="0" step="1">
                                <small class="form-text text-muted">Maximum price is $100.</small>
                            </div>

                        </div>   

                        <div class="col-4 mb-4">
                            
                            <label class="required-field form-label" class="form-label" for="category">Stock Category </label>
                            <select class="form-select" aria-label="Default select example" name="category" id="category">
                                <option selected>Select a Category</option>
                                <option value="clothing">Clothing</option>
                                <option value="accessories">Accessories</option>
                                <option value="stationary">Stationary</option>
                                <option value="crockery">Crockery</option>                                
                            </select>                  

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
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="edit" type="submit" value="edit">Update Item</button>
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