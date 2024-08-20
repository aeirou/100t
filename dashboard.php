<?php
require_once'includes/connect.inc';
include'includes/basehead.html';
session_start();
?>

<body>

    <nav class="menu position" id="menu">
        <div class="actionbar">
            <button id="menuBtn">
                <i class="fas fa-bar"></i>
                Dashboard
            </button>            
        </div>
        <ul class="optionBar">
            <li class="menuItem">
                <a href="#" class="menuOption">
                    <i class="fas fa-home"></i>
                    <h5 class="menuText">Home</h5>
                </a>
            </li>
        </ul>
    </nav>

</body>

<?php
require_once('footer.php');

