<?php
include 'config.php';
session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Page</title>
    <?php include 'bootstrapcss.html'; ?>
</head>

<body>
    <?php
    if (isset($_POST['loginbtn'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $codepassword = $_POST['codepassword'];

        if ($email == null || empty($email) || $email == '') {
    ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Enter Your Email Address!',
                });
            </script>
        <?php
        } else if ($password == null || empty($password) || $password == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Enter Your Password!',
                });
            </script>
        <?php
        } else if ($codepassword == null || empty($codepassword) || $codepassword == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Enter Your Code!',
                });
            </script>
            <?php
        } else {
            $query = "SELECT * FROM `docs` WHERE `email`= '$email' AND `password`= '$password' AND `code` = '$codepassword'";
            $res = $conn->query($query);
            if ($res->num_rows > 0) {
                while ($qrow = $res->fetch_assoc()) {
                    $userid = $qrow['id'];
                    $_SESSION['userid'] = $userid;
                    header('Location:dhome.php');
                }
            } else {
            ?>
                <script>
                    $.alert({
                        title: 'Warning!',
                        content: 'Incorrect Login Credentials Provided!',
                    });
                </script>
            <?php
            }
        }
    }

    if (isset($_POST['regist'])) {

        $name = $_POST['name'];
        $emailadd = $_POST['emailadd'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $password = $_POST['password'];
        $codepassword = $_POST['codepassword'];
        $bio = $_POST['bio'];
        $hq = $_POST['hq'];
        $awardb = $_POST['awardb'];
        $awardy = $_POST['awardy'];
        $yexp = $_POST['yexp'];
        $special = $_POST['special'];

        if ($name == null || empty($name) || $name == '') {
            ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Specify A Name!',
                });
            </script>
        <?php
        } else if ($emailadd == null || empty($emailadd) || $emailadd == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Specify An Email Address!',
                });
            </script>
        <?php
        } else if ($age == null || empty($age) || $age == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Specify Your Age!',
                });
            </script>
        <?php
        } else if ($address == null || empty($address) || $address == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Specify Your Address!',
                });
            </script>
        <?php
        } else if ($contact == null || empty($contact) || $contact == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Specify Your Contact!',
                });
            </script>
        <?php
        } else if (!filter_var($emailadd, FILTER_VALIDATE_EMAIL)) {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Specify A Valid Email Address!',
                });
            </script>
        <?php
        } else if ($password == null || empty($password) || $password == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Password Cannot Be Empty!',
                });
            </script>
        <?php
        } else if ($codepassword == null || empty($codepassword) || $codepassword == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Specify A Login Code!',
                });
            </script>
        <?php
        } else if ($bio == null || empty($bio) || $bio == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Enter A Short Bio!',
                });
            </script>
        <?php
        } else if ($hq == null || empty($hq) || $hq == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Specify Your Highest Qualification!',
                });
            </script>
        <?php
        } else if ($awardb == null || empty($awardb) || $awardb == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Specify The Awarding Body!',
                });
            </script>
        <?php
        } else if ($yexp == null || empty($yexp) || $yexp == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Specify Total Years Of Experience!',
                });
            </script>
        <?php
        } else if ($special == null || empty($special) || $special == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Specify Your Specialization!',
                });
            </script>
            <?php
        } else {
            $pdostmt = $conn->prepare('INSERT INTO `docs`(`name`, `age`, `email`, `address`, `contact`, `doc_spcial`, `exp_years`, `highest_qual`, `institue`, `completion_year`, `bio`, `password`, `code`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)');
            $pdostmt->bind_param('sssssssssssss', $name, $age, $emailadd, $address, $contact, $special, $yexp, $hq, $awardb, $awardy, $bio, $password, $codepassword);
            if ($pdostmt->execute() === TRUE) {
            ?>
                <script>
                    $.alert({
                        title: 'Successfull',
                        content: 'Your Registration Was Successfull!',
                    });
                </script>
                <?php
                try {
                    //Recipients
                    $mail->setFrom('medic@support.com', 'Medic Support Team');
                    $mail->addAddress($emailadd, $name);
                    $mail->addReplyTo('medic@support.com', 'Medic Support Team');

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Your Registration Was Successfull - Team Medic';
                    $mail->Body    = 'Hi Dr. ' . $name . '<br><br>We wish to confirm you that your registration was successfull<br><br>Best Regards<br>Team Medic';
                    $mail->AltBody = 'Hi Dr. ' . $name . '<br><br>We wish to confirm you that your registration was successfull<br><br>Best Regards<br>Team Medic';

                    $mail->send();
                } catch (Exception $e) {
                    echo "Internal Mailer Error : {$mail->ErrorInfo}";
                }
            } else {
                ?>
                <script>
                    $.alert({
                        title: 'Request Failed',
                        content: 'We Couldn\'t Process Your Request. Please Try Again!',
                    });
                </script>
    <?php
            }
        }
    }
    ?>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card" style="background-color: navy; height:100vh;">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <form action="" method="post">
                                <h2 class="fw-bold mb-5 text-uppercase text-white">Login</h2>
                                <div class="form-outline form-white mb-4">
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="someone@example.com" style="color:black;">
                                        <label for="floatingInput" style="color:black;">Email Address</label>
                                    </div>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="password" class="form-control" id="floatingInput" placeholder="********" style="color:black;">
                                        <label for="floatingInput" style="color:black;">Password</label>
                                    </div>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="codepassword" class="form-control" id="floatingInput" placeholder="********" style="color:black;">
                                        <label for="floatingInput" style="color:black;">Code</label>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-lg w-100 px-5" type="submit" name="loginbtn">Login</button>
                            </form>

                            <div class="row">
                                <div class="col-md-12 mt-3 mb-3">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#signupmodal" class="btn btn-secondary btn-sm w-100">Get Registered Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Signup Modal -->
    <div class="modal fade" id="signupmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Personal Details
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="name" class="form-control" id="floatingInputname" placeholder="Name">
                                                        <label for="floatingInputname">Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="email" name="emailadd" class="form-control" id="floatemail" placeholder="Email Address">
                                                        <label for="floatemail">Email Address</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="number" name="age" class="form-control" id="floatage" placeholder="Age">
                                                        <label for="floatage">Age</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="address" class="form-control" id="floataddress" placeholder="Address">
                                                        <label for="floataddress">Address</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="number" name="contact" class="form-control" id="floatcontact" placeholder="Contact Number">
                                                        <label for="floatcontact">Contact Number</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="password" name="password" class="form-control" id="floatpassword" placeholder="Password">
                                                        <label for="floatpassword">Password</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="password" name="codepassword" class="form-control" id="logincode" placeholder="Login Code">
                                                        <label for="logincode">Login Code</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <textarea name="bio" class="form-control" cols="30" rows="5" placeholder="Enter A Bio"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Educational Qualifications
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="hq" class="form-control" id="floathq" placeholder="Highest Qualification">
                                                        <label for="floathq">Highest Qualification</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="awardb" class="form-control" id="floatins" placeholder="Awarding Body">
                                                        <label for="floatins">Awarding Body</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="number" name="awardy" class="form-control" id="floatyear" placeholder="Awarded Year">
                                                        <label for="floatyear">Awarded Year</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Professional Details
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="yexp" class="form-control" id="floatexpyear" placeholder="Years Of Experience">
                                                        <label for="floatexpyear">Years Of Experience</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="special" class="form-control" id="floatspecial" placeholder="Specialization">
                                                        <label for="floatspecial">Specialization</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="regist" class="btn btn-primary w-100 mt-4">Register Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'bootstrapjs.html'; ?>
</body>

</html>