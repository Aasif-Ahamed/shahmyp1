<?php
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
            <style>
                body {
                    background-image: linear-gradient(315deg, #2a2a72 0%, #009ffd 74%);
                }

                #controls {
                    display: flex;
                    margin-top: 2rem;
                    max-width: 100%;
                }

                audio {
                    display: block;
                    width: 100%;
                    margin-top: 0.2rem;
                }

                li {
                    list-style: none;
                    margin-bottom: 1rem;
                }

                #formats {
                    margin-top: 0.5rem;
                    font-size: 80%;
                }

                #recordingsList {
                    max-width: 100%;
                }

                .stopwatch {
                    display: grid;
                    justify-items: center;
                    grid-row-gap: 23px;
                    width: 100%;
                    padding-top: 25px;
                }

                .circle {
                    display: flex;
                    justify-content: center;
                    align-items: center;

                    height: 270px;
                    width: 270px;

                    border: 2px solid white;
                    border-radius: 50%;
                }

                .time {
                    font-family: "Roboto Mono", monospace;
                    font-weight: 300;
                    font-size: 48px;
                    color: white;
                }

                .gold {
                    font-weight: 900;
                    color: #f2c94c;
                    text-shadow: 0 0 0px #fff, 0 0 50px #f2c94c;
                }

                .controls {
                    display: flex;
                    justify-content: space-between;

                    width: 187px;
                }

                button {
                    cursor: pointer;
                    background: transparent;
                    padding: 0;
                    border: none;
                    margin: 0;
                    outline: none;
                }
            </style>
        </head>

        <body>
            <?php
            include 'pnav.php';
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
            <center>
                <div class="circle mt-5">
                    <span class="time" id="display">00:00:00</span>
                </div>
                <div class="controls">
                    <button class="buttonPlay">
                        <img id="playButton" src="https://res.cloudinary.com/https-tinloof-com/image/upload/v1593360448/blog/time-in-js/play-button_opkxmt.svg" />

                        <img id="pauseButton2" src="https://res.cloudinary.com/https-tinloof-com/image/upload/v1593360448/blog/time-in-js/pause-button_pinhpy.svg" />
                    </button>

                    <button class="buttonReset">
                        <img id="resetButton" src="https://res.cloudinary.com/https-tinloof-com/image/upload/v1593360448/blog/time-in-js/reset-button_mdv6wf.svg" />
                    </button>
                </div>
            </center>

            <div id="controls">
                <button class="btn btn-success w-100" style="border-radius: 0px;" id="recordButton">Record</button>
                <button class="btn btn-secondary w-100" style="border-radius: 0px;" id="pauseButton" disabled>Pause</button>
                <button class="btn btn-secondary w-100" style="border-radius: 0px;" id="stopButton" disabled>Stop</button>
                <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#exampleModalupload" style="border-radius: 0px;">Upload</button>
            </div>
            <!-- Upload Modal -->
            <div class="modal fade" id="exampleModalupload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Upload Your Recording</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype='multipart/form-data'>
                                <div class="container">
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
                                    <div class="col-md-12">
                                        <div class="alert alert-warning" role="alert">
                                            Only One Audio File At A Time
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-3 mb-3">
                                        <input type="file" name="audiof" class="form-control">
                                    </div>

                                    <div class="col-md-12 mt-3 mb-3">
                                        <div>
                                            <input type="text" name="audiodesc" class="form-control" id="exampleFormControlInput1" placeholder="Audio Label">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-3 mb-3">
                                        <button type="submit" name="audiosub" class="btn btn-primary w-100">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END -->
            <span class="badge text-bg-warning">Note: Please Save To Disk And Then Upload The Audio File</span>
            <span id="formats" class="badge text-bg-warning"></span>

            <p class="text-white text-center mt-4"><strong>Your Recordings</strong></p>
            <ol id="recordingsList" class="text-center text-light"></ol>

            <script>
                jQuery(function() {
                    jQuery('#playButton').click();
                    jQuery('#recordButton').click();
                });
                // Convert time to a format of hours, minutes, seconds, and milliseconds

                function timeToString(time) {
                    let diffInHrs = time / 3600000;
                    let hh = Math.floor(diffInHrs);

                    let diffInMin = (diffInHrs - hh) * 60;
                    let mm = Math.floor(diffInMin);

                    let diffInSec = (diffInMin - mm) * 60;
                    let ss = Math.floor(diffInSec);

                    let diffInMs = (diffInSec - ss) * 100;
                    let ms = Math.floor(diffInMs);

                    let formattedMM = mm.toString().padStart(2, "0");
                    let formattedSS = ss.toString().padStart(2, "0");
                    let formattedMS = ms.toString().padStart(2, "0");

                    return `${formattedMM}:${formattedSS}:${formattedMS}`;
                }

                // Declare variables to use in our functions below

                let startTime;
                let elapsedTime = 0;
                let timerInterval;

                // Create function to modify innerHTML

                function print(txt) {
                    document.getElementById("display").innerHTML = txt;
                }

                // Create "start", "pause" and "reset" functions

                function start() {
                    startTime = Date.now() - elapsedTime;
                    timerInterval = setInterval(function printTime() {
                        elapsedTime = Date.now() - startTime;
                        print(timeToString(elapsedTime));
                    }, 10);
                    showButton("PAUSE");
                }

                function pause() {
                    clearInterval(timerInterval);
                    showButton("PLAY");
                }

                function reset() {
                    clearInterval(timerInterval);
                    print("00:00:00");
                    elapsedTime = 0;
                    showButton("PLAY");
                }

                // Create function to display buttons

                function showButton(buttonKey) {
                    const buttonToShow = buttonKey === "PLAY" ? playButton : pauseButton2;
                    const buttonToHide = buttonKey === "PLAY" ? pauseButton2 : playButton;
                    buttonToShow.style.display = "block";
                    buttonToHide.style.display = "none";
                }
                // Create event listeners

                let playButton = document.getElementById("playButton");
                let pauseButton2 = document.getElementById("pauseButton2");
                let resetButton = document.getElementById("resetButton");

                playButton.addEventListener("click", start);
                pauseButton2.addEventListener("click", pause);
                resetButton.addEventListener("click", reset);
            </script>
            <script src="js/recorder.js"></script>
            <script src="js/app.js"></script>

            <?php include 'bootstrapjs.html'; ?>
        </body>

        </html>
<?php
    }
} else {
    header('Location:index.php');
}
?>