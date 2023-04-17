<?php
ob_start();
session_start();
$pageTitle = 'reports';

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
        $reports = $reportObject->all3();


        if (!empty($reports)) {
?>
            <h1 class="text-center edit">All Reports</h1>
            <div class="container ">
                <div class="table-responsive trips-table">
                    <table class="table main-table text-center  ">
                        <thead>
                            <tr>

                                <td class=""> Maker Name </td>
                                <td class=""> Maker Email </td>



                                <td class=""> maker mobile </td>
                                <td class=""> Receiver name </td>
                                <td class=""> Maker [ Driver / Client ] </td>


                                <td>controllers</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reports as $report) {
                                $user = $userObject->find("User_ID ='{$report['Report_Maker_ID']}'");
                            ?>
                                <tr>

                                    <td><?php echo $report['Report_Maker_Name'] ?></td>

                                    <td><?php echo $report['Report_Maker_Email'] ?></td>

                                    <td><?php echo $report['Report_Maker_Mobile'] ?></td>
                                    <td><?php echo $report['Report_Receiver_Name'] ?></td>
                                    <td><?php
                                        //is_array($row) && ($user ==  $row['username_users'])
                                        if (is_array($user) && ($user['Group_ID'] == 1)) {
                                            echo "Driver";
                                        } else {
                                            echo "client";
                                        }


                                        ?></td>


                                    <td>

                                        <a class="btn btn-primary" href="reports.php?do=view&reportid=<?php echo $report['Report_ID'] ?>">view Report</a>


                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>

        <?php
        } else {
        ?>
            <div class="container">
                <div class="alert alert-danger mt-3 error3"> no reports available to you </div>
            </div>

        <?php
        }
    } elseif ($do == 'view') {
        $reportid = isset($_GET['reportid']) && is_numeric($_GET['reportid']) ? intval($_GET['reportid']) : 0;

        $report = $reportObject->find("Report_ID  ='{$reportid}'");
        $user = $userObject->find("User_ID ='{$report['Report_Maker_ID']}'");

        ?>
        <section class="view-trip">
            <div class="container">
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <div class="col-md-4 col-12">
                            <div class="card shadow mt-3 mb-5 ">
                                <div class="card-header">
                                    <h3>
                                        Report Details
                                        <span class="float-end mt-2">
                                            <h6>
                                                Maker /
                                                <?php
                                                if (is_array($user) && ($user['Group_ID'] == 1)) {
                                                    echo "driver";
                                                } else {
                                                    echo "client";
                                                }

                                                ?>
                                                <h6>
                                        </span>

                                    </h3>

                                </div>
                                <div class="card-body">
                                    <div>
                                        Maker name : <?php echo $report['Report_Maker_Name'] ?>
                                    </div>


                                    <div>
                                        Maker email: <?php echo $report['Report_Maker_Email'] ?>
                                    </div>
                                    <div>
                                        Maker phone: <?php echo $report['Report_Maker_Mobile'] ?>
                                    </div>
                                    <hr>
                                    <div>
                                        Reciever name: <?php echo $report['Report_Receiver_Name'] ?>
                                    </div>
                                    <hr>


                                    <div class="text-center">
                                        <h3>Reasons</h3>
                                    </div>
                                    <div class="">
                                        <p>
                                            <?php echo $report['Reason'] ?>
                                        </p>
                                    </div>



                                </div>
                                <div class="card-footer text-center">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php
                                            if (is_array($user) && ($user['Group_ID'] == 1)) {
                                            ?>
                                                <a class="btn btn-primary mb-2" href="users.php?do=view&userid=<?php echo $report['Report_Receiver_ID'] ?>">user profile</a>
                                                <a class="btn btn-primary mb-2" href="drivers.php?do=view&driverid=<?php echo $report['Report_Maker_ID'] ?>">driver profile</a>

                                            <?php
                                            } else {
                                            ?>
                                                <a class="btn btn-primary mb-2" href="users.php?do=view&userid=<?php echo $report['Report_Maker_ID'] ?>">user profile</a>
                                                <a class="btn btn-primary mb-2" href="drivers.php?do=view&driverid=<?php echo $report['Report_Receiver_ID'] ?>">driver profile</a>

                                            <?php
                                            }

                                            ?>


                                            <a class="btn btn-primary mb-2" href="alltrips.php?do=view&tripid=<?php echo $report['TripID'] ?>">view Trip</a>
                                            <div class="chat-form">
                                                <form action="chating.php" method="POST">
                                                    <input type="hidden" name="user1" value="<?php echo $report['Report_Maker_ID'] ?>">
                                                    <input type="hidden" name="user2" value="<?php echo $report['Report_Receiver_ID'] ?>">

                                                    <!-- <input class="btn btn-primary" type="submit" value="chat"> -->
                                                    <button class="btn btn-primary" type="submit">View chat</button>
                                                </form>

                                            </div>

                                        </div>
                                        <?php




                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </section>



<?php


    }
} else {
    header('location: ../prehome.php');
    exit();
}
include $tpl . ('footer.php');
ob_end_flush();
