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
            <div class="col-md-12  d-flex justify-content-center user-chat">
                <div class="wrapper">
                    <section class="users">

                        <?php
                        $stmt = $conn->prepare("SELECT * FROM users WHERE	User_ID = '{$_SESSION['uid']}'");
                        $stmt->execute();
                        $count = $stmt->rowCount();
                        if ($count > 0) {
                            $user = $stmt->fetch();
                            if ($user['Group_ID'] == 0) {
                                $stmt = $conn->prepare("SELECT * FROM uprofiles WHERE UID = '{$_SESSION['uid']}'");
                                $stmt->execute();
                                $puser = $stmt->fetch();
                                if (!empty($puser)) {
                        ?>

                                    <header>
                                        <div class="content">
                                            <img src="images/userimages/<?php echo $puser['User_Image'] ?>" alt="">
                                            <div class="details">
                                                <span><?php echo $puser['First_Name'] . ' ' . $puser['Last_Name'] ?></span>

                                            </div>
                                        </div>
                                    </header>

                                    <div class="search">
                                        <span class="text">select user </span>
                                        <input type="text" placeholder="enter name of user">
                                        <button> <i class="fas fa-search"></i> </button>
                                    </div>

                                    <div class="users-list">

                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger">please set all info <a class="btn btn-outline-danger float-end" href="profile.php">profile</a></div>

                                <?php
                                }
                            } else {
                                $stmt = $conn->prepare("SELECT * FROM  drivers WHERE UserID = '{$_SESSION['uid']}'");

                                $stmt->execute();
                                $duser = $stmt->fetch();
                                if (!empty($duser)) {
                                ?>
                                    <header>
                                        <div class="content">
                                            <img src="images/driverimages/<?php echo $duser['Driver_Image'] ?>" alt="">
                                            <div class="details">
                                                <span><?php echo $duser['First_Name'] . ' ' . $duser['First_Name'] ?></span>

                                            </div>
                                        </div>
                                    </header>

                                    <div class="search">
                                        <span class="text">select user </span>
                                        <input type="text" placeholder="enter name of user">
                                        <button> <i class="fas fa-search"></i> </button>
                                    </div>

                                    <div class="users-list">

                                    </div>

                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger">please set all info <a class="btn btn-outline-danger float-end" href="profile.php">profile</a></div>

                        <?php
                                }
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

    header('location:prehome.php');
}
ob_end_flush();

?>