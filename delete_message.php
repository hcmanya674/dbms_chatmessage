<?php

session_start();

include("db.php");

$current_user_id =
$_SESSION['user_id'];

$message_id =
$_POST['message_id'];

$sql = "DELETE FROM messages

WHERE

message_id='$message_id'

AND

sender_id='$current_user_id'";

mysqli_query($conn,$sql);

?>