<?php
session_start();
include ('../int.php');

$outgoing_id = $_SESSION['uid'];
$stmt = $conn->prepare("SELECT * FROM users WHERE User_ID = '{$outgoing_id}' ");
$stmt->execute();
$user=$stmt->fetch();

if($user['Group_ID']==1){
  $stmt = $conn->prepare("SELECT * FROM uprofiles 
                          LEFT JOIN users ON users.User_ID = uprofiles.UID
                          LEFT JOIN chats ON chats.userid = uprofiles.UID
                          WHERE NOT User_ID = '{$outgoing_id}' AND Group_ID =0 
                          AND chats.driverid= {$_SESSION['uid']}");
  $stmt->execute();
  $count = $stmt->rowCount();
  $output="";
  if($count == 0 ){
    $output .= "no users are available to chat";
  }elseif($count > 0 ){
    include "data.php";   
  }

  echo $output;
}else{
  $stmt = $conn->prepare("SELECT * FROM drivers 
                          LEFT JOIN users ON users.User_ID = drivers.UserID
                          LEFT JOIN chats ON chats.driverid = drivers.UserID
                        
                          WHERE NOT User_ID = '{$outgoing_id}' AND Group_ID =1
                          AND User_Status=1 AND chats.userid= {$_SESSION['uid']}");
  $stmt->execute();
  $count = $stmt->rowCount();
  $output="";
  if($count == 0 ){
    $output .= "no users are available to chat";
  }elseif($count > 0 ){
    include "data.php";   
  }
  echo $output;
}
