<?php
ob_start();
session_start();
include 'config.php';
$fetchuser = $_SESSION['userid'];
if (isset($fetchuser) == null) {
    header('Location: index.php');
} else if (empty($fetchuser)) {
    header('Location: index.php');
}
$query = "SELECT * FROM `users` WHERE `id`=$fetchuser";
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
            <title>Welcome <?php echo $urow['fullname']; ?></title>
            <link rel="stylesheet" href="./pcss.css">
            <?php include 'bootstrapcss.html'; ?>
        </head>

        <body>
            <?php
            include 'clientnav.html';
            if (isset($_POST['startbtn'])) {
                $ptime = $_POST['ptime'];
                $tname = $_POST['tname'];

                $redirecturl = 'recordprogress.php?a=' . $ptime . '&z=' . $tname . '';
                header('Location: ' . $redirecturl . '');
            }
            ?>

            <div class="row mx-auto my-auto text-center mt-4 mb-4">
                <div class="col-md-12 mt-4 mb-4">
                    <?php
                    $queryval = "SELECT * FROM `dc_assign` WHERE `uid`='$fetchuser' AND `expired`=0";
                    $queryvalres = $conn->query($queryval);
                    if ($queryvalres->num_rows > 0) {
                    ?>
                        Connected <i class="fa-solid fa-circle-check" style="color:green;"></i>
                    <?php
                    } else {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            You Haven't Registred With A Doctor Yet<br><a href="doconnect.php" class="btn btn-primary btn-sm">Connect Now</a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-md-6 mb-4 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Record</h4>
                            <a data-bs-toggle="modal" data-bs-target="#modalRecord" class="card-link"><i class="fa-solid fa-eye" style="color: white;"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Diagnosis</h4>
                            <a href="#" class="card-link"><i class="fa-solid fa-eye"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Habit</h4>
                            <a href="myhabit.php" class="card-link"><i class="fa-solid fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Medic</h4>
                            <a href="mymedic.php" class="card-link"><i class="fa-solid fa-eye"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RECORD MODAL -->
            <div class="modal fade" id="modalRecord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Recording Options</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="ullistone">
                                                <li>Set Time <br>(Default 20 Minutes)</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <select class="form-select" name="ptime" id="floatingSelect" aria-label="Floating label select example">
                                                    <option value="5">5 Minutes</option>
                                                    <option value="10">10 Minutes</option>
                                                    <option value="15">15 Minutes</option>
                                                    <option value="20" selected>20 Minutes</option>
                                                    <option value="25">25 Minutes</option>
                                                    <option value="30">30 Minutes</option>
                                                    <option value="35">35 Minutes</option>
                                                    <option value="40">40 Minutes</option>
                                                    <option value="45">45 Minutes</option>
                                                    <option value="50">50 Minutes</option>
                                                    <option value="55">55 Minutes</option>
                                                    <option value="60">60 Minutes</option>
                                                    <option value="65">65 Minutes</option>
                                                    <option value="70">70 Minutes</option>
                                                    <option value="75">75 Minutes</option>
                                                    <option value="80">80 Minutes</option>
                                                    <option value="85">85 Minutes</option>
                                                    <option value="90">90 Minutes</option>
                                                </select>
                                                <label for="floatingSelect">Choose Your Time</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <ul class="ullistone">
                                                <li>Select Tracks</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <select class="form-select" name="tname" id="floatingSelect" aria-label="Floating label select example">
                                                    <?php
                                                    $trackquery = "SELECT * FROM ctracks";
                                                    $trackres = $conn->query($trackquery);
                                                    if ($trackres->num_rows > 0) {
                                                        while ($ctrack = $trackres->fetch_assoc()) {
                                                    ?>
                                                            <option value="<?php echo $ctrack['id']; ?>"><?php echo $ctrack['trackname']; ?></option>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <option value="None">No Tracks Found</option>
                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                                <label for="floatingSelect">Choose Your Track</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <ul class="ullistone">
                                                <li>Capture Mode</li>
                                            </ul>
                                        </div>

                                        <div class="col-md-12 mt-4 mb-4">
                                            <button type="submit" name="startbtn" class="btn btn-primary btn-lg w-100">START</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END -->
            <footer>
                <nav class="navbar fixed-bottom bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#reportmodal">R</a>
                        <a class="navbar-brand btn btn-success" href="viewrecord.php">R</a>
                        <a class="navbar-brand btn btn-primary" href="#">H</a>
                        <a class="navbar-brand btn btn-success" href="#" data-bs-toggle="modal" data-bs-target="#modaldocs">C</a>
                        <a class="navbar-brand btn btn-primary" href="profile.php">P</a>
                    </div>
                </nav>
            </footer>

            <?php
            if (isset($_POST['viewdoc'])) {
                $docname = $_POST['docname'];
                $redirecturldoc = 'docprofile.php?a=' . $docname;
                header('Location:' . $redirecturldoc . '');
            }
            ?>

            <!-- Doc Modal -->
            <div class="modal fade" id="modaldocs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <div class="form-floating">
                                                <select class="form-select" name="docname" id="floatingSelect" aria-label="Floating label select example">
                                                    <?php
                                                    $querydoc = "SELECT * FROM `docs`";
                                                    $docres = $conn->query($querydoc);
                                                    if ($docres->num_rows > 0) {
                                                        while ($drow = $docres->fetch_assoc()) {
                                                    ?>
                                                            <option value="<?php echo $drow['id']; ?>"><?php echo 'Dr. ' . $drow['name']; ?></option>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <option value="#">Sorry No Doctors Availabe</option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <label for="floatingSelect">Search A Doctor</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <button type="submit" name="viewdoc" class="btn btn-primary w-100">View Doctor</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END -->

            <!-- Report Modal -->
            <div class="modal fade" id="reportmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Select Date</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <div class="alert alert-warning" role="alert">
                                            Please Note - Minimum Required Range Is 7 Days
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="alert alert-primary h-100" role="alert">
                                            Select Starting Date
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <input type="date" name="firstrange" class="form-control h-100">
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="alert alert-primary h-100" role="alert">
                                            Select Ending Date
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <input type="date" name="finalrange" class="form-control h-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary w-100">Generate</button>
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