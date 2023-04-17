<?php
ob_start();
session_start();
$pageTitle = 'cars';

if (isset($_SESSION['admin'])) {
    include('int.php');

    $carObject = new cars();
    $driverObject = new drivers();
    $userObject = new users();
    $categoryObject = new categories();


    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'manage';
    }



    //start manage page
    if ($do == 'manage') {

        $query = ' ';
        if (isset($_GET['page']) && $_GET['page'] == 'carsInCategory') {
            $categoryid = isset($_GET['categoryid']) && is_numeric($_GET['categoryid']) ? intval($_GET['categoryid']) : 0; //short if condition

            $query = "AND CatID='$categoryid'";
        }
        $cars = $carObject->joins(
            "users.User_Name  AS userName, categories.Category_Name AS Category",
            "INNER JOIN users        ON users.User_ID            = cars.User_id
                                        INNER JOIN categories   ON categories.Category_ID   = cars.CatID
                                        $query AND Group_ID=1 "
        );

        if (!empty($cars)) {
?>

            <h1 class="text-center edit">cars</h1>
            <div class="container ">
                <div class="table-responsive">
                    <table class="table main-table text-center  ">
                        <thead>
                            <tr>
                                <td class=""> # </td>
                                <td class=""> Car Type </td>
                                <td class=""> Car Color </td>
                                <td class=""> Car number </td>
                                <td class=""> User Name </td>
                                <td class=""> Category </td>
                                <td class=""> controlls </td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($cars as $car) {  ?>
                                <tr>
                                    <td><?php echo $car['Car_ID'] ?></td>
                                    <td><?php echo $car['Car_Type'] ?></td>
                                    <td><?php echo $car['Car_Color'] ?></td>
                                    <td><?php echo $car['Car_Number'] ?> | <?php echo $car['Car_Characters'] ?></td>

                                    <td>
                                        <a class="view" href="drivers.php?do=view&driverid=<?php echo $car['User_id'] ?>">
                                            <?php echo $car['userName'] ?>
                                        </a>
                                    </td>
                                    <td><?php echo $car['Category'] ?></td>

                                    <td class="">
                                        <a href="cars.php?do=delete&carid=<?php echo $car['Car_ID'] ?>" class="btn btn-danger confirm"> <i class="fa fa-close"></i>Delete</a>
                                        <a href="cars.php?do=edit&carid=<?php echo $car['Car_ID'] ?>" class="btn btn-primary "> <i class="fa fa-edit"></i>edit</a>

                                    </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <a class="btn btn-danger mb-5" href="cars.php?do=search">search</a>
            </div>

        <?php
        } else {
            echo '<div class="container">';
            echo '<div class="nice-msg alert alert-danger">no records to show</div>';
        ?>

        <?php
            echo '</div>';
        }
    } elseif ($do == 'search') {
        if (isset($_POST['search'])) {
            $searchq = $_POST['search'];
            $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);

            /* $stmt=$conn->prepare("SELECT * FROM users WHERE User_Name LIKE '%$searchq%'");
            $stmt->execute();
            $count=$stmt->rowCount();*/

            $cars = $carObject->joins(
                "users.User_Name  AS userName, categories.Category_Name AS Category",
                "INNER JOIN users        ON users.User_ID            = cars.User_id
             INNER JOIN categories   ON categories.Category_ID   = cars.CatID
             WHERE Car_Type LIKE '%$searchq%'
             OR Car_Number LIKE '%$searchq%'
             OR Car_Characters LIKE '%$searchq%'
             OR License_Car_ID  LIKE '%$searchq%'
             OR users.User_Name  LIKE '%$searchq%'"
            );



            $out = ' ';

            if (!empty($cars)) {
                $out .= '
                <div class="container con-search">
                    <div class="table-responsive">
                        <table class="table main-table text-center  t-search">
                            <thead>
                                <tr>
                                <td class="" >#</td>
                                <td class="" >type</td>
                                <td class="">   color  </td>
                                <td class="" > Car number    </td>
                                <td class="">  license   </td>
                                <td class="" > User Name     </td>
                                <td class="" > Category      </td>
                              
                               
                                <td class="" >controlls</td>
                                </tr>
                            </thead>';
                foreach ($cars as $car) {
                    $out .= '    
                            <tbody>
                                <tr>
                                <td>' . $car['Car_ID'] . '</td>
                                 <td>' . $car['Car_Type'] . '</td>
                                <td>' . $car['Car_Color'] . '</td>
                                <td>' . $car['Car_Number'] . ' | ' . $car['Car_Characters'] . '</td>
                                <td>' . $car['License_Car_ID'] . '</td>
                                <td>
                                <a class="view" href="drivers.php?do=view&driverid=' . $car['User_id'] . '">' .
                        $car['userName'] .
                        '</a>
                                </td>
                               <td>' . $car['Category'] . '</td>
                                
                                <td class="" >
                                 <a href="cars.php?do=delete&carid=' . $car['Car_ID'] . '" class="btn btn-danger confirm">
                                    <i class="fa fa-close"></i>
                                    Delete
                                 </a>
                                 </td>
                               
                                </tr>
                            </tbody>';
                }
                $out .= ' 
                        </table>
                    </div>
                </div>';
            } else {
                $out = '<div class="alert alert-success text-center test">there was no member</div> ';
            }
        }
        ?>

        <h1 class="text-center sh">Search </h1>
        <form action="cars.php?do=search" method="POST">
            <div class="col-md-4 text-center mx-auto">
                <div class="input-group has-validation search ">
                    <input type="text" class="form-control fsearch" name="search" id="validationCustomUsername" aria-describedby="inputGroupPrepend" placeholder="Search">
                    <input class="btn btn-danger" type="submit" value="Search">
                </div>
            </div>
        </form>


        <?php


        if (!empty($out)) {
            print_r("$out");
        }
    }


    //start edit page
    elseif ($do == 'edit') {

        $carid = isset($_GET['carid']) && is_numeric($_GET['carid']) ? intval($_GET['carid']) : 0; //short if condition
        $car = $carObject->find("Car_ID ='$carid'");
        ?>

        <h1 class="text-center edit">Edit cars</h1>
        <div class="container ">
            <form class="row g-3 needs-validation edit-from  " action="cars.php?do=update" method="POST" novalidate>
                <input type="hidden" name="carid" value="<?php echo $carid ?>">

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label "> Type Of Car</label>
                    <input type="text" class="form-control " name="type" autocomplete="off" value="<?php echo $car['Car_Type'] ?>" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please Enter Your Type Of Car.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">Color Of Car</label>
                    <select class="form-select" aria-label="Default select example" name="color" required>

                        <option value="red" <?php if ($car['Car_Color'] == "red") {
                                                echo 'selected';
                                            } ?>>red</option>
                        <option value="green" <?php if ($car['Car_Color'] == 'green') {
                                                    echo 'selected';
                                                } ?>>green</option>
                        <option value="blue" <?php if ($car['Car_Color'] == 'blue') {
                                                    echo 'selected';
                                                } ?>>blue</option>
                        <option value="black" <?php if ($car['Car_Color'] == 'black') {
                                                    echo 'selected';
                                                } ?>>black</option>
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
                    <input type="text" class="form-control" name="number" autocomplete="off" value="<?php echo $car['Car_Number'] ?>" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter number of car.
                    </div>
                </div>
                <div class="col-12 form-control-lg">
                    <label for="validationCustomUsername" class="form-label">characters Of Car</label>
                    <input type="text" class="form-control" name="char" autocomplete="off" value="<?php echo $car['Car_Characters'] ?>" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please characters of car.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustomUsername" class="form-label">Car License ID</label>
                    <input type="text" class="form-control" name="licenseid" autocomplete="off" value="<?php echo $car['License_Car_ID'] ?>" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter car license id.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustomUsername" class="form-label">End Date Of License</label>
                    <input type="date" class="form-control" name="date" autocomplete="off" value="<?php echo $car['End_Date_License'] ?>" required>
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

                        <?php
                        $categories = $categoryObject->all3();
                        foreach ($categories as $category) {

                            echo "<option value='" . $category['Category_ID'] . "'";
                            if ($car['CatID'] == $category['Category_ID']) {
                                echo 'selected';
                            }
                            echo ">" . $category['Category_Name'] . "</option>";
                        }
                        ?>
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter name of category.
                    </div>
                </div>






                <div class="col-12 ">
                    <button class="btn btn-primary " type="submit" value="update">Update</button>
                </div>
            </form>
        </div>
<?php
    }

    //start update page
    elseif ($do == 'update') {
        echo '<h1 class="text-center edit">Update Drivers</h1>';
        echo '<div class="container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $carid = $_POST['carid'];
            $type = $_POST['type'];
            $color = $_POST['color'];
            $number = $_POST['number'];
            $char = $_POST['char'];
            $licenseid = $_POST['licenseid'];
            $date = $_POST['date'];
            $category = $_POST['category'];

            //car tybe validation

            if (strlen($type) < 2) {
                $errors[] = 'first name cant be less than 4';
            }
            if (strlen($type) > 20) {
                $errors[] = 'first name cant be more than 20';
            }
            if (empty($type)) {
                $errors[] = 'first name cant be empty';
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
                $errors[] = 'country can not contain numbers only characters';
            }
            if (strlen($char) < 3) {
                $errors[] = 'country cant be less than 4';
            }
            if (strlen($char) > 4) {
                $errors[] = 'country cant be more than 10';
            }
            if (empty($char)) {
                $errors[] = 'country cant be empty';
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
            $count = $carObject->unique("License_Car_ID ='$licenseid' AND Car_ID !='$carid'");
            if ($count > 0) {
                $errors[] = 'car license id is exists';
            }
            //end date of license validation


            if (empty($date)) {
                $errors[] = 'country cant be empty';
            }

            if (isset($errors)) {
                foreach ($errors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
            } else {

                $car = $carObject->update(
                    "Car_Type=?, Car_Color=?, Car_Number=?, Car_Characters=?, License_Car_ID=?, End_Date_License=?, CatID=?  WHERE Car_ID=?",
                    array($type, $color, $number, $char, $licenseid, $date, $category, $carid)
                );

                echo "<div class='container'>";
                $theMsg = '<div class="alert alert-success"> record has updated </div>';
                redirectHome($theMsg, 'back');
                echo "</div>";
            }
        } else {
            $theMsg = '<div class="alert alert-danger">you cant inter here</div>';
            redirectHome($theMsg);
        }
        echo '</div>';
    }

    //start delete page
    elseif ($do == 'delete') {
        echo '<h1 class="text-center edit">Delete Users</h1>';
        echo '<div class="container ">';
        $carid = isset($_GET['carid']) && is_numeric($_GET['carid']) ? intval($_GET['carid']) : 0; //short if
        $count = $carObject->unique("Car_ID ='$carid'");

        if ($count > 0) {
            $car = $carObject->delete("Car_ID ='$carid'");
            $theMsg = '<div class="alert alert-success"> record has deleted </div>';
            redirectHome($theMsg, 'back');
        } else {
            $theMsg = '<div class="alert alert-danger">this id is not exsits</div>';
            redirectHome($theMsg);
        }
        echo '</div>';
    }



    include $tpl . ('footer.php');
} else {
    header('location: ../prehome.php');
    exit();
}


ob_end_flush();
