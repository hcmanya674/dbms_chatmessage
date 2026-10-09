<?php

session_start();

include("db.php");

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
}

$current_user_id =
$_SESSION['user_id'];

$sql = "SELECT * FROM users
        WHERE user_id != '$current_user_id'";

$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>

<html>

<head>
     <link rel="stylesheet" href="css/style.css">
    <title>Dashboard</title>

    <style>

        body{

            font-family: Arial;

            margin: 50px;
        }

        .user{

            padding: 15px;

            border: 1px solid gray;

            margin-bottom: 10px;

            width: 300px;
        }

        a{

            text-decoration: none;

            color: black;

            font-size: 18px;
        }

    </style>

</head>

<body>

<div class="main-container">

    <div class="sidebar">

        <div class="sidebar-header">

            Chats

        </div>

        <div class="user-list">

        <?php

        while($row =
        mysqli_fetch_assoc($result)){

        ?>

        <div class="user">

            <a href=
            "chat.php?user_id=
            <?php echo $row['user_id']; ?>">

            <?php
            echo $row['username'];
            ?>

            </a>

        </div>

        <?php
        }
        ?>

        </div>

    </div>

</div>
</body>

</html>