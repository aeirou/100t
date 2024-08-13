<!DOCTYPE html>
<html lang="en">

<?php
include'includes/basehead.html';
session_start();

?>

<head>
    <title>Christchurch Adventist School</title>
</head>

<body>

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
    }

    if (isset($_GET['l'])) {
        echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
        echo "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
        <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
        </svg>";

        echo 'You have been logged out!' ;

        echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
            </div>";
    }
    ?>
    <div class="welcome-banner">
        <div class="align-item-start">
                <div class="hstack gap-3">
                    <p class="lead text-light mb-4 text-shadow-1">Christchurch Adventist School</p>
                    <div class="text-light vr mb-4"></div>
                    <p class="lead mb-4 text-light text-shadow-1 fw-bold">Since 1925</p>
                </div>
        </div>

        <div class="row">    
            <div class="col-6 d-flex justify-content-center">
                <?php
                if (isset($_SESSION['login'])) {
                    echo '<h1 class="welcome-text"> Welcome <br>' . $_SESSION['fname'] . '</h1>';
                } else {
                    echo '<h1 class="welcome-text"> Welcome <br> Guest</h1>';
                }                
                ?>
                <h1 class="welcome-text2"><strong>to the CAS Centenary!</strong></h1>
            </div>
        </div>
    </div>


</body>

</html>

<?php
include'footer.php';
