<?php

include("db.php");

$message = "";

if(isset($_POST['register'])){

    $username =
    mysqli_real_escape_string(
        $conn,
        $_POST['username']
    );

    $password =
    password_hash(

        $_POST['password'],

        PASSWORD_DEFAULT
    );

    $check =
    mysqli_query(

        $conn,

        "SELECT * FROM users
        WHERE username='$username'"
    );

    if(mysqli_num_rows($check)>0){

        $message =
        "Username already exists";

    }else{

        $sql = "INSERT INTO users
                (username,password)

                VALUES
                ('$username','$password')";

        if(mysqli_query($conn,$sql)){

            $message =
            "Registration Successful";

        }else{

            $message =
            "Registration Failed";
        }
    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Register</title>

    <link
    rel="stylesheet"
    href="css/style.css">

</head>

<body>

<div class="auth-container">

    <h2>Create Account</h2>

    <?php

    if($message!=""){

        echo "<p style='margin-bottom:15px;
        color:green;'>$message</p>";
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
        name="register">

            Register

        </button>

    </form>

    <br>

    <p>

        Already have account?

        <a href="login.php">

            Login

        </a>

    </p>

</div>

</body>

</html>