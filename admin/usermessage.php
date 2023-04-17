<?php
ob_start();

session_start();
$pageTitle = 'messages';

if (isset($_SESSION['admin'])) {
    include('int.php');


    $userObject = new users();
    $contactObject = new contacts();



    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'manage';
    }



    //start manage page
    if ($do == 'manage') {


        $contacs = $contactObject->joins(
            "users.User_Name  AS userName",
            "INNER JOIN users        ON users.User_ID            = contacts.userid
                                         WHERE Group_ID=0 "
        );
?>

        <h1 class="text-center edit">User messages</h1>
        <div class="container ">
            <div class="table-responsive">
                <table class="table main-table text-center  ">
                    <thead>
                        <tr>
                            <td class=""> # </td>
                            <td class=""> Email </td>
                            <td class=""> User Name </td>
                            <td class=""> Number </td>
                            <td class=""> Subject </td>
                            <td class=""> controlls </td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($contacs as $contact) {  ?>
                            <tr>
                                <td><?php echo $contact['Message_ID'] ?></td>
                                <td><?php echo $contact['Email'] ?></td>
                                <td><?php echo $contact['userName'] ?></td>
                                <td><?php echo $contact['Mobile'] ?></td>
                                <td><?php echo $contact['Subject'] ?></td>





                                <td class="">
                                    <a href="usermessage.php?do=delete&messageid=<?php echo $contact['Message_ID'] ?>" class="btn btn-danger confirm"> <i class="fa fa-close"></i>Delete</a>
                                    <a href="usermessage.php?do=view&messageid=<?php echo $contact['Message_ID'] ?>" class="btn btn-primary ">view</a>

                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>


            <?php


        }

        //start view page
        elseif ($do == 'view') {
            $messageid = $_GET['messageid'];

            //$user=$userObject->find("userid='$messageid'");
            $contact = $contactObject->find("Message_ID='$messageid'");

            ?>

                <section class="view-trip">
                    <div class="container">
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <div class="col-md-4 col-12">
                                    <div class="card shadow mt-3 mb-5 ">
                                        <div class="card-body">
                                            <div>
                                                Email : <?php echo $contact['Email'] ?>
                                            </div>

                                            <div>
                                                number : <?php echo $contact['Mobile'] ?>
                                            </div>
                                            <hr>
                                            <div>
                                                subject : <?php echo $contact['Subject'] ?>
                                            </div>
                                            <hr>
                                            <div>
                                                <h2>Message</h2>
                                                <p><?php echo $contact['Message'] ?></p>
                                            </div>


                                        </div>
                                        <div class="card-footer">
                                            <a href="users.php?do=view&userid=<?php echo $contact['userid'] ?>" class="btn btn-primary">view profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>




        <?php
        }


        //start delete page
        elseif ($do == 'delete') {
            echo '<h1 class="text-center edit">Delete Users</h1>';
            echo '<div class="container ">';
            $messageid = isset($_GET['messageid']) && is_numeric($_GET['messageid']) ? intval($_GET['messageid']) : 0; //short if
            $count = $contactObject->unique("Message_ID ='$messageid'");

            if ($count > 0) {
                $contact = $contactObject->delete("Message_ID ='$messageid'");
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
