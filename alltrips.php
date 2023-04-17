<?php
ob_start();
session_start();
$pageTitle = 'trips';
include 'int.php';
include $tpl . "navbarUser.php";

$tripObject= new trips();
$driverObject = new drivers();
$userObject = new users();

if (isset($_SESSION['userName'])) {
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['rating'])){
            //rate
       
            $rating =$_POST['rating'];
            $driverid =$_POST['driverid'];
            $tripid =$_POST['tripid'];

            
            
          
             $stmt=$conn->prepare("INSERT INTO feedback (rating , UserID , DriverID , TripID) VALUES (?,?,?,?)");
             $stmt->execute(array ($rating , $_SESSION['uid'] ,$driverid, $tripid));
          
             if($stmt){
                 
               $msg="<div class='alert alert-primary'>success</div>";
               header("location:alltrips.php");
               echo $driverid;
             }
          }}
    $user = $userObject->find("User_Name='{$_SESSION["userName"]}'");
    if ($user['Group_ID'] == 1) {

        if(isset($_GET['do'])){
            $do=$_GET['do'];
        }else{
            $do='manage';
        }
        
        if($do == 'manage'){
           $trips=$tripObject->all("DriverID = {$_SESSION['uid']} ORDER BY Trip_Date");

        
            if(!empty($trips)){
                ?>
                <h1 class="text-center edit">All trips</h1>
                <div class="container ">
                    <div class="table-responsive trips-table">
                        <table class="table main-table text-center  " >
                        <thead>
                                <tr>
                                   
                                    <td class="">   User Name   </td>
                                    
                                    <td class="">   User Mobile   </td>
                                    
                                    <td class="">   Trip Date         </td>
                                    <td class="">   Trip Day       </td>
                                    <td class="">   From   </td>
                                    <td class="">   To   </td>
                                    <td class="">   Cost   </td>
                                    <td class="">   Status   </td>
                                    <td>controllers</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($trips as $trip){  ?>
                            <tr>
                               
                                <td><?php echo $trip['Full_Name_User'] ?></td>
                                
                                <td><?php echo $trip['Phone_User'] ?></td>
                                
                                <td><?php echo $trip['Trip_Date'] ?></td>
                                <td><?php echo $trip['Trip_Day'] ?></td>
                                <td><?php echo $trip['From_Place'] ?></td>
                                <td><?php echo $trip['To_Place'] ?></td>
                                <td><?php echo $trip['Trip_Cost'] ?></td>
                                <td>
                                    <?php
                                        if($trip['Status']==0){
                                            ?>
                                            
                                            <a class="btn btn-primary mb-2" href="alltrips.php?do=finish&tripid=<?php echo $trip['Trip_ID'] ?>">finished</a>
                                            <a class="btn btn-danger" href="alltrips.php?do=cancel&tripid=<?php echo $trip['Trip_ID'] ?>">cancle</a>
                                            <?php
                                        }elseif($trip['Status']==1){
                                            echo "completed";
                                        }else{
                                            echo "cancelled";
                                        }
                                    ?>
                                </td>
                                <td>
                              
                                <a class="btn btn-primary" href="alltrips.php?do=view&tripid=<?php echo $trip['Trip_ID'] ?>">view trip</a>

                                        
                                </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="row text-center " style="width: 100%;">
                            <div class="col-4">
                            <a class="btn btn-primary mb-2" href="alltrips.php?do=unfinish">unfinished trips</a>

                            </div>
                            <div class="col-4">
                            <a class="btn btn-success mb-2" href="alltrips.php?do=finished">finished trips</a>

                                </div>
                                <div class="col-4">
                                <a class="btn btn-danger mb-2 " href="alltrips.php?do=cancelled">cancelled trips</a>

                                </div>
                        </div>
                    </div>
                </div>

                <?php
            }else{
                ?>
                <div class="container">
                    <div class="alert alert-danger mt-3 error3"> no trips available to you </div>
                </div>
                
                <?php
            }
        }
        
        elseif($do == 'view'){
            $tripid= isset($_GET['tripid']) && is_numeric($_GET['tripid']) ? intval($_GET['tripid']) : 0;

            $trip = $tripObject->find("Trip_ID ='{$tripid}'");

            ?>
            <section class="view-trip">
                <div class="container">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <div class="col-md-4 col-12">
                                <div class="card shadow mt-3 mb-5 ">
                                    <div class="card-header">
                                        <h3>
                                            Trip Details 
                                            <span class="float-end">
                                                <h6>
                                                    <?php
                                                    if($trip['Status'] == 0){ echo "UnFinished"; }
                                                    if($trip['Status'] == 1){ echo "Finished"; }
                                                    if($trip['Status'] == 2){ echo "Cancelled"; }

                                                    ?>
                                                <h6>
                                            </span>
                                        
                                        </h3>
                                        
                                    </div>
                                    <div class="card-body">
                                    <div>
                                            Your name : <?php echo $trip['Driver_Name'] ?>
                                        </div>
                                        <hr>
                                        <div>
                                            Client name: <?php echo $trip['Full_Name_User'] ?>
                                        </div>
                                        <div>
                                        Client email: <?php echo $trip['Email_User'] ?>
                                        </div>
                                        <div>
                                        Client phone: <?php echo $trip['Phone_User'] ?>
                                        </div>
                                        <hr>
                                        
                                        
                                        <div class="">
                                            date of trip : <?php echo $trip['Trip_Date'] ?>
                                        </div>
                                        <div class="">
                                            day of trip : <?php echo $trip['Trip_Day'] ?>
                                        </div>
                                        <hr>
                                       <div>
                                            from: <?php echo $trip['From_Place'] ?>
                                       </div>
                                       <div>
                                            to: <?php echo $trip['To_Place'] ?>
                                       </div>
                                       <div>
                                            cost: <?php echo $trip['Trip_Cost'] ?>
                                       </div>

                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a class="btn btn-primary mb-2" href="profileuser.php?userid=<?php echo $trip['UserID'] ?>">profile</a>
                                            </div>
                                            <?php
                                                 if($trip['Status'] == 0){
                                                     ?>
                                                     <div class="col-md-4">
                                                        <a class="btn btn-success mb-2" href="alltrips.php?do=finish&tripid=<?php echo $trip['Trip_ID'] ?>">finished</a>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <a class="btn btn-danger" href="alltrips.php?do=cancel&tripid=<?php echo $trip['Trip_ID'] ?>">cancle</a>
                                                    </div>
                                                     <?php

                                                 }

                                                 if($trip['Status'] == 1){
                                                    ?>
                                                    <div class="col-md-4">
                                                    <form action="report.php" method="POST">
                                                            <input type="hidden" name="report-receiver" value="<?php echo $trip['UserID'] ?>">
                                                            <input type="hidden" name="trip-id" value="<?php echo $trip['Trip_ID'] ?>">
                                                            <input type="submit" class="btn btn-danger" value="Report">
                                                        </form>
                                                    </div>
                                                    
                                                    <?php
                                                 }

                                                 if($trip['Status'] == 2){
                                                    ?>
                                                    <div class="col-md-4">
                                                        <form action="report.php" method="POST">
                                                            <input type="hidden" name="report-receiver" value="<?php echo $trip['UserID'] ?>">
                                                            <input type="hidden" name="trip-id" value="<?php echo $trip['Trip_ID'] ?>">
                                                            <input type="submit" class="btn btn-danger" value="Report">
                                                        </form>
                                                    </div>
                                                
                                                    <?php
                                                 }

                                            ?>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                                
           
            </section>



            <?php

            
         }
        elseif($do == 'finish'){
            $tripid= isset($_GET['tripid']) && is_numeric($_GET['tripid']) ? intval($_GET['tripid']) : 0;

            $count=$tripObject->unique("Trip_ID='$tripid'");
            
            if($count>0){         
                $trip=$tripObject->update("Status = 1 WHERE Trip_ID=?", array ($tripid));
                header("location: alltrips.php");
               
            }else{
                header("location: alltrips.php");
                }
        }
        elseif($do == 'cancel'){
            $tripid= isset($_GET['tripid']) && is_numeric($_GET['tripid']) ? intval($_GET['tripid']) : 0;

            $count=$tripObject->unique("Trip_ID='$tripid'");
            
            if($count>0){         
                $trip=$tripObject->update("Status = 2 WHERE Trip_ID=?", array ($tripid));
                header("location: alltrips.php");
               
            }else{
                header("location: alltrips.php");
                }
        }
        elseif($do == 'unfinish'){
            $trips=$tripObject->all("DriverID = {$_SESSION['uid']} AND Status = 0 ORDER BY Trip_Date");
            if(!empty($trips)){
                ?>
                <h1 class="text-center edit">UnFinished trips</h1>
                <div class="container ">
                    <div class="table-responsive trips-table">
                        <table class="table main-table text-center  ">
                        <thead>
                                <tr>
                                    
                                    <td class="">   USer Name   </td>
                                   
                                    <td class="">   User Mobile   </td>
                                   
                                    <td class="">   Trip Date         </td>
                                    <td class="">   Trip Day       </td>
                                    <td class="">   From   </td>
                                    <td class="">   To   </td>
                                    <td class="">   Cost   </td>
                                    <td class="">   Status   </td>
                                    <td>controllers</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($trips as $trip){  ?>
                            <tr>
                                
                                <td><?php echo $trip['Full_Name_User'] ?></td>
                              
                                <td><?php echo $trip['Phone_User'] ?></td>
                              
                                <td><?php echo $trip['Trip_Date'] ?></td>
                                <td><?php echo $trip['Trip_Day'] ?></td>
                                <td><?php echo $trip['From_Place'] ?></td>
                                <td><?php echo $trip['To_Place'] ?></td>
                                <td><?php echo $trip['Trip_Cost'] ?></td>
                                <td>
                                    <?php
                                        if($trip['Status']==0){
                                            ?>
                                            <a class="btn btn-primary" href="alltrips.php?do=finish&tripid=<?php echo $trip['Trip_ID'] ?>">finished</a>
                                            <a class="btn btn-danger" href="alltrips.php?do=cancel&tripid=<?php echo $trip['Trip_ID'] ?>">cancle</a>
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td>
                              
                                <a class="btn btn-primary" href="alltrips.php?do=view&tripid=<?php echo $trip['Trip_ID'] ?>">view trip</a>
                                        
                                </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                                        
                                        <a class="btn btn-success" href="alltrips.php?do=finished">finished trips</a>
                                        <a class="btn btn-danger" href="alltrips.php?do=cancelled">cancelled trips</a>
                    </div>
                </div>

                <?php
            }else{
                ?>
                <div class="container">
                    <div class="alert alert-danger mt-3 error3"> no trips available to you </div>
                </div>
                
                <?php
            }
        }

        
        elseif($do == 'finished'){
            $trips=$tripObject->all("DriverID = {$_SESSION['uid']} AND Status = 1 ORDER BY Trip_Date");

        
            if(!empty($trips)){
                ?>
                <h1 class="text-center edit">Finished trips</h1>
                <div class="container ">
                    <div class="table-responsive trips-table">
                        <table class="table main-table text-center  ">
                        <thead>
                                <tr>
                                    
                                    <td class="">   USer Name   </td>
                                   
                                    <td class="">   User Mobile   </td>
                                   
                                    <td class="">   Trip Date         </td>
                                    <td class="">   Trip Day       </td>
                                    <td class="">   From   </td>
                                    <td class="">   To   </td>
                                    <td class="">   Cost   </td>
                                    <td class="">   Status   </td>
                                    <td>controllers</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($trips as $trip){  ?>
                            <tr>
                              
                                <td><?php echo $trip['Full_Name_User'] ?></td>
                              
                                <td><?php echo $trip['Phone_User'] ?></td>
                         
                                <td><?php echo $trip['Trip_Date'] ?></td>
                                <td><?php echo $trip['Trip_Day'] ?></td>
                                <td><?php echo $trip['From_Place'] ?></td>
                                <td><?php echo $trip['To_Place'] ?></td>
                                <td><?php echo $trip['Trip_Cost'] ?></td>
                                <td>
                                   Finished
                                </td>
                                <td>
                            
                                <a class="btn btn-primary" href="alltrips.php?do=view&tripid=<?php echo $trip['Trip_ID'] ?>">view trip</a>
                                        
                                </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                                        <a class="btn btn-primary" href="alltrips.php?do=unfinish">unfinished trips</a>
                                        
                                        <a class="btn btn-danger" href="alltrips.php?do=cancelled">cancelled trips</a>
                    </div>
                </div>

                <?php
            }else{
                ?>
                <div class="container">
                    <div class="alert alert-danger mt-3 error3"> no trips available to you </div>
                </div>
                
                <?php
            }
        }
        elseif($do == 'cancelled'){
            $trips=$tripObject->all("DriverID = {$_SESSION['uid']} AND Status = 2 ORDER BY Trip_Date");

        
            if(!empty($trips)){
                ?>
                <h1 class="text-center edit">Cancelled trips</h1>
                <div class="container ">
                    <div class="table-responsive trips-table">
                        <table class="table main-table text-center  ">
                        <thead>
                                <tr>
                                    
                                    <td class="">   USer Name   </td>
                        
                                    <td class="">   User Mobile   </td>
                                 
                                    <td class="">   Trip Date         </td>
                                    <td class="">   Trip Day       </td>
                                    <td class="">   From   </td>
                                    <td class="">   To   </td>
                                    <td class="">   Cost   </td>
                                    <td class="">   Status   </td>
                                    <td>controllers</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($trips as $trip){  ?>
                            <tr>
                             
                                <td><?php echo $trip['Full_Name_User'] ?></td>
                               
                                <td><?php echo $trip['Phone_User'] ?></td>
                              
                                <td><?php echo $trip['Trip_Date'] ?></td>
                                <td><?php echo $trip['Trip_Day'] ?></td>
                                <td><?php echo $trip['From_Place'] ?></td>
                                <td><?php echo $trip['To_Place'] ?></td>
                                <td><?php echo $trip['Trip_Cost'] ?></td>
                                <td>
                                   cancelled
                                </td>
                                <td>
                             
                                <a class="btn btn-primary" href="alltrips.php?do=view&tripid=<?php echo $trip['Trip_ID'] ?>">view trip</a>
                                        
                                </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                                        <a class="btn btn-primary" href="alltrips.php?do=unfinish">unfinished trips</a>
                                        <a class="btn btn-success" href="alltrips.php?do=finished">finished trips</a>
                                        
                    </div>
                </div>

                <?php
            }else{
                ?>
                <div class="container">
                    <div class="alert alert-danger mt-3 error3"> no trips available to you </div>
                </div>
                
                <?php
            }
        }

    
    }else{
        if(isset($_GET['do'])){
            $do=$_GET['do'];
        }else{
            $do='manage';
        }

        if($do == 'manage'){
            $trips=$tripObject->all("UserID = {$_SESSION['uid']} ORDER BY Trip_Date");
 
         
             if(!empty($trips)){
                 ?>
                 <h1 class="text-center edit">All trips</h1>
                 <div class="container ">
                     <div class="table-responsive trips-table">
                         <table class="table main-table text-center  ">
                         <thead>
                                 <tr>
                                     
                                     <td class="">   User Name  </td>
                                   
                                     <td class="">   Driver Name      </td>
                                     <td class="">   Trip Date         </td>
                                     <td class="">   Trip Day       </td>
                                     <td class="">   From   </td>
                                     <td class="">   To   </td>
                                     <td class="">   Cost   </td>
                                     <td class="">   Status   </td>
                                     <td>controllers</td>
                                 </tr>
                             </thead>
                             <tbody>
                             <?php foreach($trips as $trip){  ?>
                             <tr>
                                
                                 <td><?php echo $trip['Full_Name_User'] ?></td>
                               
                                 <td><?php echo $trip['Driver_Name'] ?></td>
                                 <td><?php echo $trip['Trip_Date'] ?></td>
                                 <td><?php echo $trip['Trip_Day'] ?></td>
                                 <td><?php echo $trip['From_Place'] ?></td>
                                 <td><?php echo $trip['To_Place'] ?></td>
                                 <td><?php echo $trip['Trip_Cost'] ?></td>
                                 <td>
                                     <?php
                                         if($trip['Status']==0){
                                             ?>
                                             <a class="btn btn-primary mb-2" href="alltrips.php?do=finish&tripid=<?php echo $trip['Trip_ID'] ?>">finished</a>
                                             <a class="btn btn-danger" href="alltrips.php?do=cancel&tripid=<?php echo $trip['Trip_ID'] ?>">cancle</a>
                                             <?php
                                         }elseif($trip['Status']==1){
                                             echo "completed";
                                         }else{
                                             echo "cancelled";
                                         }
                                     ?>
                                 </td>
                                 <td>
                                            <a class="btn btn-primary" href="alltrips.php?do=view&tripid=<?php echo $trip['Trip_ID'] ?>">view trip</a>
                                        </td>
                                 </tr>
                             <?php } ?>
                             </tbody>
                         </table>
                                         <a class="btn btn-primary mb-2" href="alltrips.php?do=unfinish">unfinished trips</a>
                                         <a class="btn btn-success mb-2" href="alltrips.php?do=finished">finished trips</a>
                                         <a class="btn btn-danger mb-2" href="alltrips.php?do=cancelled">cancelled trips</a>
                     </div>
                 </div>
 
                 <?php
             }else{
                 ?>
                 <div class="container">
                     <div class="alert alert-danger mt-3 error3"> no trips available to you </div>
                 </div>
                 
                 <?php
             }
         }


         elseif($do == 'view'){
            $tripid= isset($_GET['tripid']) && is_numeric($_GET['tripid']) ? intval($_GET['tripid']) : 0;

            $trip = $tripObject->find("Trip_ID ='{$tripid}'");

            ?>
            <section class="view-trip">
                <div class="container">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <div class="col-md-4 col-12">
                                <div class="card shadow mt-3 mb-5 ">
                                    <div class="card-header">
                                        <h3>
                                            Trip Details 
                                            <span class="float-end">
                                                <h6>
                                                    <?php
                                                    if($trip['Status'] == 0){ echo "UnFinished"; }
                                                    if($trip['Status'] == 1){ echo "Finished"; }
                                                    if($trip['Status'] == 2){ echo "Cancelled"; }

                                                    ?>
                                                <h6>
                                            </span>
                                        
                                        </h3>
                                        
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            your name: <?php echo $trip['Full_Name_User'] ?>
                                        </div>
                                        <div>
                                            your email: <?php echo $trip['Email_User'] ?>
                                        </div>
                                        <div>
                                            your phone: <?php echo $trip['Phone_User'] ?>
                                        </div>
                                        <hr>
                                        <div>
                                            driver name : <?php echo $trip['Driver_Name'] ?>
                                        </div>
                                        <hr>
                                        
                                        <div class="">
                                            date of trip : <?php echo $trip['Trip_Date'] ?>
                                        </div>
                                        <div class="">
                                            day of trip : <?php echo $trip['Trip_Day'] ?>
                                        </div>
                                        <hr>
                                       <div>
                                            from: <?php echo $trip['From_Place'] ?>
                                       </div>
                                       <div>
                                            to: <?php echo $trip['To_Place'] ?>
                                       </div>
                                       <div>
                                            cost: <?php echo $trip['Trip_Cost'] ?>
                                       </div>

                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a class="btn btn-primary mb-2" href="driverprofile.php?driverid=<?php echo $trip['DriverID'] ?>">profile</a>
                                            </div>
                                            <?php
                                                 if($trip['Status'] == 0){
                                                     ?>
                                                     <div class="col-md-4">
                                                        <a class="btn btn-success mb-2" href="alltrips.php?do=finish&tripid=<?php echo $trip['Trip_ID'] ?>">finished</a>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <a class="btn btn-danger mb-2" href="alltrips.php?do=cancel&tripid=<?php echo $trip['Trip_ID'] ?>">cancle</a>
                                                    </div>
                                                     <?php

                                                 }

                                                 if($trip['Status'] == 1){
                                                    ?>
                                                    <div class="col-md-4 mb-2">
                                                    <form action="report.php" method="POST">
                                                            <input type="hidden" name="report-receiver" value="<?php echo $trip['DriverID'] ?>">
                                                            <input type="hidden" name="trip-id" value="<?php echo $trip['Trip_ID'] ?>">
                                                            <input type="submit" class="btn btn-danger" value="Report">
                                                        </form>
                                                    </div>
                                                    <div class="col-md-4 rate mb-2">
                                                        <button type="button" class="btn btn-success " data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                            rate me
                                                        </button>
                                                    </div>
                                                    <?php
                                                 }

                                                 if($trip['Status'] == 2){
                                                    ?>
                                                    <div class="col-md-4">
                                                        <form action="report.php" method="POST">
                                                            <input type="hidden" name="report-receiver" value="<?php echo $trip['DriverID'] ?>">
                                                            <input type="hidden" name="trip-id" value="<?php echo $trip['Trip_ID'] ?>">
                                                            <input type="submit" class="btn btn-danger" value="Report">
                                                        </form>
                                                    </div>
                                                
                                                    <?php
                                                 }

                                            ?>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                                
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">rating</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="" method="POST">
                            <div class="form-group">
                                <label for="">rating</label> 
                                <div id="rateYo"></div>
                        
                            </div>
                            <div class="form-group">
                            <input type="hidden" name="rating" id="rating">
                            <input type="hidden" name="tripid" value="<?php echo  $tripid ?>">
                            <input type="hidden" name="driverid" value="<?php echo  $trip['DriverID'] ?>">
                        
                            </div>
                            

                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button  class="btn btn-primary">submit</button>
                    </div>
                    </form>
                    </div>
                </div>
                </div>
            </section>



            <?php

            
         }

         elseif($do == 'finish'){
            $tripid= isset($_GET['tripid']) && is_numeric($_GET['tripid']) ? intval($_GET['tripid']) : 0;

            $count=$tripObject->unique("Trip_ID='$tripid'");
            
            if($count>0){         
                $trip=$tripObject->update("Status = 1 WHERE Trip_ID=?", array ($tripid));
                header("location: alltrips.php");
               
            }else{
                header("location: alltrips.php");
                }
        }

        elseif($do == 'cancel'){
            $tripid= isset($_GET['tripid']) && is_numeric($_GET['tripid']) ? intval($_GET['tripid']) : 0;

            $count=$tripObject->unique("Trip_ID='$tripid'");
            
            if($count>0){         
                $trip=$tripObject->update("Status = 2 WHERE Trip_ID=?", array ($tripid));
                header("location: alltrips.php");
               
            }else{
                header("location: alltrips.php");
                }
        }

        elseif($do == 'unfinish'){
            $trips=$tripObject->all("UserID = {$_SESSION['uid']} AND Status = 0 ORDER BY Trip_Date");
            if(!empty($trips)){
                ?>
                <h1 class="text-center edit">UnFinished trips</h1>
                <div class="container ">
                    <div class="table-responsive trips-table">
                        <table class="table main-table text-center  ">
                        <thead>
                                <tr>
                                 
                                    <td class="">   Your Name   </td>
                                   
                                    <td class="">   Driver Name      </td>
                                    <td class="">   Trip Date         </td>
                                    <td class="">   Trip Day       </td>
                                    <td class="">   From   </td>
                                    <td class="">   To   </td>
                                    <td class="">   Cost   </td>
                                    <td class="">   Status   </td>
                                    <td>controllers</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($trips as $trip){  ?>
                            <tr>
                                
                                <td><?php echo $trip['Full_Name_User'] ?></td>
                               
                                <td><?php echo $trip['Driver_Name'] ?></td>
                                <td><?php echo $trip['Trip_Date'] ?></td>
                                <td><?php echo $trip['Trip_Day'] ?></td>
                                <td><?php echo $trip['From_Place'] ?></td>
                                <td><?php echo $trip['To_Place'] ?></td>
                                <td><?php echo $trip['Trip_Cost'] ?></td>
                                <td>
                                    <?php
                                        if($trip['Status']==0){
                                            ?>
                                            <a class="btn btn-primary" href="alltrips.php?do=finish&tripid=<?php echo $trip['Trip_ID'] ?>">finished</a>
                                            <a class="btn btn-danger" href="alltrips.php?do=cancel&tripid=<?php echo $trip['Trip_ID'] ?>">cancle</a>
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td>
                                            <a class="btn btn-primary" href="alltrips.php?do=view&tripid=<?php echo $trip['Trip_ID'] ?>">view trip</a>
                                        </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                                        
                                        <a class="btn btn-success" href="alltrips.php?do=finished">finished trips</a>
                                        <a class="btn btn-danger" href="alltrips.php?do=cancelled">cancelled trips</a>
                    </div>
                </div>

                <?php
            }else{
                ?>
                <div class="container">
                    <div class="alert alert-danger mt-3 error3"> no trips available to you </div>
                </div>
                
                <?php
            }
        }

        elseif($do == 'finished'){
            $trips=$tripObject->all("UserID = {$_SESSION['uid']} AND Status = 1 ORDER BY Trip_Date");

        
            if(!empty($trips)){
                ?>
                <h1 class="text-center edit">Finished trips</h1>
                <div class="container ">
                    <div class="table-responsive trips-table">
                        <table class="table main-table text-center  ">
                        <thead>
                                <tr>
                                    
                                    <td class="">   Your Name   </td>
                                    
                                    <td class="">   Driver Name      </td>
                                    <td class="">   Trip Date         </td>
                                    <td class="">   Trip Day       </td>
                                    <td class="">   From   </td>
                                    <td class="">   To   </td>
                                    <td class="">   Cost   </td>
                                    <td class="">   Status   </td>
                                    <td>controllers</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($trips as $trip){  ?>
                            <tr>
                                
                                <td><?php echo $trip['Full_Name_User'] ?></td>
                               
                                <td><?php echo $trip['Driver_Name'] ?></td>
                                <td><?php echo $trip['Trip_Date'] ?></td>
                                <td><?php echo $trip['Trip_Day'] ?></td>
                                <td><?php echo $trip['From_Place'] ?></td>
                                <td><?php echo $trip['To_Place'] ?></td>
                                <td><?php echo $trip['Trip_Cost'] ?></td>
                                <td>
                                   Finished
                                </td>
                                <td>
                                            <a class="btn btn-primary" href="alltrips.php?do=view&tripid=<?php echo $trip['Trip_ID'] ?>">view trip</a>
                                        </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                                        <a class="btn btn-primary" href="alltrips.php?do=unfinish">unfinished trips</a>
                                        
                                        <a class="btn btn-danger" href="alltrips.php?do=cancelled">cancelled trips</a>
                    </div>
                </div>

                <?php
            }else{
                ?>
                <div class="container">
                    <div class="alert alert-danger mt-3 error3"> no trips available to you </div>
                </div>
                
                <?php
            }
        }

        elseif($do == 'cancelled'){
            $trips=$tripObject->all("UserID = {$_SESSION['uid']} AND Status = 2 ORDER BY Trip_Date");

        
            if(!empty($trips)){
                ?>
                <h1 class="text-center edit">Cancelled trips</h1>
                <div class="container ">
                    <div class="table-responsive trips-table">
                        <table class="table main-table text-center  ">
                        <thead>
                                <tr>
                               
                                    <td class="">   Your Name   </td>
                                    
                                    <td class="">   Driver Name      </td>
                                    <td class="">   Trip Date         </td>
                                    <td class="">   Trip Day       </td>
                                    <td class="">   From   </td>
                                    <td class="">   To   </td>
                                    <td class="">   Cost   </td>
                                    <td class="">   Status   </td>
                                    <td>controllers</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($trips as $trip){  ?>
                            <tr>
                               
                                <td><?php echo $trip['Full_Name_User'] ?></td>
                                
                                <td><?php echo $trip['Driver_Name'] ?></td>
                                <td><?php echo $trip['Trip_Date'] ?></td>
                                <td><?php echo $trip['Trip_Day'] ?></td>
                                <td><?php echo $trip['From_Place'] ?></td>
                                <td><?php echo $trip['To_Place'] ?></td>
                                <td><?php echo $trip['Trip_Cost'] ?></td>
                                <td>
                                   cancelled
                                </td>
                                <td>
                                            <a class="btn btn-primary" href="alltrips.php?do=view&tripid=<?php echo $trip['Trip_ID'] ?>">view trip</a>
                                        </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                                        <a class="btn btn-primary" href="alltrips.php?do=unfinish">unfinished trips</a>
                                        <a class="btn btn-success" href="alltrips.php?do=finished">finished trips</a>
                                        
                    </div>
                </div>

                <?php
            }else{
                ?>
                <div class="container">
                    <div class="alert alert-danger mt-3 error3"> no trips available to you </div>
                </div>
                
                <?php
            }
        }



    }

}else{
    header('location:login.php');
    exit();
}
include $tpl . ('footer.php');
ob_end_flush();

