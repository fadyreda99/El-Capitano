<?php
ob_start();
session_start();
$pageTitle = 'profile';
include 'int.php';
include $tpl . "navbarUser.php";

$userObject = new users();
$driverObject = new drivers();
$carObject = new cars();
$categoryObject = new categories();
$uprofileObject = new uprofiles();
$tripObject = new trips();
$memberObject = new memberships();


if (isset($_SESSION['userName'])) {
    $getUser = $userObject->find("User_Name='{$_SESSION["userName"]}'");
    $getdriver = $driverObject->find("UserID='{$getUser["User_ID"]}'");
    $getcar = $carObject->find("User_id='{$getUser["User_ID"]}'");
    $getuprofile = $uprofileObject->find("UID='{$getUser["User_ID"]}'");
    $cats = $carObject->joins(
        "categories.Category_Name AS name",
        "INNER JOIN categories ON categories.Category_ID = cars.CatID 
                              WHERE User_id='{$getUser["User_ID"]}'"
    );

    if ($getUser['Group_ID'] == 1) {

?>
        <section class="profiledriver">
            <div class="">
                <!--start slider for car images-->
                <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner slider-img">
                        <?php
                        if (empty($getcar['Car_Images'])) { ?>
                            <div class="carousel-item active">
                                <img src="images/car3.jfif" class="d-block w-100" alt="...">
                            </div>
                            <?php
                        } else {
                            $images = explode(',', $getcar['Car_Images']); //to make all images as array 
                            $i = 0;
                            foreach ($images as $image) {
                                $actives = ' ';
                                if ($i == 0) {
                                    $actives = 'active';
                                } ?>

                                <div class="carousel-item <?php echo $actives ?>">
                                    <img src="images/carimages/<?php echo $image  ?>" class="d-block w-100" alt="...">
                                </div>
                        <?php
                                $i++;
                            }
                        } ?>

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
            $finish = $tripObject->unique("DriverID ='{$_SESSION["uid"]}' AND Status= 1 ");
            $unfinish = $tripObject->unique("DriverID ='{$_SESSION["uid"]}' AND Status= 0 ");
            $cancel = $tripObject->unique("DriverID ='{$_SESSION["uid"]}' AND Status= 2 ");

            ?>
            <div class="bg-light p-4 counttrips  counttrips__final ">

                <div class='row '>
                    <div class=" d-flex justify-content-end text-center ">
                        <a class="btn btn-outline-dark trips" href="alltrips.php">All Trips</a>
                        <ul class="list-inline mb-0 counts">
                            <li class="list-inline-item">
                                <h5 class="font-weight-bold mb-0 d-block"> <a href="alltrips.php?do=finished"><?php echo $finish  ?></h5><small class="text-muted"> finished</small></a>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="font-weight-bold mb-0 d-block"><a href="alltrips.php?do=unfinish"><?php echo $unfinish  ?></h5><small class="text-muted"> unfinished</small></a>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="font-weight-bold mb-0 d-block"> <a href="alltrips.php?do=cancelled"><?php echo $cancel  ?></h5><small class="text-muted"> cancelled</small></a>
                            </li>
                        </ul>
                    </div>
                    <div class="rate d-flex justify-content-start  " id="avgrating">

                    </div>

                </div>




            </div>


            <?php
            //driver image
            if (empty($getdriver['Driver_Image'])) { ?>
                <img src="images/image.JFIF" class=" driver-image img-thumbnail  " alt="...">
            <?php
            } else {
                echo " <img src='images/driverimages/" . $getdriver['Driver_Image'] . "' class=' driver-image   ' alt=''>";
            } ?>

            <section class="driverinfo">
                <div class="container-fluid">
                    <div class="row test">
                        <div class="col-12">

                            <div class="card shadow mt-3 mb-5 ">
                                <h5 class="text-center card-header mb-3">
                                    Personal Information
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 in">
                                        <span><i class="fas fa-user-tag"></i> User Name : <?php echo $getUser['User_Name'] ?></span>
                                    </div>
                                    <div class="col-md-6 in">
                                        <span><i class="fas fa-envelope-open-text"></i> Email : <?php echo $getUser['Email'] ?></span>

                                    </div>
                                </div>
                                <?php
                                if (!empty($getdriver)) { ?>
                                    <div class="row">
                                        <div class="col-md-6 in">
                                            <span><i class="fas fa-user"></i> Full Name : <?php echo $getdriver['First_Name'] . ' ' . $getdriver['Last_Name'] ?></span>
                                        </div>
                                        <div class="col-md-6 in">
                                            <span><i class="fas fa-mobile"></i> Mobile : <?php echo $getdriver['Mobile'] ?></span>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 in">
                                            <span><i class="fa fa-calendar fa-fw"></i> Age : <?php echo $getdriver['Age'] ?></span>
                                        </div>
                                        <div class="col-md-6 in">
                                            <span><i class="fas fa-flag"></i> Country : <?php echo $getdriver['Country'] ?></span>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 in">
                                            <span><i class="fas fa-id-card-alt"></i> National ID : <?php echo $getdriver['National_ID'] ?></span>
                                        </div>
                                        <div class="col-md-6 in">
                                            <span><i class="fas fa-id-badge"></i> License ID : <?php echo $getdriver['License_ID'] ?></span>

                                        </div>
                                    </div>


                                <?php } else {
                                    echo '<div class="info-error alert alert-danger">there is no personal information</div>';
                                }

                                if (!empty($getcar)) { ?>
                                    <div class="col-12 card-header mb-3">
                                        <h5 class="text-center">
                                            Car Information
                                        </h5>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 in ">
                                            <span><i class="fas fa-car"></i> Car type : <?php echo $getcar['Car_Type'] ?></span>
                                        </div>
                                        <div class="col-md-6 in">
                                            <span><i class="fas fa-tint"></i> Color : <?php echo $getcar['Car_Color'] ?></span>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 in">
                                            <span><i class="fas fa-envelope-open-text"></i> Car Number : <?php echo $getcar['Car_Number'] ?> | <?php echo $getcar['Car_Characters'] ?></span>
                                        </div>
                                        <div class="col-md-6 in">
                                            <span><i class="fas fa-id-badge"></i> License Car : <?php echo $getcar['License_Car_ID'] ?></span>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 in">
                                            <span><i class="fa fa-calendar fa-fw"></i> End Date License : <?php echo $getcar['End_Date_License'] ?></span>
                                        </div>
                                        <div class="col-md-6 in">
                                            <?php
                                            foreach ($cats as $cat) { ?>
                                                <span><i class="fas fa-filter"></i> Category : <?php echo $cat['name'] ?></span>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>

                                <?php  } ?>
                                <?php
                                if (!empty($getdriver)) {
                                    $id = $getdriver['Driver_ID'];
                                    $membership = $memberObject->find("DriverID='$id'");
                                }


                                if (!empty($membership)) {
                                    $ldate = date("Y-m-d");

                                    $edate = $membership['End_Date_Of_Membership'];

                                    $test = strtotime($edate);
                                    $finalDate = date("Y-m-d", $test);
                                    //date                    
                                    $date1 = date_create($finalDate);
                                    $date2 = date_create($ldate);
                                    $diff = date_diff($date2, $date1);
                                    $diff->format("%a days");

                                ?>
                                    <div class="col-12 card-header mb-3">
                                        <h5 class="text-center">


                                            Membership
                                        </h5>
                                        <div class="text-center">
                                            <?php
                                            if ($ldate > $finalDate) {
                                            ?>
                                                <span class="text-center" style="color:red; font-size:25px ;">Membership had Ended</span>

                                            <?php
                                            } else {
                                            ?>
                                                <span class="text-center" style="color:red; font-size:25px ;"><?php echo $diff->format("%a day/s left") ?></span>
                                            <?php }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 in ">
                                            <span><i class="fa fa-calendar fa-fw"></i> Start Date : <?php echo $membership['Start_Date_Of_Membership'] ?></span>
                                        </div>
                                        <div class="col-md-6 in">
                                            <span><i class="fa fa-calendar fa-fw"></i> End Date : <?php echo $membership['End_Date_Of_Membership'] ?></span>
                                        </div>
                                    </div>




                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger">there is no membership please go to our company</div>

                                <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>

            </section>



            <section class="trip ">
                <?php
                $trips = $tripObject->all("DriverID = {$_SESSION['uid']} AND Status = 0 ORDER BY Trip_Date");
                if (!empty($trips)) {
                ?>

                    <div class="container-fluid ">
                        <div class="table-responsive trips-table">
                            <h2 class="text-center">Unfinished Trips</h2>
                            <table class="table main-table text-center  ">
                                <thead>
                                    <tr>

                                        <td class=""> USer Name </td>

                                        <td class=""> User Mobile </td>

                                        <td class=""> Trip Date </td>
                                        <td class=""> Trip Day </td>
                                        <td class=""> From </td>
                                        <td class=""> To </td>
                                        <td class=""> Cost </td>
                                        <td class=""> Status </td>
                                        <td class=""> controllers </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($trips as $trip) {  ?>
                                        <tr>

                                            <td><?php echo $trip['Full_Name_User'] ?></td>

                                            <td><?php echo $trip['Phone_User'] ?></td>

                                            <td><?php echo $trip['Trip_Date'] ?></td>
                                            <td><?php echo $trip['Trip_Day'] ?></td>
                                            <td><?php echo $trip['From_Place'] ?></td>
                                            <td><?php echo $trip['To_Place'] ?></td>
                                            <td><?php echo $trip['Trip_Cost'] ?></td>
                                            <td>
                                                <?php
                                                if ($trip['Status'] == 0) {
                                                ?>
                                                    <a class="btn btn-primary" href="alltrips.php?do=finish&tripid=<?php echo $trip['Trip_ID'] ?>">finished</a>
                                                    <a class="btn btn-danger" href="alltrips.php?do=cancel&tripid=<?php echo $trip['Trip_ID'] ?>">cancle</a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>

                                                <a class="btn btn-primary" href="alltrips.php?do=view&tripid=<?php echo $trip['Trip_ID'] ?>">view trip</a>

                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>


                        </div>
                    </div>

                <?php
                }
                ?>
            </section>





            <div class="container-fluid">
                <div class="per-buttons">
                    <?php
                    if (empty($getdriver)) { ?>
                        <a href="personalinfo.php" class="btn btn-primary">set your info</a>
                    <?php
                    }
                    if (empty($getcar)) { ?>
                        <a href="carinfo.php" class="btn btn-primary">set your car info</a>
                    <?php
                    } ?>

                </div>
            </div>


        </section>


    <?php





    } else { //user profile 
    ?>
        <section class="userProfile">
            <?php
            if (!empty($getuprofile)) { ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card shadow mt-3 mb-5 ">
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
                                    <div class="mobiles  text-center font-weight-bold">
                                        <span> </span> <?php echo $getuprofile['Mobile'] ?>
                                    </div>

                                </div>

                                <?php
                                $finish = $tripObject->unique("UserID ='{$_SESSION["uid"]}' AND Status= 1 ");
                                $unfinish = $tripObject->unique("UserID ='{$_SESSION["uid"]}' AND Status= 0 ");
                                $cancel = $tripObject->unique("UserID ='{$_SESSION["uid"]}' AND Status= 2 ");

                                ?>
                                <div class="bg-light p-4 counttrips mb-4">
                                    <div class=" d-flex justify-content-center text-center">

                                        <ul class="list-inline mb-0 counts">
                                            <li class="list-inline-item">
                                                <h5 class="font-weight-bold mb-0 d-block"> <a href="alltrips.php?do=finished"><?php echo $finish  ?></h5><small class="text-muted"> finished</small></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <h5 class="font-weight-bold mb-0 d-block"><a href="alltrips.php?do=unfinish"><?php echo $unfinish  ?></h5><small class="text-muted"> unfinished</small></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <h5 class="font-weight-bold mb-0 d-block"> <a href="alltrips.php?do=cancelled"><?php echo $cancel  ?></h5><small class="text-muted"> cancelled</small></a>
                                            </li>
                                        </ul>

                                    </div>
                                </div>

                                <div class="second-head text-center mb-4">
                                    <div class="">
                                        <span> <?php echo $getUser['Email'] ?></span>

                                    </div>
                                    <div class="">
                                        <span><?php echo $getUser['User_Name'] ?></span>
                                    </div>
                                    <div class="">
                                        <span> </span> <?php echo $getuprofile['Age'] ?>
                                    </div>
                                    <div class="">
                                        <span></span> <?php echo $getuprofile['Country'] ?>
                                    </div>
                                </div>

                                <a class="btn btn-outline-dark trips mb-5" href="alltrips.php">All Trips</a>

                            </div>
                        </div>
                        <div class="col-md-9">


                            <section class="trip mt-4">
                                <?php
                                $trips = $tripObject->all("UserID = {$_SESSION['uid']} AND Status = 0 ORDER BY Trip_Date");
                                if (!empty($trips)) {
                                ?>

                                    <div class="container-fluid ">
                                        <div class="table-responsive trips-table">
                                            <h2 class="text-center fw-bolder">Unfinished Trips</h2>
                                            <table class="table main-table text-center  ">
                                                <thead>
                                                    <tr>

                                                        <td class=""> Your Name </td>


                                                        <td class=""> Driver Name </td>
                                                        <td class=""> Trip Date </td>
                                                        <td class=""> Trip Day </td>
                                                        <td class=""> From </td>
                                                        <td class=""> To </td>
                                                        <td class=""> Cost </td>
                                                        <td class=""> Status </td>
                                                        <td class=""> Controlles </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($trips as $trip) {  ?>
                                                        <tr>

                                                            <td><?php echo $trip['Full_Name_User'] ?></td>


                                                            <td><?php echo $trip['Driver_Name'] ?></td>
                                                            <td><?php echo $trip['Trip_Date'] ?></td>
                                                            <td><?php echo $trip['Trip_Day'] ?></td>
                                                            <td><?php echo $trip['From_Place'] ?></td>
                                                            <td><?php echo $trip['To_Place'] ?></td>
                                                            <td><?php echo $trip['Trip_Cost'] ?></td>
                                                            <td>
                                                                <?php
                                                                if ($trip['Status'] == 0) {
                                                                ?>
                                                                    <a class="btn btn-primary " href="alltrips.php?do=finish&tripid=<?php echo $trip['Trip_ID'] ?>">finished</a>
                                                                    <a class="btn btn-danger" href="alltrips.php?do=cancel&tripid=<?php echo $trip['Trip_ID'] ?>">cancle</a>
                                                                <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>

                                                                <a class="btn btn-primary" href="alltrips.php?do=view&tripid=<?php echo $trip['Trip_ID'] ?>">view trip</a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                <?php
                                } else {
                                    echo '<div class="info-error alert alert-danger mt-3">Sorry you do not have any trips right now</div>';
                                }
                                ?>
                            </section>

                        </div>
                    </div>
                </div>

                </div>
                </div>
            <?php } else {
                echo '<div class="info-error alert alert-danger">there is no personal information</div>';
            }

            if (empty($getuprofile)) { ?>
                <div class="per-buttons">
                    <a href="userprofile.php" class="btn btn-primary btn-setinfo">set your personal info</a>
                </div>
            <?php
            }
            ?>
        </section>

    <?php
    } ?>




    <script>
        //get avarege of rating
        $(function() {
            $("#avgrating").rateYo({
                readOnly: true,
                rating: '<?php echo  getAverageRating("WHERE DriverID ='{$_SESSION['uid']}'") ?>'


            });
        });
    </script>
<?php
} else {
    header('location:login.php');
    exit();
}
include $tpl . ('footer.php');
ob_end_flush();
