<?php

ob_start();
session_start();
$pageTitle = 'trips';




if (isset($_SESSION['admin'])) {
    include('int.php');

    $tripObject = new trips();
    $driverObject = new drivers();
    $userObject = new users();




    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'manage';
    }

    if ($do == 'manage') {
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $trips = $tripObject->all("DriverID = {$userid} ORDER BY Trip_Date");


        if (!empty($trips)) {
?>
            <h1 class="text-center edit">driver trips</h1>
            <div class="container ">
                <div class="table-responsive trips-table">
                    <table class="table main-table text-center  ">
                        <thead>
                            <tr>

                                <td class=""> User Name </td>

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
                    <div class="row text-center " style="width: 100%;">
                        <div class="col-4">
                            <a class="btn btn-primary " href="usertrips.php?do=unfinish&userid=<?php echo $trip['DriverID'] ?>">unfinished trips</a>

                        </div>
                        <div class="col-4">
                            <a class="btn btn-success" href="usertrips.php?do=finished&userid=<?php echo $trip['DriverID'] ?>">finished trips</a>

                        </div>
                        <div class="col-4">
                            <a class="btn btn-danger" href="usertrips.php?do=cancelled&userid=<?php echo $trip['DriverID'] ?>">cancelled trips</a>

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
    } elseif ($do == 'unfinish') {
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $trips = $tripObject->all("DriverID = {$userid} AND Status = 0 ORDER BY Trip_Date");
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

                    <a class="btn btn-success" href="usertrips.php?do=finished&userid=<?php echo $trip['DriverID'] ?>">finished trips</a>
                    <a class="btn btn-danger" href="usertrips.php?do=cancelled&userid=<?php echo $trip['DriverID'] ?>">cancelled trips</a>

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
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $trips = $tripObject->all("DriverID = {$userid} AND Status = 1 ORDER BY Trip_Date");


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
                    <a class="btn btn-primary " href="usertrips.php?do=unfinish&userid=<?php echo $trip['DriverID'] ?>">unfinished trips</a>


                    <a class="btn btn-danger" href="usertrips.php?do=cancelled&userid=<?php echo $trip['DriverID'] ?>">cancelled trips</a>
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
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $trips = $tripObject->all("DriverID = {$userid} AND Status = 2 ORDER BY Trip_Date");


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
                    <a class="btn btn-primary " href="usertrips.php?do=unfinish&userid=<?php echo $trip['DriverID'] ?>">unfinished trips</a>
                    <a class="btn btn-success" href="usertrips.php?do=finished&userid=<?php echo $trip['DriverID'] ?>">finished trips</a>

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
