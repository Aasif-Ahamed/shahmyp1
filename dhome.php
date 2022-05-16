<?php
ob_start();
session_start();
include 'config.php';
$fetchuser = $_SESSION['userid'];
if (isset($fetchuser) == null) {
    header('Location: docindex.php');
} else if (empty($fetchuser)) {
    header('Location: docindex.php');
}
$query = "SELECT * FROM `docs` WHERE `id`=$fetchuser";
$res = $conn->query($query);
if ($res->num_rows > 0) {
    while ($urow = $res->fetch_assoc()) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Welcome <?php echo $urow['name']; ?></title>
            <link rel="stylesheet" href="./pcss.css">
            <?php include 'bootstrapcss.html'; ?>
            <style>
                .date-card {
                    border: 1px solid #ddd;
                    width: 200px;
                    padding: 10px;
                    display: flex;
                    align-items: center;
                }

                .date-card .day {
                    font-size: 48px;
                    margin: 0px 10px;
                    color: #2ab6b6;
                }

                .date-card .month {
                    font-weight: bold;
                }
            </style>
        </head>

        <body>
            <?php
            if (isset($_POST['startbtn'])) {
                $ptime = $_POST['ptime'];
                $tname = $_POST['tname'];

                $redirecturl = 'recordprogress.php?a=' . $ptime . '&z=' . $tname . '';
                header('Location: ' . $redirecturl . '');
            }
            ?>
            <div class="row" style="background-image: linear-gradient(315deg, #2a2a72 0%, #009ffd 74%);color:white; padding-top:25px; padding-bottom:25px;">
                <div class="col-md-6">
                    <h3>&nbsp;Welcome Dr. <?php echo $urow['name']; ?></h3>
                </div>
                <div class="col-md-6 text-center">
                    <center>
                        <button type="button" class="btn btn-success">
                            Reviews <span class="badge text-bg-secondary">11</span>
                        </button>
                        <button type="button" class="btn btn-info">
                            Patients <span class="badge text-bg-secondary">78</span>
                        </button>
                    </center>
                </div>
            </div>
            <br>

            <div style="background-image: linear-gradient(315deg, #2a2a72 0%, #009ffd 74%);color:white; padding-top:25px; padding-bottom:25px;">
                <h3>Appointments Today</h3>
                <hr>
            </div>
            <br>
            <div class="row" style="width: 100%;">
                <div class="col-md-3">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">John Steves</h5>
                            <p class="card-text">Appointment Today At 04:30 PM</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Steven William</h5>
                            <p class="card-text">Appointment Today At 05:30 PM</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Sara John</h5>
                            <p class="card-text">Appointment Today At 07:30 PM</p>
                        </div>
                    </div>
                </div>
            </div>

            <footer>
                <nav class="navbar fixed-bottom bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand btn btn-primary btn-sm" href="#">Patients</a>
                        <a class="navbar-brand btn btn-success btn-sm" href="#">Home</a>
                        <a class="navbar-brand btn btn-primary btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#modalappoint">Appointments</a>
                        <a class="navbar-brand btn btn-danger btn-sm" href="logout.php">Logout</a>
                    </div>
                </nav>
            </footer>

            <!-- Appointment Modal -->
            <div class="modal fade" id="modalappoint" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Upcoming Appointments</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="date-card">
                                        <div class="day">18</div>
                                        <div>
                                            <div class="month">May</div>
                                            <div class="year">2022</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="date-card">
                                        <div class="day">19</div>
                                        <div>
                                            <div class="month">May</div>
                                            <div class="year">2022</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title">John Steves</h5>
                                        <p class="card-text">Appointment Today At 04:30 PM</p>
                                        <a href="tel:0111231234" class="btn btn-success"><i class="fa-solid fa-phone"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END -->


            <?php include 'bootstrapjs.html'; ?>
        </body>

        </html>

<?php
    }
} else {
    header('Location:index.php');
}
?>