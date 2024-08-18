<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>

<body class="reg_bg">

    <div class="col-xl py-2 pt-3 text-center">                            
        <img src="static/backgroundlogo.svg" class="img-fluid"
            style="width:100px;"/>
    </div>

    <form  action="login.php" method="POST" class="form" id="form">
        <div class="container h-60">
                <div class="card card-registration my-4">          
                    <div class="card-body p-md-5 text-black">
                        <h3 class="mb-5 text-uppercase">Add stocks</h3>     
                        
                        <div class="row">

                            <div class="col-6 mb-4">

                                <div data-mdb-input-init class="form-outline">
                                    <label class="required-field form-label" class="form-label" for="stock_name">Name of item </label>
                                    <input type="text" name="stock_name" class="form-control form-control-md" placeholder="CAS Mug"/>                                                
                                </div>

                            </div>                        

                        </div>

                        <div class="row">

                            <div class="col-6 mb-4">
                                <div data-mdb-input-init class="form-outline">
                                    <label class="form-label" for="stock_desc">Description of the item </label>
                                    <input type="desc"  style="height:100px" name="stock_desc" class="form-control form-control-md" placeholder="CAS Mug"/>                                                
                                </div>
                            </div>

                        </div>
                        
                        <div class="row">

                            <div class="col-4 mb-4">

                                <div data-mdb-input-init class="form-outline">
                                    <label class="required-field form-label" for="stock_amount">Stocks available </label>
                                    <input name="stock_amount" type="number" class="form-control form-control-md" value="1" max="500" min="1" step="1">
                                </div>                                        

                            </div>

                            <div class="col-4 mb-4">

                                <div data-mdb-input-init class="form-outline">
                                    <label class="required-field form-label" class="form-label" for="stock_price">Stock price </label>
                                    <input type="number" name="stock_price" class="form-control form-control-md" value="1" max="100" min="0" step="1"/>                                                
                                </div>

                            </div>   

                            <div class="col-4 mb-4">

                                <div data-mdb-input-init class="form-outline">
                                    <label class="required-field form-label" class="form-label" for="stock_category">Stock category </label>
                                    <input type="text" name="stock_category" class="form-control form-control-md" placeholder="T-Shirt"/>                                                
                                </div>

                            </div>   

                        </div>

                        <div class="d-flex justify-content-end pt-3">
                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="login" type="login" value="login">Add Item</button>
                        </div>
                        
                    </div>  
                    <div class="d-flex justify-content-center">
                        <p class="text-muted fs-10">© Copyright 2024 - Christchurch Adventist School</p>
                    </div>   
                </div>
        </div>
    </form>
</body>


<?php
include'footer.php';