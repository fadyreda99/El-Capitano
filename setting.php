<?php
ob_start();
session_start();
$pageTitle = 'setting';
include('int.php');
include $tpl . "navbarUser.php";
$userObject = new users();
$driverObject = new drivers();
$carObject = new cars();
$uprofileObject = new uprofiles();
$feedbackObject = new feedback();

if (isset($_SESSION['userName'])) {
    $getUser        = $userObject->find("User_Name='{$_SESSION["userName"]}'");
    $getdriver      = $driverObject->find("UserID='{$getUser["User_ID"]}'");
    $getcar         = $carObject->find("User_id='{$getUser["User_ID"]}'");
    $getuprofile    = $uprofileObject->find("UID='{$getUser["User_ID"]}'");

    if ($getUser['Group_ID'] == 1) {



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = array();
            $success = array();



            if (isset($_POST['nationalid'])) {
                $national     =   filter_var($_POST['nationalid'], FILTER_SANITIZE_NUMBER_INT);

                if ($national == $getdriver['National_ID']) {

                    $password = $_POST['password'];
                    $repassword = $_POST['repassword'];

                    if (empty($national)) {
                        $errors[] = 'Please Enter Your National ID Correctly';
                    }
                    if (empty($password)) {
                        $errors[] = 'Please Enter Your New Password At Least 6 characters and numbers';
                    }
                    if (empty($repassword)) {
                        $errors[] = 'please write again your password in correctly';
                    }

                    if (isset($password) && isset($repassword)) {
                        if (strlen($password) < 6) {
                            $errors[] = 'password must be more than 6 characters';
                        }
                        if (strlen($password) > 30) {
                            $errors[] = 'password cant be more than 30';
                        }
                        if ($password !== $repassword) {
                            $errors[] = 'the passwords is not match';
                        } else {
                            $passHash1 = password_hash($password, PASSWORD_BCRYPT);
                            $user = $userObject->update(
                                "Password=? WHERE User_ID=?",
                                array($passHash1, $_SESSION["uid"])
                            );

                            $success[] = "your password changed";
                        }
                    }
                } else {
                    $errors[] = 'Your national ID is Wrong Please Try again';
                }
            }

            if (isset($_POST['email'])) {

                $email  =   filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

                if (filter_var($email, FILTER_VALIDATE_EMAIL) != true) {
                    $errors[] = 'this email is not valid';
                }
                if (empty($email)) {
                    $errors[] = 'email cant be empty';
                }

                $count = $userObject->unique("Email='$email' AND User_ID !='{$_SESSION["uid"]}'");
                if ($count > 0) {
                    $errors[] = 'email is exists';
                } else {
                    $user = $userObject->update("Email=? WHERE User_ID=?", array($email, $_SESSION["uid"]));
                    $success[] = "your Email changed";
                }
            }

            if (isset($_POST['username'])) {
                $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                if (empty($username)) {
                    $errors[] = 'user name cant be empty';
                }
                if (strlen($username) < 4) {
                    $errors[] = 'user name must be more than 4 characters';
                }
                if (strlen($username) > 20) {
                    $errors[] = 'user name cant be more than 20';
                }
                $count = $userObject->unique("User_Name='$username' AND User_ID !='{$_SESSION["uid"]}'");
                if ($count > 0) {
                    $errors[] = 'user name is exists';
                } else {
                    $user = $userObject->update("User_Name=? WHERE User_ID=?", array($username, $_SESSION["uid"]));
                    $success[] = "your User Name changed";
                }
            }

            if (isset($_POST['mobile'])) {
                $mobile = filter_var($_POST['mobile'], FILTER_SANITIZE_NUMBER_INT);

                if (preg_match('([a-zA-Z].*[a-zA-Z])', $mobile)) //if last name contains numbers
                {
                    $errors[] = 'phone number can not contain characters only numbers';
                }
                if (strlen($mobile) < 11) {
                    $errors[] = 'phone can not less than 11 ';
                }
                if (strlen($mobile) > 11) {
                    $errors[] = 'phone can not more than 11 ';
                }
                $count = $driverObject->unique("Mobile='$mobile' AND UserID !='{$_SESSION["uid"]}'");
                if ($count > 0) {
                    $errors[] = 'this phone Number already exsists';
                } else {
                    $driver = $driverObject->update(
                        "Mobile=? WHERE UserID =?",
                        array($mobile, $_SESSION["uid"])
                    );
                    $success[] = "your Mobile changed";
                }
            }

            if (isset($_POST['city'])) {
                $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
                if (empty($city)) {
                    $errors[] = 'country cant be empty';
                }

                if (preg_match('([0-9]|[0-9])', $city)) //if country contains numbers
                {
                    $errors[] = 'country can not contain numbers only characters';
                }
                if (strlen($city) < 4) {
                    $errors[] = 'country cant be less than 4';
                }
                if (strlen($city) > 10) {
                    $errors[] = 'country cant be more than 10';
                } else {
                    $driver = $driverObject->update(
                        "Country=? WHERE UserID =?",
                        array($city, $_SESSION["uid"])
                    );
                    $success[] = "your city changed";
                }
            }

            if (isset($_POST['date'])) {
                $date = filter_var($_POST['date'], FILTER_SANITIZE_NUMBER_INT);
                if (empty($date)) {
                    $errors[] = 'date cant be empty';
                } else {
                    $car = $carObject->update(
                        "End_Date_License=? WHERE User_id =?",
                        array($date, $_SESSION["uid"])
                    );
                    $success[] = "end date of license car had changed";
                }
            }

            if (isset($_FILES['dimage'])) {



                //get info of image from form
                $image_name = $_FILES['dimage']['name'];
                $image_type = $_FILES['dimage']['type'];
                $image_tmp = $_FILES['dimage']['tmp_name'];
                $image_size = $_FILES['dimage']['size'];
                $image_error = $_FILES['dimage']['error'];


                //allowed extensions
                $allowedExtensions = array("jpeg", "jpg", "png", "gif", "jfif");


                //get image extension
                $image_extension = explode('.', $image_name);
                $end_extension = end($image_extension);
                $lowerExtension = strtolower($end_extension); // convert extension to lower case

                //driver image validation

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

                if (empty($errors)) {
                    $driver_image = rand(0, 10000000000) . '_' . $image_name;
                    move_uploaded_file($image_tmp, $_SERVER['DOCUMENT_ROOT'] . '\gradproject\images\driverimages\\' . $driver_image);

                    $driver = $driverObject->update(
                        "Driver_Image=? WHERE UserID =?",
                        array($driver_image, $_SESSION["uid"])
                    );
                    $success[] = "your Profile Picture changed";
                }
            }


            if (isset($_FILES['cimage'])) {
                //setting database image name
                $all_image = array();

                $uploaded_files = $_FILES['cimage'];


                //get info of image from form
                $image_name = $uploaded_files['name'];
                $image_type = $uploaded_files['type'];
                $image_tmp = $uploaded_files['tmp_name'];
                $image_size = $uploaded_files['size'];
                $image_error = $uploaded_files['error'];

                //allowed extensions
                $allowedExtensions = array("jpeg", "jpg", "png", "gif", "jfif");

                if ($image_error[0] == 4) {
                    $errors[] = 'no file uploaded ';
                } else {
                    $files_count = count($image_name);

                    for ($i = 0; $i < $files_count; $i++) {
                        $carerrors = array();

                        //get file extension
                        $image_extension[$i] = explode('.', $image_name[$i]);
                        $end_extension[$i] = end($image_extension[$i]);
                        $loweExtension[$i] = strtolower($end_extension[$i]);


                        //get random name for file 
                        $car_image[$i] = rand(0, 10000000000000000) . '.' . $loweExtension[$i];

                        if (!in_array($loweExtension[$i], $allowedExtensions)) {
                            $carerrors[] = '  not valid ';
                        }
                        if ($image_size[$i] > 4194304) {
                            $carerrors[] = 'max size of image is 4MP';
                        }

                        if (empty($carerrors)) {
                            move_uploaded_file($image_tmp[$i], $_SERVER['DOCUMENT_ROOT'] . '\gradproject\images\carimages\\' . $car_image[$i]);
                            //$success_msg[]= 'file number ' . ($i + 1) . ' is uploaded';
                            $all_image[] = $car_image[$i];
                            $image_field = implode(',', $all_image);
                            $car = $carObject->update(
                                "Car_Images=? WHERE User_id =?",
                                array($image_field, $_SESSION["uid"])
                            );

                            //$success_msg[]= 'file number ' . ($i + 1) . ' is uploaded';

                            $success_msg = 'your car images changed';
                        }
                    }
                }
            }
        }


?>
        <div class="setting">
            <div class="container ">
                <?php
                if (!empty($errors)) {
                    foreach ($errors as $err) {
                ?>
                        <div class="alert alert-danger alert-dismissible fade show error-alert error mt-3" role="alert">
                            <?php echo $err ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    }
                }
                if (!empty($success)) {
                    foreach ($success as $suc) {
                    ?>
                        <div class="alert alert-success alert-dismissible fade show error-alert error mt-3" role="alert">
                            <?php echo $suc ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    }
                }

                if (isset($carerrors)) {
                    foreach ($carerrors as $err) {
                    ?>

                        <div class="alert alert-danger alert-dismissible fade show error-alert error mt-3" role="alert">
                            <?php echo 'file number' . ' ' . ($i + 1) . ' is' . $err ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php

                    }
                }

                if (isset($success_msg)) {

                    ?>

                    <div class="alert alert-success alert-dismissible fade show error-alert error mt-3" role="alert">
                        <?php echo ' ' . $success_msg ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php


                }

                ?>
                <h1 class="text-center mt-5">Settings</h1>
                <div class="row">
                    <div class="col-12">

                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Change Password
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">enter your national ID</label>
                                                <input type="text" class="form-control " name="nationalid" autocomplete="off" value="" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please enter your national ID.
                                                </div>
                                            </div>

                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">password</label>
                                                <input type="password" class="form-control " name="password" autocomplete="off" value="" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Enter Your new password.
                                                </div>
                                            </div>

                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">re-password</label>
                                                <input type="password" class="form-control " name="repassword" autocomplete="off" value="" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please rewrite the new password.
                                                </div>
                                            </div>

                                            <div class="col-12  form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                        Change Email
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">Email</label>
                                                <input type="email" class="form-control " name="email" autocomplete="off" value="<?php echo  $getUser['Email'];  ?>" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Enter Your new Email.
                                                </div>
                                            </div>
                                            <div class="col-12  form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="">Update</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingfour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                        Change User Name
                                    </button>
                                </h2>
                                <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingfour" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">username</label>
                                                <input type="text" class="form-control " name="username" autocomplete="off" value="<?php echo  $getUser['User_Name'];  ?>" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Enter Your new username.
                                                </div>
                                            </div>
                                            <div class="col-12  form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                        Change Mobile
                                    </button>
                                </h2>
                                <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">mobile</label>
                                                <input type="text" class="form-control " name="mobile" autocomplete="off" value="<?php echo $getdriver['Mobile'] ?>" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Enter Your new phone number.
                                                </div>
                                            </div>
                                            <div class="col-12  form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                                        Change City
                                    </button>
                                </h2>
                                <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">your city</label>
                                                <input type="text" class="form-control " name="city" autocomplete="off" value="<?php echo $getdriver['Country'] ?>" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Enter Your new city.
                                                </div>
                                            </div>
                                            <div class="col-12  form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>




                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                        Change End date Of car License
                                    </button>
                                </h2>
                                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">end date of license id</label>
                                                <input type="date" class="form-control " name="date" autocomplete="off" value="<?php echo $getcar['End_Date_License'] ?>" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Enter new date of end license id.
                                                </div>
                                            </div>
                                            <div class="col-12  form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingSeven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                                        Change Profile Picture
                                    </button>
                                </h2>
                                <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">

                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" novalidate>


                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label">your photo</label>
                                                <input type="file" class="form-control" name="dimage" autocomplete="off" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Select your photo.
                                                </div>
                                            </div>

                                            <div class="col-12 form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="add user">Update</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>


                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingNine">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseNine" aria-expanded="false" aria-controls="flush-collapseNine">
                                        Change Car Photos
                                    </button>
                                </h2>
                                <div id="flush-collapseNine" class="accordion-collapse collapse" aria-labelledby="flush-headingNine" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">

                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" novalidate>


                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label">car photo</label>
                                                <input type="file" class="form-control" name="cimage[]" autocomplete="off" multiple required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Select car photo.
                                                </div>
                                            </div>

                                            <div class="col-12 form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="add user">Update</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>




    <?php
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = array();
            $success = array();
            if (isset($_POST['phone'])) {
                $phone     =   filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
                if ($phone == $getuprofile['Mobile']) {
                    $password = $_POST['password'];
                    $repassword = $_POST['repassword'];

                    if (empty($phone)) {
                        $errors[] = 'Please Enter Your National ID Correctly';
                    }

                    if (empty($password)) {
                        $errors[] = 'Please Enter Your New Password At Least 6 characters and numbers';
                    }

                    if (empty($repassword)) {
                        $errors[] = 'please write again your password in correctly';
                    }

                    if (isset($password) && isset($repassword)) {
                        if (strlen($password) < 6) {
                            $errors[] = 'password must be more than 6 characters';
                        }
                        if (strlen($password) > 30) {
                            $errors[] = 'password cant be more than 30';
                        }
                        if ($password !== $repassword) {
                            $errors[] = 'the passwords is not match';
                        } else {
                            $passHash1 = password_hash($password, PASSWORD_BCRYPT);
                            $user = $userObject->update(
                                "Password=? WHERE User_ID=?",
                                array($passHash1, $_SESSION["uid"])
                            );

                            $success[] = "your password changed";
                        }
                    }
                } else {
                    $errors[] = 'Your Phone Number is Wrong Please Try again';
                }
            }

            if (isset($_POST['email'])) {

                $email  =   filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

                if (filter_var($email, FILTER_VALIDATE_EMAIL) != true) {
                    $errors[] = 'this email is not valid';
                }
                if (empty($email)) {
                    $errors[] = 'email cant be empty';
                }

                $count = $userObject->unique("Email='$email' AND User_ID !='{$_SESSION["uid"]}'");
                if ($count > 0) {
                    $errors[] = 'email is exists';
                } else {
                    $user = $userObject->update("Email=? WHERE User_ID=?", array($email, $_SESSION["uid"]));
                    $success[] = "your Email changed";
                }
            }


            if (isset($_POST['username'])) {
                $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                if (empty($username)) {
                    $errors[] = 'user name cant be empty';
                }
                if (strlen($username) < 4) {
                    $errors[] = 'user name must be more than 4 characters';
                }
                if (strlen($username) > 20) {
                    $errors[] = 'user name cant be more than 20';
                }
                $count = $userObject->unique("User_Name='$username' AND User_ID !='{$_SESSION["uid"]}'");
                if ($count > 0) {
                    $errors[] = 'user name is exists';
                } else {
                    $user = $userObject->update("User_Name=? WHERE User_ID=?", array($username, $_SESSION["uid"]));
                    $success[] = "your User Name changed";
                }
            }

            if (isset($_POST['mobile'])) {
                $mobile = filter_var($_POST['mobile'], FILTER_SANITIZE_NUMBER_INT);

                if (preg_match('([a-zA-Z].*[a-zA-Z])', $mobile)) //if last name contains numbers
                {
                    $errors[] = 'phone number can not contain characters only numbers';
                }
                if (strlen($mobile) < 11) {
                    $errors[] = 'phone can not less than 11 ';
                }
                if (strlen($mobile) > 11) {
                    $errors[] = 'phone can not more than 11 ';
                }
                $count = $uprofileObject->unique("Mobile='$mobile' AND UID !='{$_SESSION["uid"]}'");
                if ($count > 0) {
                    $errors[] = 'this phone Number already exsists';
                } else {
                    $user = $uprofileObject->update(
                        "Mobile=? WHERE UID =?",
                        array($mobile, $_SESSION["uid"])
                    );
                    $success[] = "your Mobile changed";
                }
            }

            if (isset($_POST['city'])) {
                $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
                if (empty($city)) {
                    $errors[] = 'country cant be empty';
                }

                if (preg_match('([0-9]|[0-9])', $city)) //if country contains numbers
                {
                    $errors[] = 'country can not contain numbers only characters';
                }
                if (strlen($city) < 4) {
                    $errors[] = 'country cant be less than 4';
                }
                if (strlen($city) > 10) {
                    $errors[] = 'country cant be more than 10';
                } else {
                    $user = $uprofileObject->update(
                        "Country=? WHERE UID =?",
                        array($city, $_SESSION["uid"])
                    );
                    $success[] = "your city changed";
                }
            }

            if (isset($_FILES['uimage'])) {
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

                if (empty($errors)) {
                    $user_image = rand(0, 10000000000) . '_' . $image_name;
                    move_uploaded_file($image_tmp, $_SERVER['DOCUMENT_ROOT'] . '\gradproject\images\userimages\\' . $user_image);

                    $user = $uprofileObject->update(
                        "User_Image=? WHERE UID =?",
                        array($user_image, $_SESSION["uid"])
                    );
                    $success[] = "your profile picure changed";
                }
            }
        }
    ?>
        <div class="setting2 ">
            <div class="container ">
                <?php
                if (!empty($errors)) {
                    foreach ($errors as $err) {
                ?>
                        <div class="alert alert-danger alert-dismissible fade show error-alert error mt-3" role="alert">
                            <?php echo $err ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    }
                }
                if (!empty($success)) {
                    foreach ($success as $suc) {
                    ?>
                        <div class="alert alert-success alert-dismissible fade show error-alert error mt-3" role="alert">
                            <?php echo $suc ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php
                    }
                }

                ?>
                <h1 class="text-center mt-5">Settings</h1>
                <div class="row">
                    <div class="col-12">

                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Change Password
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">enter your Phone number</label>
                                                <input type="text" class="form-control " name="phone" autocomplete="off" value="" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Enter Your Phone number.
                                                </div>
                                            </div>

                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">password</label>
                                                <input type="password" class="form-control " name="password" autocomplete="off" value="" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Enter Your new password.
                                                </div>
                                            </div>

                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">re-password</label>
                                                <input type="password" class="form-control " name="repassword" autocomplete="off" value="" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please rewite new password.
                                                </div>
                                            </div>

                                            <div class="col-12  form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                        Change Email
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">Email</label>
                                                <input type="email" class="form-control " name="email" autocomplete="off" value="<?php echo  $getUser['Email'];  ?>" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Enter Your new email.
                                                </div>
                                            </div>
                                            <div class="col-12  form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="">Update</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingfour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                        Change User Name
                                    </button>
                                </h2>
                                <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingfour" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">username</label>
                                                <input type="text" class="form-control " name="username" autocomplete="off" value="<?php echo  $getUser['User_Name'];  ?>" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Enter Your new username.
                                                </div>
                                            </div>
                                            <div class="col-12  form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                        Change Mobile
                                    </button>
                                </h2>
                                <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">mobile</label>
                                                <input type="text" class="form-control " name="mobile" autocomplete="off" value="<?php echo $getuprofile['Mobile'] ?>" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Enter Your new phone number.
                                                </div>
                                            </div>
                                            <div class="col-12  form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                                        Change City
                                    </button>
                                </h2>
                                <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label ">your city</label>
                                                <input type="text" class="form-control " name="city" autocomplete="off" value="<?php echo $getuprofile['Country'] ?>" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Enter Your new city.
                                                </div>
                                            </div>
                                            <div class="col-12  form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingSeven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                                        Change Profile Picture
                                    </button>
                                </h2>
                                <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">

                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" novalidate>


                                            <div class="col-12 form-control-lg">
                                                <label for="validationCustom01" class="form-label">your photo</label>
                                                <input type="file" class="form-control" name="uimage" autocomplete="off" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please Select your photo.
                                                </div>
                                            </div>

                                            <div class="col-12 form-control-lg">
                                                <button class="btn btn-primary " type="submit" value="add user">Update</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
<?php
    }
    include $tpl . ('footer.php');
} else {
    header('location:login.php');
}
ob_end_flush();