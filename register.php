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

    if (empty($_POST['first_name'] || $_POST['last_name'] || $_POST['year_graduated'] || $_POST['email'] || $_POST['username'] || $_POST['password1'])) {
		array_push($errors, "Fields empty!");
	} else {

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

                // year grad input
                $year_graduated = $_POST['year_graduated'];

                // adds user to the db
                $q = "INSERT INTO user (username, fname, lname, email, password, year_graduated ,created_at)
                VALUES ('$u', '$fn', '$ln', '$e', SHA1('$p'), $year_graduated, NOW())";

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

    <form action="register.php" method="POST" class="form" id="form">
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

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="required-field form-label" for="first_name">First name (11 characters max) </label>
                                        <input type="text" name="first_name" class="form-control form-control-md" placeholder="First Name"
                                        value="<?php if (isset($trimmed['first_name'])) echo $trimmed['first_name']; ?>" />                                                
                                        <small class="form-text text-muted">We'll never share your name with anyone else.</small>
                                    </div>

                                </div>

                                <div class="col-md-6 mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="required-field form-label" for="last_name">Last name </label>
                                        <input type="text" name="last_name" class="form-control form-control-md" placeholder="Last Name"
                                        value="<?php if (isset($trimmed['last_name'])) echo $trimmed['last_name']; ?>" />
                                    </div>                                            

                                </div>                                    

                            </div>

                            <div class="row">

                                <div class="col mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="required-field form-label" for="year_graduated">Year Graduated </label>
                                        <input name="year_graduated" type="number" class="form-control form-control-md" value="2024" max="2024" min="1925" step="1">
                                    </div>
                                
                                </div>

                            </div>

                            <div class="row">

                                <div class=" mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="required-field form-label" for="email">Email </label>
                                        <input type="text" name="email" class="form-control form-control-md" placeholder="example@gmail.com"
                                        value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>" />                                                
                                        <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="required-field form-label" for="username">Username </label>
                                        <input type="text" name="username" class="form-control form-control-md" placeholder="johndoe"
                                        value="<?php if (isset($trimmed['username'])) echo $trimmed['username']; ?>" />
                                        <small class="form-text text-muted">Username must be greater than 2 and less than 16 characters and without special characters.</small>
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="required-field form-label" for="password1">Password </label>
                                        <input type="password" name="password1" class="form-control form-control-md" placeholder="12345678m"
                                        value="<?php if (isset($trimmed['password1'])) echo $trimmed['password1']; ?>" />
                                        <small class="form-text text-muted">Password must have a minimum of 8 and maximum of 20 characters and must contain a letter. </small>
                                    </div>

                                </div>                                    

                            </div>

                            <div class="row">

                                <div class="col mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="required-field form-label" for="password2">Confirm password </label>
                                        <input type="password" name="password2" class="form-control form-control-md" placeholder="Confirm password"
                                        value="<?php if (isset($trimmed['password2'])) echo $trimmed['password2']; ?>"/>
                                        <br>
                                        <small class="form-text text-muted"><p class="text-dark">Already have an account? <a href="login.php" class="text-primary text-decoration-none"> Sign In</a></p></small>
                                    </div>

                                </div>
                            
                            </div>

                            <div class="d-flex justify-content-end pt-3">
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="register" type="submit">Register</button>
                            </div>
                            
                        </div>
                    </div>     

                    <div class="d-flex justify-content-center">
                        <p class="text-muted fs-10">© Copyright 2024 - Christchurch Adventist School</p>
                    </div>   

                </div>
            </div>
        </div>
    </form>
</body>

<?php
include'footer.php';