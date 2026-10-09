<?php

session_start();

include("db.php");

if(isset($_POST['message_id'])
&&
isset($_POST['updated_message'])){

    $message_id =
    $_POST['message_id'];

    $updated_message =
    mysqli_real_escape_string(

        $conn,

        $_POST['updated_message']
    );

    $user_id =
    $_SESSION['user_id'];

    $sql = "UPDATE messages

            SET message='$updated_message', is_edited=1

            WHERE message_id='$message_id'

            AND sender_id='$user_id'";

    mysqli_query($conn,$sql);

    echo "Updated";
}

?>