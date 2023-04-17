<?php
ob_start();
session_start();
if (isset($_SESSION['userName'])) {
    $pageTitle = 'driver profile';
    include 'int.php';
    include $tpl . "navbarUser.php";

    $driverObject = new drivers();
    $carObject = new cars();
    $userObject = new users();
    $chatObject = new chats();
    $tripObject = new trips();
    $memberObject = new memberships();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['user'])) {
            //chat
            $user = $_POST['user'];
            $driver = $_POST['driver'];
            $chat = $chatObject->unique("userid='$user' AND driverid='$driver'");
            if ($chat > 0) {
                header("location: message.php?user_id=$driver");
            } else {
                $chatObject->insert(
                    "(userid, driverid) VALUES (?,?)",
                    array($user, $driver)
                );
                if ($chatObject) {
                    header("location: message.php?user_id=$driver");
                }
            }
        }



        //

    }






    $driverid = isset($_GET['driverid']) && is_numeric($_GET['driverid']) ? intval($_GET['driverid']) : 0;


    $user = $userObject->unique("User_ID='$driverid' AND User_Status = 1");
    if ($user > 0) {

        $cats = $carObject->joins(
            "categories.Category_Name AS name",
            "INNER JOIN categories ON categories.Category_ID = cars.CatID WHERE User_id='$driverid'"
        );
        $driver = $driverObject->find("UserID='$driverid'");
        /*$user=$userObject->find("User_ID='$driverid'");*/
        $car = $carObject->find("User_id='$driverid'");
        $id = $driver['Driver_ID'];
        $membership = $memberObject->find("DriverID='$id'");


?>

        <section class="dprofile">
            <div class="">

                <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner slider-img">
                        <?php

                        if (empty($car['Car_Images'])) { ?>
                            <div class="carousel-item active">

                                <img src="images/car3.jfif" class="d-block w-100" alt="...">
                            </div>
                            <?php
                        } else {
                            $images = explode(',', $car['Car_Images']); //to make all images as array 
                            $i = 0;
                            foreach ($images as $image) {
                                $actives = ' ';
                                if ($i == 0) {
                                    $actives = 'active';
                                }
                            ?>
                                <div class="carousel-item <?= $actives ?>">
                                    <img src="images/carimages/<?php echo $image  ?>" class="d-block w-100" alt="...">
                                </div>

                        <?php
                                $i++;
                            }
                        }
                        ?>
                    </div>
                    <button class="carousel-control-prev btn" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next btn" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

            </div>

            <?php
            $finish = $tripObject->unique("DriverID ='{$driver['UserID']}' AND Status= 1 ");


            ?>
            <div class="bg-light p-4 counttrips">




                <div class=" d-flex justify-content-end text-center">

                    <ul class="list-inline mb-0 counts">
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block"> <?php echo $finish  ?></h5><small class="text-muted"> Trips</small>
                        </li>

                    </ul>
                </div>
                <div class="rate d-flex justify-content-start" id="avgrating"></div>

            </div>




            <?php

            if (empty($driver['Driver_Image'])) { ?>
                <img src="images/image.JFIF" class=" driver-image " alt="...">

            <?php

            } else {
                echo " <img src='images/driverimages/" . $driver['Driver_Image'] . "' class=' driver-image i' alt=''>";
            } ?>

            <section class="dinfo">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mt-3 mb-5 ">
                                <h5 class="text-center card-header mb-3">
                                    Personal Information
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 in">
                                        <span><i class="fas fa-user"></i> Full Name : <?php echo  $driver['First_Name'] . ' ' . $driver['Last_Name'] ?></span>

                                    </div>
                                    <div class="col-md-6 in">
                                        <span><i class="fa fa-calendar fa-fw"></i> Age : <?php echo  $driver['Age'] ?></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 in">
                                        <span><i class="fas fa-flag"></i> Country : <?php echo $driver['Country'] ?></span>
                                    </div>
                                </div>

                                <div class="col-12 card-header mb-3">
                                    <h5 class="text-center">
                                        Car Information
                                    </h5>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 in">
                                        <span><i class="fas fa-car"></i> Car type : <?php echo $car['Car_Type'] ?></span>
                                    </div>
                                    <div class="col-md-6 in">
                                        <span><i class="fas fa-tint"></i> Color : <?php echo $car['Car_Color'] ?></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 in">
                                        <?php
                                        foreach ($cats as $cat) { ?>
                                            <span><i class="fas fa-filter"></i> Category : <?php echo $cat['name'] ?></span>
                                        <?php
                                        } ?>
                                    </div>
                                    <div class="col-md-6 in">
                                        <span><i class="fas fa-envelope-open-text"></i> Car Number : <?php echo $car['Car_Number'] ?> | <?php echo $car['Car_Characters'] ?></span>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </section>
            <?php
            if (!empty($membership)) {
                $ldate = date("Y-m-d");

                $edate = $membership['End_Date_Of_Membership'];

                $test = strtotime($edate);
                $finalDate = date("Y-m-d", $test);
                if ($ldate > $finalDate) {
            ?>
                    <div class="container-fluid">
                        <div class="alert alert-danger">This driver is not available please search for another driver</div>

                    </div>

                <?php
                } else {
                ?>

                    <section class="btns text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class=" col-6 col-md-6">
                                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                        <input type="text" name="user" value="<?php echo $_SESSION['uid'] ?>" hidden>
                                        <input type="text" name="driver" value="<?php echo $driver['UserID'] ?>" hidden>
                                        <button class="btn btn-outline-dark btn2" type="submit" value="add user">start chat</button>
                                    </form>

                                </div>
                                <div class="col-6 col-md-6">
                                    <a class="btn btn-outline-secondary" href="trip.php?driverid=<?php echo $driver['UserID'] ?>">Trip Request</a>

                                </div>


                            </div>
                        </div>
                    </section>

                <?php
                }
            } else {
                ?>
                <div class="container-fluid">
                    <div class="alert alert-danger">This driver is not available please search for another driver</div>

                </div>
            <?php
            }
            ?>




        </section>
        </div>
        </div>

    <?php

    } else {
    ?>
        <div class="container">
            <div class="alert alert-danger"> sorry this ID is not available</div>
        </div>


    <?php
    }

    include $tpl . ('footer.php');
    ?>

    <script>
        //get avarege of rating
        $(function() {
            $("#avgrating").rateYo({
                readOnly: true,
                rating: '<?php echo  getAverageRating("WHERE DriverID ='$driverid'") ?>'


            });
        });
    </script>
<?php

} else {
    header('location:login.php');
}
ob_end_flush();
