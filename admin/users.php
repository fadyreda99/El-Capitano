<?php
ob_start();

session_start();
$pageTitle = 'users';

if (isset($_SESSION['admin'])) {
    include('int.php');

    $userObject = new users();
    $uprofileObject = new uprofiles();
    $tripObject = new trips();

    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'manage';
    }



    //start manage page
    if ($do == 'manage') {

        $users = $userObject->all(" Group_ID = 0  ORDER BY User_ID  DESC");
        if (!empty($users)) {
?>

            <h1 class="text-center edit">Users</h1>
            <div class="container ">
                <div class="table-responsive">
                    <table class="table main-table text-center  ">
                        <thead>
                            <tr>
                                <td class="">#</td>
                                <td class="">User Name</td>
                                <td class="">Email</td>
                                <td class="">Registration Date</td>
                                <td class="">controlls</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($users as $user) {  ?>
                                <tr>
                                    <td><?php echo $user['User_ID'] ?></td>
                                    <td><?php echo $user['User_Name'] ?></td>
                                    <td><?php echo $user['Email'] ?></td>
                                    <td><?php echo $user['Date'] ?></td>
                                    <td class="">
                                        <a href="users.php?do=delete&userid=<?php echo $user['User_ID'] ?>" class="btn btn-danger confirm"> <i class="fa fa-close"></i>Delete</a>
                                        <a href="users.php?do=view&userid=<?php echo $user['User_ID'] ?>" class="btn btn-primary "> <i class="fa fa-user"></i>view</a>

                                    </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <a class="btn btn-danger" href="users.php?do=search">search</a>
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

            $stmt = $conn->prepare("SELECT * FROM users WHERE User_Name LIKE '%$searchq%'");
            $stmt->execute();
            $count = $stmt->rowCount();



            $out = ' ';

            if ($count > 0) {
                while ($row = $stmt->fetch()) {
                    $id = $row['User_ID'];
                    $username = $row['User_Name'];
                    $email = $row['Email'];
                    $regdate = $row['Date'];

                    $out .= '
                            <div class="container con-search">
                                <div class="table-responsive">
                                    <table class="table main-table text-center  t-search">
                                        <thead>
                                            <tr>
                                            <td class="" >#</td>
                                            <td class="" >User Name</td>
                                            <td class="" >Email</td>
                                            <td class="" >Registration Date</td>
                                            <td class="" >controlls</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>' . $id . '</td>
                                            <td>' . $username . '</td>
                                            <td>' . $email . '</td>
                                            <td>' . $regdate . '</td>
                                            <td class="" >
                                                        <a href="users.php?do=delete&userid=' . $row['User_ID'] . '" class="btn btn-danger confirm"> <i class="fa fa-close"></i>Delete</a>
                                                        <a href="users.php?do=view&userid=' . $row['User_ID'] . '" class="btn btn-primary"> <i class="fa fa-user"></i>view</a>

  
                                                    </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>';
                }
            } else {
                $out = '<div class="alert alert-success text-center test">there was no member</div> ';
            }
        }
        ?>

        <h1 class="text-center sh">Search </h1>
        <form action="users.php?do=search" method="POST">
            <div class="col-md-4 text-center mx-auto">
                <div class="input-group has-validation search ">
                    <input type="text" class="form-control fsearch" name="search" id="validationCustomUsername" aria-describedby="inputGroupPrepend" placeholder="Search " required>
                    <input class="btn btn-danger" type="submit" value="Search">
                </div>
            </div>
        </form>


        <?php


        if (!empty($out)) {
            print_r("$out");
        }
    } elseif ($do == 'view') {

        $userid = $_GET['userid'];
        $user = $userObject->find("User_ID='$userid'");
        $uprofile = $uprofileObject->find("UID='$userid'");

        if (empty($uprofile['User_Image'])) { ?>
            <img src="../images/image.JFIF" class=" user-image img-thumbnail img-circle " alt="...">

        <?php

        } else {
            echo " <img src='../images/userimages/" . $uprofile['User_Image'] . "' class=' user-image img-thumbnail img-circle ' alt=''>";
        }


        $finish = $tripObject->unique("UserID ='{$uprofile['UID']}' AND Status= 1 ");
        $unfinish = $tripObject->unique("UserID ='{$uprofile['UID']}' AND Status= 0 ");
        $cancel = $tripObject->unique("UserID ='{$uprofile['UID']}' AND Status= 2 ");

        ?>
        <div class="container">
            <div class="bg-light p-4 mb-2 counttrips2">




                <div class=" d-flex justify-content-center text-center">

                    <ul class="list-inline mb-0 counts">
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block"> <a href="alltrips.php?do=finished"><?php echo $finish  ?></h5><small class="text-muted"> finished</small></a>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block"><a href="alltrips.php?do=unfinish"><?php echo $unfinish  ?></h5><small class="text-muted"> unfinished</small></a>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block"> <a href="alltrips.php?do=cancelled"><?php echo $cancel  ?></h5><small class="text-muted"> cancelled</small></a>
                        </li>
                    </ul>
                </div>

                <div class="rate d-flex justify-content-start" id="avgrating">






                </div>

            </div>

        </div>



        <div class="container profile-parent">
            <div class="card border-default general-information mb-2">
                <div class="card-header bg-default">general information </div>
                <ul class="  list-group list-group-flush card-body">

                    <li class="list-group-item">
                        <i class="fas fa-user-tag"></i>
                        <span> User Name </span> : <?php echo $user['User_Name'] ?>
                    </li>

                    <li class="list-group-item">
                        <i class="fas fa-envelope-open-text"></i>
                        <span> Email </span> : <?php echo $user['Email'] ?>
                    </li>


                </ul>
            </div>

            <?php
            if (!empty($uprofile)) { ?>

                <div class="card border-default personal-information mb-2">
                    <div class="card-header bg-default">Personal information </div>
                    <ul class="  list-group list-group-flush card-body">


                        <li class="list-group-item">
                            <i class="fas fa-user"></i>
                            <span> First Name </span> : <?php echo $uprofile['First_Name'] ?>
                        </li>

                        <li class="list-group-item">
                            <i class="fas fa-user"></i>
                            <span> Last Name </span> : <?php echo $uprofile['Last_Name'] ?>
                        </li>

                        <li class="list-group-item">
                            <i class="fas fa-mobile"></i>
                            <span> Mobile </span> : <?php echo $uprofile['Mobile'] ?>
                        </li>

                        <li class="list-group-item">
                            <i class="fa fa-calendar fa-fw"></i>
                            <span> Age </span> : <?php echo $uprofile['Age'] ?>
                        </li>

                        <li class="list-group-item">
                            <i class="fas fa-flag"></i>
                            <span> Country </span> : <?php echo $uprofile['Country'] ?>
                        </li>

                    </ul>
                </div>



            <?php     } else {
                echo '<div class="info-error alert alert-danger">there is no personal information</div>';
            } ?>



            <div class="per-buttons">

                <?php if (!empty($uprofile)) { ?>
                    <a href="users.php?do=edit&profileid=<?php echo $uprofile['Profile_ID'] ?>" class="btn btn-success">
                        <i class="fa fa-edit"></i>
                        Presonal Info
                    </a>
                <?php } ?>


                <a href="users.php?do=editBasic&userid=<?php echo $user['User_ID'] ?>" class="btn btn-secondary">
                    <i class="fa fa-edit"></i>
                    basic Info
                </a>
                <a href="clienttrips.php?do=manage&userid=<?php echo $user['User_ID'] ?>" class="btn btn-primary ">trips</a>


            </div>

        </div>



    <?php

    }

    //start edit page
    elseif ($do == 'edit') {

        $profileid = isset($_GET['profileid']) && is_numeric($_GET['profileid']) ? intval($_GET['profileid']) : 0; //short if condition
        $uprofile = $uprofileObject->find("Profile_ID='$profileid'");
    ?>

        <h1 class="text-center edit">Edit user info</h1>
        <div class="container ">
            <form class="row g-3 needs-validation edit-from  " action="users.php?do=update" method="POST" novalidate>
                <input type="hidden" name="profileid" value="<?php echo $profileid ?>">

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">First Name</label>
                    <input type="text" class="form-control " name="firstname" autocomplete="off" value="<?php echo $uprofile['First_Name'] ?>" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please Enter Your First Name.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustom02" class="form-label">Last Name</label>
                    <input type="text" class="password form-control" name="lastname" autocomplete="off" value="<?php echo $uprofile['Last_Name'] ?>" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please Enter Your Last Name.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustomUsername" class="form-label">Mobile</label>
                    <input type="text" class="form-control" name="mobile" autocomplete="off" value="<?php echo $uprofile['Mobile'] ?>" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please Enter Your Mobile.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustomUsername" class="form-label">Age</label>
                    <input type="number" class="form-control" name="age" autocomplete="off" value="<?php echo $uprofile['Age'] ?>" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please Enter Your Age.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustomUsername" class="form-label">Country</label>
                    <input type="text" class="form-control" name="country" autocomplete="off" value="<?php echo $uprofile['Country'] ?>" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please Enter Your Country.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <div class="form-check">
                        <input id="vis-yes" type="radio" name="gender" value="1" <?php if ($uprofile['Gender'] == 1) {
                                                                                        echo 'checked';
                                                                                    } ?> required>
                        <label for="vis-yes">male</label>
                        <input id="vis-no" type="radio" name="gender" value="2" <?php if ($uprofile['Gender'] == 2) {
                                                                                    echo 'checked';
                                                                                } ?> required>
                        <label for="vis-no">female</label>
                        <div class="invalid-feedback">please check on male or female</div>
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

            $profileid = $_POST['profileid'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $mobile = $_POST['mobile'];
            $age = $_POST['age'];
            $country = $_POST['country'];
            $gender = $_POST['gender'];


            //first name validation
            if (preg_match('([0-9]|[0-9])', $firstname)) //if first name contains numbers
            {
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
            if (preg_match('([0-9]|[0-9])', $lastname)) //if first name contains numbers
            {
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
            $count = $uprofileObject->unique("Mobile='$mobile' AND Profile_ID !='$profileid' ");
            if ($count > 0) {
                $errors[] = 'this user names already exsists';
            }

            //age validation
            if (preg_match('([a-zA-Z].*[a-zA-Z])', $age)) //if age contains letters
            {
                $errors[] = 'phone number can not contain characters only numbers';
            }
            if (strlen($age) > 2) {
                $errors[] = 'age cant be more than 20';
            }
            if (empty($age)) {
                $errors[] = 'first name cant be empty';
            }
            if ($age >= '60') {
                $errors[] = 'you not available';
            }

            //country validation
            if (preg_match('([0-9]|[0-9])', $country)) //if country contains numbers
            {
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

            // radio validation
            if ($gender != 1) {
                if ($gender != 2) {
                    $errors[] = 'please choose you will be a male or female?';
                }
            }



            if (isset($errors)) {
                foreach ($errors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
            } else {

                $uprofile = $uprofileObject->update(
                    "First_Name=?, Last_Name=?, Mobile=?, Age=?, Country=?, Gender=? WHERE Profile_ID =?",
                    array($firstname, $lastname, $mobile, $age, $country, $gender, $profileid)
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



    //start edit basic information page
    elseif ($do == 'editBasic') {

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; //short if condition
        $user = $userObject->find("User_ID='$userid'");
    ?>

        <h1 class="text-center edit">add new User</h1>
        <div class="container ">
            <form class="row g-3 needs-validation edit-from  " action="users.php?do=updateBasic" method="POST" novalidate>
                <input type="hidden" name="userid" value="<?php echo $userid ?>">

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">User name</label>
                    <input type="text" class="form-control " name="username" required autocomplete="off" value="<?php echo $user['User_Name'] ?>">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter username.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustomUsername" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required aria-describedby="inputGroupPrepend" autocomplete="off" value="<?php echo $user['Email'] ?>">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please choose a email.
                    </div>
                </div>

                <div class="col-12 form-control-lg">
                    <label for="validationCustom02" class="form-label">Password</label>
                    <input type="password" class="password form-control" name="password" autocomplete="new-password">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter password.
                    </div>
                </div>

                <div class="col-12 ">
                    <button class="btn btn-primary " type="submit" value="add user">add user</button>
                </div>
            </form>
        </div>
<?php
    }


    //start update basic information page
    elseif ($do == 'updateBasic') {
        echo '<h1 class="text-center edit">Update Users</h1>';
        echo '<div class="container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $userid = $_POST['userid'];
            $username = $_POST['username'];
            $email = $_POST['email'];

            //user name validatio
            if (strlen($username) < 4) {
                $errors[] = 'user name cant be less than 4';
            }
            if (strlen($username) > 20) {
                $errors[] = 'user name cant be more than 20';
            }
            if (empty($username)) {
                $errors[] = 'user name cant be empty';
            }
            $count = $userObject->unique("User_Name='$username' AND User_ID !='$userid'");
            if ($count > 0) {
                $errors[] = 'user name is exists';
            }

            //email validation
            if (empty($email)) {
                $errors[] = 'email cant be empty';
            }
            $count = $userObject->unique("Email='$email' AND User_ID !='$userid'");
            if ($count > 0) {
                $errors[] = 'email is exists';
            }

            if (isset($errors)) {
                foreach ($errors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
            } else {

                if (empty($_POST['password'])) {
                    $user = $userObject->update("User_Name=?, Email=? WHERE User_ID=?", array($username, $email, $userid));
                } else {
                    $password = $_POST['password'];
                    $hashedPass = password_hash($password, PASSWORD_BCRYPT);
                    $user = $userObject->update(
                        "User_Name=?, Email=?, Password=? WHERE User_ID=?",
                        array($username, $email, $hashedPass, $userid)
                    );
                }
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
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        //check if this id exsit in data base or no
        $count = $userObject->unique("User_ID='$userid'");
        if ($count > 0) {
            //delete this user
            $user = $userObject->delete(" User_ID='$userid'");
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
