<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "chat_app"
);

if(!$conn){
    die("Database Connection Failed");
}

?>