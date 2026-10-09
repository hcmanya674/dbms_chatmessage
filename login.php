<?php

session_start();

include("db.php");

$error = "";

if(isset($_POST['login'])){

    $username =
    mysqli_real_escape_string(
        $conn,
        $_POST['username']
    );

    $password =
    $_POST['password'];

    $sql = "SELECT * FROM users
            WHERE username='$username'";

    $result =
    mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)>0){

        $row =
        mysqli_fetch_assoc($result);

        if(
            password_verify(
                $password,
                $row['password']
            )
        ){

            $_SESSION['user_id'] =
            $row['user_id'];

            header(
                "Location: dashboard.php"
            );

        }else{

            $error =
            "Incorrect Password";
        }

    }else{

        $error =
        "User Not Found";
    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Login</title>

    <link
    rel="stylesheet"
    href="css/style.css">

</head>

<body>

<div class="auth-container">

    <h2>Login</h2>

    <?php

    if($error!=""){

        echo "<p style='color:red;
        margin-bottom:15px;'>$error</p>";
    }

    ?>

    <form method="POST">

        <input

            type="text"

            name="username"

            placeholder="Username"

            required
        >

        <input

            type="password"

            name="password"

            placeholder="Password"

            required
        >

        <button
        type="submit"
        name="login">

            Login

        </button>

    </form>

    <br>

    <p>

        Don't have an account?

        <a href="register.php">

            Register

        </a>

    </p>

</div>

</body>

</html>