<?php
ob_start();
session_start();
$pageTitle = 'membership';

if (isset($_SESSION['admin'])) {
    include('int.php');

    $userObject = new users();
    $driverObject = new drivers();
    $carObject = new cars();
    $categoryObject = new categories();
    $memberObject = new memberships();



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();

        $driverid        =   $_POST['driverid'];
        $startdate       =   filter_var($_POST['startdate'], FILTER_SANITIZE_NUMBER_INT);
        $enddate       =   filter_var($_POST['enddate'], FILTER_SANITIZE_NUMBER_INT);
        $cost           =   filter_var($_POST['cost'], FILTER_SANITIZE_NUMBER_INT);


        //start date of membership
        if (empty($startdate)) {
            $errors[] = 'date cant be empty';
        }

        //end date of membership
        if (empty($enddate)) {
            $errors[] = 'date cant be empty';
        }

        //cost
        if (preg_match('([a-zA-Z].*[a-zA-Z])', $cost)) { //if last name contains numbers
            $errors[] = 'trip cost can not contain characters only numbers';
        }
        if (strlen($cost) < 2) {
            $errors[] = 'trip cost can not less than 2 numbers ';
        }
        if (strlen($cost) > 4) {
            $errors[] = 'trip cost can not more than 4 numbers ';
        }
        if (empty($cost)) {
            $errors[] = 'trip cost cant be empty';
        }

        if (empty($errors)) {
           
            $member = $memberObject->update(
                "Start_Date_Of_Membership=?, End_Date_Of_Membership=?, Cost_Of_Membership=? WHERE DriverID =?",
                array($startdate, $enddate, $cost, $driverid)
            );
            $theMsg = '<div class="container"><div class="alert alert-success"> record has updated </div> </div>';
            
            header('location: drivers.php');
         

        }
    }


?>
    <div class="container">
        <?php
        if (isset($errors)) {
            foreach ($errors as $error) {
        ?>
                <div class="alert alert-danger alert-dismissible fade show error-alert mt-2" role="alert">
                    <?php echo $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        <?php
            }
        }
        if (isset($theMsg)) {
            echo $theMsg;
        }
        ?>


        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <?php
            $memberid = isset($_GET['memberid']) && is_numeric($_GET['memberid']) ? intval($_GET['memberid']) : 0; //short if condition
            $membership = $memberObject->find("DriverID ='$memberid'");


            ?>
            <input type="hidden" class="form-control " name="driverid" autocomplete="off" value="<?php echo  $memberid ?>">






            <div class="col-12 form-control-lg">
                <label for="validationCustom01" class="form-label ">Start Date Of Membership</label>
                <input type="date" class="form-control " name="startdate" autocomplete="off" value="<?php echo  $membership['Start_Date_Of_Membership'] ?>" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please enter new Start Date Of Membership.
                </div>
            </div>

            <div class="col-12 form-control-lg">
                <label for="validationCustom01" class="form-label ">End Date Of Membership</label>
                <input type="date" class="form-control " name="enddate" autocomplete="off" value="<?php echo  $membership['End_Date_Of_Membership'] ?>" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please enter new End Date Of Membership.
                </div>
            </div>







            <div class="col-12 form-control-lg">
                <label for="validationCustom01" class="form-label ">Cost Of Membership</label>
                <input type="text" class="form-control " name="cost" autocomplete="off" value="<?php echo  $membership['Cost_Of_Membership'] ?>" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please enter  Cost.
                </div>
            </div>

            <div class="col-12 form-control-lg">
                <button class="btn btn-primary " type="submit" value="add user">set membership</button>
            </div>

        </form>
    </div>




<?php
    include $tpl . ('footer.php');
} else {
    header('location: ../prehome.php');
    exit();
}
ob_end_flush();
