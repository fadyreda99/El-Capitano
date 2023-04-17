<?php


/*get page title */
function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else{
        echo 'default';
    }


}


/*
** redirect function v2.0 
** function accept parametrs
** $theMsg = echo the message you wnat t show
** $url = the link you want to redirect to
** $seconds = seconds before redirecting
*/
function redirectHome($theMsg, $url = null ,$seconds = 3){
    if($url ===null){
        $url = 'index.php';
        $link='home page';

    }else{
        if(isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER'] !== ''){
            $url =$_SERVER['HTTP_REFERER'];
            $link='previous page';

        }else{
            $url='index.php';
            $link='home page';

        }
        
    }
    echo  $theMsg ;
    echo "<div class='alert alert-info'>You Will Be Redirect To $link After $seconds Seconds. </div>";
    header("refresh:$seconds;url=$url");
    exit();


}

/*its same unique function in oop
** countItems function v1.0
** function to count itmes or users or any thing in database 
** $items = what i need count
** $table = from where 
*/
/*function countItems($item , $table){
    global $conn;
    $stmt=$conn->prepare("SELECT COUNT($item) FROM $table");
    $stmt->execute();
    $count=$stmt->fetchColumn();
    return $count;
}*/



/*
** getLatest function v1.0
** function to get latest items or users or any thing from database
** $select = what i want to get like [user name , email ]
** $table = which table i want to get latest from 
** $limit = number of records i want to get
** $order = arrange by which feild you want like [user name or userId ]
** DESC -> DESCENDING [tnazoly]
** ASCD -> ASCENDING [tsa3ody]
*/
function getlatest($select , $table , $order , $limit){
    global $conn;
    $stmt=$conn->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $stmt->execute();
    $rows=$stmt->fetchAll();
    return $rows;

    //ex
    //getlatest("*" , "users" , "userID" , 3)
}

 //function to get avarege of rating
 function getAverageRating($where){
    global $conn;
    $stmt=$conn->prepare("SELECT avg(Rating) as avg FROM feedback $where");
    if($stmt->execute()){
      $count=$stmt->rowCount();
      if($count > 0){
        $row=$stmt->fetch();
        return $row['avg'];
        
      }
    }
  
    
  
  }
  function getAverageRating2($where){
    global $conn;
    $stmt=$conn->prepare("SELECT avg(Rating) as avg FROM feedback $where");
    if($stmt->execute()){
      $count=$stmt->rowCount();
      if($count > 0){
        $row=$stmt->fetch();
        return $row['avg'];
        
      }
    }
  
    
  
  }