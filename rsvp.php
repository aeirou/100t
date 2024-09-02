<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

// variable that holds a list - list of errors/success messages
$errors = [];
$success = [];

$user_id = $_SESSION['id'];
$user_fname = $_SESSION['fname'];
$user_lname = $_SESSION['lname'];
$user_email = $_SESSION['email'];

if (isset($_POST['reserve'])) {
    // trims whitespace of all incoming data
    $trimmed = array_map('trim',$_POST);

    if (empty($_POST['first_name'] || $_POST['last_name'] || $_POST['year_graduated'])) {
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
    }

    // if everthing is ok
    if ($fn&&$ln) {
        
        $pending = 1;

        // check for unqiue reservations
        $check_rsvp = "SELECT `pending` FROM `user` WHERE `pending` = $pending AND `id` = $user_id";        
        $check_result = mysqli_query($conn, $check_rsvp) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
        
        // if email is unique
        if (mysqli_num_rows($check_result) == 0) {

            // year grad input
            $year_graduated = $_POST['year_graduated'];

            // adds user to the db
            $q = "UPDATE `user` SET `pending`= $pending, `year_graduated` = $year_graduated, `modified_at` = NOW() WHERE `id` = $user_id ";
            $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
            
            if ($r) {
                array_push($success, "You have successfully reserved a spot, please wait for a confirmation.");
            } else {
                array_push($errors, "There has been an error to registering you in. Please try again later.");
            }

        } else {
            array_push($errors, "This email has already been used to the event!");
        }
    }
}    
?>

<head>
   <title>RSVP - 100thCAS</title>
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

    <form action="rsvp.php" method="POST" class="form">
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
                            <h3 class="mb-5 text-uppercase">Alumni Reservation</h3>

                            <div class="text my-5">
                                <small>The Reunion will have a <strong>mandatory $20</strong> fee which will be paid onsite.</small>
                                <br>
                                <small>On arrival, you will recieve the following: <br>
                                <strong>a tote bag, lanyard, and an electronic copy of the formal event photographs.</strong></small> 
                                <br>   
                                <small>Hope to see you there!</small>
                            </div>

                            <div class="row">

                                <div class="col-md-6 mb-4">

                                    <div data-mdb-input-init class="form-outline">  <!--for attribute is to link the label and input together.-->
                                        <label class="required-field form-label" for="first_name">First name (11 chars max) </label>
                                        <input type="text" id="first_name" name="first_name" class="form-control form-control-md" autocomplete="given-name" placeholder="First Name" value="<?php echo $user_fname; ?>">                                                                                        
                                    </div>

                                </div>

                                <div class="col-md-6 mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="required-field form-label" for="last_name">Last name </label>
                                        <input type="text" id="last_name" name="last_name" class="form-control form-control-md" autocomplete="family-name" placeholder="Last Name" value="<?php echo $user_lname; ?> ">
                                    </div>                                            

                                </div>                                    

                            </div>

                            <div class="row">

                                <div class="col mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label for="year_graduated">Year Graduated (If applicable) </label>
                                        <input name="year_graduated" id="year_graduated" type="number" class="form-control form-control-md" value="2024" max="2024" min="1925" step="1">
                                    </div>
                                
                                </div>

                            </div>

                            <div class="row">

                                <div class=" mb-4">                            
                                    <div data-mdb-input-init class="form-outline">
                                        <label  for="email">Email </label>
                                        <input type="text" name="email" id="email" class="form-control form-control-md" autocomplete="off" placeholder="example@gmail.com" value="<?php echo $user_email; ?>" disabled>                                                
                                        <small class="form-text text-muted">This cannot be changed at this time.</small>
                                    </div>

                                </div>

                            </div>                        

                            <div class="d-flex justify-content-end pt-3">
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="reserve" type="submit">Reserve</button>
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