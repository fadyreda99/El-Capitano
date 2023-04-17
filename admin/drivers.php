<?php
ob_start();
session_start();
$pageTitle = 'drivers';

if (isset($_SESSION['admin'])) {
    include('int.php');

    $userObject = new users();
    $driverObject = new drivers();
    $carObject = new cars();
    $categoryObject = new categories();
    $memberObject = new memberships();

    $tripObject = new trips();

    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'manage';
    }

    //start manage page
    if ($do == 'manage') {
        $query = ' ';
        if (isset($_GET['page']) && $_GET['page'] == 'pending') {

            $query = "AND User_Status=0";
        }
        $drivers = $driverObject->joins(
            "users.User_Name  AS userName, users.Email AS email, users.User_Status AS status ",
            "INNER JOIN users ON users.User_ID  = drivers.UserID 
                                       $query AND Group_ID=1 "
        );

        if (!empty($drivers)) {
    ?>
            <h1 class="text-center edit">Drivers</h1>
            <div class="container ">
                <div class="table-responsive driver-table">
                    <table class="table main-table text-center  ">
                        <thead>
                            <tr>
                                <td class=""> # </td>
                                <td class=""> USer Name </td>
                                <td class=""> First Name </td>
                                <td class=""> Last Name </td>
                                <td class=""> Mobile </td>
                                <td class=""> Age </td>
                                <td class=""> Email </td>
                                <td class=""> controlls </td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($drivers as $driver) {  ?>
                                <tr>
                                    <td> <?php echo $driver['Driver_ID'] ?> </td>
                                    <td>
                                        <a class="view" href="drivers.php?do=view&driverid=<?php echo $driver['UserID'] ?>">
                                            <?php echo $driver['userName'] ?>
                                        </a>
                                    </td>
                                    <td> <?php echo $driver['First_Name'] ?> </td>
                                    <td> <?php echo $driver['Last_Name'] ?> </td>
                                    <td> <?php echo $driver['Mobile'] ?> </td>
                                    <td> <?php echo $driver['Age'] ?> </td>
                                    <td> <?php echo $driver['email'] ?> </td>
                                    <td class="">
                                        <a href="drivers.php?do=delete&driverid=<?php echo $driver['UserID'] ?>" class="btn btn-danger confirm">
                                            <i class="fa fa-close"></i>
                                            Delete
                                        </a>

                                        <?php if ($driver['status'] == 0) { ?>
                                            <a href="drivers.php?do=activate&driverid=<?php echo $driver['UserID'] ?>" class="btn btn-info activate">
                                                <i class="fa fa-check"></i>
                                                activate
                                            </a>
                                        <?php
                                        }
                                        if ($driver['status'] == 1) { ?>
                                            <a href="drivers.php?do=deactivate&driverid=<?php echo $driver['UserID'] ?>" class="btn btn-warning activate">
                                                <i class="fa fa-check"></i>
                                                DE-activate
                                            </a>
                                        <?php  } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <a class="btn btn-danger mb-5" href="drivers.php?do=search">search</a>
            </div>

        <?php
        } else {
            echo '<div class="container">';
            echo '<div class="nice-msg alert alert-danger">no records to show</div>';
        ?>

        <?php
            echo '</div>';
        }
    }

    //start view page
    elseif ($do == 'view') {
        $driverid = $_GET['driverid'];
        $cats = $carObject->joins(
            "categories.Category_Name AS name",
            "INNER JOIN categories ON categories.Category_ID = cars.CatID WHERE User_id='$driverid'"
        );
        $driver = $driverObject->find("UserID='$driverid'");
        $user = $userObject->find("User_ID='$driverid'");
        $car = $carObject->find("User_id='$driverid'");
        $id = $driver['Driver_ID'];

        $membership = $memberObject->find("DriverID='$id'");

        ?>
        <div class="container">

            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner slider-img">
                    <?php


                    if (empty($car['Car_Images'])) { ?>
                        <div class="carousel-item active">

                            <img src="../images/car3.jfif" class="d-block w-100" alt="...">
                        </div>
                        <?php
                    } else {

                        $images = explode(',', $car['Car_Images']); //to make all images as array 
                        $i = 0;
                        foreach ($images as $image) {
                            $actives = ' ';
                            if ($i == 0) {
                                $actives = 'active';
                            }
                        ?>
                            <div class="carousel-item <?php echo $actives ?>">
                                <img src="../images/carimages/<?php echo $image  ?>" class="d-block w-100" alt="...">
                            </div>

                    <?php
                            $i++;
                        }
                    }
                    ?>
                </div>
                <button class="carousel-control-prev btn" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next btn" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>



                <?php

                if (empty($driver['Driver_Image'])) { ?>
                    <img src="../images/image.jfif" class="driver-image  img-thumbnail" alt="..." width="200" height="300">

                <?php

                } else {
                    echo " <img src='../images/driverimages/" . $driver['Driver_Image'] . "' class=' driver-image img-thumbnail img-circle ' alt=''>";
                } ?>
            </div>


            <?php
         

            $finish = $tripObject->unique("DriverID ='{$driver['UserID']}' AND Status= 1 ");
            $unfinish = $tripObject->unique("DriverID ='{$driver['UserID']}' AND Status= 0 ");
            $cancel = $tripObject->unique("DriverID ='{$driver['UserID']}' AND Status= 2 ");

            ?>
            <div class="bg-light p-4 counttrips">




                <div class=" d-flex justify-content-end text-center">

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



        <div class="information block">
            <div class="container personal-info">



                <div class="card border-default general-information">
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

                <?php if (!empty($driver)) { ?>

                    <div class="card border-default personal-information">
                        <div class="card-header bg-default">Personal information </div>
                        <ul class="  list-group list-group-flush card-body">


                            <li class="list-group-item">
                                <i class="fas fa-user"></i>
                                <span> First Name </span> : <?php echo $driver['First_Name'] ?>
                            </li>

                            <li class="list-group-item">
                                <i class="fas fa-user"></i>
                                <span> Last Name </span> : <?php echo $driver['Last_Name'] ?>
                            </li>

                            <li class="list-group-item">
                                <i class="fas fa-mobile"></i>
                                <span> Mobile </span> : <?php echo $driver['Mobile'] ?>
                            </li>

                            <li class="list-group-item">
                                <i class="fa fa-calendar fa-fw"></i>
                                <span> Age </span> : <?php echo $driver['Age'] ?>
                            </li>

                            <li class="list-group-item">
                                <i class="fas fa-flag"></i>
                                <span> Country </span> : <?php echo $driver['Country'] ?>
                            </li>

                            <li class="list-group-item">
                                <i class="fas fa-id-card-alt"></i>
                                <span>National ID </span> : <?php echo $driver['National_ID'] ?>
                            </li>

                            <li class="list-group-item">
                                <i class="fas fa-id-badge"></i>
                                <span> License ID </span> : <?php echo $driver['License_ID'] ?>
                            </li>
                        </ul>
                    </div>



                <?php     } else {
                    echo '<div class="alert alert-danger">there is no personal information</div>';
                } ?>


                <?php

                if (!empty($car)) { ?>

                    <div class="card border-default car-information">
                        <div class="card-header bg-default">Car information </div>
                        <ul class="  list-group list-group-flush card-body">

                            <li class="list-group-item">
                                <i class="fas fa-car"></i>
                                <span> Car Type </span> : <?php echo $car['Car_Type'] ?>
                            </li>

                            <li class="list-group-item">
                                <i class="fas fa-palette"></i>
                                <span> color </span> : <?php echo $car['Car_Color'] ?>
                            </li>

                            <li class="list-group-item">
                                <i class="fas fa-envelope-open-text"></i>
                                <span> car number </span> : <?php echo $car['Car_Number'] ?> | <?php echo $car['Car_Characters'] ?>
                            </li>

                            <li class="list-group-item">
                                <i class="fas fa-mobile"></i>
                                <span> license car </span> : <?php echo $car['License_Car_ID'] ?>
                            </li>

                            <li class="list-group-item">
                                <i class="fa fa-calendar fa-fw"></i>
                                <span> end date of license </span> : <?php echo $car['End_Date_License'] ?>
                            </li>
                            <?php
                            foreach ($cats as $cat) {
                            ?>
                                <li class="list-group-item">
                                    <i class="fa fa-calendar fa-fw"></i>
                                    <span> category </span> : <?php echo $cat['name'] ?>
                                </li>
                            <?php } ?>


                        </ul>
                    </div>
                <?php
                } else {
                    echo '<div class="alert alert-danger">there is no car</div>';
                }

                if (!empty($membership)) {
                    $ldate = date("Y-m-d");

                    $edate = $membership['End_Date_Of_Membership'];


                    //$newformat = date('Y-m-d',$edate);
                ?>


                    <div class="information block mt-2">
                        <div class=" personal-info">



                            <div class="card border-default general-information">
                                <div class="card-header bg-default">Membership
                                    <?php

                                    // $date = str_replace('-', '/', $edate); 
                                    $test = strtotime($edate);
                                    $finalDate = date("Y-m-d", $test);



                                    //date                    
                                    $date1 = date_create($finalDate);
                                    $date2 = date_create($ldate);
                                    $diff = date_diff($date2, $date1);
                                    $diff->format("%a days");

                                    if ($ldate > $finalDate) {
                                    ?>
                                        <span class="float-end" style="color:red;">Membership had Ended</span>

                                    <?php
                                    } else {
                                    ?>
                                        <span class="float-end" style="color:red;"><?php echo $diff->format("%a day/s left") ?></span>
                                    <?php } 


                                    ?>
                                </div>
                                <ul class="  list-group list-group-flush card-body">

                                    <li class="list-group-item">
                                        <i class="fas fa-user-tag"></i>
                                        <span> Start Date of Membership </span> : <?php echo $membership['Start_Date_Of_Membership'] ?>
                                    </li>

                                    <li class="list-group-item">
                                        <i class="fas fa-envelope-open-text"></i>
                                        <span> End Date of Membership </span> : <?php echo $membership['End_Date_Of_Membership'] ?>
                                    </li>


                                </ul>
                            </div>
                        <?php


                    } else {
                        ?>
                            <div class="alert alert-danger">there is no membership</div>

                        <?php
                    }

                        ?>




                        <div class="per-buttons">
                            <a href="drivers.php?do=delete&driverid=<?php echo $driver['UserID'] ?>" class="btn btn-danger confirm">
                                <i class="fa fa-close"></i>
                                Delete
                            </a>
                            <?php if (!empty($driver)) { ?>
                                <a href="drivers.php?do=edit&driverid=<?php echo $driver['Driver_ID'] ?>" class="btn btn-success">
                                    <i class="fa fa-edit"></i>
                                    Presonal Info
                                </a>
                            <?php } ?>


                            <a href="drivers.php?do=editBasic&driverid=<?php echo $driver['UserID'] ?>" class="btn btn-secondary">
                                <i class="fa fa-edit"></i>
                                basic Info
                            </a>
                            <?php

                            if (!empty($car)) { ?>
                                <a href="cars.php?do=edit&carid=<?php echo $car['Car_ID'] ?>" class="btn btn-dark">
                                    <i class="fa fa-edit"></i>
                                    car Info
                                </a>
                            <?php } ?>
                            <?php if ($user['User_Status'] == 0) { ?>
                                <a href="drivers.php?do=activate&driverid=<?php echo $driver['UserID'] ?>" class="btn btn-info activate">
                                    <i class="fa fa-check"></i>
                                    activate
                                </a>
                            <?php
                            }
                            if ($user['User_Status'] == 1) { ?>
                                <a href="drivers.php?do=deactivate&driverid=<?php echo $driver['UserID'] ?>" class="btn btn-warning activate">
                                    <i class="fas fa-cut"></i>
                                    DE-activate
                                </a>
                            <?php  } ?>

                            <?php

                            if (empty($membership)) {
                            ?>
                                <a href="addmembership.php?memberid=<?php echo $driver['Driver_ID'] ?>" class="btn btn-primary">Add Membership</a>
                            <?php
                            } else {
                            ?>
                                <a href="changemember.php?memberid=<?php echo $driver['Driver_ID'] ?>" class="btn btn-primary ">Change Membership</a>
                            <?php
                            }


                            ?>
                            <a href="usertrips.php?do=manage&userid=<?php echo $driver['UserID'] ?>" class="btn btn-primary ">trips</a>





                        </div>
                        </div>
                    </div>

                    <script>
                        //get avarege of rating
                        $(function() {
                            $("#avgrating").rateYo({
                                readOnly: true,
                                rating: '<?php echo  getAverageRating("WHERE DriverID ='{$driverid}'") ?>'


                            });
                        });
                    </script>

                <?php //}    

            } elseif ($do == 'search') {
                if (isset($_POST['search'])) {
                    $searchq = $_POST['search'];
                    $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);

                    /*$stmt=$conn->prepare("SELECT * FROM drivers WHERE Mobile LIKE '%$searchq%'");
        $stmt->execute();
        $count=$stmt->rowCount();*/

                    $drivers = $driverObject->joins(
                        "users.User_Name  AS userName, users.Email AS email, users.User_Status AS status ",
                        "INNER JOIN users ON users.User_ID  = drivers.UserID 
        WHERE First_Name    LIKE '%$searchq%' 
        OR    Last_Name     LIKE '%$searchq%' 
        OR    Mobile        LIKE '%$searchq%' 
        OR    National_ID   LIKE '%$searchq%' 
        OR    License_ID    LIKE '%$searchq%'
        OR    users.User_Name     LIKE '%$searchq%'
        
         "
                    );

                    $out = ' ';

                    if (!empty($drivers)) {
                        $out .= '
                        <div class="container con-search">
                            <div class="table-responsive">
                                <table class="table main-table text-center  t-search">
                                    <thead>
                                        <tr>
                                        <td class="" >#</td>
                                        <td class="" >User Name</td>
                                        <td class="">   First Name  </td>
                                        <td class="">   Last Name   </td>
                                        <td class="">   Mobile      </td>
                                        <td class="">   Age         </td>
                                        <td class="" >Email</td>
                                       
                                        <td class="" >controlls</td>
                                        </tr>
                                    </thead>';
                        foreach ($drivers as $driver) {
                            $out .= '    
                                    <tbody>
                                        <tr>
                                        <td>' . $driver['Driver_ID'] . '</td>
                                        <td>
                                             <a class="view" href="drivers.php?do=view&driverid=' . $driver['UserID'] . '">' . $driver['userName'] . '</a></td>
                                        <td>' . $driver['First_Name'] . '</td>
                                        <td>' . $driver['Last_Name'] . '</td>
                                        <td>' . $driver['Mobile'] . '</td>
                                        <td>' . $driver['Age'] . '</td>
                                        <td>' . $driver['email'] . '</td>
                                        <td class="" >
                                         <a href="drivers.php?do=delete&driverid=' . $driver['UserID'] . '" class="btn btn-danger confirm">
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
                    <form action="drivers.php?do=search" method="POST">
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

                    $driverid = isset($_GET['driverid']) && is_numeric($_GET['driverid']) ? intval($_GET['driverid']) : 0; //short if condition
                    $driver = $driverObject->find("Driver_ID='$driverid'");
                    ?>

                    <h1 class="text-center edit">Edit Drivers</h1>
                    <div class="container ">
                        <form class="row g-3 needs-validation edit-from  " action="drivers.php?do=update" method="POST" novalidate>
                            <input type="hidden" name="driverid" value="<?php echo $driverid ?>">

                            <div class="col-12 form-control-lg">
                                <label for="validationCustom01" class="form-label ">First Name</label>
                                <input type="text" class="form-control " name="firstname" autocomplete="off" value="<?php echo $driver['First_Name'] ?>" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please Enter Your First Name.
                                </div>
                            </div>

                            <div class="col-12 form-control-lg">
                                <label for="validationCustom02" class="form-label">Last Name</label>
                                <input type="text" class="password form-control" name="lastname" autocomplete="off" value="<?php echo $driver['Last_Name'] ?>" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please Enter Your Last Name.
                                </div>
                            </div>

                            <div class="col-12 form-control-lg">
                                <label for="validationCustomUsername" class="form-label">Mobile</label>
                                <input type="text" class="form-control" name="mobile" autocomplete="off" value="<?php echo $driver['Mobile'] ?>" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please Enter Your Mobile.
                                </div>
                            </div>

                            <div class="col-12 form-control-lg">
                                <label for="validationCustomUsername" class="form-label">Age</label>
                                <input type="number" class="form-control" name="age" autocomplete="off" value="<?php echo $driver['Age'] ?>" required> 
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please Enter Your Age.
                                </div>
                            </div>

                            <div class="col-12 form-control-lg">
                                <label for="validationCustomUsername" class="form-label">Country</label>
                                <input type="text" class="form-control" name="country" autocomplete="off" value="<?php echo $driver['Country'] ?>" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please Enter Your Country.
                                </div>
                            </div>

                            <div class="col-12 form-control-lg">
                                <label for="validationCustomUsername" class="form-label">National ID</label>
                                <input type="text" class="form-control" name="nationalid" autocomplete="off" value="<?php echo $driver['National_ID'] ?>" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please Enter Your National ID.
                                </div>
                            </div>

                            <div class="col-12 form-control-lg">
                                <label for="validationCustomUsername" class="form-label">License ID</label>
                                <input type="text" class="form-control" name="licenseid" autocomplete="off" value="<?php echo $driver['License_ID'] ?>" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please Enter Your License ID.
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

                        $driverid = $_POST['driverid'];
                        $firstname = $_POST['firstname'];
                        $lastname = $_POST['lastname'];
                        $mobile = $_POST['mobile'];
                        $age = $_POST['age'];
                        $country = $_POST['country'];
                        $nationalid = $_POST['nationalid'];
                        $licenseid = $_POST['licenseid'];

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
                        $count = $driverObject->unique("Mobile='$mobile' AND Driver_ID !='$driverid' ");
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

                        //national id validation
                        if (preg_match('([a-zA-Z].*[a-zA-Z])', $nationalid)) //if natioonal id contains letters
                        {
                            $errors[] = 'national id can not contain characters only numbers';
                        }
                        if (strlen($nationalid) < 14) {
                            $errors[] = 'national id cant be less than 14';
                        }
                        if (strlen($nationalid) > 114) {
                            $errors[] = 'national id cant be more than 14';
                        }
                        if (empty($nationalid)) {
                            $errors[] = 'national id cant be empty';
                        }
                        $count = $driverObject->unique("National_ID='$nationalid' AND Driver_ID !='$driverid' ");
                        if ($count > 0) {
                            $errors[] = 'this user names already exsists';
                        }

                        //license id validation
                        if (preg_match('([a-zA-Z].*[a-zA-Z])', $licenseid)) //if license id contains letters
                        {
                            $errors[] = 'license id can not contain characters only numbers';
                        }
                        if (strlen($licenseid) < 14) {
                            $errors[] = 'license id cant be less than 14';
                        }
                        if (strlen($licenseid) > 114) {
                            $errors[] = 'license id cant be more than 14';
                        }
                        if (empty($licenseid)) {
                            $errors[] = 'license id cant be empty';
                        }
                        $count = $driverObject->unique("License_ID='$licenseid' AND Driver_ID !='$driverid' ");
                        if ($count > 0) {
                            $errors[] = 'this user names already exsists';
                        }
                        if (isset($errors)) {
                            foreach ($errors as $error) {
                                echo '<div class="alert alert-danger">' . $error . '</div>';
                            }
                        } else {

                            $driver = $driverObject->update(
                                "First_Name=?, Last_Name=?, Mobile=?, Age=?, Country=?, National_ID=?, License_ID=? WHERE Driver_ID =?",
                                array($firstname, $lastname, $mobile, $age, $country, $nationalid, $licenseid, $driverid)
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

                    $driverid = isset($_GET['driverid']) && is_numeric($_GET['driverid']) ? intval($_GET['driverid']) : 0; //short if condition
                    $user = $userObject->find("User_ID='$driverid'");
                ?>

                    <h1 class="text-center edit">add new User</h1>
                    <div class="container ">
                        <form class="row g-3 needs-validation edit-from  " action="drivers.php?do=updateBasic" method="POST" novalidate>
                            <input type="hidden" name="driverid" value="<?php echo $driverid ?>">

                            <div class="col-12 form-control-lg">
                                <label for="validationCustom01" class="form-label ">User name</label>
                                <input type="text" class="form-control " name="username" required autocomplete="off" value="<?php echo $user['User_Name'] ?>" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please enter username.
                                </div>
                            </div>

                            <div class="col-12 form-control-lg">
                                <label for="validationCustomUsername" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required aria-describedby="inputGroupPrepend" autocomplete="off" value="<?php echo $user['Email'] ?>" required>
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

                        $driverid = $_POST['driverid'];
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
                        $count = $userObject->unique("User_Name='$username' AND User_ID !='$driverid'");
                        if ($count > 0) {
                            $errors[] = 'user name is exists';
                        }

                        //email validation
                        if (empty($email)) {
                            $errors[] = 'email cant be empty';
                        }
                        $count = $userObject->unique("Email='$email' AND User_ID !='$driverid'");
                        if ($count > 0) {
                            $errors[] = 'email is exists';
                        }

                        if (isset($errors)) {
                            foreach ($errors as $error) {
                                echo '<div class="alert alert-danger">' . $error . '</div>';
                            }
                        } else {

                            if (empty($_POST['password'])) {
                                $user = $userObject->update("User_Name=?, Email=? WHERE User_ID=?", array($username, $email, $driverid));
                            } else {
                                $password = $_POST['password'];
                                $hashedPass = password_hash($password, PASSWORD_BCRYPT);
                                $user = $userObject->update(
                                    "User_Name=?, Email=?, Password=? WHERE User_ID=?",
                                    array($username, $email, $hashedPass, $driverid)
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
                    $driverid = isset($_GET['driverid']) && is_numeric($_GET['driverid']) ? intval($_GET['driverid']) : 0; //short if
                    $count = $driverObject->unique("UserID='$driverid'");

                    if ($count > 0) {
                        $user = $userObject->delete(" User_ID='$driverid'");
                        $theMsg = '<div class="alert alert-success"> record has deleted </div>';
                        redirectHome($theMsg, 'back');
                    } else {
                        $theMsg = '<div class="alert alert-danger">this id is not exsits</div>';
                        redirectHome($theMsg);
                    }
                    echo '</div>';
                }

                //start activate page
                elseif ($do == 'activate') {
                    echo '<h1 class="text-center edit">activate driver</h1>';
                    echo '<div class="container ">';
                    $driverid = isset($_GET['driverid']) && is_numeric($_GET['driverid']) ? intval($_GET['driverid']) : 0;
                    $count = $driverObject->unique("UserID='$driverid'");

                    if ($count > 0) {
                        $user = $userObject->update("User_Status = 1 WHERE User_ID=?", array($driverid));
                        $theMsg = '<div class="alert alert-success"> record has activated </div>';
                        redirectHome($theMsg, 'back');
                    } else {
                        $theMsg = '<div class="alert alert-danger">this id is not exsits</div>';
                        redirectHome($theMsg);
                    }
                    echo '</div>';
                }

                //start de-activate page
                elseif ($do == 'deactivate') {
                    echo '<h1 class="text-center edit">activate driver</h1>';
                    echo '<div class="container ">';
                    $driverid = isset($_GET['driverid']) && is_numeric($_GET['driverid']) ? intval($_GET['driverid']) : 0;
                    $count = $driverObject->unique("UserID='$driverid'");

                    if ($count > 0) {
                        $user = $userObject->update("User_Status = 0 WHERE User_ID=?", array($driverid));
                        $theMsg = '<div class="alert alert-success"> record has activated </div>';
                        redirectHome($theMsg, 'back');
                    } else {
                        $theMsg = '<div class="alert alert-danger">this id is not exsits</div>';
                        redirectHome($theMsg);
                    }

                    echo '</div>';
                }

                include $tpl . ('footer.php');




                ob_end_flush();
            } else {
                header('location: ../prehome.php');
                exit();
            }
