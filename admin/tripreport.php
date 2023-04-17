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
        $tripid = isset($_GET['tripid']) && is_numeric($_GET['tripid']) ? intval($_GET['tripid']) : 0;
        $reports = $reportObject->all("TripID = '{$tripid}'");


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
    }
} else {
    header('location: ../prehome.php');
    exit();
}
include $tpl . ('footer.php');
ob_end_flush();
