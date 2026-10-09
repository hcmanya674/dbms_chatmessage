<?php

session_start();

include("db.php");

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");

    exit();
}

if(!isset($_GET['user_id'])){

    header("Location: dashboard.php");

    exit();
}

$current_user_id =
$_SESSION['user_id'];

$receiver_id =
$_GET['user_id'];

$_SESSION['receiver_id']
= $receiver_id;

$sql = "SELECT * FROM users
        WHERE user_id='$receiver_id'";

$result =
mysqli_query($conn,$sql);

$receiver =
mysqli_fetch_assoc($result);

if(!$receiver){

    echo "User not found";

    exit();
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Chat Application</title>

    <link
    rel="stylesheet"
    href="css/style.css">

</head>

<body>

<div class="main-container">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div class="sidebar-header">

            Chat App

        </div>

        <div class="user-list">

            <div class="user">

                <a href="dashboard.php">

                    ← Back to Chats

                </a>

            </div>

            <div class="user">

                <a href="logout.php">

                    Logout

                </a>

            </div>

        </div>

    </div>

    <!-- CHAT AREA -->

    <div class="chat-area">

        <!-- HEADER -->

        <div class="chat-header">

            <?php
            echo $receiver['username'];
            ?>

        </div>

        <!-- CHAT BOX -->

        <div id="chat-box">

        </div>

        <!-- MESSAGE FORM -->

       <form
id="chat-form"
class="chat-form">

    <input

        type="text"

        id="message"

        placeholder="Type a message..."

        required
    >

   <div id="emoji-box">

<span>😀</span>
<span>😂</span>
<span>😍</span>
<span>❤️</span>
<span>👍</span>
<span>🔥</span>
<span>😎</span>
<span>🎉</span>
<span>😢</span>
<span>😡</span>
<span>😁</span>
<span>🤣</span>
<span>🙌</span>
<span>💯</span>
<span>🚀</span>

</div>

    <button
    type="button"
    id="emoji-btn">

        😀

    </button>

    <button type="submit">

        Send

    </button>

</form>

    </div>

</div>

<script>

/* LOAD MESSAGES */

let lastData = "";

function loadMessages(){

    fetch("fetch_messages.php")

    .then(response => response.text())

    .then(data => {

        /* UPDATE ONLY IF CHANGED */

        if(data !== lastData){

            let chatBox =
            document.getElementById(
                "chat-box"
            );

            chatBox.innerHTML = data;

            /* AUTO SCROLL */

            chatBox.scrollTop =
            chatBox.scrollHeight;

            lastData = data;
        }
    });
}
/* EMOJI PICKER */

const emojiBtn =
document.getElementById(
    "emoji-btn"
);

const emojiBox =
document.getElementById(
    "emoji-box"
);

emojiBtn.addEventListener(

    "click",

    function(){

        if(
            emojiBox.style.display
            ==
            "block"
        ){

            emojiBox.style.display =
            "none";

        }else{

            emojiBox.style.display =
            "block";
        }
    }
);

/* ADD EMOJI TO INPUT */
emojiBox.addEventListener(

    "click",

    function(e){

        if(
            e.target.tagName
            ==
            "SPAN"
        ){

            let emoji =
            e.target.textContent;

            document.getElementById(
                "message"
            ).value += emoji;
            emojiBox.style.display =
"none";
        }
    }
);

/* SEND MESSAGE */

const form =
document.getElementById(
    "chat-form"
);

form.addEventListener(
"submit",

function(e){

    e.preventDefault();

    let message =
    document.getElementById(
        "message"
    ).value;

    fetch("send_message.php",{

        method:"POST",

        headers:{
            "Content-Type":
            "application/x-www-form-urlencoded"
        },

        body:
        "message=" +

        encodeURIComponent(
            message
        )

    })

    .then(() => {

        document.getElementById(
            "message"
        ).value = "";

        loadMessages();
    });
});

/* DELETE MESSAGE */

function deleteMessage(messageId){

    fetch("delete_message.php",{

        method:"POST",

        headers:{
            "Content-Type":
            "application/x-www-form-urlencoded"
        },

        body:
        "message_id=" + messageId

    })

    .then(() => {

        loadMessages();
    });
}

/* EDIT MESSAGE */
function editMessage(
    messageId,
    oldMessage
){

    let updatedMessage =
    prompt(
        "Edit your message",
        oldMessage
    );

    if(
        updatedMessage == null
        ||
        updatedMessage.trim() == ""
    ){

        return;
    }

    fetch("update_message.php",{

        method:"POST",

        headers:{
            "Content-Type":
            "application/x-www-form-urlencoded"
        },

        body:

        "message_id=" +

        messageId +

        "&updated_message=" +

        encodeURIComponent(
            updatedMessage
        )

    })

    .then(response => response.text())

    .then(data => {

        loadMessages();
    });
}
/* AUTO REFRESH */

setInterval(
    loadMessages,
    1000
);

/* INITIAL LOAD */

loadMessages();

</script>

</body>

</html>