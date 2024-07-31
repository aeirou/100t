<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';

if (isset($_POST['submit']))

    // trims whitespace of all incoming data
    $trimmed = array_map('trim',$_POST);

    // assumes that default values are invalid
    $u = $fn = $ln = $e = $p = FALSE;
    
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

    // checks for first name
    if (preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžæÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u",
    $trimmed['first_name'])) {
        $fn = mysqli_real_escape_string($conn, $trimmed['first_name']);
    } else {
        echo '<p class="error">Please enter your first name!</p>';
    }

    // checks for last name
    if (preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžæÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u",
    $trimmed['last_name'])) {
        $ln = mysqli_real_escape_string($conn, $trimmed['last_name']);
    } else {
        echo '<p class="error">Please enter your last name!</p>';
    }
    
    // checks for valid email address
    if (filter_var($trimmed['email'],
    FILTER_VALIDATE_EMAIL)) {
        $e - mysqli_real_escape_string($conn, $trimmed['email']);
    } else {
        echo '<p class="error">Please enter a valid email address!</p>';
    }

    // checks for password match with confirmed password - min 8 char & max 20 char; 1 letter
    if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/', 
    $trimmed['password1'])) {
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

        // check for unique email

        $q = "SELECT user_id FROM user WHERE email='$e'";
        $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
        
        // if email is unique
        if (mysqli_num_rows($r) == 0) {

            // adds user to the db
            $grad_year = $_POST['grad_year'];

            $q = "INSERT INTO user (username, fname, lname, email, password, created_at)
            VALUES ('$u', '$fn', '$ln', '$e', SHA1('$p'), NOW())";


        } else {
            echo '<p class="error">This email has already been taken!</p>';
        }
    }
?>

<head>
   <title>Register - 100thCAS</title>
</head>

<form action="action_page.php" method="post">
    <fieldset>
    
        <section class="h-100 bg-dark">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col">
                        <div class="card card-registration my-4">

                            <div class="row g-0">

                                <div class="col-xl-6 d-none d-xl-block">
                                    <img src="static/100logomottogold.svg"
                                        alt="Sample photo" class="img-fluid"
                                        style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;"
                                    />
                                </div>
                                
                                <div class="col-xl-6">
                                    <div class="card-body p-md-5 text-black">
                                        <h3 class="mb-5 text-uppercase">Attendee Registration Form</h3>

                                        <div class="row">

                                            <div class="col-md-6 mb-4">

                                                <div data-mdb-input-init class="form-outline">
                                                    <label class="form-label" for="fname">First name</label>
                                                    <input type="text" id="fname" name="fname" class="form-control form-control-lg" placeholder="First Name"
                                                    value="<?php if (isset($trimmed['first_name'])) echo $trimmed['first_name']; ?>" />
                                                </div>

                                            </div>

                                            <div class="col-md-6 mb-4">

                                                <div data-mdb-input-init class="form-outline">
                                                    <label class="form-label" for="lname">Last name</label>
                                                    <input type="text" id="lname" name="lname" class="form-control form-control-lg" placeholder="Last Name"
                                                    value="<?php if (isset($trimmed['last_name'])) echo $trimmed['last_name']; ?>" />
                                                </div>

                                            </div>


                                            <div class="col-md mb-4">

                                                <div data-mdb-input-init class="form-outline">
                                                    <label class="form-label" for="email">Email</label>
                                                    <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Email"
                                                    value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>" />
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md mb-4">

                                                    <div data-mdb-input-init class="form-outline">
                                                        <label class="form-label" for="username">Username</label>
                                                        <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Username"
                                                        value="<?php if (isset($trimmed['username'])) echo $trimmed['username']; ?>" />
                                                    </div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md mb-4">

                                                <div data-mdb-input-init class="form-outline">
                                                    <label class="form-label" for="password1">Password</label>
                                                    <input type="password" id="password" name="password1" class="form-control form-control-lg" placeholder="Password"
                                                    value="<?php if (isset($trimmed['password1'])) echo $trimmed['password1']; ?>" />
                                                </div>

                                            </div>                                    

                                        </div>

                                        <div class="row">

                                            <div class="col-md mb-4">

                                                <div data-mdb-input-init class="form-outline">
                                                    <label class="form-label" for="password2">Confirm password</label>
                                                    <input type="password" id="password" name="password2" class="form-control form-control-lg" placeholder="Password"
                                                    value="<?php if (isset($trimmed['password2'])) echo $trimmed['password2']; ?>" />
                                                </div>

                                            </div>
                                        
                                        </div>

                                        <div class="d-flex justify-content-end pt-3">
                                            <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="submit" type="submit" value="register">Register</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </fieldset>


</div>
</form>
