<?php
/*log in page*/
ob_start();
session_start();
$pageTitle = 'login';

if (isset($_SESSION['userName'])) {
  header('location:profile.php');
} elseif (isset($_SESSION['admin'])) {
  header('location:admin/dashboard.php');
}

$noNavbar = '';

include 'int.php';
$userObject = new users();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE User_Name= '$username'");
    $stmt->execute();
    $count = $stmt->rowCount();

    if ($count > 0) {
      $user = $stmt->fetch();
      if (password_verify($password, $user['Password'])) {
        if ($user['Group_ID'] == 2) {
          $_SESSION['admin'] = $username;

          $_SESSION['ID'] = $user['User_ID'];
          header('location:admin/dashboard.php');
          exit();
        } else {
          $_SESSION['userName'] = $username;

          $_SESSION['uid'] = $user['User_ID'];
          if ($user['Group_ID'] == 1) {
            header('location:profile.php');
          } elseif ($user['Group_ID'] == 0) {
            header('location:drivers.php');
          }
        }

      } else {
        $formErrors[] = 'please write your right password';
      }
    } else {
      $formErrors[] = 'please write your right User Name and right password';
    }
  } else {
    //validation and filtter  lazm a3ml kda lma l user hwa ely ygy ysgl
    $formErrors = array();

    $username = $_POST['username'];
    $password = $_POST['password'];
    $repassword = $_POST['re-password'];
    $email = $_POST['email'];
    $groupid = $_POST['groupid'];

    //user name ely gy mn l reg form lw el user 7to fe tags by fltro w yb2a string
    if (isset($username)) {
      $filterdUser = filter_var($username, FILTER_SANITIZE_STRING);
      if (strlen($filterdUser) < 4) {
        $formErrors[] = 'user name must be more than 4 characters';
      }
      if (strlen($filterdUser) > 20) {
        $formErrors[] = 'user name cant be more than 20';
      }
    }
    if (empty($username)) {
      $formErrors[] = 'user name cant be empty';
    }

    //validation ll password
    if (empty($password)) {
      $formErrors[] = 'sorry password can not be empty';
    }
    if (empty($repassword)) {
      $formErrors[] = 'please write again your password in correctly';
    }
    if (isset($password) && isset($repassword)) {
      if (strlen($password) < 6) {
        $formErrors[] = 'password must be more than 6 characters';
      }
      if (strlen($password) > 30) {
        $formErrors[] = 'password cant be more than 30';
      }
      if ($password !== $repassword) {
        $formErrors[] = 'the passwords is not match';
      } else {
        $passHash1 = password_hash($password, PASSWORD_BCRYPT);
      }
    }

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

    // radio validation
    if ($groupid != 0) {
      if ($groupid != 1) {
        $formErrors[] = 'please choose you will be a driver or user?';
      }
    }

    if (empty($formErrors)) {
      $count = $userObject->unique("User_Name='$username'");
      if ($count > 0) {
        $formErrors[] = 'user name is exists';
      }

      $count = $userObject->unique("Email='$email'");
      if ($count > 0) {
        $formErrors[] = 'email is exists';
      } else {
        $userObject->insert(
          "(User_Name, Password, Email , Group_ID ) VALUES (?,?,?,?)",
          array($username, $passHash1, $filterdEmail, $groupid)
        );
        header('location:login.php');
        exit();
      }
    }
  }
}
?>
<div class="login-register containeer container-fluid">
  <div class="forms-container">
    <div class="signin-signup">
      <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="sign-in-form login">
        <?php
        if (!empty($formErrors)) {
          foreach ($formErrors as $error) { ?>

            <div class="alert alert-danger alert-dismissible fade show error-alert error rounded-pill" role="alert">
              <?php echo $error ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        <?php
          }
        } ?>

        <h2 class="title">Login</h2>

        <div class="input-field">
          <i class="fas fa-envelope"></i>
          <input type="text" name="username" autocomplete="off" placeholder="user name" required />
        </div>

        <div class="input-field">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" autocomplete="new-password" placeholder="Password" required />
        </div>

        <input type="submit" value="login" name="login" class="btn solid" />

        <div class="row signup_btn">
          <div class="col-md-12">
            Not yet Registered ? <a id="sign-up-btn">Register</a>
          </div>
        </div>
      </form>

      <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="sign-up-form signup">
        <h2 class="title">Register</h2>

        <div class="input-field">
          <i class="fas fa-user"></i>
          <input type="text" name="username" autocomplete="off" placeholder="Username" required />
        </div>

        <div class="input-field">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="Email" required />
        </div>

        <div class="input-field">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" autocomplete="new-password" placeholder="Password" required />
        </div>

        <div class="input-field">
          <i class="fas fa-lock"></i>
          <input type="password" name="re-password" autocomplete="new-password" placeholder="re-Password" required />
        </div>

        <div class="row">
          <div class="form-check   input-field2 col-md-3 col-sm-12 offset-md-2 form-check-inline">
            <input class="form-check-input " type="radio" name="groupid" value="0" required>
            <label class="form-check-label" for="inlineRadio1">User</label>
          </div>

          <div class="form-check  input-field2 col-md-3 col-sm-12 offset-md-2  form-check-inline" style="margin-left: 75px;">
            <input class="form-check-input" type="radio" name="groupid" value="1" required>
            <label class="form-check-label" for="inlineRadio2">Driver</label>
          </div>
        </div>

        <input type="submit" class="btn signup__btn " name="signup" value="Signup" />

        <div class="row login_btn">
          <div class="col-md-12 offset-md-4 ">
            Already Registered ? <a id="sign-in-btn">Login </a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="panels-container">
    <div class="panel left-panel">
      <div class="content">
        <h3>One of us ?</h3>
        <p>
          We wish you a nice and comfortable journey with us.
        </p>
      </div>
      <img src="images/default/login.svg" class="image" alt="" />
    </div>

    <div class="panel right-panel">
      <div class="content">
        <h3>New here ?</h3>
        <p>
          Don't west the time. join to us and you well find your comfort.
        </p>
      </div>
      <img src="images/default/login.svg" class="image" alt="" />
    </div>
  </div>
</div>
<script src="/gradproject/layout/js/app.js"> </script>
<?php
ob_end_flush();
