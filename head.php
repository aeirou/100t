<body>

    <?php
    require_once'includes/connect.inc';

    session_start();

    ?>

    <nav class="navbar-expand-lg bg-body-secondary p-3 sticky-top">
        <div class="container-fluid">

            <a class="navbar-brand-two me-auto d-sm-flex" href="index.php">                
                <img src="static/navbar/100logogold-nav.svg" alt="">
                <div class="vr mb-1 bg-dark"></div>
                <img src="static/navbar/motto-nav.svg" alt="">
            </a>

            <button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="nav_button">
                <span class="navbar-toggler-icon text-dark">
                </span>
			</button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar navbar-nav bg-text-shadow ms-auto mb-lg-0 pe-3">

                    <li class="nav-item bg-text-shadow p-3">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>

                    <li class="nav-item px-3">
                        <a class="nav-link" href="#">RSVP Now!</a>
                    </li>

                    <li class="nav-item px-3">
                        <a class="nav-link" href="#">Store</a>
                    </li>

                    <li class="nav-item px-3">
                        <a class="nav-link" href="#">About Us</a>
                    </li>

                    <li class="nav-item px-3">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>

                    <li class="nav-item px-3">
                        <a class="nav-link" href="login.php">Sign In</a>
                    </li>

                    <li class="nav-item px-3">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</body>