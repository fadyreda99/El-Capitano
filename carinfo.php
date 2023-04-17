<?php
ob_start();
session_start();
if (isset($_SESSION['userName'])) {
    $pageTitle = 'car infromation';
    include('int.php');
    include $tpl . "navbarUser.php";
    $categoryObject = new categories();
    $carObject = new cars();
    $userObject = new users();
    $driverid = $_SESSION['uid'];
    $car = $carObject->find("User_id='$driverid'");
    $user = $userObject->find("User_Name='{$_SESSION['userName']}'");

    if ($user['Group_ID'] == 1) {
        if (empty($car)) {


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $errors = array();

                $color = $_POST['color'];
                $category = $_POST['category'];
                $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
                $number = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
                $char = filter_var($_POST['char'], FILTER_SANITIZE_STRING);
                $licenseid = filter_var($_POST['licenseid'], FILTER_SANITIZE_NUMBER_INT);
                $date = filter_var($_POST['date'], FILTER_SANITIZE_NUMBER_INT);


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
                            $success_msg[] = 'file number ' . ($i + 1) . ' is uploaded';
                            $all_image[] = $car_image[$i];
                        }
                    }
                }
                $image_field = implode(',', $all_image);




                //car tybe validation

                if (strlen($type) < 2) {
                    $errors[] = 'type cant be less than 4';
                }
                if (strlen($type) > 20) {
                    $errors[] = 'type cant be more than 20';
                }
                if (empty($type)) {
                    $errors[] = 'type cant be empty';
                }

                //car color validation

                if (empty($color)) {
                    $errors[] = 'color cant be empty';
                }

                //car number validation
                if (preg_match('([a-zA-Z].*[a-zA-Z])', $number)) //if last name contains numbers
                {
                    $errors[] = 'car number can not contain characters only numbers';
                }
                if (strlen($number) < 3) {
                    $errors[] = 'car number can not less than 3 ';
                }
                if (strlen($number) > 4) {
                    $errors[] = 'car number can not more than 4 ';
                }
                if (empty($number)) {
                    $errors[] = 'car number cant be empty';
                }






                //car characters validation
                if (preg_match('([0-9]|[0-9])', $char)) //if car characters contains numbers
                {
                    $errors[] = 'chars can not contain numbers only characters';
                }
                if (strlen($char) < 3) {
                    $errors[] = 'chars cant be less than 3';
                }
                if (strlen($char) > 4) {
                    $errors[] = 'chars cant be more than 4';
                }
                if (empty($char)) {
                    $errors[] = 'chars cant be empty';
                }



                //car license id validation
                if (preg_match('([a-zA-Z].*[a-zA-Z])', $licenseid)) //if car license id contains letters
                {
                    $errors[] = 'license id can not contain characters only numbers';
                }
                if (strlen($licenseid) < 14) {
                    $errors[] = 'license id cant be less than 14';
                }
                if (strlen($licenseid) > 14) {
                    $errors[] = 'license id cant be more than 14';
                }
                if (empty($licenseid)) {
                    $errors[] = 'license id cant be empty';
                }

                $count = $carObject->unique("License_Car_ID ='$licenseid'");
                if ($count > 0) {
                    $errors[] = 'car license id is exists';
                }


                //end date of license validation


                if (empty($date)) {
                    $errors[] = 'date cant be empty';
                }


                //category validation
                if (empty($category)) {
                    $errors[] = 'category cant be empty';
                }


                if (empty($errors)) {
                    if (empty($carerrors)) {

                        $carObject->insert(
                            "(Car_Type, Car_Color, Car_Number, Car_Characters, License_Car_ID, End_Date_License, User_id, CatID ,Car_Images) VALUES (?,?,?,?,?,?,?,?,?)",
                            array($type, $color, $number, $char, $licenseid, $date, $_SESSION['uid'], $category, $image_field)
                        );
                        if ($carObject) {
                            header('location:profile.php');
                        }
                    }
                }
            }
?>



            <h1 class="text-center edit">set car information</h1>
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

                if (isset($carerrors)) {
                    foreach ($carerrors as $err) {
                    ?>

                        <div class="alert alert-danger alert-dismissible fade show error-alert" role="alert">
                            <?php echo 'file number' . ' ' . ($i + 1) . ' is' . $err ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php

                    }
                }

                if (isset($success_msg)) {
                    foreach ($success_msg as $msg) {
                    ?>

                        <div class="alert alert-success alert-dismissible fade show error-alert" role="alert">
                            <?php echo ' ' . $msg ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php

                    }
                }


                ?>
                <form class="row g-3 needs-validation edit-from  " action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" novalidate>

                    <div class="col-12 form-control-lg">
                        <label for="validationCustom01" class="form-label ">Type Of Car</label>
                        <input type="text" class="form-control " name="type" autocomplete="off" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please enter type of car.
                        </div>
                    </div>

                    <div class="col-12 form-control-lg">
                        <label for="validationCustom01" class="form-label ">Color Of Car</label>
                        <select class="form-select" aria-label="Default select example" name="color" required>
                            <option value="">...</option>
                            <option value="red">red</option>
                            <option value="green">green</option>
                            <option value="blue">blue</option>
                            <option value="black">black</option>
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please enter color of car.
                        </div>
                    </div>




                    <div class="col-12 form-control-lg">
                        <label for="validationCustomUsername" class="form-label">Number Of Car</label>
                        <input type="text" class="form-control" name="number" autocomplete="off" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please enter number of car.
                        </div>
                    </div>
                    <div class="col-12 form-control-lg">
                        <label for="validationCustomUsername" class="form-label">characters Of Car</label>
                        <input type="text" class="form-control" name="char" autocomplete="off" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please characters of car.
                        </div>
                    </div>

                    <div class="col-12 form-control-lg">
                        <label for="validationCustomUsername" class="form-label">Car License ID</label>
                        <input type="text" class="form-control" name="licenseid" autocomplete="off" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please enter car license id.
                        </div>
                    </div>

                    <div class="col-12 form-control-lg">
                        <label for="validationCustomUsername" class="form-label">End Date Of License</label>
                        <input type="date" class="form-control" name="date" autocomplete="off" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please choose end date of car license.
                        </div>
                    </div>



                    <div class="col-12 form-control-lg">
                        <label for="validationCustom01" class="form-label ">Categories</label>
                        <select class="form-select" aria-label="Default select example" name="category" required>
                            <option value="">...</option>
                            <?php
                            $categories = $categoryObject->all3();
                            foreach ($categories as $category) {

                                echo "<option value='" . $category['Category_ID'] . "'>" . $category['Category_Name'] . "</option>";
                            }
                            ?>
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please choose category name of your car.
                        </div>
                    </div>

                    <div class="col-12 form-control-lg">
                        <label for="validationCustom01" class="form-label">car photos</label>
                        <input type="file" class="form-control" name="cimage[]" autocomplete="off" multiple required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please select car images.
                        </div>
                    </div>



                    <div class="col-12 ">
                        <button class="btn btn-primary " type="submit" value="add user">add car</button>
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
    include $tpl . ('footer.php');
} else {
    header('location:login.php');
}
ob_end_flush();
