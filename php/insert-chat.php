<?php
session_start();
if(isset($_SESSION['userName'])){
    include ('../int.php');
    $outgoing_id    = $_POST['outgoing_id'];
    $incoming_id    = $_POST['incoming_id'];
    $chat_id        = $_POST['chat_id'];
    $message        = $_POST['message'];
    
    if(!empty($message)){
        $stmt=$conn->prepare("INSERT INTO messages (income_message_id , outing_message_id , message , Chat_ID) VALUES (?,?,?,?)");
        $stmt->execute(array ($incoming_id , $outgoing_id ,$message, $chat_id));
    }
}else{
    header("../login.php");
}
?>