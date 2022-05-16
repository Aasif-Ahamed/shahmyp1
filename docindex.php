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
    if (isset($_POST['signup'])) {
        $salutation = $_POST['salutation'];
        $fullname = $_POST['fullname'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $emailadd = $_POST['emailadd'];
        $pazzword = $_POST['pazzword'];
        $cpazzword = $_POST['cpazzword'];
        if ($salutation == null || empty($salutation) || $salutation == '') {
            ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Specify A Salutation!',
                });
            </script>
        <?php
        } else if ($fullname == null || empty($fullname) || $fullname == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Specify Your Full Name!',
                });
            </script>
        <?php
        } else if ($dob == null || empty($dob) || $dob == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Specify Your DOB!',
                });
            </script>
        <?php
        } else if ($gender == null || empty($gender) || $gender == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Specify Your Gender!',
                });
            </script>
        <?php
        } else if ($emailadd == null || empty($emailadd) || $emailadd == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Specify Your Email Address!',
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
        } else if ($pazzword == null || empty($pazzword) || $pazzword == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Password Cannot Be Empty!',
                });
            </script>
        <?php
        } else if ($cpazzword == null || empty($cpazzword) || $cpazzword == '') {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Please Confirm Your Password!',
                });
            </script>
        <?php
        } else if ($cpazzword != $pazzword) {
        ?>
            <script>
                $.alert({
                    title: 'Warning',
                    content: 'Password Confirmation Doen\'t Match!',
                });
            </script>
            <?php
        } else {
            $pdostmt = $conn->prepare('INSERT INTO `users`(`salutation`,`fullname`, `dob`, `gender`, `email`, `password`) VALUES (?,?,?,?,?,?)');
            $pdostmt->bind_param('ssssss', $salutation, $fullname, $dob, $gender, $emailadd, $pazzword);
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
                    $mail->addAddress($emailadd, $fullname);
                    $mail->addReplyTo('medic@support.com', 'Medic Support Team');

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Your Registration Was Successfull - Team Medic';
                    $mail->Body    = 'Hi ' . $salutation . '. ' . $fullname . '<br><br>We wish to confirm you that your registration was successfull<br><br>Best Regards<br>Team Medic';
                    $mail->AltBody = 'Hi ' . $salutation . '. ' . $fullname . '<br><br>We wish to confirm you that your registration was successfull<br><br>Best Regards<br>Team Medic';

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
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" name="salutation" id="floatingSelect" aria-label="Floating label select example">
                                            <option selected value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Dr">Dr</option>
                                        </select>
                                        <label for="floatingSelect">Salutation</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="fullname" class="form-control" id="floatingFullName" placeholder="Full Name">
                                        <label for="floatingFullName">Full Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="dob" class="form-control" id="floatingDOB" placeholder="DOB" value="<?php echo date('Y-m-d'); ?>">
                                        <label for="floatingDOB">DOB</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="gender" id="floatingSelect" aria-label="Floating label select example">
                                            <option selected value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        <label for="floatingSelect">Gender</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" name="emailadd" class="form-control" id="floatingEmail" placeholder="Email Address">
                                        <label for="floatingEmail">Email Address</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="pazzword" class="form-control" id="floatingPassword" placeholder="Password">
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="cpazzword" class="form-control" id="floatingConfirmPassword" placeholder="Confirm Password">
                                        <label for="floatingConfirmPassword">Confirm Password</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" name="signup" class="btn btn-primary w-100">Sign Up</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'bootstrapjs.html'; ?>
</body>

</html>