<?php
session_start();
include 'config.php';
$userid = $_SESSION['userid'];
$query = "SELECT * FROM `users` WHERE `id`='$userid'";
$res = $conn->query($query);
if ($res->num_rows > 0) {
    while ($resrow = $res->fetch_assoc()) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>View Recording Details</title>
            <?php include 'bootstrapcss.html'; ?>
        </head>

        <body>
            <?php
            include 'clientnav.html';

            $recordid = $_GET['a'];
            $queryrec = "SELECT * FROM `cuploads` WHERE `id`='$recordid'";
            $recqueryres = $conn->query($queryrec);
            if ($recqueryres->num_rows > 0) {
                while ($recordrow = $recqueryres->fetch_assoc()) {
            ?>
                    <h1 style="background-image: linear-gradient(315deg, #2a2a72 0%, #009ffd 74%);color:white; padding-top:25px; padding-bottom:25px; text-align:center;"><?php echo date("F j, Y, g:i a", strtotime($recordrow['upload_time'])); ?></h1>
                    <hr>
                    <br>
                    <div class="text-center">
                        <audio src="./<?php echo $recordrow['cpath']; ?>" controls autoplay style="width: 50%; padding-left:10px; padding-right:10px;"></audio>
                    </div>
                    <hr>
                    <br>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if ($recordrow['score'] == 'Pending') {
                                ?>
                                    <div class="alert alert-warning" role="alert">
                                        <?php echo $recordrow['score']; ?>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?php echo $recordrow['score']; ?>
                                    </div>
                                <?php
                                }

                                ?>
                            </div>
                            <div class="col-md-12 text-center">
                                <p><?php echo $recordrow['add_comments']; ?></p>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
            <?php include 'bootstrapjs.html'; ?>
        </body>

        </html>
<?php
    }
}
?>