<?php
ob_start();
session_start();

if (isset($_SESSION['admin'])) {
    $pageTitle = 'Dashboard';

    include('int.php');
    $userObject = new users();
    $driverObject = new drivers();
    $carObject = new cars();
    $categoryObject = new categories();
    $contactObject = new contacts();

    $tripObject = new trips();
    $reportObject = new reports();
?>

    <div class="container home-state text-center mt-5">

        <div class="row">
            <div class="col-md-4">
                <div class="stat status1  st-members">
                    <i class="fa fa-users"></i>
                    <div class="info">

                        Total users
                        <span><a href="users.php"><?php echo  $userObject->unique("User_ID AND Group_ID=0") ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat status1 st-drivers">
                    <i class="fas fa-user-tie"></i>
                    <div class="info">
                        total drivers


                        <span><a href="drivers.php"><?php echo  $driverObject->unique("Driver_ID") ?></a></span>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat status1 st-cars">
                    <i class="fas fa-car "></i>
                    <div class="info">
                        Total cars
                        <span><a href="cars.php"><?php echo  $carObject->unique("Car_ID") ?></a></span>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="stat status1 st-members">
                    <i class="fa fa-tags"></i>
                    <div class="info">
                        Total categories
                        <span><a href="categories.php"><?php echo  $categoryObject->unique("Category_ID") ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat status1 st-drivers">
                    <i class="fas fa-user-clock"></i>
                    <div class="info">
                        pending drivers
                        <span><a href="drivers.php?do=manage&page=pending"><?php echo $userObject->unique("User_Status=0 AND Group_ID=1") ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <?php


                ?>
                <div class="stat status1  st-cars">
                    <i class="fas fa-envelope"></i>
                    <div class="info">
                        total messages
                        <span><a href="#"><?php echo $contactObject->unique('Message_ID') ?></a></span>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">
                <div class="stat status1 st-members">
                    <i class="fas fa-plane-departure"></i>
                    <div class="info">
                        unfinished trips
                        <span><a href="alltrips.php?do=unfinish"><?php echo  $tripObject->unique("Status = 0") ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat status1 st-drivers">
                    <i class="fas fa-plane-arrival"></i>
                    <div class="info">
                        finished trips
                        <span><a href="alltrips.php?do=finished"><?php echo $tripObject->unique("Status = 1") ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">

                <div class="stat status1  st-cars">
                    <i class="fas fa-plane-slash"></i>
                    <div class="info">
                        cancelled trips
                        <span><a href="alltrips.php?do=cancelled"><?php echo $tripObject->unique('Status = 2') ?></a></span>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-4">
                <div class="stat status1 st-members">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div class="info">
                        Reports
                        <span><a href="reports.php"><?php echo  $reportObject->unique("Report_ID") ?></a></span>
                    </div>
                </div>
            </div>


        </div>

    </div>


<?php
    include $tpl . ('footer.php');
} else {

    header('location: ../prehome.php');
    exit();
}
ob_end_flush();
