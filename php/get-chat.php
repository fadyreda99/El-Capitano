<?php
session_start();
if(isset($_SESSION['userName'])){
    include ('../int.php');
    $outgoing_id = $_POST['outgoing_id'];
    $incoming_id = $_POST['incoming_id'];
    $output = "";
    
    $stmt = $conn->prepare("SELECT * FROM messages 
                            LEFT JOIN users ON users.User_ID = messages.outing_message_id
                            LEFT JOIN drivers ON drivers.UserID = messages.outing_message_id
                            LEFT JOIN uprofiles ON uprofiles.UID = messages.outing_message_id
                            WHERE outing_message_id = {$outgoing_id} AND income_message_id = {$incoming_id}
                            OR outing_message_id = {$incoming_id} AND income_message_id = {$outgoing_id}
                            ORDER BY Message_ID");
    $stmt->execute();
    $count = $stmt->rowCount();
    if($count > 0 ){
        while($msg=$stmt->fetch()){
            if($msg['outing_message_id'] === $outgoing_id){
                $output .= '
                            <div class="chat outgoing">
                                <div class="details">
                                    <p>'. $msg['message'] .'</p>
                                </div>
                            </div>';
            }else{
                if($msg['Group_ID']==1){  
                    $output .=  '
                                <div class="chat incoming">
                                    <img src="images/driverimages/'.$msg['Driver_Image'].'" alt="">
                                    <div class="details">
                                        <p>'. $msg['message'] .'</p>
                                    </div>
                                </div>';
                }else{     
                    $output .=  '
                                <div class="chat incoming">
                                    <img src="images/userimages/'.$msg['User_Image'].'" alt="">
                                    <div class="details">
                                        <p>'. $msg['message'] .'</p>
                                    </div>
                                </div>';
                }
            }   
        }
        echo $output;
    } 
}else{
    header("../login.php");
}
?>