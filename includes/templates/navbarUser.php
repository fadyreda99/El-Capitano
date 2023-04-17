<?php
if (isset($_SESSION['userName'])) {
  $userObject = new users();
  $User = $userObject->find("User_Name='{$_SESSION["userName"]}'");
?>

  <nav class="navbar navbar-expand-lg   navbarTwo">
    <div class="container ">


      <a class="navbar-brand nav-link" href="#">
        <img class="image2 " src="./images/logo/2.png" alt="">

      </a>


      <ul class='navbar-nav'>
        <li class="nav-item nav1">
          <a class="nav-link nav1 head__link" href="#">AL-CAPITANO</a>
        </li>
      </ul>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown2" aria-controls="navbarNavDropdown2" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon i"><i class="fas fa-grip-lines"></i></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end  " id="navbarNavDropdown2">
        <ul class="navbar-nav ">



          <?php if ($User['Group_ID'] == 0) {
            echo '
          <li class="nav-item nav1">
            <a class="nav-link nav1 " href="drivers.php">drivers</a>
          </li>';
          } ?>

          <li class="nav-item nav1">
            <a class="nav-link nav1 " href="chat.php">chat</a>
          </li>

          <li class="nav-item nav1">
            <a class="nav-link" href="contactus.php">contact us</a>
          </li>
          <div class="more  ">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle nav2" href="#" id="navbarDropdownMenuLink2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                more
              </a>
              <ul class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink2">
                <li><a class="dropdown-item nav3" href="profile.php">profile</a></li>
                <li><a class="dropdown-item nav3" href="setting.php">Setting</a></li>
                <li><a class="dropdown-item nav3" href="logout.php">log out</a></li>
              </ul>
            </li>
          </div>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">
              <div id="google_translate_element"></div>
            </a>
          </li>


        </ul>
        <script>
          function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en'
              },
              'google_translate_element'
            );
          }
        </script>
        <script src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
      </div>




      </ul>
    </div>
    </div>
  </nav>
<?php } else {

  header('location:prehome.php');
} ?>