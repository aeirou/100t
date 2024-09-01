<?php
include'includes/basehead.html';
session_start();

?>

<head>
    <title>Home - 100thCAS</title>
</head>

</body>

    <?php
    require_once'header.php';

    // message after the user has logged in
    if (isset($_SESSION['login']) && isset($_SESSION['message'])) {
        echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert' px-3>";

        echo 'Welcome ' . $_SESSION['fname'] . '! ' . $_SESSION['message'] ;
    
        echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
        </div>";
        
        // make sure the alert only shows once - unsets the session
        unset($_SESSION['message']);

    } elseif (isset($_SESSION['danger'])) { // for any message that requires a danger notification (except when user logged out)
        echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";

        echo $_SESSION['danger'] ;

        echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
            </div>";

         // unsets the session 
        unset($_SESSION['danger']);

    } elseif (isset($_GET['l'])) {
        echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";

        echo 'You have been logged out!' ;

        echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
            </div>";
    }
    ?>

    <div class="welcome_banner">
                
        <div class="container-fluid">
  
            <div class="row">    
                <div class="welcome_text col-6 text-start px-5 pt-5">     

                    <?php
                    if (isset($_SESSION['login'])) {                        
                        echo '<p><small>Hey there, ' .$_SESSION['fname'] . '!</small></p>';
                    } else {
                        echo '<p>Log in or Sign up to start!</p>';
                    }                        
                    ?>

                    <p class="text-start text-uppercase">
                        <strong>                                                      
                            100th CAS ANNIVERSARY
                        </strong>
                    </p>

                    <?php
                    if (isset($_SESSION['login'])) {
                        // if admin
                        if ($_SESSION['admin'] == 1) {
                            echo '
                            <a href="dashboard.php" class="text-decoration-none">                                                    
                                <button type="button" class="btn btn-m text-start" id="btn">Dashboard</button>
                            </a>
                            <a href="attendees.php" class="text-decoration-none">                                                    
                                <button type="button" class="btn btn-m text-start" id="btn">RSVP List</button>
                            </a>
                            ';
                        } else { // if not admin
                            echo '
                            <a href="store.php" class="text-decoration-none">                                                    
                                <button type="button" class="btn btn-m text-start" id="btn">View Store</button>
                            </a>
                            <a href="rsvp.php" class="text-decoration-none">                                                    
                                <button type="button" class="btn btn-m text-start" id="btn">RSVP</button>
                            </a>
                            ';
                        }

                    } else {
                        echo '
                            <a href="store.php" class="text-decoration-none">                                                    
                                <button type="button" class="btn btn-m text-start" id="btn">View Store</button>
                            </a>
                            <a href="login.php" class="text-decoration-none">                                                    
                                <button type="button" class="btn btn-m text-start" id="btn">Log in to RSVP</button>
                            </a>
                            ';
                    }                  
                    ?>                    

                </div>            

            </div>
        </div>

    </div>
    
    <footer class="text-white">
        <div class="row">
            <div class="col-md-6">
                <img src="static/schoool.jpg" alt="">
            </div>
            <div class="col-md-6">
                <p class="welcome fw-bold">Welcome to CAS! </p>
                <p class="para">
                Reaching the 100th year of Christchurch Adventist School is a remarkable milestone that celebrates a century of faith,
                learning, and community. For a hundred years, the school has nurtured young minds, fostering academic excellence while 
                instilling values of Respect, Integrity, Excellence and Responsibility. This centennial anniversary is not just a 
                celebration of the past but a tribute to the dedication of teachers, students, families, and supporters who have been 
                part of this journey. As we honor this legacy, we look forward to a future filled with continued growth, achievement, 
                and the enduring mission of shaping lives for Christ.
                </p>
            </div>
        </div>
    </footer>

</body>

<?php
require_once('footer.php');