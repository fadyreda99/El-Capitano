
<?php
 $userObject = new users();
 $User = $userObject->find("User_Name='{$_SESSION["userName"]}'");
 if($User['Group_ID']==0){
   ?>
   <footer class="container-fluid">
    <div class="row ">
        <div class="col-md-12">
           <div class="row">  
                <div class="col-md-6 offset-md-4 copy"><br><br>
                  &copy  2020/2021 All Rights Reserved by Al - Capitano.
                </div>
           </div>
           <br><br>
           <section class="icons">
           <div class="row text-center">
                <div class="col-12">
                <a href="https://www.facebook.com/Al-Capitano-100615638929172/" target="_blank"><i class="fab fa-facebook-square"></i></a>
                    <a href="https://www.instagram.com/alcapitano975/" target="_blank"><i class="fab fa-instagram-square"></i></a>
                    <!-- <a href="#"><i class="fab fa-twitter-square"></i></a> -->
                </div>
           </div>
           
           </section>
         <section class="linkss">
         <div class="row ">
           <div class="col-md-6 offset-md-4 links">
                
                <a href="index.php">HOME </a><span>/</span>
                <a href="aboutus.php">ABOUT US   </a><span>/</span>
                <a href="profile.php">MY PROFILE  </a><span>/</span>
                <a href="chat.php">CHAT </a><span>/</span>
                <a href="drivers.php">DRIVERS </a><span>/</span>
                
                
                <a href="contactus.php">CONTACT US </a>
                <br><br>
            </div>
           </div>

         </section>
         
         
        </div>
    </div>
</footer>

   <?php
 }else{
   ?>
    <footer class="container-fluid">
    <div class="row ">
        <div class="col-md-12">
           <div class="row">  
                <div class="col-md-6 offset-md-4 copy"><br><br>
                  &copy  2020/2021 All Rights Reserved by Al - Capitano.
                </div>
           </div>
           <br><br>
           <section class="icons">
           <div class="row text-center">
                <div class="col-12">
                <a href="https://www.facebook.com/Al-Capitano-100615638929172/" target="_blank"><i class="fab fa-facebook-square"></i></a>
                    <a href="https://www.instagram.com/alcapitano975/" target="_blank"><i class="fab fa-instagram-square"></i></a>
                    <!-- <a href="#"><i class="fab fa-twitter-square"></i></a> -->
                </div>
           </div>
           
           </section>
         <section class="linkss">
         <div class="row ">
           <div class="col-md-6 offset-md-4 links-driver">
                
                <a href="index.php">HOME </a><span>/</span>
                <a href="aboutus.php">ABOUT US   </a><span>/</span>
                <a href="profile.php">MY PROFILE  </a><span>/</span>
                <a href="chat.php">CHAT </a><span>/</span>
                
                
                
                <a href="contactus.php">CONTACT US </a>
                <br><br>
            </div>
           </div>

         </section>
         
         
        </div>
    </div>
</footer>




<?php

 }
?>

 

    <script src="layout\js\jquery-3.5.1.min.js">        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="/gradproject/layout/js/frontend.js">   </script>
    <script src="/gradproject/layout/js/frontend2.js">  </script>
    
    <script src="/gradproject/layout/js/users.js">        </script>
    <script src="/gradproject/layout/js/chat.js">        </script>
    <script src="/gradproject/layout/js/navlang.js">        </script>
     <!-- important for rate cdn-->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
     <script src="/gradproject/layout/js/rate.js">        </script>
 

</body>
</html>