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
            <title>My Habits</title>
            <?php include 'bootstrapcss.html'; ?>
        </head>

        <body>
            <?php
            include 'clientnav.html';
            if (isset($_POST['btnsave'])) {
                $name = $_POST['name'];
                if ($name == "" || empty($name) || $name == null) {
            ?>
                    <script>
                        $.alert({
                            title: 'Warning!',
                            content: 'Give At Least One Habbit To Save',
                        });
                    </script>
                    <?php
                } else {
                    foreach ($name as $polldiops2) {
                        $stmt2 = $conn->prepare("INSERT INTO `habbits`(`habit`, `uid`) VALUES (?,?)");
                        $stmt2->bind_param('ss', $polldiops2, $fetchuser);
                        $status = $stmt2->execute();
                    }
                    if ($status === TRUE) {
                    ?>
                        <script>
                            $.confirm({
                                title: 'Habbits Saved Successfully',
                                content: 'Your Habbits Have Been Saved Successfully',
                                autoClose: 'logoutUser|5000',
                                buttons: {
                                    logoutUser: {
                                        text: 'OK',
                                        action: function() {
                                            window.location.href = 'myhabit.php';
                                        }
                                    }
                                }
                            });
                        </script>
            <?php
                    } else {
                        echo 'Some Error Occured Please Try Again';
                    }
                }
            }
            ?>
            <h1 style="background-image: linear-gradient(315deg, #2a2a72 0%, #009ffd 74%); padding-top:25px; padding-bottom:25px; color:white;">My Habbits</h1>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalhabit">Add New Habbit</button>
                    </div>
                </div>
            </div>
            <!-- Modal Habit -->
            <div class="modal fade" id="modalhabit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add A New Habbit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post">
                                <div class="row mb-4" style="width:100%;">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table" style="border: transparent;" id="dynamic_field">
                                                <tr>
                                                    <td>
                                                        <label class="mb-2">Enter Your Habbit</label>
                                                        <input type="text" name="name[]" placeholder="Enter Your Habbit" class="form-control name_list" />
                                                    </td>
                                                    <td>
                                                        <br>
                                                        <button type="button" name="add" id="add" class="btn btn-success w-100 mt-2"><i class="fas fa-plus-circle"></i></button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                var i = 1;
                                                $('#add').click(function() {
                                                    i++;
                                                    $('#dynamic_field').append('<tr id="row' + i + '"><td><label class="mb-2">Enter Another Habbit</label><input type="text" name="name[]" placeholder="Enter Your Habbit" class="form-control name_list" /></td><td><br><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove w-100 mt-2"><i class="fas fa-minus-circle"></i></button></td></tr>');
                                                });
                                                $(document).on('click', '.btn_remove', function() {
                                                    var button_id = $(this).attr("id");
                                                    $('#row' + button_id + '').remove();
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="btnsave" class="btn btn-primary">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END -->

            <div class="container">
                <div class="row">
                    <?php
                    $count = 1;
                    $fetchhabits = "SELECT * FROM `habbits` WHERE `uid`='$fetchuser'";
                    $fetchres = $conn->query($fetchhabits);
                    if ($fetchres->num_rows > 0) {
                        while ($resrow = $fetchres->fetch_assoc()) {
                    ?>
                            <div class="col-md-3">
                                <div class="alert alert-success" role="alert">
                                    <?php echo $count++ . ') ' . $resrow['habit']; ?>
                                </div>
                                <a class="btn btn-danger btn-sm" href="delscreen.php?a=<?php echo $resrow['id']; ?>"><i class="fa-solid fa-trash-can"></i></a>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="col-md-12">
                            <div class="alert alert-warning" role="alert">
                                No Habbits Added Yet
                            </div>
                        </div>
                    <?php
                    }
                    ?>
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
