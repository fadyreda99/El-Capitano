<?php
ob_start();

session_start();
$pageTitle = 'end memberships';

if (isset($_SESSION['admin'])) {
    include('int.php');

    $userObject = new users();
    $driverObject = new drivers();
    $carObject = new cars();
    $categoryObject = new categories();
    $memberObject = new memberships();

    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'manage';
    }
    //start manage page
    if ($do == 'manage') {

        //echo $ldate;
        $members = $memberObject->joins(
            "drivers.First_Name  AS fname, drivers.Last_Name  AS lname, drivers.Mobile   AS Mobile, drivers.UserID AS id",
        "INNER JOIN drivers ON drivers.Driver_ID = memberships.DriverID");
    
        $ldate = date("Y-m-d");
    ?>
        <h1 class="text-center edit">end memberships</h1>
        <div class="container ">
            <div class="table-responsive driver-table">
                <table class="table main-table text-center  ">
                    <thead>
                        <tr>

                            <td class=""> Driver Name </td>

                            <td class=""> Mobile </td>
                            <td class=""> start Date </td>
                            <td class=""> end date </td>
                            <td class=""> controlls </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($members as $member) {
                            $edate = $member['End_Date_Of_Membership'];
                            $test = strtotime($edate);
                            $finalDate = date("Y-m-d", $test);
                            if ($ldate > $finalDate) {

                        ?>
                                <tr>
                                    <td><?php echo $member['fname'] . ' ' . $member['lname'] ?></td>
                                    <td><?php echo $member['Mobile'] ?></td>
                                    <td><?php echo $member['Start_Date_Of_Membership'] ?></td>
                                    <td><?php echo $member['End_Date_Of_Membership'] ?></td>
                                    <td><a href="drivers.php?do=view&driverid=<?php echo $member['id'] ?>" class="btn btn-primary">view profile</a></td>
                                </tr>

                        <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
<?php
    }
    include $tpl . ('footer.php');
} else {
    header('location: ../prehome.php');
    exit();
}

ob_end_flush();
