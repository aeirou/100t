<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>

<body class="reg_bg">
    <form  action="login.php" method="POST" class="form" id="form">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card card-registration my-4">

                        <div class="row g-0">            
                            
                            <div class="col-xl-6">
                                <div class="card-body p-md-5 text-black">
                                    <h3 class="mb-5 text-uppercase">Add stocks</h3>                        

                                    <div class="row">

                                        <div class="col mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="stock_name">Name of item</label>
                                                <input type="text" name="usern_email" class="form-control form-control-md" placeholder="Username or Email"/>                                                
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="password1">Password</label>
                                                <input type="password" name="pass" class="form-control form-control-md" placeholder="Password"/>      
                                                <br>
                                                <small class="form-text text-muted"><p class="text-dark">Don't have an account? <a href="register.php" class="text-primary text-decoration-none"> Sign Up</a></p></small>                                          
                                            </div>

                                        </div>                                    

                                    </div>                                   

                                    <div class="d-flex justify-content-end pt-3">
                                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="login" type="login" value="login">Log In</button>
                                    </div>
                                    
                                </div>
                            </div>     

                            <div class="d-flex justify-content-center">
                                <p class="text-muted fs-10">© Copyright 2024 - Christchurch Adventist School</p>
                            </div>   

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</body>


<?php
include'footer.php';