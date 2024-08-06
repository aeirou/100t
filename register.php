<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// assumes that default values are invalid
$u = $fn = $ln = $e = $p = FALSE;

if (isset($_POST['register'])) {
    // trims whitespace of all incoming data
    $trimmed = array_map('trim',$_POST);
    
    // checks for username
    if (preg_match('/^\w{2,}$/', $trimmed['username'])) {
        if (preg_match('/^\w{2,16}$/', $trimmed['username'])) {
            $u = mysqli_real_escape_string($conn, $trimmed['username']);
        } else {
            echo '<p class="error">Your username has exceeded the 16 character limit or a special character has been added!</p>';
        }
    } else {
        echo '<p class="error">Your username is less than 2 characters long or a special character has been added!</p>';
    }

    $re = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžæÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u";

    // checks for first name
    if (preg_match($re, $trimmed['first_name'])) {
        $fn = mysqli_real_escape_string($conn, $trimmed['first_name']);
    } else {
        echo '<p class="error">Please enter your first name!</p>';
    }

    // checks for last name
    if (preg_match($re, $trimmed['last_name'])) {
        $ln = mysqli_real_escape_string($conn, $trimmed['last_name']);
    } else {
        echo '<p class="error">Please enter your last name!</p>';
    }
    
    // checks for valid email address
    if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
        $e = mysqli_real_escape_string($conn, $trimmed['email']);
    } else {
        echo '<p class="error">Please enter a valid email address!</p>';
    }

    $re_pass = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/';

    // checks for password match with confirmed password - min 8 char & max 20 char; 1 letter
    if (preg_match($re_pass, $trimmed['password1'])) {
        if ($trimmed['password1'] == $trimmed['password2']) {
            $p = mysqli_real_escape_string($conn, $trimmed['password1']);
        } else {
            echo '<p class="error">Your passwords does not match!</p>';
        }
    } else {
        echo '<p class="error">Please enter a valid password!</p>';
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
                    echo '<p class="success">You have successfully registered!</p>';
                } else {
                    echo '<p class="error">There was an error registering your account. Please try again later.</p>';
                }

                var_dump($q);

            } else {
                echo '<p class="error">This email has already been taken!</p>';
            }
        } else {
            echo '<p class="error">This username has already been taken!</p>';
        }
    }
}    
?>

<head>
   <title>Register - 100thCAS</title>
</head>
<body class="reg_bg">
    <form action="register.php" method="post">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
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
                                                <label class="form-label" for="first_name">First name</label>
                                                <input type="text" id="first_name" name="first_name" class="form-control form-control-md" placeholder="First Name"
                                                value="<?php if (isset($trimmed['first_name'])) echo $trimmed['first_name']; ?>" />
                                            </div>

                                        </div>

                                        <div class="col-md-6 mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="last_name">Last name</label>
                                                <input type="text" id="last_name" name="last_name" class="form-control form-control-md" placeholder="Last Name"
                                                value="<?php if (isset($trimmed['last_name'])) echo $trimmed['last_name']; ?>" />
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="year_graduated">Year Graduated</label>
                                                <input name="year_graduated" type="number" class="form-control form-control-md" value="2024" max="2024" min="1925" step="1">
                                            </div>
                                        
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class=" mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="email" id="email" name="email" class="form-control form-control-md" placeholder="Email"
                                                value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>" />
                                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="username">Username</label>
                                                <input type="text" id="username" name="username" class="form-control form-control-md" placeholder="Username"
                                                value="<?php if (isset($trimmed['username'])) echo $trimmed['username']; ?>" />
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="password1">Password</label>
                                                <input type="password" id="password" name="password1" class="form-control form-control-md" placeholder="Password"
                                                value="<?php if (isset($trimmed['password1'])) echo $trimmed['password1']; ?>" />
                                            </div>

                                        </div>                                    

                                    </div>

                                    <div class="row">

                                        <div class="col mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="password2">Confirm password</label>
                                                <input type="password" name="password2" class="form-control form-control-md" placeholder="Password"
                                                value="<?php if (isset($trimmed['password2'])) echo $trimmed['password2']; ?>"/>
                                                <br>
                                                <small class="form-text text-muted"><p class="text-dark">Already have an account? <a href="login.php" class="text-primary text-decoration-none"> Sign In</a></p></small>
                                            </div>

                                        </div>
                                    
                                    </div>

                                    <div class="d-flex justify-content-end pt-3">
                                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="register" type="register" value="register">Register</button>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
