<!DOCTYPE html>
<?php
include'includes/basehead.html';
session_start();

?>

<head>
    <title>CAS - Home</title>
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

    <div class="welcome-banner"
        style="background-image: url('static/schoool.jpg');
               background-color: rgba(0, 0, 0, 0.6);
                background-size: cover;
                background-position:center;">
        <div class="container-fluid">
  
            <div class="row mask h-100" style="background-color: rgba(0, 0, 0, 0.6);">    
                <div class="col-6 px-5 pt-5">
                    <?php
                    if (isset($_SESSION['login'])) {
                        if (isset($_SESSION['admin']) == 1 ){
                            echo '<h1 class="text-1 text-fluid"> Welcome back, Master <br>' . $_SESSION['fname'] . ',</h1>';            
                            
                            } else {
                                echo '<h1 class="text-1 text-fluid">Welcome <br>' . $_SESSION['fname'] . ',</h1>';                            
                            }   
                    } else {
                        echo '<h1 class="text-1 text-fluid"> Welcome <br> Guest,</h1>';            
                    }
                    ?>
                    <h1 class="text-2 font-weight-bold text-fluid">to the CAS Centenary.</h1>
                </div>
                
                <figure class="quote col-6 text-end text-light">
                    <blockquote class="blockquote">
                        <p>Educating For Eternity.</p>
                    </blockquote>
                    <figcaption class="blockquote-footer text-light">
                        <cite title="Source Title">Christchurch Adventist School</cite>
                    </figcaption>
                </figure>

            </div>
        </div>

    </div>

    <div class="col-xl py-2 pt-3 text-center">                            
        <img src="static/backgroundlogo.svg" class="img-fluid"
            style="width:100px;"/>
    </div>

    <form  action="login.php" method="POST" class="form" id="form">
        <div class="container h-50">           
            <div class="card my-4">
                <div class="row g-0">

                    <div class="col-xl-6">
                        <a href="index.php">
                            <img src="static/100logomottogold.svg" class="img-fluid"
                                style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;"/>
                        </a>
                    </div>
                    
                    <div class="col-xl-6">
                        <div class="p-md-5 text-black">
                            <h3 class="mb-5 text-uppercase">Log In</h3>                        

                            <div class="row">

                                <div class="col mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="usern_email">Username or Email</label>
                                        <input type="text" name="usern_email" class="form-control" placeholder="Username or Email"/>                                                
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col mb-4">

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="password1">Password</label>
                                        <input type="password" name="pass" class="form-control" placeholder="Password"/>      
                                        <br>
                                        <small class="text-muted"><p class="text-dark">Don't have an account? <a href="register.php" class="text-primary text-decoration-none"> Sign Up</a></p></small>                                          
                                    </div>

                                </div>                                    

                            </div>                                   

                            <div class="d-flex justify-content-end pt-3">
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="login" type="submit" value="login">Log In</button>
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
require_once('footer.php');