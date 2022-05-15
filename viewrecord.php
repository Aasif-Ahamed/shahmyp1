<?php
session_start();
include 'config.php';
$usersid = $_SESSION['userid'];
$fethid = "SELECT * FROM `users` WHERE `id`='$usersid'";
$fetchres = $conn->query($fethid);
if ($fetchres->num_rows > 0) {
    while ($fuser = $fetchres->fetch_assoc()) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>View Recordings</title>
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
            <?php include 'clientnav.html'; ?>
            <h1 style="background-image: linear-gradient(315deg, #2a2a72 0%, #009ffd 74%); padding-top:25px; padding-bottom:25px; color:white;">Your Saved Recordings</h1>
            <br>

            <table id="myTable" class="table table-bordered table-striped table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Audio</th>
                        <th>Score</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    $fetchrecords = "SELECT * FROM `cuploads` WHERE `uid`='$usersid'";
                    $fetchres = $conn->query($fetchrecords);
                    $count = 1;
                    if ($fetchres->num_rows > 0) {
                        while ($srecs = $fetchres->fetch_assoc()) {
                    ?>
                            <tr>
                                <td scope="row"><?php echo $count++; ?></td>
                                <td>
                                    <?php echo $srecs['clabel']; ?></audio>
                                </td>
                                <?php
                                if ($srecs['score'] == 'Pending') {
                                ?>
                                    <td style="background-color: yellow;">
                                        <?php echo $srecs['score']; ?>
                                    </td>
                                <?php
                                } else {
                                    echo $srecs['score'];
                                }
                                ?>
                                <td class="text-center">
                                    <a href="viewdata.php?a=<?php echo $srecs['id']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="3">No Data Found</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <?php include 'bootstrapjs.html'; ?>
        </body>

        </html>
<?php
    }
} else {
    header('Location: index.php');
}
?>