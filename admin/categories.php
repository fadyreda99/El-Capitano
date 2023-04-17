<?php
ob_start();

session_start();
$pageTitle = 'categories';

if (isset($_SESSION['admin'])) {
    include('int.php');

    $categoryObject = new categories();
    $carObject = new cars();


    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'manage';
    }

    //start manage page
    if ($do == 'manage') {
        $categories = $categoryObject->all3();
        if (!empty($categories)) { ?>
            <h1 class="text-center edit">Categories</h1>
            <div class="container ">
                <div class="table-responsive">
                    <table class="table main-table text-center  ">
                        <thead>
                            <tr>
                                <td class=""> # </td>
                                <td class=""> Category Name </td>
                                <td class=""> cars </td>
                                <td class=""> Date </td>
                                <td class=""> controlls </td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category) {  ?>
                                <tr class="tabl__tr">
                                    <td> <?php echo $category['Category_ID'] ?> </td>
                                    <td> <?php echo $category['Category_Name'] ?> </td>
                                    <td>

                                        <?php
                                        $cat = $category['Category_ID'];
                                        ?>
                                        <a href="cars.php?do=manage&page=carsInCategory&categoryid=<?php echo $category['Category_ID'] ?>">
                                            <?php
                                            echo  $carObject->unique("Car_ID AND CatID='$cat'") ?>
                                        </a>
                                    </td>
                                    <td> <?php echo $category['Rag_Date_Cat'] ?> </td>

                                    <td class="">
                                        <a href="categories.php?do=delete&categoryid=<?php echo $category['Category_ID'] ?>" class="btn btn-danger confirm">
                                            <i class="fa fa-close"></i>
                                            Delete
                                        </a>
                                        <a href="categories.php?do=edit&categoryid=<?php echo $category['Category_ID'] ?>" class="btn btn-success">
                                            <i class="fa fa-edit"></i>
                                            edit category
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <a class="btn btn-primary" href="categories.php?do=add"><i class="fa fa-plus"></i>
                    <strong>New Category</strong>
                </a>
                <a class="btn btn-danger" href="categories.php?do=search">search</a>
            </div>

        <?php
        } else {
            echo '<div class="container">';
            echo '<div class="nice-msg alert alert-danger">no records to show</div>';
        ?>
            <a class="btn btn-primary" href="categories.php?do=add"><i class="fa fa-plus"></i> <strong>New Category</strong> </a>
        <?php
            echo '</div>';
        }
    } elseif ($do == 'search') {
        if (isset($_POST['search'])) {
            $searchq = $_POST['search'];
            $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);

            $stmt = $conn->prepare("SELECT * FROM categories WHERE Category_Name LIKE '%$searchq%'");
            $stmt->execute();
            $count = $stmt->rowCount();



            $out = ' ';

            if ($count > 0) {
                while ($row = $stmt->fetch()) {
                    $id = $row['Category_ID'];
                    $catname = $row['Category_Name'];
                    $date = $row['Rag_Date_Cat'];


                    $out .= '
                            <div class="container con-search">
                                <div class="table-responsive">
                                    <table class="table main-table text-center  t-search">
                                        <thead>
                                            <tr>
                                            <td class="" > #              </td>
                                            <td class="" > Category Name  </td>
                                            <td class="" > Date           </td>
                                            <td class="" > cars           </td>
                                            <td class="" > controlls      </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>' . $id . '</td>
                                            <td>' . $catname . '</td>
                                            <td>' . $date . '</td>
                                            <td>' .

                        '<a href="cars.php?do=manage&page=carsInCategory&categoryid=' . $id . '">' .
                        $carObject->unique("Car_ID AND CatID='$id'")
                        . '</td>
                                            <td class="" >
                                            <a href="categories.php?do=delete&categoryid=' . $id . '" class="btn btn-danger confirm">
                                            <i class="fa fa-close"></i>
                                            Delete
                                    </a>
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
        <form action="categories.php?do=search" method="POST">
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

    //start add page
    elseif ($do == 'add') { ?>

        <h1 class="text-center edit">add new category</h1>
        <div class="container ">
            <form class="row g-3 needs-validation edit-from  " action="categories.php?do=insert" method="POST" novalidate>
                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">Category name</label>
                    <input type="text" class="form-control " name="categoryname" required autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter Category name.
                    </div>
                </div>

                <div class="col-12 ">
                    <button class="btn btn-primary " type="submit" value="add category">add category</button>
                </div>

            </form>
        </div>
    <?php
    }

    //start insert page
    elseif ($do == 'insert') {
        echo '<div class="container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center edit">Add Users</h1>';
            $categoryname = $_POST['categoryname'];

            //category name validation
            if (preg_match('([0-9]|[0-9])', $categoryname)) //if category contains numbers
            {
                $errors[] = 'first name can not contain numbers only characters';
            }
            if (strlen($categoryname) < 3) {
                $errors[] = 'first name cant be less than 4';
            }
            if (strlen($categoryname) > 20) {
                $errors[] = 'first name cant be more than 20';
            }
            if (empty($categoryname)) {
                $errors[] = 'first name cant be empty';
            }
            $count = $categoryObject->unique("Category_Name ='$categoryname'");
            if ($count > 0) {
                $errors[] = 'mobile is exists';
            }

            if (isset($errors)) {
                foreach ($errors as $error) {
                    echo  '<div class="alert alert-danger">' . $error . '</div>';
                    header("refresh:2 ;url='categories.php?do=add'");
                }
            } else {
                $categoryObject->insert("(Category_Name) VALUES (?)", array($categoryname));
                $theMsg = '<div class="alert alert-success"> record has Added </div>';
                redirectHome($theMsg, 'back');
            }
        } else {
            echo "<div class='container'>";
            $theMsg = '<div class="alert alert-danger">you cant inter here</div>';
            redirectHome($theMsg, 'back');
            echo "</div>";
        }
        echo '</div>';
    }

    //start edit page
    elseif ($do == 'edit') {

        $categoryid = isset($_GET['categoryid']) && is_numeric($_GET['categoryid']) ? intval($_GET['categoryid']) : 0; //short if condition
        $category = $categoryObject->find("Category_ID='$categoryid'");
    ?>

        <h1 class="text-center edit">Edit category</h1>
        <div class="container ">
            <form class="row g-3 needs-validation edit-from  " action="categories.php?do=update" method="POST" novalidate>
                <input type="hidden" name="categoryid" value="<?php echo $categoryid ?>">

                <div class="col-12 form-control-lg">
                    <label for="validationCustom01" class="form-label ">category Name</label>
                    <input type="text" class="form-control " name="categoryname" autocomplete="off" value="<?php echo $category['Category_Name'] ?>" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please Enter category name.
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

            $categoryid = $_POST['categoryid'];
            $categoryname = $_POST['categoryname'];

            //first name validation
            if (preg_match('([0-9]|[0-9])', $categoryname)) //if first name contains numbers
            {
                $errors[] = 'first name can not contain numbers only characters';
            }
            if (strlen($categoryname) < 3) {
                $errors[] = 'first name cant be less than 4';
            }
            if (strlen($categoryname) > 20) {
                $errors[] = 'first name cant be more than 20';
            }
            if (empty($categoryname)) {
                $errors[] = 'first name cant be empty';
            }
            $count = $categoryObject->unique("Category_Name ='$categoryname' AND Category_ID !='$categoryid'");
            if ($count > 0) {
                $errors[] = 'this user names already exsists';
            }

            if (isset($errors)) {
                foreach ($errors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
            } else {
                $category = $categoryObject->update("Category_Name=? WHERE Category_ID=?", array($categoryname, $categoryid));
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
        $categoryid = isset($_GET['categoryid']) && is_numeric($_GET['categoryid']) ? intval($_GET['categoryid']) : 0; //short if
        $count = $categoryObject->unique("Category_ID ='$categoryid'");

        if ($count > 0) {
            $category = $categoryObject->delete(" Category_ID='$categoryid'");
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
