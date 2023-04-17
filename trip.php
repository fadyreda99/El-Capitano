<?php
ob_start();
session_start();
if (isset($_SESSION['userName'])) {
    $pageTitle = 'trips';
    include('int.php');
    include $tpl . "navbarUser.php";

    $tripObject = new trips();
    $driverObject = new drivers();


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();


        $driverid        =   $_POST['driverid'];
        $fullname       =   filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
        $email          =   filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $number         =   filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
        $drivername     =   filter_var($_POST['drivername'], FILTER_SANITIZE_STRING);
        $tripdate       =   filter_var($_POST['tripdate'], FILTER_SANITIZE_NUMBER_INT);
        $tripday        =   $_POST['tripday'];
        $from           =   filter_var($_POST['from'], FILTER_SANITIZE_STRING);
        $to             =   filter_var($_POST['to'], FILTER_SANITIZE_STRING);
        $cost           =   filter_var($_POST['cost'], FILTER_SANITIZE_NUMBER_INT);

        //full name validation
        if (preg_match('([0-9]|[0-9])', $fullname)) { //if first name contains numbers
            $errors[] = 'full name can not contain numbers only characters';
        }
        if (strlen($fullname) < 8) {
            $errors[] = 'full name cant be less than 8';
        }
        if (strlen($fullname) > 30) {
            $errors[] = 'full name cant be more than 30';
        }
        if (empty($fullname)) {
            $errors[] = 'full name cant be empty';
        }

        //email
        if (empty($email)) {
            $formErrors[] = 'this email can not be ampty';
        }
        if (isset($email)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) != true) {
                $formErrors[] = 'this email is not valid';
            }
        }

        //user number phone
        if (preg_match('([a-zA-Z].*[a-zA-Z])', $number)) { //if last name contains numbers
            $errors[] = 'phone number can not contain characters only numbers';
        }
        if (strlen($number) < 11) {
            $errors[] = 'phone can not less than 11 ';
        }
        if (strlen($number) > 11) {
            $errors[] = 'phone can not more than 11 ';
        }
        if (empty($number)) {
            $errors[] = 'phone cant be empty';
        }

        //driver name
        if (preg_match('([0-9]|[0-9])', $drivername)) { //if first name contains numbers
            $errors[] = 'driver name can not contain numbers only characters';
        }
        if (strlen($drivername) < 4) {
            $errors[] = 'driver name cant be less than 4';
        }
        if (strlen($drivername) > 20) {
            $errors[] = 'driver name cant be more than 30';
        }
        if (empty($drivername)) {
            $errors[] = 'driver name cant be empty';
        }

        //trip date
        if (empty($tripdate)) {
            $errors[] = 'date cant be empty';
        }

        //trip day
        if (empty($tripday)) {
            $errors[] = 'day of trip cant be empty';
        }

        //from
        if (preg_match('([0-9]|[0-9])', $from)) { //if first name contains numbers
            $errors[] = 'start place of the trip cant be contain numbers characters only';
        }
        if (strlen($from) < 3) {
            $errors[] = 'start place cant be less 3 characters';
        }
        if (strlen($from) > 50) {
            $errors[] = 'start place cant be more 50 characters';
        }
        if (empty($from)) {
            $errors[] = 'please set start place for the trip';
        }


        //to
        if (preg_match('([0-9]|[0-9])', $to)) { //if first name contains numbers
            $errors[] = 'end place of the trip cant be contain numbers characters only';
        }
        if (strlen($to) < 3) {
            $errors[] = 'end place cant be less 3 characters';
        }
        if (strlen($to) > 50) {
            $errors[] = 'end place cant be more 50 characters';
        }
        if (empty($to)) {
            $errors[] = 'please set end place for the trip';
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
        } else {
            $tripObject->insert(
                "(Full_Name_User, Email_User, Phone_User, Driver_Name, Trip_Date, Trip_Day, From_Place, To_Place, Trip_Cost, DriverID , UserID) VALUES (?,?,?,?,?,?,?,?,?,?,?)",
                array($fullname, $email, $number, $drivername, $tripdate, $tripday, $from, $to, $cost, $driverid, $_SESSION['uid'])
            );
            if ($tripObject) {
                echo ' <div class="container">
                                  <div class="alert alert-success alert-dismissible fade show error-alert mt-2" role="alert">
                                        Your Request Done After 2 Sec you will back to drivers. 
                                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>';

                header("refresh:2;url=drivers.php");
            }
        }
    }
    //}

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
            $driverid = isset($_GET['driverid']) && is_numeric($_GET['driverid']) ? intval($_GET['driverid']) : 0;
            ?>
            <h1 class="text-center mt-3 mb-3">Make Your Trip Request</h1>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <input type="hidden" class="form-control " name="driverid" autocomplete="off" value="<?php echo  $driverid ?>">

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">Your Full Name</label>
                    <input type="text" class="form-control " name="fullname" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter your full name.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">Your Email</label>
                    <input type="email" class="form-control " name="email" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter your email.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">Your Phone Number</label>
                    <input type="text" class="form-control " name="number" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter your Phone Number.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">Driver Name</label>
                    <input type="text" class="form-control " name="drivername" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter Driver Name.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">Date Of Your Trip</label>
                    <input type="date" class="form-control " name="tripdate" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter Your Trip Date.
                    </div>
                </div>


                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">Day Of The Trip</label>
                    <select class="form-select" aria-label="Default select example" name="tripday" required>
                        <option value="">...</option>
                        <option value="SaturDay">SaturDay</option>
                        <option value="SunDay">SunDay</option>
                        <option value="MonDay">MonDay</option>
                        <option value="TuesDay">TuesDay</option>
                        <option value="WednesDay">WednesDay</option>
                        <option value="ThursDay">ThursDay</option>
                        <option value="FriDay">FriDay</option>
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please choose The Day Of Your Trip.
                    </div>
                </div>


                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">From Where</label>
                    <input type="text" class="form-control " name="from" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter Start place.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">To Where</label>
                    <input type="text" class="form-control " name="to" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter End Place.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">The Price Agreed Upon By You And The Driver</label>
                    <input type="text" class="form-control " name="cost" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter Trip Cost.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <button class="btn btn-primary " type="submit" value="add user">Make Trip</button>
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
