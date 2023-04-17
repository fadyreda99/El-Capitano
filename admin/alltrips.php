<?php
ob_start();
session_start();
$pageTitle = 'trips';

if (isset($_SESSION['admin'])) {
    include('int.php');

    $tripObject = new trips();
    $driverObject = new drivers();
    $userObject = new users();
    $reportObject = new reports();

    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'manage';
    }

    if ($do == 'manage') {
        $trips = $tripObject->all3();


        if (!empty($trips)) {
?>
            <h1 class="text-center edit">All trips</h1>
            <div class="container ">
                <div class="table-responsive trips-table">
                    <table class="table main-table text-center  ">
                        <thead>
                            <tr>

                                <td class=""> User Name </td>
                                <td class=""> driver Name </td>
                                <td class=""> Trip Date </td>
                                <td class=""> Trip Day </td>
                                <td class=""> From </td>
                                <td class=""> To </td>
                                <td class=""> Cost </td>
                                <td class=""> Status </td>
                                <td>controllers</td>
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
                                            echo "unfinished";
                                        } elseif ($trip['Status'] == 1) {
                                            echo "completed";
                                        } else {
                                            echo "cancelled";
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
                    <div class="row text-center mb-5" style="width: 100%;">
                        <div class="col-4">
                            <a class="btn btn-primary " href="alltrips.php?do=unfinish">unfinished trips</a>

                        </div>
                        <div class="col-4">
                            <a class="btn btn-success" href="alltrips.php?do=finished">finished trips</a>

                        </div>
                        <div class="col-4">
                            <a class="btn btn-danger" href="alltrips.php?do=cancelled">cancelled trips</a>

                        </div>
                    </div>
                </div>
            </div>

        <?php
        } else {
        ?>
            <div class="container">
                <div class="alert alert-danger mt-3 error3"> no trips available to you </div>
            </div>

        <?php
        }
    } elseif ($do == 'view') {
        $tripid = isset($_GET['tripid']) && is_numeric($_GET['tripid']) ? intval($_GET['tripid']) : 0;

        $trip = $tripObject->find("Trip_ID ='{$tripid}'");

        ?>
        <section class="view-trip">
            <div class="container">
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <div class="col-md-4 col-12">
                            <div class="card shadow mt-3 mb-5 ">
                                <div class="card-header">
                                    <h3>
                                        Trip Details
                                        <span class="float-end">
                                            <h6>
                                                <?php
                                                if ($trip['Status'] == 0) {
                                                    echo "UnFinished";
                                                }
                                                if ($trip['Status'] == 1) {
                                                    echo "Finished";
                                                }
                                                if ($trip['Status'] == 2) {
                                                    echo "Cancelled";
                                                }

                                                ?>
                                                <h6>
                                        </span>

                                    </h3>

                                </div>
                                <div class="card-body">
                                    <div>
                                        driver name : <?php echo $trip['Driver_Name'] ?>
                                    </div>
                                    <hr>
                                    <div>
                                        Client name: <?php echo $trip['Full_Name_User'] ?>
                                    </div>
                                    <div>
                                        Client email: <?php echo $trip['Email_User'] ?>
                                    </div>
                                    <div>
                                        Client phone: <?php echo $trip['Phone_User'] ?>
                                    </div>
                                    <hr>


                                    <div class="">
                                        date of trip : <?php echo $trip['Trip_Date'] ?>
                                    </div>
                                    <div class="">
                                        day of trip : <?php echo $trip['Trip_Day'] ?>
                                    </div>
                                    <hr>
                                    <div>
                                        from: <?php echo $trip['From_Place'] ?>
                                    </div>
                                    <div>
                                        to: <?php echo $trip['To_Place'] ?>
                                    </div>
                                    <div>
                                        cost: <?php echo $trip['Trip_Cost'] ?>
                                    </div>

                                </div>
                                <div class="card-footer text-center">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="btn btn-primary mb-2" href="users.php?do=view&userid=<?php echo $trip['UserID'] ?>">user profile</a>
                                            <a class="btn btn-primary mb-2" href="drivers.php?do=view&driverid=<?php echo $trip['DriverID'] ?>">driver profile</a>
                                            <?php
                                            $report = $reportObject->unique("TripID ='{$tripid}'");
                                            if ($report > 0) {
                                            ?>
                                                <a class="btn btn-danger mb-2" href="tripreport.php?tripid=<?php echo $trip['Trip_ID'] ?>">view reports</a>
                                            <?php
                                            }
                                            ?>

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


    } elseif ($do == 'unfinish') {
        $trips = $tripObject->all("Status = 0 ORDER BY Trip_Date");
        if (!empty($trips)) {
        ?>
            <h1 class="text-center edit">UnFinished trips</h1>
            <div class="container ">
                <div class="table-responsive trips-table">
                    <table class="table main-table text-center  ">
                        <thead>
                            <tr>

                                <td class=""> USer Name </td>

                                <td class=""> driver name </td>

                                <td class=""> Trip Date </td>
                                <td class=""> Trip Day </td>
                                <td class=""> From </td>
                                <td class=""> To </td>
                                <td class=""> Cost </td>
                                <td class=""> Status </td>
                                <td>controllers</td>
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
                                            echo "unfinished";
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

                    <a class="btn btn-success" href="alltrips.php?do=finished">finished trips</a>
                    <a class="btn btn-danger" href="alltrips.php?do=cancelled">cancelled trips</a>
                </div>
            </div>

        <?php
        } else {
        ?>
            <div class="container">
                <div class="alert alert-danger mt-3 error3"> no trips available to you </div>
            </div>

        <?php
        }
    } elseif ($do == 'finished') {
        $trips = $tripObject->all("Status = 1 ORDER BY Trip_Date");


        if (!empty($trips)) {
        ?>
            <h1 class="text-center edit">Finished trips</h1>
            <div class="container ">
                <div class="table-responsive trips-table">
                    <table class="table main-table text-center  ">
                        <thead>
                            <tr>

                                <td class=""> USer Name </td>

                                <td class=""> driver name </td>

                                <td class=""> Trip Date </td>
                                <td class=""> Trip Day </td>
                                <td class=""> From </td>
                                <td class=""> To </td>
                                <td class=""> Cost </td>
                                <td class=""> Status </td>
                                <td>controllers</td>
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
                                        Finished
                                    </td>
                                    <td>

                                        <a class="btn btn-primary" href="alltrips.php?do=view&tripid=<?php echo $trip['Trip_ID'] ?>">view trip</a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <a class="btn btn-primary" href="alltrips.php?do=unfinish">unfinished trips</a>

                    <a class="btn btn-danger" href="alltrips.php?do=cancelled">cancelled trips</a>
                </div>
            </div>

        <?php
        } else {
        ?>
            <div class="container">
                <div class="alert alert-danger mt-3 error3"> no trips available to you </div>
            </div>

        <?php
        }
    } elseif ($do == 'cancelled') {
        $trips = $tripObject->all("Status = 2 ORDER BY Trip_Date");


        if (!empty($trips)) {
        ?>
            <h1 class="text-center edit">Cancelled trips</h1>
            <div class="container ">
                <div class="table-responsive trips-table">
                    <table class="table main-table text-center  ">
                        <thead>
                            <tr>

                                <td class=""> USer Name </td>

                                <td class=""> driver name </td>

                                <td class=""> Trip Date </td>
                                <td class=""> Trip Day </td>
                                <td class=""> From </td>
                                <td class=""> To </td>
                                <td class=""> Cost </td>
                                <td class=""> Status </td>
                                <td>controllers</td>
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
                                        cancelled
                                    </td>
                                    <td>

                                        <a class="btn btn-primary" href="alltrips.php?do=view&tripid=<?php echo $trip['Trip_ID'] ?>">view trip</a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <a class="btn btn-primary" href="alltrips.php?do=unfinish">unfinished trips</a>
                    <a class="btn btn-success" href="alltrips.php?do=finished">finished trips</a>

                </div>
            </div>

        <?php
        } else {
        ?>
            <div class="container">
                <div class="alert alert-danger mt-3 error3"> no trips available to you </div>
            </div>

<?php
        }
    }
} else {
    header('location: ../prehome.php');
    exit();
}
include $tpl . ('footer.php');
ob_end_flush();
