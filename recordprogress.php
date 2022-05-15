<?php
include 'config.php';
$time = $_GET['a'];
$track = $_GET['z'];
$fetchtrack = "SELECT * FROM `ctracks` WHERE `id`='$track'";
$res = $conn->query($fetchtrack);
if ($res->num_rows > 0) {
    while ($trow = $res->fetch_assoc()) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Recording Countdown</title>
            <link rel="stylesheet" href="./pcss.css">
            <?php include 'bootstrapcss.html'; ?>
        </head>

        <body class="cback">
            <?php
            include 'pnav.php';
            ?>
            <div class="container w-100">
                <div class="row">
                    <div class="col-md-12 text-center text-light mt-4 mb-4">
                        <h1>You Have Set The Timer To <span id="timedu"> <?php echo $time; ?></span> Minutes</h1>
                    </div>
                    <div class="col-md-12 text-center text-light">
                        <h4 id="demo"></h4>
                    </div>
                    <div class="col-md-12 mt-4 text-center text-light">
                        <h1>You Have Choosed To Play <?php echo $trow['trackname']; ?></h1>
                    </div>
                    <div class="col-md-12 text-center text-light mt-4">
                        <iframe src="./CustomTracks/2secondsofsilence.mp3" allow="autoplay" style="display: none"></iframe>

                        <audio autoplay controls loop>
                            <source src="./CustomTracks/RainSound.mp3" type="audio/mp3">
                        </audio>
                    </div>
                </div>
            </div>
            <script>
                var timer = document.getElementById('timedu').innerText;
                console.log(timer);
                var currentdate = new Date();
                console.log(currentdate);
                var currentdate = currentdate + timer;
                console.log(currentdate);

                var add_minutes = function(dt, minutes) {
                    return new Date(dt.getTime() + minutes * 60000);
                }
                var finalvalue = add_minutes(new Date(), timer).toString()

                console.log(finalvalue);

                // Set the date we're counting down to
                var countDownDate = new Date(finalvalue).getTime();

                // Update the count down every 1 second
                var x = setInterval(function() {

                    // Get today's date and time
                    var now = new Date().getTime();

                    // Find the distance between now and the count down date
                    var distance = countDownDate - now;

                    // Time calculations for days, hours, minutes and seconds
                    //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Output the result in an element with id="demo"
                    document.getElementById("demo").innerHTML = hours + " Hours " +
                        minutes + " Minutes & " + seconds + " Seconds Remaining";

                    // If the count down is over, write some text 
                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById("demo").innerHTML = "Recording In Progress";
                        window.location.replace("recordingstart.php");
                    }
                }, 1000);
            </script>
            <?php include 'bootstrapjs.html'; ?>
        </body>

        </html>
<?php
    }
} else {
    echo 'Track Error Occured. Please Try Again';
}
?>