<?php
ob_start();
session_start();
if (isset($_SESSION['userName'])) {
    $pageTitle = 'drivers';
    include('int.php');
    include $tpl . "navbarUser.php";
    $driverObject = new drivers();
    $carObject = new cars();
    $categoryObject = new categories();
    $uprofileObject = new uprofiles();

    $getuprofile = $uprofileObject->find("UID='{$_SESSION['uid']}'");


    if (empty($getuprofile)) {
?>
        <div class="per-error2 alert alert-danger">
            <span>
                there is no personal information please go to your profile and set your personal information and finish your profile

            </span>
            <span>
                <a href="profile.php" class="btn btn-outline-danger float-end ">My Profile</a>
            </span>

        </div>


    <?php
    } ?>



    <div class="container">


        <div class="row">
            <!-- filter -->
            <div class="col-md-3">
                <form action="" method="GET">
                    <div class="card shadow mt-3">
                        <div class="card-header">
                            <h5>
                                search on special driver
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <input type="text" name="search" value="<?php if (isset($_GET['search'])) {
                                                                                echo $_GET['search'];
                                                                            }  ?>" class="form-control" placeholder="search by name " required>
                                </div>
                                <div class="col-3">
                                    <button type="submit" class="btn btn-primary btn-sm float-end "> search</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

                <form action="" method="POST">
                    <div class="card shadow mt-3">
                        <div class="card-header">
                            <h5>
                                filtter
                                <button type="submit" class="btn btn-primary btn-sm float-end">filter</button>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <h6 class="mt-2">age</h6>
                                <hr>
                                <div class="col-md-6">
                                    <label for="">minimum age</label>
                                    <input type="text" name="miniage" value="<?php if (isset($_POST['miniage'])) {
                                                                                    echo $_POST['miniage'];
                                                                                } else {
                                                                                    echo "20";
                                                                                } ?>" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="">maxmum age</label>
                                    <input type="text" name="maxage" value="<?php if (isset($_POST['maxage'])) {
                                                                                echo $_POST['maxage'];
                                                                            } else {
                                                                                echo "60";
                                                                            } ?>" class="form-control">

                                </div>
                            </div>
                            <h6 class="mt-2">Categories</h6>
                            <hr>
                            <?php
                            $categories = $categoryObject->all3();
                            /*$categories=$categoryObject->joins( "cars.CatID AS CatID ",
                            "INNER JOIN cars ON cars.CatID  = categories.Category_ID 
                                
                                WHERE cars.CatID");*/

                            foreach ($categories as $category) {
                                $checked = [];
                                if (isset($_POST['category'])) {
                                    $checked = $_POST['category'];
                                }
                            ?>
                                <div>
                                    <input type="checkbox" name="category[]" value="<?php echo $category['Category_ID'] ?>" <?php if (in_array($category['Category_ID'], $checked)) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> />
                                    <?php echo $category['Category_Name'] ?>
                                </div>
                            <?php
                            } ?>
                            <hr>
                            <h6 class="mt-2">Country</h6>

                            <hr>
                            <div>
                                <input type="radio" name="country" value="Cairo" />
                                cairo
                            </div>
                            <div>
                                <input type="radio" name="country" value="giza" />
                                giza
                            </div>


                        </div>
                    </div>
                </form>
            </div>

            <!-- drivers -->
            <div class="col-md-9 mt-3">
                <section class="drivers row">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['miniage']) && isset($_POST['maxage'])) {
                            $miniage = $_POST['miniage'];
                            $maxage = $_POST['maxage'];
                        } else {
                            $miniage = null;
                            $maxage = null;
                        }
                        if (isset($_POST['category']) && isset($_POST['country'])) {
                            $catcheck = [];
                            //$city = [];
                            $catcheck = $_POST['category'];
                            $city = $_POST['country'];

                            foreach ($catcheck as $row) {
                                //foreach($city as $ci){
                                $cars = $carObject->joins(
                                    "users.User_Status AS status , users.User_ID AS ID , drivers.Age AS age ,drivers.Country AS Country",
                                    "INNER JOIN users ON users.User_ID = cars.User_id
                                                            INNER JOIN drivers ON drivers.UserID = cars.User_id
                                                            WHERE age BETWEEN $miniage AND $maxage AND CatID IN ($row) AND User_Status=1 AND Group_ID=1 AND drivers.Country LIKE '%$city%'"
                                );


                                foreach ($cars as $car) {
                                    $driver = $driverObject->find("UserID='{$car['ID']}'"); ?>

                                    <div class="col-md-4">
                                        <div class="third">
                                            <img src="images/driverimages/<?php echo $driver['Driver_Image'] ?>" alt="">
                                            <h3><span><?php echo $driver['First_Name'] . ' ' . $driver['Last_Name']   ?></span></h3>
                                            <h3><?php echo $driver['Country']  ?></h3>

                                            <?php
                                            $stmt = $conn->prepare("SELECT avg(Rating) as avg ,Feedback_ID,DriverID FROM feedback WHERE DriverID = {$car['ID']}");
                                            if ($stmt->execute()) {
                                                $count = $stmt->rowCount();
                                                if ($count > 0) {
                                                    $rates = $stmt->fetchAll();
                                                    foreach ($rates as $rate) { ?>

                                                        <div class="rating ">
                                                            <div class=" rateYo-<?php echo $rate['DriverID'] ?>"></div>
                                                        </div>
                                                    <?php
                                                    } ?>

                                                    <script>
                                                        $(function() {
                                                            $(".rateYo-<?php echo $rate['DriverID'] ?>").rateYo({
                                                                readOnly: true,
                                                                rating: <?php echo $rate['avg'] ?>
                                                            });
                                                        });
                                                    </script>
                                            <?php
                                                }
                                            } ?>

                                            <h5><?php echo $car['Car_Type']  ?></h5>
                                            <?php
                                            if (!empty($getuprofile)) {
                                            ?>
                                                <a href="driverprofile.php?driverid=<?php echo $driver['UserID'] ?>" class="btn btn-primary">view profile</a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                            //}
                        } elseif (isset($_POST['category'])) {
                            $catcheck = [];
                            //$city = [];
                            $catcheck = $_POST['category'];


                            foreach ($catcheck as $row) {
                                //foreach($city as $ci){
                                $cars = $carObject->joins(
                                    "users.User_Status AS status , users.User_ID AS ID , drivers.Age AS age ",
                                    "INNER JOIN users ON users.User_ID = cars.User_id
                                                            INNER JOIN drivers ON drivers.UserID = cars.User_id
                                                            WHERE age BETWEEN $miniage AND $maxage AND CatID IN ($row) AND User_Status=1 AND Group_ID=1 "
                                );


                                foreach ($cars as $car) {
                                    $driver = $driverObject->find("UserID='{$car['ID']}'"); ?>

                                    <div class="col-md-4">
                                        <div class="third">
                                            <img src="images/driverimages/<?php echo $driver['Driver_Image'] ?>" alt="">
                                            <h3><span><?php echo $driver['First_Name'] . ' ' . $driver['Last_Name']   ?></span></h3>
                                            <h3><?php echo $driver['Country']  ?></h3>

                                            <?php
                                            $stmt = $conn->prepare("SELECT avg(Rating) as avg ,Feedback_ID,DriverID FROM feedback WHERE DriverID = {$car['ID']}");
                                            if ($stmt->execute()) {
                                                $count = $stmt->rowCount();
                                                if ($count > 0) {
                                                    $rates = $stmt->fetchAll();
                                                    foreach ($rates as $rate) { ?>

                                                        <div class="rating ">
                                                            <div class=" rateYo-<?php echo $rate['DriverID'] ?>"></div>
                                                        </div>
                                                    <?php
                                                    } ?>

                                                    <script>
                                                        $(function() {
                                                            $(".rateYo-<?php echo $rate['DriverID'] ?>").rateYo({
                                                                readOnly: true,
                                                                rating: <?php echo $rate['avg'] ?>
                                                            });
                                                        });
                                                    </script>
                                            <?php
                                                }
                                            } ?>

                                            <h5><?php echo $car['Car_Type']  ?></h5>
                                            <?php
                                            if (!empty($getuprofile)) {
                                            ?>
                                                <a href="driverprofile.php?driverid=<?php echo $driver['UserID'] ?>" class="btn btn-primary">view profile</a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                        } elseif (isset($_POST['country'])) {
                
                            $city = $_POST['country'];

                            $cars = $carObject->joins(
                                "users.User_Status AS status , users.User_ID AS ID , drivers.Age AS age ,drivers.Country AS Country",
                                "INNER JOIN users ON users.User_ID = cars.User_id
                                                            INNER JOIN drivers ON drivers.UserID = cars.User_id
                                                            WHERE age BETWEEN $miniage AND $maxage AND User_Status=1 AND Group_ID=1 AND drivers.Country LIKE '%$city%'"
                            );


                            foreach ($cars as $car) {
                                $driver = $driverObject->find("UserID='{$car['ID']}'"); ?>

                                <div class="col-md-4">
                                    <div class="third">
                                        <img src="images/driverimages/<?php echo $driver['Driver_Image'] ?>" alt="">
                                        <h3><span><?php echo $driver['First_Name'] . ' ' . $driver['Last_Name']   ?></span></h3>
                                        <h3><?php echo $driver['Country']  ?></h3>

                                        <?php
                                        $stmt = $conn->prepare("SELECT avg(Rating) as avg ,Feedback_ID,DriverID FROM feedback WHERE DriverID = {$car['ID']}");
                                        if ($stmt->execute()) {
                                            $count = $stmt->rowCount();
                                            if ($count > 0) {
                                                $rates = $stmt->fetchAll();
                                                foreach ($rates as $rate) { ?>

                                                    <div class="rating ">
                                                        <div class=" rateYo-<?php echo $rate['DriverID'] ?>"></div>
                                                    </div>
                                                <?php
                                                } ?>

                                                <script>
                                                    $(function() {
                                                        $(".rateYo-<?php echo $rate['DriverID'] ?>").rateYo({
                                                            readOnly: true,
                                                            rating: <?php echo $rate['avg'] ?>
                                                        });
                                                    });
                                                </script>
                                        <?php
                                            }
                                        } ?>

                                        <h5><?php echo $car['Car_Type']  ?></h5>
                                        <?php
                                        if (!empty($getuprofile)) {
                                        ?>
                                            <a href="driverprofile.php?driverid=<?php echo $driver['UserID'] ?>" class="btn btn-primary">view profile</a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }




                            //}

                        } else {
                            $cars = $carObject->joins(
                                "users.User_Status AS status , users.User_ID AS ID , drivers.Age AS age",
                                "INNER JOIN users ON users.User_ID = cars.User_id
                            INNER JOIN drivers ON drivers.UserID = cars.User_id
                            WHERE age BETWEEN $miniage AND $maxage  AND User_Status=1 AND Group_ID=1"
                            );
                            if ($cars) {
                                foreach ($cars as $car) {
                                    $driver = $driverObject->find("UserID='{$car['ID']}'"); ?>

                                    <div class="col-md-4">
                                        <div class="third">
                                            <img src="images/driverimages/<?php echo $driver['Driver_Image'] ?>" alt="">
                                            <h3><span><?php echo $driver['First_Name'] . ' ' . $driver['Last_Name']   ?></span></h3>
                                            <h3><?php echo $driver['Country']  ?></h3>

                                            <?php
                                            $stmt = $conn->prepare("SELECT avg(Rating) as avg ,Feedback_ID,DriverID FROM feedback WHERE DriverID = {$car['ID']}");
                                            if ($stmt->execute()) {
                                                $count = $stmt->rowCount();
                                                if ($count > 0) {
                                                    $rates = $stmt->fetchAll();
                                                    foreach ($rates as $rate) { ?>

                                                        <div class="rating">
                                                            <div class="rateYo-<?php echo $rate['DriverID'] ?>"></div>
                                                        </div>
                                                    <?php
                                                    } ?>

                                                    <script>
                                                        $(function() {
                                                            $(".rateYo-<?php echo $rate['DriverID'] ?>").rateYo({
                                                                readOnly: true,
                                                                rating: <?php echo $rate['avg'] ?>
                                                            });
                                                        });
                                                    </script>
                                            <?php
                                                }
                                            } ?>

                                            <h5><?php echo $car['Car_Type']  ?></h5>
                                            <?php
                                            if (!empty($getuprofile)) {
                                            ?>
                                                <a href="driverprofile.php?driverid=<?php echo $driver['UserID'] ?>" class="btn btn-primary">view profile</a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "no";
                            }
                        }
                    } elseif (isset($_GET['search'])) {
                        //$search = $_GET['search'];
                        $search = filter_var($_GET['search'], FILTER_SANITIZE_STRING);
                        $cars = $carObject->joins(
                            "users.User_Status AS status ,
                                              users.User_ID AS ID , 
                                              drivers.First_Name AS fname, 
                                              drivers.Last_Name AS lname",
                            "INNER JOIN users ON users.User_ID = cars.User_id
                                               INNER JOIN drivers ON drivers.UserID = cars.User_id
                                               WHERE CONCAT(drivers.First_Name,drivers.Last_Name) LIKE '%$search%' AND User_Status=1 AND Group_ID=1"
                        );
                        foreach ($cars as $car) {
                            $driver = $driverObject->find("UserID='{$car['ID']}'"); ?>

                            <div class="col-md-4">
                                <div class="third">
                                    <img src="images/driverimages/<?php echo $driver['Driver_Image'] ?>" alt="">
                                    <h3><span><?php echo $driver['First_Name'] . ' ' . $driver['Last_Name']   ?></span></h3>

                                    <?php
                                    $stmt = $conn->prepare("SELECT avg(Rating) as avg ,Feedback_ID,DriverID FROM feedback WHERE DriverID = {$car['ID']}");
                                    if ($stmt->execute()) {
                                        $count = $stmt->rowCount();
                                        if ($count > 0) {
                                            $rates = $stmt->fetchAll();
                                            foreach ($rates as $rate) { ?>

                                                <div class="rating">
                                                    <div class="rateYo-<?php echo $rate['DriverID'] ?>"></div>
                                                </div>
                                            <?php
                                            } ?>

                                            <script>
                                                $(function() {
                                                    $(".rateYo-<?php echo $rate['DriverID'] ?>").rateYo({
                                                        readOnly: true,
                                                        rating: <?php echo $rate['avg'] ?>
                                                    });
                                                });
                                            </script>
                                    <?php
                                        }
                                    } ?>

                                    <h5><?php echo $car['Car_Type']  ?></h5>
                                    <?php
                                    if (!empty($getuprofile)) {
                                    ?>
                                        <a href="driverprofile.php?driverid=<?php echo $driver['UserID'] ?>" class="btn btn-primary">view profile</a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        $cars = $carObject->joins(
                            "users.User_Status AS status , users.User_ID AS ID , drivers.Age AS age",
                            "INNER JOIN users ON users.User_ID = cars.User_id
                    INNER JOIN drivers ON drivers.UserID = cars.User_id
                    WHERE User_Status=1 AND Group_ID=1"
                        );

                        foreach ($cars as $car) {
                            $driver = $driverObject->find("UserID='{$car['ID']}'"); ?>

                            <div class="col-md-4">
                                <div class="third">
                                    <img src="images/driverimages/<?php echo $driver['Driver_Image'] ?>" alt="">
                                    <h3><span><?php echo $driver['First_Name'] . ' ' . $driver['Last_Name']   ?></span></h3>
                                    <h3><?php echo $driver['Country']  ?></h3>
                                    <?php
                                    $stmt = $conn->prepare("SELECT avg(Rating) as avg ,Feedback_ID,DriverID FROM feedback WHERE DriverID = {$car['ID']}");
                                    if ($stmt->execute()) {
                                        $count = $stmt->rowCount();
                                        if ($count > 0) {
                                            $rates = $stmt->fetchAll();
                                            foreach ($rates as $rate) { ?>

                                                <div class="rating">
                                                    <div class="rateYo-<?php echo $rate['DriverID'] ?>"></div>
                                                </div>
                                            <?php
                                            } ?>

                                            <script>
                                                $(function() {
                                                    $(".rateYo-<?php echo $rate['DriverID'] ?>").rateYo({
                                                        readOnly: true,
                                                        rating: <?php echo $rate['avg'] ?>
                                                    });
                                                });
                                            </script>
                                    <?php
                                        }
                                    } ?>
                                    <h5><?php echo $car['Car_Type']  ?></h5>
                                    <?php
                                    if (!empty($getuprofile)) {
                                    ?>
                                        <a href="driverprofile.php?driverid=<?php echo $driver['UserID'] ?>" class="btn btn-primary">view profile</a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                    <?php
                        }
                    } ?>

                </section>
            </div>
        </div>
    </div>
<?php

    include $tpl . ('footer.php');
} else {
    header('location:login.php');
}
ob_end_flush();
