<?php
ob_start();
session_start();
if (isset($_SESSION['userName'])) {
    $pageTitle = 'report';
    include('int.php');
    include $tpl . "navbarUser.php";

    $reportObject = new reports();
    $driverObject = new drivers();
    $userObject = new users();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['tripreportid'])) {
            $errors = array();

            $tripreportid        =   $_POST['tripreportid'];
            $receiverid        =   $_POST['report_receiver'];

            $makerFullName       =   filter_var($_POST['makerName'], FILTER_SANITIZE_STRING);
            $makerEmail          =   filter_var($_POST['makerEmail'], FILTER_SANITIZE_EMAIL);
            $makerNumber         =   filter_var($_POST['makerNumber'], FILTER_SANITIZE_NUMBER_INT);
            $receiverName     =   filter_var($_POST['recieverName'], FILTER_SANITIZE_STRING);
            $reason         =   filter_var($_POST['reason'], FILTER_SANITIZE_STRING);

            //full name validation
            if (preg_match('([0-9]|[0-9])', $makerFullName)) { //if first name contains numbers
                $errors[] = 'full name can not contain numbers only characters';
            }
            if (strlen($makerFullName) < 8) {
                $errors[] = 'full name cant be less than 8';
            }
            if (strlen($makerFullName) > 30) {
                $errors[] = 'full name cant be more than 30';
            }
            if (empty($makerFullName)) {
                $errors[] = 'full name cant be empty';
            }

            //email
            if (empty($makerEmail)) {
                $formErrors[] = 'this email can not be ampty';
            }
            if (isset($makerEmail)) {
                if (filter_var($makerEmail, FILTER_VALIDATE_EMAIL) != true) {
                    $formErrors[] = 'this email is not valid';
                }
            }

            //user number phone
            if (preg_match('([a-zA-Z].*[a-zA-Z])', $makerNumber)) { //if last name contains numbers
                $errors[] = 'phone number can not contain characters only numbers';
            }
            if (strlen($makerNumber) < 11) {
                $errors[] = 'phone can not less than 11 ';
            }
            if (strlen($makerNumber) > 11) {
                $errors[] = 'phone can not more than 11 ';
            }
            if (empty($makerNumber)) {
                $errors[] = 'phone cant be empty';
            }

            //driver name
            if (preg_match('([0-9]|[0-9])', $receiverName)) { //if first name contains numbers
                $errors[] = 'driver name can not contain numbers only characters';
            }
            if (strlen($receiverName) < 4) {
                $errors[] = 'driver name cant be less than 4';
            }
            if (strlen($receiverName) > 20) {
                $errors[] = 'driver name cant be more than 30';
            }
            if (empty($receiverName)) {
                $errors[] = 'driver name cant be empty';
            }


            //reasons validation

            if (strlen($reason) < 10) {
                $errors[] = 'reasons cant be less than 10';
            }
            if (strlen($reason) > 1000) {
                $errors[] = 'reasons cant be more than 1000';
            }
            if (empty($reason)) {
                $errors[] = 'reasons cant be empty';
            } else {
                $reportObject->insert(
                    "(Report_Maker_Name, Report_Maker_Email, Report_Maker_Mobile, Report_Receiver_Name, Reason, Report_Maker_ID , Report_Receiver_ID, TripID) VALUES (?,?,?,?,?,?,?,?)",
                    array($makerFullName, $makerEmail, $makerNumber, $receiverName, $reason, $_SESSION['uid'], $receiverid, $tripreportid)
                );

                if ($reportObject) {
                    echo ' <div class="container">
                                      <div class="alert alert-danger alert-dismissible fade show error-alert mt-2" role="alert">
                                            Your report Done After 2 Sec you will back to Your Profile.
                                             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>';
                    //$url='driverprofile.php?driverid= $_POST["driverid"]';
                    header("refresh:2;url=profile.php");
                    //redirectHome($theMsg ,'back');
                    //header('refresh:2; url=driverprofile.php?driverid= $_POST["driverid"]' );

                }
            }
        }
    }

?>
    <div class="container">
        <div class="row">
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
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['report-receiver'])) {
                    $tripid        =   $_POST['trip-id'];
                    $report_receiver        =   $_POST['report-receiver'];
                }
            }

            ?>
            <h1 class="text-center mt-3 mb-3">Make report</h1>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

                <input type="hidden" name="tripreportid" value="<?php echo $tripid ?>">
                <input type="hidden" name="report_receiver" value="<?php echo $report_receiver ?>">

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">Your Full Name</label>
                    <input type="text" class="form-control " name="makerName" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter your full name.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">Your Email</label>
                    <input type="email" class="form-control " name="makerEmail" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter your email.
                    </div>
                </div>


                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">Your Phone Number</label>
                    <input type="text" class="form-control " name="makerNumber" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter your Phone Number.
                    </div>
                </div>

                <?php
                $user = $userObject->find("User_Name='{$_SESSION["userName"]}'");

                ?>
                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">
                        <?php if ($user['User_Status'] == 0) {
                            echo "Driver Name";
                        } ?>
                        <?php if ($user['User_Status'] == 1) {
                            echo "Client Name";
                        } ?>
                    </label>
                    <input type="text" class="form-control " name="recieverName" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter receiver Name.
                    </div>
                </div>

                <div class="form-floating col-12 form-control-lg">
                    <abel for="validationCustomUsername" class="form-label">your Reasons</label>
                        <textarea class="form-control" name="reason" id="floatingTextarea2" style="height: 100px" required></textarea>
                </div>

                <div class="col-12 form-control-lg">
                    <button class="btn btn-danger " type="submit" value="add user">Send Report</button>
                </div>
            </form>
        </div>
    </div>




<?php
} else {
    header('location:login.php');
}
include $tpl . ('footer.php');
ob_end_flush();
