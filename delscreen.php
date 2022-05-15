<?php
include 'config.php';

$id = $_GET['a'];
$query = "DELETE FROM `habbits` WHERE `id`='$id'";

if ($conn->query($query) === TRUE) {
    header('Location: myhabit.php');
} else {
    header('Location: myhabit.php');
}


if (isset($_POST['delmedic'])) {
    $idval = $_POST['idval'];
    $querymedic = "DELETE FROM `medical` WHERE `id`='$idval'";

    if ($conn->query($querymedic) === TRUE) {
        header('Location: mymedic.php');
    } else {
        echo 'Some Error Occured' . $conn->error;
    }
}
