<?php
ob_start();
session_start();
if (isset($_SESSION['userName'])) {
    $pageTitle = 'user profile';
    include 'int.php';
    include $tpl . "navbarUser.php";
    $uprofileObject = new uprofiles();
    $tripObject = new trips();
    $userObject = new users();

    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;


    $user = $userObject->unique("User_ID='$userid'");
    if ($user > 0) {
        $getUser = $userObject->find("User_ID ='{$userid}'");
        $getuprofile = $uprofileObject->find("UID='{$userid}'");
?>

        <section class="userProfile">

            <div class="container-fluid">
                <div class="row ">
                    <div class="text-center d-flex justify-content-center">
                        <div class="col-md-3">
                            <div class="card card__user shadow mt-3 mb-5 ">
                                <?php
                                if (empty($getuprofile['User_Image'])) { ?>
                                    <img src="images/image.JFIF" class=" user-image img-thumbnail img-circle " alt="...">
                                <?php
                                } else {
                                    echo " <img src='images/userimages/" . $getuprofile['User_Image'] . "' class=' user-image img-thumbnail img-circle ' alt=''>";
                                } ?>
                                <div class="first-head">
                                    <div class="names  text-center">
                                        <span> </span> <?php echo $getuprofile['First_Name'] . ' ' . $getuprofile['Last_Name'] ?>

                                    </div>


                                </div>

                                <?php
                                $finish = $tripObject->unique("UserID ='{$userid}' AND Status= 1 ");

                                ?>
                                <div class="bg-light p-4 counttrips mb-4">
                                    <div class=" d-flex justify-content-center text-center">
                                       
                                        <ul class="list-inline mb-0 counts">
                                            <li class="list-inline-item">
                                                <h5 class="font-weight-bold mb-0 d-block"> <a href="#"><?php echo $finish  ?></h5><small class="text-muted"> finished</small></a>
                                            </li>

                                        </ul>

                                    </div>
                                </div>

                                <div class="second-head text-center mb-4">
                                    <div class="">
                                        <span> <?php echo $getUser['Email'] ?></span>

                                    </div>
                                    <div class="">

                                    </div>
                                    <div class="">
                                        <span> </span> <?php echo $getuprofile['Age'] ?>
                                    </div>
                                    <div class="">
                                        <span></span> <?php echo $getuprofile['Country'] ?>
                                    </div>
                                </div>



                            </div>
                        </div>

                    </div>


                </div>
            </div>

            </div>
            </div>

        </section>




    <?php

    } else {
    ?>
        <div class="alert alert-danger mb-5">this id is not available</div>
<?php
        header("refresh:1 ;url='profile.php'");
    }


    include $tpl . ('footer.php');
    ob_end_flush();
} else {
    header('location:login.php');
}
ob_end_flush();
