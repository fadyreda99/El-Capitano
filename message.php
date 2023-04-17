<?php
ob_start();
session_start();
if (isset($_SESSION['userName'])) {
    $pageTitle = 'chat';
    include('int.php');
    include $tpl . "chatnav.php";



?>

    <div class="container">
        <div class="row">
            <div class="col-md-12  d-flex justify-content-center user-chat-area">

                <div class="wrapper2 wrapper">
                    <section class="chat-area">
                        <?php
                        $user_id = $_GET['user_id'];
                        $stmt = $conn->prepare("SELECT * FROM users WHERE User_ID = '{$user_id}'");
                        $stmt->execute();
                        $count = $stmt->rowCount();
                        if ($count > 0) {
                            $user = $stmt->fetch();
                            if ($user['Group_ID'] == 1) {
                                $stmt = $conn->prepare("SELECT * FROM drivers WHERE UserID = '{$user_id}'");
                                $stmt->execute();
                                $duser = $stmt->fetch();
                                $stmt = $conn->prepare("SELECT * FROM chats WHERE userid = {$_SESSION['uid']} AND driverid = '{$user_id}'");
                                $stmt->execute();
                                $chat = $stmt->fetch();
                        ?>
                                <header>
                                    <a href="chat.php" class="back-icon"> <i class="fas fa-arrow-left"></i></a>
                                    <img src="images/driverimages/<?php echo $duser['Driver_Image'] ?>" alt="">
                                    <div class="details">
                                        <span><?php echo $duser['First_Name'] . ' ' . $duser['Last_Name'] ?></span>
                                        <p>online</p>
                                    </div>
                                </header>
                                <div class="chat-box">

                                </div>

                                <form action="#" class="typing-area">
                                    <div class="container">
                                        <div class="row">
                                            <div class="">
                                                <input type="text" name="outgoing_id" value="<?php echo $_SESSION['uid'] ?>" hidden>
                                                <input type="text" name="chat_id" value="<?php echo $chat['Chat_ID'] ?>" hidden>
                                                <input type="text" name="incoming_id" value="<?php echo $user_id ?>" hidden>
                                                <input type="text" name="message" class="input-field " placeholder="type your message" autocomplete="off">

                                            </div>
                                            <div class="">
                                                <button>send</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                            <?php
                            } else {
                                $stmt = $conn->prepare("SELECT * FROM uprofiles WHERE UID = '{$user_id}'");
                                $stmt->execute();
                                $puser = $stmt->fetch();
                                $stmt = $conn->prepare("SELECT * FROM chats WHERE userid = {$user_id} AND driverid = {$_SESSION['uid']}");
                                $stmt->execute();
                                $chat = $stmt->fetch();
                            ?>
                                <header>
                                    <a href="chat.php" class="back-icon"> <i class="fas fa-arrow-left"></i></a>
                                    <img src="images/userimages/<?php echo $puser['User_Image'] ?>" alt="">
                                    <div class="details">
                                        <span><?php echo $puser['First_Name'] . ' ' . $puser['Last_Name'] ?></span>
                                        <p>online</p>
                                    </div>
                                </header>
                                <div class="chat-box">

                                </div>
                                <form action="#" class="typing-area">
                                    <div class="container">


                                        <div class="row">
                                            <div class="">
                                                <input type="text" name="outgoing_id" value="<?php echo $_SESSION['uid'] ?>" hidden>
                                                <input type="text" name="incoming_id" value="<?php echo $user_id ?>" hidden>
                                                <input type="text" name="chat_id" value="<?php echo $chat['Chat_ID'] ?>" hidden>
                                                <input type="text" name="message" class="input-field" placeholder="type your message" autocomplete="off">

                                            </div>
                                            <div class="">
                                                <button>send</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        <?php
                            }
                        }
                        ?>

                    </section>

                </div>

            </div>

        </div>

    </div>
<?php


    include $tpl . ('footer.php');
} else {
    header("location:login.php");
}
ob_end_flush();
