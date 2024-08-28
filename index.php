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
                    if (isset($_SESSION['login']) || !isset($_SESSION['login'])) {
                        // if admin
                        if ($_SESSION['admin'] == 1) {
                            echo '
                            <a href="dashboard.php" class="text-decoration-none">                                                    
                                <button type="button" class="btn btn-m text-start" id="btn">Dashboard</button>
                            </a>
                            <a href="rsvplist.php" class="text-decoration-none">                                                    
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

                    }                    
                    ?>                    

                </div>            

            </div>
        </div>

    </div>

    <div class="col-xl py-2 pt-3 text-center">                            
        <img src="static/backgroundlogo.svg" class="img-fluid"
            style="width:100px;"/>
    </div>

    <form action="addstock.php" method="POST" class="form">
        <div class="container h-60">
            <div class="card card-registration my-4">          
                <div class="card-body p-md-5 text-black">
                    <h3 class="mb-5 text-uppercase text-info"><strong>Add stocks</strong></h3>     
                    
                    <div class="row">

                        <div class="col-6 mb-4">

                            <div data-mdb-input-init class="form-outline">
                                <label class="required-field form-label" class="form-label" for="stock_name">Name of item </label>
                                <input type="text" name="stock_name" id="stock_name" class="form-control form-control-md" placeholder="CAS Mug" value="<?php if (isset($_POST['stock_name'])) echo $_POST['stock_name'];?>">   
                                <small class="form-text text-muted">Name of item should be less than 225 and more than 5 characters.</small>                                                                                             
                            </div>

                        </div>
                        
                        <div class="col-6 mb-4">

                            <div data-mdb-input-init class="form-outline">
                                <label class="form-label" for="stock_img">Image of the item </label>
                                <input type="text" name="stock_img" id="stock_img" class="form-control form-control-md" placeholder="image.jpg">   
                            </div>

                        </div> 

                    </div>

                    <div class="row">

                        <div class="col mb-4">
                            <div data-mdb-input-init class="form-outline">
                                <label class="form-label" for="stock_desc">Description of the item </label>
                                <textarea type="desc" style="height:100px" name="stock_desc" id="stock_desc" class="form-control form-control-md" placeholder="This is a mug." value="<?php if (isset($_POST['stock_desc'])) echo $_POST['stock_desc'];?>"></textarea>                                                
                                <small class="form-text text-muted">Description can be up to 1000 characters.</small>                                                                                             
                            </div>
                        </div>

                    </div>
                    
                    <div class="row">

                        <div class="col-4 mb-4">

                            <div data-mdb-input-init class="form-outline">
                                <label class="required-field form-label" for="stock_quantity">Stocks available </label>
                                <input name="stock_quantity" id="stock_quantity" type="number" class="form-control form-control-md" value="1" step="1">
                            </div>                                        

                        </div>

                        <div class="col-4 mb-4">

                            <div data-mdb-input-init class="form-outline">
                                <label class="required-field form-label" class="form-label" for="stock_price">Stock price </label>
                                <input type="number" name="stock_price" id="stock_price" class="form-control form-control-md" value="1" step="1">                                                
                            </div>

                        </div>   

                        <div class="col-4 mb-4">
                            
                            <label class="required-field form-label" class="form-label" for="category">Stock Category </label>
                            <select class="form-select" aria-label="Default select example" name="category" id="category" placeholder="hello">
                                <option selected></option>
                                <option value="clothing">Clothing</option>
                                <option value="accessories">Accessories</option>
                                <option value="stationary">Stationary</option>
                                <option value="crockery">Crockery</option>                                
                            </select>                  

                        </div>   

                    </div>

                    <div class="row">

                        <div class="col-sm-3">

                            <div class="d-flex justify-content-sm-start pt-3"> 
                                <a href="dashboard.php">
                                    <button class="btn btn-info btn-lg ms-2" type="button">View Stocks</button>
                                </a>                                                 
                            </div>

                        </div>

                        <div class="col-sm-9">

                            <div class="d-flex justify-content-sm-end pt-3">
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="add" type="submit" value="add">Add Item</button>
                            </div>                            

                        </div>                    

                    </div>
                    
                </div>
            
            <div class="d-flex justify-content-center">
            <small class="text-muted fs-10 pb-3">© Copyright 2024 - Christchurch Adventist School</small>
        </div>   
    </form>


</body>

<?php
require_once('footer.php');