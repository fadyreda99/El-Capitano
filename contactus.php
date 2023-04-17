<?php
ob_start();
session_start();
if (isset($_SESSION['userName'])) {
    $pageTitle = 'contact us';
    include('int.php');
    include $tpl . "navbarUser.php";
    $userObject = new users();
    $contactObject = new contacts();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $formErrors = array();

        $email = $_POST['email'];
        $mobile = filter_var($_POST['mobile'], FILTER_SANITIZE_NUMBER_INT);
        $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
        $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

        //validation ll mail
        if (empty($email)) {
            $formErrors[] = 'this email can not be ampty';
        }
        if (isset($email)) {
            //b3ml ll email filter 3lshan lw kan mktob gwa tags
            $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
            // b3ml check 3la l email elu 3mltlo filter lw hwa valid wla la
            if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {
                $formErrors[] = 'this email is not valid';
            }
        }

        //mobile validation
        if (preg_match('([a-zA-Z].*[a-zA-Z])', $mobile)) //if last name contains numbers
        {
            $formErrors[] = 'phone number can not contain characters only numbers';
        }
        if (strlen($mobile) < 11) {
            $formErrors[] = 'phone can not less than 11 ';
        }
        if (strlen($mobile) > 11) {
            $formErrors[] = 'phone can not more than 11 ';
        }
        if (empty($mobile)) {
            $formErrors[] = 'phone cant be empty';
        }


        //subject validation
        if (preg_match('([0-9]|[0-9])', $subject)) //if first name contains numbers
        {
            $formErrors[] = 'subject can not contain numbers only characters';
        }
        if (strlen($subject) < 10) {
            $formErrors[] = 'subject cant be less than 10';
        }
        if (strlen($subject) > 40) {
            $formErrors[] = 'subject cant be more than 40';
        }
        if (empty($subject)) {
            $formErrors[] = 'subject cant be empty';
        }




        //message validation
        if (preg_match('([0-9]|[0-9])', $message)) //if first name contains numbers
        {
            $formErrors[] = 'message can not contain numbers only characters';
        }
        if (strlen($message) < 30) {
            $formErrors[] = 'message cant be less than 30';
        }
        if (strlen($message) > 500) {
            $formErrors[] = 'message cant be more than 500';
        }
        if (empty($message)) {
            $formErrors[] = 'message cant be empty';
        }


        if (empty($formErrors)) {

            $contactObject->insert(
                "(Email, Mobile, Subject, Message, userid) VALUES (?,?,?,?,?)",
                array($filterdEmail, $mobile, $subject, $message, $_SESSION['uid'])
            );
            if ($contactObject) {
                header('location:drivers.php');
            }
        }
    }
?>

    <div class="container">
        <?php
        if (isset($formErrors)) {
            foreach ($formErrors as $error) {
        ?>

                <div class="alert alert-danger alert-dismissible fade show error-alert" role="alert">
                    <?php echo $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        <?php

            }
        }



        ?>

        <form class="row g-3 needs-validation mt-5 mb-5 contactus " action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" novalidate>

            <div class="col-12 form-control-lg">
                <label for="validationCustom01" class="form-label ">Email</label>
                <input type="email" class="form-control " name="email" autocomplete="off" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please enter email.
                </div>
            </div>



            <div class="col-12 form-control-lg">
                <abel for="validationCustomUsername" class="form-label">Mobile</label>
                    <input type="text" class="form-control" name="mobile" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter your mobile phone.
                    </div>
            </div>


            <div class="col-12 form-control-lg">
                <abel for="validationCustomUsername" class="form-label">Subject</label>
                    <input type="text" class="form-control" name="subject" autocomplete="off" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please enter a subject of message.
                    </div>
            </div>

            <div class="form-floating form-control-lg">
                <abel for="validationCustomUsername" class="form-label">your message</label>
                    <textarea class="form-control" name="message" id="floatingTextarea2" style="height: 100px" required></textarea>

            </div>


            <div class="col-12 form-control-lg">
                <button class="btn btn-primary " type="submit" value="add user">send message</button>
            </div>

        </form>

    </div>





<?php
    include $tpl . ('footer.php');
} else {
    header('location:login.php');
}
ob_end_flush();
