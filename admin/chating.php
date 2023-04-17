<?php
ob_start();
session_start();
$pageTitle = 'chat';

if (isset($_SESSION['admin'])) {
    include('int.php');

    $tripObject = new trips();
    $driverObject = new drivers();
    $userObject = new users();
    $reportObject = new reports();
    $uprofileObject = new uprofiles();


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['user1'])) {
            $user1 = $_POST['user1'];
            $user2 = $_POST['user2'];

            $user = $userObject->find("User_ID ='{$user1}'");
            if ($user['Group_ID'] == 1) {
                $driver = $driverObject->find("UserID  ='{$user1}'");
                $user = $uprofileObject->find("UID  ='{$user2}'");
            } else {
                $driver = $driverObject->find("UserID  ='{$user2}'");
                $user = $uprofileObject->find("UID  ='{$user1}'");
            }


            $stmt = $conn->prepare("SELECT * FROM messages 
                WHERE outing_message_id = {$user1} AND income_message_id = {$user2}
                OR outing_message_id = {$user2} AND income_message_id = {$user1}
                ORDER BY Message_ID");

            $stmt->execute();
            $count = $stmt->rowCount();
?>
            <section class="view-chat">
                <div class="container">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <div class="col-md-4 col-12">
                                <div class="card shadow mt-3 mb-5 chat-box">
                                    <div class="card-header">
                                        <h2>chat Between

                                            <h6>
                                                <strong>Driver: </strong>
                                                <?php echo $driver['First_Name'] . ' ' . $driver['Last_Name'] ?>
                                                /
                                                <strong>Client: </strong>
                                                <?php echo $user['First_Name'] . ' ' . $user['Last_Name'] ?>
                                            </h6>
                                        </h2>

                                    </div>
                                    <div class="card-body">




                                        <?php

                                        if ($count > 0) {
                                            while ($msg = $stmt->fetch()) {
                                                if ($msg['outing_message_id'] === $user1) {
                                        ?>
                                                    <div class="chat outgoing">
                                                        <div class="details">
                                                            <p class="ps-2 pe-2"><?php echo  $msg['message'] ?></p>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>

                                                    <div class="chat incoming">

                                                        <div class="details">
                                                            <p class="ps-2 pe-2"><?php echo  $msg['message'] ?></p>

                                                        </div>
                                                    </div>
                                        <?php

                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

<?php
        }
    }
} else {
    header('location: ../prehome.php');
    exit();
}
include $tpl . ('footer.php');
ob_end_flush();
