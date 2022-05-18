<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();
include 'config.php';
$userid = $_SESSION['userid'];
$fetchuser = "SELECT * FROM `users` WHERE `id`='$userid'";
$fetchuser = $conn->query($fetchuser);
if ($fetchuser->num_rows > 0) {
    while ($user = $fetchuser->fetch_assoc()) {
        $usersname = $user['fullname'];
        $fetchedid = $user['id'];
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
            include 'clientnav.html';
            if (isset($_POST['audiosub'])) {
                $docselect = $_POST['docselect'];
                $audiodesc = $_POST['audiodesc'];
                /* Audio */
                $file = $_FILES['audiof'];
                $fileName = $_FILES['audiof']['name'];
                $fileTmpName = $_FILES['audiof']['tmp_name'];
                $fileSize = $_FILES['audiof']['size'];
                $fileError = $_FILES['audiof']['error'];
                $fileType = $_FILES['audiof']['type'];
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));
                $allowed = array('mp3', 'wav');
                if (in_array($fileActualExt, $allowed)) {
                    if ($fileError === 0) {
                        $fileNameNew = uniqid($usersname . $fetchedid, true) . "." . $fileActualExt;
                        $fileDestination = 'ClientAudio/' . $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);

                        $uploadstmt = $conn->prepare('INSERT INTO `cuploads`(`uid`,`did`,`clabel`, `cpath`) VALUES (?,?,?,?)');
                        $uploadstmt->bind_param('ssss', $fetchedid, $docselect, $audiodesc, $fileDestination);
                        if ($uploadstmt->execute() === TRUE) {
            ?>
                            <script>
                                $.confirm({
                                    title: 'Upload Successfull',
                                    content: 'Your Audio Upload Was Successfull',
                                    autoClose: 'OK|8000',
                                    buttons: {
                                        OK: function() {

                                            window.location.href = 'chome.php';
                                        }
                                    }
                                });
                            </script>
            <?php
                        }
                    } else {
                        echo 'Failed';
                    }
                }
                /* END */
            }
            ?>

            <form action="" method="post" enctype='multipart/form-data'>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mt-3 mb-3">
                            <div class="alert alert-success" role="alert">
                                Select Whom To Send This Audio
                            </div>
                            <p>Note : If already connected doctors are not availabe in the list below that would be mean the doctor is not availabe at the moment. Once the doctor is back and has turned on availability the doctor will be listed below</p>
                            <div class="form-floating">
                                <select class="form-select" name="docselect" id="floatingSelect" aria-label="Floating label select example">
                                    <?php
                                    $querydocs = "SELECT docs.*, dc_assign.docid,dc_assign.uid,dc_assign.expired FROM docs INNER JOIN dc_assign ON docs.id = dc_assign.docid WHERE dc_assign.uid=$fetchedid AND docs.availabe=1";
                                    $querydocsres = $conn->query($querydocs);
                                    if ($querydocsres->num_rows > 0) {
                                        while ($docresrow = $querydocsres->fetch_assoc()) {
                                    ?>
                                            <option value="<?php echo $docresrow['id'] ?>"><?php echo $docresrow['name']; ?></option>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="-">No Doctors Availabe</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="floatingSelect">Choose Doctor</label>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3 mb-3">
                            <div class="alert alert-warning" role="alert">
                                Only One Audio File At A Time
                            </div>
                            <input type="file" name="audiof" class="form-control">
                        </div>

                        <div class="col-md-6 mt-3 mb-3">
                            <div class="alert alert-danger" role="alert">
                                Search For This Audio Later Using This Label
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="audiodesc" class="form-control" id="floatingInput" placeholder="Audio Label">
                                <label for="floatingInput">Audio Label</label>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3 mb-3">
                            <button type="submit" name="audiosub" class="btn btn-primary w-100">Upload</button>
                        </div>
            </form>
            </div>
            </div>


            <?php include 'bootstrapjs.html'; ?>
        </body>

        </html>
<?php
    }
} else {
    header('Location:index.php');
}
?>