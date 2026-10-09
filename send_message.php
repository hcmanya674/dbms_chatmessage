<?php

session_start();

include("db.php");

$sender_id =
$_SESSION['user_id'];

$receiver_id =
$_SESSION['receiver_id'];

$message =
$_POST['message'];

$sql = "INSERT INTO messages(

            sender_id,
            receiver_id,
            message

        )

        VALUES(

            '$sender_id',
            '$receiver_id',
            '$message'

        )";

mysqli_query($conn,$sql);

?>