<?php
ob_start();
session_start();

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/dcc7c3c492.js" crossorigin="anonymous"></script>


  <!-- rate -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href=" \gradproject\layout\css\prehome.css">
  <title>home</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light nav33">
    <div class="container-fluid">
      <a class="navbar-brand nav-link" href="#">
        <img class="image2 " src="./images/logo/2.png" alt="">
        AL-CAPITANO
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

          <li class="nav-item">
            <a href="login.php"> <i class="fas fa-sign-in-alt"></i> <span>Login</span> / <span>Register</span> </a>

          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">
              <div class='' id="google_translate_element"></div>
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
    </div>
  </nav>

  <div class="home2">
    <section class="home-img">
      <div class="col-md-12">
        <img src="images/default/home66.jpeg" alt="">
        <div class="text">CHOOSE YOUR <span>COMFORT</span></div>

      </div>
    </section>
  </div>

  <section class="find mb-5">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="text-center">Why Us!!</h2>
          <p class="text-center">We are professional in this field.</p>
          <p class="text-center">You will search by your self on special driver and start chat with him to make a deal.</p>
          <p class="text-center">you will agree on everything related to your trip with him.</p>

        </div>
      </div>
    </div>
  </section>

  <section class="use">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="text-center mt-5">
            <h1>How To Use It!!?</h1>
          </div>
        </div>
        <div class="col-md-6">
          <video src="video/using.mp4" controls muted type="video" class="video"></video>
        </div>
        <div class="col-md-6">
          <ul>
            <li>Signup as user or driver</li>
            <li>Log in by email and password</li>
            <li>Complete the rest of your data</li>
            <li>If you a normal user. Enjoy by your trips</li>
            <li>If yo a driver. we will contact you to make an interview.</li>
            <li>Wait us to activated you.</li>
          </ul>
        </div>
      </div>
    </div>

  </section>

  <section class="somedrivers">
    <h2>Some our drivers</h2>
    <div class="container">
      <div class="row">

        <div class="col-md-3">
          <div class="third">
            <img src="images/default/image.jfif" alt="">
            <h3>samuel yousef</h3>
            <h4>cairo</h4>
            <div class="rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4>golf 2</h4>
            <a href="login.php" class="btn btn-primary">view profile</a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="third">
            <img src="images/default/image.jfif" alt="">
            <h3>ahmed mohamed</h3>
            <h4>giza</h4>
            <div class="rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h3>mazda</h3>
            <a href="login.php" class="btn btn-primary">view profile</a>
          </div>

        </div>
        <div class="col-md-3">
          <div class="third">
            <img src="images/default/image.jfif" alt="">
            <h3>medhat ahmed</h3>
            <h4>cairo</h4>
            <div class="rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h3>giza</h3>
            <a href="login.php" class="btn btn-primary">view profile</a>
          </div>

        </div>
        <div class="col-md-3">
          <div class="third">
            <img src="images/default/image.jfif" alt="">
            <h3>mohamed mohamed</h3>
            <h4>giza</h4>
            <div class="rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h3>cairo</h3>
            <a href="login.php" class="btn btn-primary">view profile</a>
          </div>
        </div>
      </div>
  </section>

  <section class="aboutus">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center">ABOUT US</h1>
        </div>
        <div class="col-12 info">
          <h4>We are AL-Capitano Group</h4>
          <h4>Fady Reda</h4>
          <h4>Rghad Omar</h4>
          <h4>Abanoub Simon</h4>
          <h4>you can contact us from our website or from this Email</p>
            <h4>alcapitano975@gmail.com</h4>

        </div>
      </div>
    </div>
  </section>

  <footer class="container-fluid footerhome">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-12  copy mb-4 mt-0 fo"><br><br>
            &copy 2020/2021 All Rights Reserved by Al - Capitano.
          </div>
        </div>

        <section class="icons">
          <div class="row text-center">
            <div class="col-12">
              <a href="https://www.facebook.com/Al-Capitano-100615638929172/" target="_blank"><i class="fab fa-facebook-square"></i></a>
              <a href="https://www.instagram.com/alcapitano975/" target="_blank"><i class="fab fa-instagram-square"></i></a>
              <!-- <a href="#"><i class="fab fa-twitter-square"></i></a> -->
            </div>
          </div>

        </section>
        <br><br>

      </div>
    </div>
  </footer>


  <script src="layout\js\jquery-3.5.1.min.js"> </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="/gradproject/layout/js/navlang.js"> </script>
  <?php


  ob_end_flush();
  ?>
</body>

</html>