<?php
include'includes/basehead.html';
session_start();

?>

<head>
    <title>Home - 100thCAS</title>
</head>

</body>

    <?php
    require_once'head.php';

    // message after the user has logged in
    if (isset($_SESSION['login']) && isset($_SESSION['message'])) {
        echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert' px-3>";
        echo "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='check-circle-fill me-2' fill='currentColor' viewBox='0 0 16 16' flex-shrink-0>
        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
        </svg>";

        echo 'Welcome ' . $_SESSION['fname'] . '! ' . $_SESSION['message'] ;
    
        echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
        </div>";
        
        // make sure the alert only shows once - unsets the session
        unset($_SESSION['message']);

    } elseif (isset($_SESSION['danger'])) { // for any message that requires a danger notification (except when user logged out)
        echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
        echo "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
        <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
        </svg>";

        echo $_SESSION['danger'] ;

        echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
            </div>";

         // unsets the session 
        unset($_SESSION['danger']);
    } elseif (isset($_GET['l'])) {
        echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
        echo "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
        <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
        </svg>";

        echo 'You have been logged out!' ;

        echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
            </div>";
    }
    ?>

    <div class="welcome_banner">
                
        <div class="container-fluid">
  
            <div class="row mask h-100">    
                <div class="welcome_text col-6 text-start px-5 pt-5 text-light">                                                        
                    <?php
                    if (isset($_SESSION['login'])) {
                        echo '<small>Hey there, ' .$_SESSION['fname'] . '!</small>';
                    } else {
                        echo '<small>Log in or Sign up to start</small>!';
                    }                        
                    ?>
                    <p class="text-light text-start text-uppercase">
                        <strong>                                                      
                            100th CAS ANNIVERSARY
                        </strong>
                    </p>

                    <button type="button" class="btn btn-outline-light btn-sm text-start" id="btn">View Store</button>
                    <button type="button" class="btn btn-outline-light btn-sm text-start" id="btn">View Store</button>

                </div>
                
                <!-- <figure class="quote col-6 text-starttext-dark">
                    <blockquote class="blockquote">
                        <p>Educating For Eternity.</p>
                    </blockquote>
                    <figcaption class="blockquote-footer text-dark">
                        <cite title="Source Title">Christchurch Adventist School</cite>
                    </figcaption>
                </figure> -->

            </div>
        </div>

    </div>

</body>

<?php
require_once('footer.php');