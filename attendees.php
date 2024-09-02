<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

// if user is not an admin, user is redirected to page invalid.
if (isset($_SESSION['login']) || !isset($_SESSION['login'])) {
    if ($_SESSION['admin'] == 0) {
        header("Location:errordocs/invalid.html");
        exit();
    }
}

$true = 1;

// query all the item in the database
$q = "SELECT `id`, `fname`, `lname`, `email`, `year_graduated`, `pending`, `rsvp`, `modified_at` FROM `user` WHERE `pending` =  $true OR `rsvp` =  $true "; 

$result =  mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

// for error
if (!$result) {
    echo "Error fetching users: " . mysqli_error($conn);
    exit();
}
?>

<head>
    <title>Dashboard - 100thCAS</title>
</head>

<body class="dash">

    <?php
    require_once'header.php';
    ?>

<p class="h1 fw-bold px-5 pb-4">Attendees List</p>

    <div class="dash_btn">
        <a href="dashboard.php" class="text-decoration-none">
            <button class="btn btn-add">Go Back</button>
        </a>        
    </div>  

    <table class="table table-striped table-bordered table-hover border-info">
        <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>                
                <th scope="col">Year Grad.</th>
                <th scope="col">Pending</th>
                <th scope="col">RSVP</th>
                <th scope="col">Last modified at</th>
                <th scope="col">Action Buttons</th>                
            </tr>
        </thead>
        <tbody>
            <?php            

            if (isset($_GET['a'])) {
                $alert_id = $_GET['a'];

                // so it pops up with only the names of the ones that were affected
                $q = "SELECT `fname`, `lname` FROM `user` WHERE `id` = $alert_id";
                $a_r =  mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));  
                $row = mysqli_fetch_assoc($a_r);

                echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";

                echo 'You have approved attendee ' . $row['fname'] . ' ' . $row['lname']  . '!';

                echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
                </div>";

            } elseif (isset($_GET['d'])) {
                
                $alert_id = $_GET['d'];

                // so it pops up with only the names of the ones that were declined
                $q = "SELECT `fname`, `lname` FROM `user` WHERE `id` = $alert_id";
                $d_r =  mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));  
                $row = mysqli_fetch_assoc($d_r);
                
                echo "<div class='alert alert-danger alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";

                echo 'You have declined attendee ' . $row['fname'] . ' ' . $row['lname']  . '!';

                echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
                </div>";
            }

            while ($row = mysqli_fetch_assoc($result)) {                     

                echo'
                <tr>
                    <th scope="row">' . $row['id'] . '</th>
                    <td>' . $row['fname'] . ' ' . $row['lname'] .'</td>
                    <td>' . $row['email'] .'</td>
                    <td>' . $row['year_graduated'] .'</td>';

                if (isset($row['pending']) == $true){
                   echo '
                    <td>Pending</td>';                
                } else {
                    echo '<td>N/A</td>';
                }

                if (isset($row['rsvp']) == $true) {
                    echo '
                    <td>Approved</td>';
                } else {
                    echo '<td>N/A</td>';
                }
                echo'
                    <td>' . $row['modified_at'] .'</td>';


                if (isset($row['pending']) == $true) {
                    echo '<td>    
                            <a href="declineattendee.php?id=' . $row['id'] . '" class="text-decoration-none">
                                <button class="btn btn-decline">Decline</button>
                            </a>                    
                            <a href="approveattendee.php?id=' . $row['id'] . '">
                                <button class="btn btn-approve btn-m">Approve</button>
                            </a>                                                
                    </td>
                </tr>   ';
                } else {
                    echo '<td>                    
                            <a href="declineattendee.php?id=' . $row['id'] . '">
                                <button class="btn btn-decline">Decline</button>
                            </a>                        
                    </td>
                </tr>   ';
                }                                                          
            }

            ?>
        </tbody>
    </table>    
</body>

<?php
include'footer.php';