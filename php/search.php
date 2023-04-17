<?php
session_start();
include ('../int.php');
$outgoing_id = $_SESSION['uid'];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE User_ID = '{$outgoing_id}' ");
    $stmt->execute();
    $user=$stmt->fetch();

    if($user['Group_ID']==1){
        $searchTerm = $_POST['searchTerm'];
        $output="";
        
        $stmt = $conn->prepare("SELECT * FROM uprofiles 
                                LEFT JOIN users ON users.User_ID = uprofiles.UID
                                WHERE  Group_ID =0 
                                AND First_Name LIKE '%{$searchTerm}%' OR Last_Name LIKE '%{$searchTerm}%'");
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count > 0 ){ 
            include "data.php";
        }else{
            $output .="no user found related to your search term"; 
        }
        echo $output;
      
    }else{
        $searchTerm = $_POST['searchTerm'];
        $output="";
       
        $stmt = $conn->prepare("SELECT * FROM drivers 
                                LEFT JOIN users ON users.User_ID = drivers.UserID
                    
                                WHERE  Group_ID =1   AND  User_Status=1
                                AND First_Name LIKE '%{$searchTerm}%' OR Last_Name LIKE '%{$searchTerm}%'
                                AND  User_Status=1");
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count > 0 ){
            include "data.php";
        }else{
            $output .="no user found related to your search term"; 
        }
        echo $output;
    }
}