<?php
ob_start();
session_start();
if (isset($_SESSION['userName'])) {
    $pageTitle = 'personal information';
    include('int.php');
    include $tpl . "navbarUser.php";

    $uprofileObject = new uprofiles();
    $userObject = new users();
    $uid = $_SESSION['uid'];
    $profile = $uprofileObject->find("UID='$uid'");
    $user = $userObject->find("User_Name='{$_SESSION['userName']}'");


    if ($user['Group_ID'] == 0) {
        if (empty($profile)) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $errors = array();

                //filter all fields
                $firstname  =   filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
                $lastname   =   filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
                $mobile     =   filter_var($_POST['mobile'], FILTER_SANITIZE_NUMBER_INT);
                $age        =   filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
                $country    =   filter_var($_POST['country'], FILTER_SANITIZE_STRING);
                $gender     =   $_POST['gender'];

                //get info of image from form
                $image_name = $_FILES['uimage']['name'];
                $image_type = $_FILES['uimage']['type'];
                $image_tmp = $_FILES['uimage']['tmp_name'];
                $image_size = $_FILES['uimage']['size'];
                $image_error = $_FILES['uimage']['error'];



                //allowed extensions
                $allowedExtensions = array("jpeg", "jpg", "png", "gif", "jfif");


                //get image extension
                $image_extension = explode('.', $image_name);
                $end_extension = end($image_extension);
                $lowerExtension = strtolower($end_extension); // convert extension to lower case





                //first name validation
                if (preg_match('([0-9]|[0-9])', $firstname)) { //if first name contains numbers
                    $errors[] = 'first name can not contain numbers only characters';
                }
                if (strlen($firstname) < 4) {
                    $errors[] = 'first name cant be less than 4';
                }
                if (strlen($firstname) > 20) {
                    $errors[] = 'first name cant be more than 20';
                }
                if (empty($firstname)) {
                    $errors[] = 'first name cant be empty';
                }

                //last name validation
                if (preg_match('([0-9]|[0-9])', $lastname)) { //if first name contains numbers
                    $errors[] = 'last name can not contain numbers only characters';
                }
                if (strlen($lastname) < 4) {
                    $errors[] = 'last name cant be less than 4';
                }
                if (strlen($lastname) > 20) {
                    $errors[] = 'last name cant be more than 20';
                }
                if (empty($lastname)) {
                    $errors[] = 'last name cant be empty';
                }

                //mobile validation
                if (preg_match('([a-zA-Z].*[a-zA-Z])', $mobile)) { //if last name contains numbers
                    $errors[] = 'phone number can not contain characters only numbers';
                }
                if (strlen($mobile) < 11) {
                    $errors[] = 'phone can not less than 11 ';
                }
                if (strlen($mobile) > 11) {
                    $errors[] = 'phone can not more than 11 ';
                }
                if (empty($mobile)) {
                    $errors[] = 'phone cant be empty';
                }
                $count = $uprofileObject->unique("Mobile ='$mobile'");
                if ($count > 0) {
                    $errors[] = 'mobile is exists';
                }

                //age validation
                if (preg_match('([a-zA-Z].*[a-zA-Z])', $age)) { //if age contains letters
                    $errors[] = 'age can not contain characters only numbers';
                }
                if (strlen($age) > 2) {
                    $errors[] = 'age cant be more than 2 chars';
                }
                if (empty($age)) {
                    $errors[] = 'age cant be empty';
                }

                //country validation
                if (preg_match('([0-9]|[0-9])', $country)) { //if country contains numbers
                    $errors[] = 'country can not contain numbers only characters';
                }
                if (strlen($country) < 4) {
                    $errors[] = 'country cant be less than 4';
                }
                if (strlen($country) > 10) {
                    $errors[] = 'country cant be more than 10';
                }
                if (empty($country)) {
                    $errors[] = 'country cant be empty';
                }

                //user image validation
                if ($image_error == 4) {
                    $errors[] = 'no file uploaded';
                } else {

                    //check file size
                    if ($image_size > 4194304) {
                        $errors[] = 'max size of image is 4MP';
                    }

                    //check if extension is valid
                    if (!in_array($lowerExtension, $allowedExtensions)) {
                        $errors[] = 'file is not valid ';
                    }
                }



                // radio validation
                if ($gender != 1) {
                    if ($gender != 2) {
                        $errors[] = 'please choose you will be a male or female?';
                    }
                }

                if (empty($errors)) {

                    $user_image = rand(0, 10000000000) . '_' . $image_name;
                    move_uploaded_file($image_tmp, $_SERVER['DOCUMENT_ROOT'] . '\gradproject\images\userimages\\' . $user_image);


                    $uprofileObject->insert(
                        "(First_Name, Last_Name, Mobile, Age, Country, Gender ,User_Image, UID) VALUES (?,?,?,?,?,?,?,?)",
                        array($firstname, $lastname, $mobile, $age, $country, $gender, $user_image, $_SESSION['uid'])
                    );
                    if ($uprofileObject) {
                        header('location:profile.php');
                    }
                }
            }
?>

            <h1 class="text-center edit">set Your personal info</h1>
            <div class="container ">
                <?php
                if (isset($errors)) {
                    foreach ($errors as $error) {
                ?>
                        <div class="alert alert-danger alert-dismissible fade show error-alert" role="alert">
                            <?php echo $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php
                    }
                }
                ?>


                <form class="row g-3 needs-validation edit-from" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" novalidate>

                    <div class="col-12 form-control-lg">
                        <label for="validationCustom01" class="form-label ">First Name</label>
                        <input type="text" class="form-control " name="firstname" autocomplete="off" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please enter First Name.
                        </div>
                    </div>

                    <div class="col-12 form-control-lg">
                        <label for="validationCustom02" class="form-label">Last Name</label>
                        <input type="text" class="password form-control" name="lastname" autocomplete="new-password" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please enter Last Name.
                        </div>
                    </div>

                    <div class="col-12 form-control-lg">
                        <label for="validationCustomUsername" class="form-label">Mobile</label>
                        <input type="text" class="form-control" name="mobile" autocomplete="off" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please enter your Mobile.
                        </div>
                    </div>

                    <div class="col-12 form-control-lg">
                        <label for="validationCustomUsername" class="form-label">Age</label>
                        <input type="number" class="form-control" name="age" autocomplete="off" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please enter your Mobile.
                        </div>
                    </div>

                    <div class="col-12 form-control-lg">
                        <label for="validationCustomUsername" class="form-label">Country</label>
                        <input type="text" class="form-control" name="country" autocomplete="off" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please enter your Country.
                        </div>
                    </div>

                    <div class="col-12 form-control-lg">
                        <label for="validationCustom01" class="form-label">user photo</label>
                        <input type="file" class="form-control" name="uimage" autocomplete="off" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please enter your photo.
                        </div>
                    </div>

                    <div class="col-12 form-control-lg">
                        <div class="form-check">
                            <input id="vis-yes" type="radio" name="gender" value="1" required>
                            <label for="vis-yes">male</label>
                            <input id="vis-no" type="radio" name="gender" value="2" required>
                            <label for="vis-no">female</label>
                            <div class="invalid-feedback">please check on male or female</div>
                        </div>
                    </div>



                    <div class="col-12 ">
                        <button class="btn btn-primary " type="submit" value="add user">set info</button>
                    </div>

                </form>
            </div>

<?php
        } else {
            header('location:profile.php');
        }
    } else {
        header('location:profile.php');
    }
} else {
    header('location:login.php');
}
include $tpl . ('footer.php');
ob_end_flush();
