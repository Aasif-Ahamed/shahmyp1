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
            <title>Connect A Doctor</title>
            <link rel="stylesheet" href="./pcss.css">
            <?php include 'bootstrapcss.html'; ?>
        </head>

        <body>
            <?php
            include 'clientnav.html';
            ?>

            <div class="container">
                <div class="row">
                    <?php
                    $queryfind = "SELECT * FROM `docs` WHERE `availabe`=1";
                    $queryfindres = $conn->query($queryfind);
                    if ($queryfindres->num_rows > 0) {
                        while ($docrow = $queryfindres->fetch_assoc()) {
                    ?>
                            <div class="col-md-6 mt-3 mb-3">
                                <form action="" method="post">
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $docrow['name']; ?></h5>
                                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $docrow['exp_years'] ?> years of experience</h6>
                                            <p class="card-text"><?php echo $docrow['bio']; ?></p>
                                            <input type="hidden" name="docid" value="<?php echo $docrow['id']; ?>">
                                            <button type="submit" name="doconnectbtn" class="btn btn-success">Connect</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <?php
            if (isset($_POST['doconnectbtn'])) {
                $docid = $_POST['docid'];
                $queryconnectdoc = "INSERT INTO `dc_assign`(`docid`, `uid`, `expired`) VALUES ('$docid','$fetchuser',0)";
                if ($conn->query($queryconnectdoc) === TRUE) {
            ?>
                    <script>
                        $.confirm({
                            title: 'Success',
                            content: 'Doctor Assigned To You Successfully',
                            autoClose: 'logoutUser|10000',
                            buttons: {
                                logoutUser: {
                                    text: 'OK',
                                    action: function() {
                                        window.location.href = 'chome.php';
                                    }
                                }
                            }
                        });
                    </script>
                <?php
                } else {
                ?>
                    <script>
                        $.confirm({
                            title: 'Ooops',
                            content: 'We Couldn\'t Process Your Request. Try Again',
                            autoClose: 'failed|10000',
                            buttons: {
                                failed: {
                                    text: 'OK',
                                    action: function() {
                                        window.location.href = 'doconnect.php';
                                    }
                                }
                            }
                        });
                    </script>
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