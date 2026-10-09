<?php

session_start();

include("db.php");

if(
    !isset($_SESSION['user_id'])
    ||
    !isset($_SESSION['receiver_id'])
){
    exit();
}

$current_user_id =
$_SESSION['user_id'];

$receiver_id =
$_SESSION['receiver_id'];

$sql = "SELECT * FROM messages

WHERE

(sender_id='$current_user_id'
AND receiver_id='$receiver_id')

OR

(sender_id='$receiver_id'
AND receiver_id='$current_user_id')

ORDER BY created_at ASC";

$result =
mysqli_query($conn,$sql);

while(
    $row =
    mysqli_fetch_assoc($result)
){

    if(
        $row['sender_id']
        ==
        $current_user_id
    ){

        $class =
        "message you";

    }else{

        $class =
        "message friend";
    }

?>

<div class="<?php echo $class; ?>">

    <!-- MESSAGE -->

    <div>

        <?php

        echo htmlspecialchars(
            $row['message']
        );

        ?>

    </div>

    <!-- EDITED LABEL -->

    <?php

    if(
        isset($row['is_edited'])
        &&
        $row['is_edited']==1
    ){

        echo "<small>(edited)</small>";
    }

    ?>

    <!-- TIME -->

    <small>

        <?php

        echo date(

            "h:i A",

            strtotime(
                $row['created_at']
            )
        );

        ?>

    </small>

    <?php

    /* SHOW BUTTONS ONLY
       FOR OWN MESSAGES */

    if(
        $row['sender_id']
        ==
        $current_user_id
    ){

    ?>

    <br><br>

    <!-- EDIT BUTTON -->

    <button

        class="action-btn"

        onclick="editMessage(

        <?php
        echo $row['message_id'];
        ?>,

        '<?php

        echo htmlspecialchars(
            $row['message'],
            ENT_QUOTES
        );

        ?>'

        )"

    >

        Edit

    </button>

    <!-- DELETE BUTTON -->

    <button

        class="action-btn"

        onclick="deleteMessage(

        <?php
        echo $row['message_id'];
        ?>

        )"

    >

        Delete

    </button>

    <?php
    }
    ?>

</div>

<?php
}
?>