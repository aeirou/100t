<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_SESSION['login'])) {
    $_SESSION['danger'] = 'You are already logged in!';
    header('Location: index.php');
    exit();
}

// assumes that default values are invalid
$u = $fn = $ln = $e = $p = FALSE;

// variable that holds a list - list of errors/success messages
$errors = [];
$success = [];

if (isset($_POST['register'])) {
    // trims whitespace of all incoming data
    $trimmed = array_map('trim',$_POST);

    if (empty($_POST['first_name'] || $_POST['last_name'] || $_POST['email'] || $_POST['username'] || $_POST['password1'])) {
		array_push($errors, "Please fill out required fields!");
	} else {
            
        // regex can be used to check specific patterns of all data for search queries as well as validating data,
        // checking if the input is in the correct format.

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
        
        // checks for valid email address
        if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
            $e = mysqli_real_escape_string($conn, $trimmed['email']);
        } else {
            array_push($errors, "Please enter a valid email address!");
        }

        // checks for username
        if (preg_match('/^\w{2,16}$/', $trimmed['username'])) {
            if (preg_match('/^\w{2,16}$/', $trimmed['username'])) {
                $u = mysqli_real_escape_string($conn, $trimmed['username']);
            } else {
                array_push($errors, "Please check your username.");
            }
        } else {
            array_push($errors, "Please check your username.");
        }

        # passworfd validation
        $re_pass = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/';

        // checks for password match with confirmed password - min 8 char & max 20 char; 1 letter
        if (preg_match($re_pass, $trimmed['password1'])) {
            if ($trimmed['password1'] == $trimmed['password2']) {
                $p = mysqli_real_escape_string($conn, $trimmed['password1']);
            } else {
                array_push($errors, "Your passwords do not match!");
            }
        } else {
            array_push($errors, "Please enter a valid password!");
        }
    }

    // if everthing is ok
    if ($u&&$fn&&$ln&&$e&&$p) {

        // check for unique email & username
        $check_email = "SELECT id FROM user WHERE email='$e'";
        $check_user = "SELECT id FROM user WHERE username='$u'";


        $r_e = mysqli_query($conn, $check_email) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
        $r_u = mysqli_query($conn, $check_user) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

        
        // if email is unique
        if (mysqli_num_rows($r_u) == 0) {
            if (mysqli_num_rows($r_e) == 0) {

                // adds user to the db
                $q = "INSERT INTO user (username, fname, lname, email, password ,created_at)
                VALUES ('$u', '$fn', '$ln', '$e', SHA1('$p'), NOW())";

                $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
                
                if ($r) {
                    array_push($success, "You have successfully registered. Please sign in to continue.");
                } else {
                    array_push($errors, "There has been an error to registering you in. Please try again later.");
                }

            } else {
                array_push($errors, "Email has already been taken!");
            }
        } else {
            array_push($errors, "Username has already been taken!");
        }
    }
}    
?>

<head>
   <title>Register - 100thCAS</title>
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

    <form action="register.php" method="POST" class="form">
        <div class="container h-40">
            <div class="card card-registration my-4">
                <div class="row g-0">

                    <div class="col-xl-6 d-none d-xl-block">
                        <a href="index.php">
                            <img src="static/100logomottogold.svg" class="img-fluid"
                                style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;"/>
                        </a>
                    </div>
                    
                    <div class="col-xl-6">
                        <div class="card-body p-md-5 text-black">
                            <h3 class="mb-5 text-uppercase">Attendee Registration Form</h3>

                            <div class="row">

                                <div class="col-md-6 mb-4">

                                    <div data-mdb-input-init class="form-outline">  <!--for attribute is to link the label and input together.-->
                                        <label class="required-field form-label" for="first_name">First name (11 characters max) </label>
                                        <input type="text" id="first_name" name="first_name" class="form-control form-control-md" autocomplete="given-name" placeholder="First Name" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>">                                                
                                        <small class="form-text text-muted">We'll never share your name with anyone else.</small>
                                    </div>

                                </div>

                                <div class="col-md-6 mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="required-field form-label" for="last_name">Last name </label>
                                        <input type="text" id="last_name" name="last_name" class="form-control form-control-md" autocomplete="family-name" placeholder="Last Name" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>">
                                    </div>                                            

                                </div>                                    

                            </div>

                            <div class="row">

                                <div class=" mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="required-field form-label" for="email">Email </label>
                                        <input type="text" name="email" id="email" class="form-control form-control-md" autocomplete="off" placeholder="example@gmail.com" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">                                                
                                        <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="required-field form-label" for="username">Username </label>
                                        <input type="text" name="username" id="username" class="form-control form-control-md" placeholder="johndoe" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">
                                        <small class="form-text text-muted">Username must be greater than 2 and less than 16 characters and without special characters.</small>
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="required-field form-label" for="password1">Password </label>
                                        <input type="password" name="password1" id="password1" class="form-control form-control-md" placeholder="12345678m">
                                        <small class="form-text text-muted">Password must have a minimum of 8 and maximum of 20 characters and must contain a letter.</small>
                                    </div>

                                </div>                                    

                            </div>

                            <div class="row">

                                <div class="col mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="required-field form-label" for="password2">Confirm password </label>
                                        <input type="password" name="password2" id="password2" class="form-control form-control-md" placeholder="Confirm password">
                                        <br>
                                        <small class="form-text text-dark">Already have an account? <a href="login.php" class="text-primary text-decoration-none"> Sign In</a></small>
                                    </div>

                                </div>
                            
                            </div>

                            <div class="d-flex justify-content-end pt-3">
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="register" type="submit">Register</button>
                            </div>
                            
                        </div>
                    </div>     

                    <div class="d-flex justify-content-center">
                        <small class="text-muted fs-10 pb-3">© Copyright 2024 - Christchurch Adventist School</small>
                    </div>   

                </div>
            </div>
        </div>
    </form>
</body>

<?php
include'footer.php';