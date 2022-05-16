<?php
session_start();
include 'config.php';
$fetchuser = $_SESSION['userid'];
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
            <title>My Account</title>
            <?php include 'bootstrapcss.html'; ?>
            <style>
                * {
                    margin: 0;
                    padding: 0
                }

                body {
                    background-image: linear-gradient(315deg, #2a2a72 0%, #009ffd 74%);
                }

                .card {
                    width: 450px;
                    background-color: #efefef;
                    border: none;
                    cursor: pointer;
                    transition: all 0.5s;
                }

                .image img {
                    transition: all 0.5s
                }

                .card:hover .image img {
                    transform: scale(1.5)
                }

                .btn {
                    height: 140px;
                    width: 140px;
                    border-radius: 50%
                }

                .name {
                    font-size: 22px;
                    font-weight: bold
                }

                .idd {
                    font-size: 14px;
                    font-weight: 600
                }

                .idd1 {
                    font-size: 12px
                }

                .number {
                    font-size: 22px;
                    font-weight: bold
                }

                .follow {
                    font-size: 12px;
                    font-weight: 500;
                    color: #444444
                }

                .btn1 {
                    height: 40px;
                    width: 150px;
                    border: none;
                    background-color: #000;
                    color: #aeaeae;
                    font-size: 15px
                }

                .text span {
                    font-size: 13px;
                    color: #545454;
                    font-weight: 500
                }

                .icons i {
                    font-size: 19px
                }

                hr .new1 {
                    border: 1px solid
                }

                .join {
                    font-size: 14px;
                    color: #a0a0a0;
                    font-weight: bold
                }

                .date {
                    background-color: #ccc
                }
            </style>
        </head>

        <body>
            <?php
            include 'clientnav.html';

            $docid = $_GET['a'];
            $docquery = "SELECT * FROM `docs` WHERE `id`='$docid'";
            $docres = $conn->query($docquery);
            if ($docres->num_rows > 0) {
                while ($drow = $docres->fetch_assoc()) {
            ?>
                    <div class="container mb-4 p-3 d-flex justify-content-center">
                        <div class="card p-4">
                            <div class=" image d-flex flex-column justify-content-center align-items-center">
                                <span class="name mt-3"><?php echo 'Dr. ' . $drow['name']; ?></span>
                                <span class="idd"><?php echo $drow['exp_years'] . ' of Experience'; ?></span>
                                <br>


                                <div class="text mt-3"> <span><?php echo 'Dr. ' . $drow['name']; ?> has completed <?php echo $drow['highest_qual']; ?> at <?php echo $drow['institue']; ?> and is currently specializing in <?php echo $drow['doc_spcial']; ?><br><br>
                                        Doctor Bio
                                        <hr><?php echo $drow['bio']; ?>
                                    </span>
                                </div>
                                <br><br>
                                <div class="gap-3 mt-3 icons d-flex flex-row justify-content-center align-items-center">
                                    <span><a href="tel:<?php echo $drow['contact'] ?>"><i class="fa-solid fa-phone"></i></a></span>
                                    <span><a href="mailto:<?php echo $drow['email']; ?>"><i class="fa-solid fa-envelope"></i></a></span>
                                    <br><br>
                                </div>

                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo 'Some Internal Error Occured';
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