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
            <?php include 'docnav.html'; ?>
            <h3 style="background-image: linear-gradient(315deg, #2a2a72 0%, #009ffd 74%);color:white; padding-top:25px; padding-bottom:25px;">&nbsp;Client Recordings</h3>
            <br>
            <div class="container">
                <table class="table table-striped table-bordered table-responsive" id="myTable">
                    <thead class="thead-inverse">
                        <tr>
                            <th>#</th>
                            <th>Client</th>
                            <th>Upload Time</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        $queryrecs = "SELECT cuploads.*, users.* FROM cuploads INNER JOIN users ON cuploads.uid = users.id WHERE cuploads.did=$fetchuser";
                        $queryres = $conn->query($queryrecs);
                        if ($queryres->num_rows > 0) {
                            while ($qrow = $queryres->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $qrow['fullname']; ?></td>
                                    <td><?php echo $qrow['upload_time']; ?></td>
                                    <td class="text-center">
                                        <a href="viewclientrec.php?c=<?php echo $qrow['uid']; ?>"><i class="fa-solid fa-eye" style="color:green;"></i></a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
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