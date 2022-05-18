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
            <link rel="stylesheet" href="http://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
            <script src="http://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#myTable').DataTable();
                });
            </script>
        </head>

        <body>
            <?php
            include 'docnav.html';
            $clientid = $_GET['c'];
            $findclient = "SELECT cuploads.*, users.* FROM cuploads INNER JOIN users ON cuploads.uid = users.id WHERE cuploads.did='$fetchuser' AND users.id='$clientid'";
            $findclientres = $conn->query($findclient);
            if ($findclientres->num_rows > 0) {
                while ($clientrow = $findclientres->fetch_assoc()) {
            ?>
                    <h3 style="background-image: linear-gradient(315deg, #2a2a72 0%, #009ffd 74%);color:white; padding-top:25px; padding-bottom:25px;">&nbsp;Client - <?php echo $clientrow['fullname']; ?> (<?php echo $clientrow['gender']; ?>)</h3>
                    <br>
                    <div class="text-center">
                        <audio src="<?php echo $clientrow['cpath'] ?>" controls></audio>
                    </div>
                    <hr>
                    <br>
                    <h3 style="background-image: linear-gradient(315deg, #2a2a72 0%, #009ffd 74%);color:white; padding-top:25px; padding-bottom:25px;">&nbsp;Client - Habits</h3>
                    <br>
                    <div class="container">
                        <div class="row">
                            <?php
                            $count = 1;
                            $fetchhabits = "SELECT * FROM `habbits` WHERE `uid`='$clientid'";
                            $fetchres = $conn->query($fetchhabits);
                            if ($fetchres->num_rows > 0) {
                                while ($resrow = $fetchres->fetch_assoc()) {
                            ?>
                                    <div class="col-md-3">
                                        <div class="alert alert-success" role="alert">
                                            <?php echo $count++ . ') ' . $resrow['habit']; ?>
                                        </div>
                                    </div>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="col-md-12">
                                    <div class="alert alert-warning" role="alert">
                                        No Habbits Added Yet
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <h3 style="background-image: linear-gradient(315deg, #2a2a72 0%, #009ffd 74%);color:white; padding-top:25px; padding-bottom:25px;">&nbsp;Client - Medic</h3>
                    <br>
                    <div class="container">
                        <div class="row">
                            <?php
                            $count = 1;
                            $fetchhabits = "SELECT * FROM `medical` WHERE `uid`='$clientid'";
                            $fetchres = $conn->query($fetchhabits);
                            if ($fetchres->num_rows > 0) {
                                while ($resrow = $fetchres->fetch_assoc()) {
                            ?>
                                    <div class="col-md-3">
                                        <div class="alert alert-success" role="alert">
                                            <?php echo $count++ . ') ' . $resrow['medic']; ?>
                                        </div>
                                        <form action="delscreen.php" method="post">
                                            <input type="hidden" name="idval" value="<?php echo $resrow['id']; ?>">
                                        </form>
                                    </div>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="col-md-12">
                                    <div class="alert alert-warning" role="alert">
                                        No Medical Details Added Yet
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <form action="" method="post">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="score" class="form-control" id="floatingscore" placeholder="Your Score">
                                        <label for="floatingscore">Your Score</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="feedback" placeholder="Additional Feedback" id="floatingTextarea" style="height: 100px"></textarea>
                                        <label for="floatingTextarea">Additional Feedback</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <input type="hidden" name="clientid" value="<?php echo $clientrow['uploadid']; ?>">
                                    <button type="submit" name="btnsave" class="btn btn-primary w-100">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    if (isset($_POST['btnsave'])) {
                        $score = $_POST['score'];
                        $feedback = $_POST['feedback'];
                        $clientid = $_POST['clientid'];

                        $queryupdate = "UPDATE `cuploads` SET `score`='$score',`add_comments`='$feedback',`score_provder`='$fetchuser' WHERE `uploadid`='$clientid'";
                        if ($conn->query($queryupdate) === TRUE) {
                    ?>
                            <script>
                                $.confirm({
                                    title: 'Success',
                                    content: 'Your Feedback And Score Was Saved Successfully',
                                    autoClose: 'logoutUser|5000',
                                    buttons: {
                                        logoutUser: {
                                            text: 'OK',
                                            action: function() {
                                                window.location.href = 'crecs.php';
                                            }
                                        }
                                    }
                                });
                            </script>
                    <?php
                        } else {
                            echo 'Failed' . $conn->error;
                            /*  ?>
                            <script>
                                $.confirm({
                                    title: 'Request Failed',
                                    content: 'We Couldn\'t Process Your Request.Please Try Again',
                                    autoClose: 'logoutUser|5000',
                                    buttons: {
                                        logoutUser: {
                                            text: 'OK',
                                            action: function() {
                                                window.location.href = 'crecs.php';
                                            }
                                        }
                                    }
                                });
                            </script>
                    <?php */
                        }
                    }
                    ?>
            <?php
                }
            }
            ?>
            <?php include 'bootstrapjs.html'; ?>
        </body>

        </html>

<?php
    }
} else {
    header('Location:index.php');
}
?>