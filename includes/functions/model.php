<?php

class model{
    function all($where){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("SELECT * FROM $table  WHERE $where");
        $stmt->execute();
        $data=$stmt->fetchAll();
        return $data;
        //$where = group id != 1
    }
    function all2($sort){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("SELECT * FROM $table $sort");
        $stmt->execute();
        $data=$stmt->fetchAll();
        return $data;
        
    }
    function all3(){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("SELECT * FROM $table  ");
        $stmt->execute();
        $data=$stmt->fetchAll();
        return $data;
    }

    function insert($values , $execute){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("INSERT INTO $table $values ");
        $stmt->execute($execute);
          //$values=(userName , email , password) VALUES (?,?,?)
        //$execute=array ($userName , $email ,$password)
    }
    function find($where){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("SELECT * FROM $table WHERE $where");
        $stmt->execute();
        $data=$stmt->fetch();
        return $data;

    }
    function update($set , $execute){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("UPDATE $table SET $set ");
        $stmt->execute($execute);
            //$set= userName=? , email=? WHERE userID=?
           //$execute=array ($userName , $email ,$id)
    }
    function delete($where){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("DELETE FROM $table WHERE $where");
        $stmt->execute();
        //$where="WHERE userID='$userid'"

    }
    function unique($where){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("SELECT * FROM $table WHERE $where");
        $stmt->execute();
        $count=$stmt->rowCount();
        return $count;
        //$where=userName='$userName'
    }
    //function to join tables
   

    function joins($chooserow,$inner){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("  SELECT $table.*, $chooserow FROM $table $inner

       
        
        ");
        $stmt->execute();
        $data=$stmt->fetchAll();
        return $data;
                        
                        //name of table.name of row you want as choose any name you want
        //$chooserow = categories.Name AS category_name,users.userName AS User_Name

                        //name of table   esm l table .row ely 3yzo = l table ely feh l forgin key
        // $inner=INNER JOIN users ON users.User_ID  = drivers.UserID 
    }
     
    function joins2($row,$row2,$row3,$chooserow,$inner){
        global $conn;
        $table=get_class($this);
        $stmt=$conn->prepare("  SELECT $table.AVG($row) $row2 $row3, $chooserow FROM $table $inner

       
        
        ");
        $stmt->execute();
        $data=$stmt->fetchAll();
        return $data;
                        
                        //name of table.name of row you want as choose any name you want
        //$chooserow = categories.Name AS category_name,users.userName AS User_Name

                        //name of table   esm l table .row ely 3yzo = l table ely feh l forgin key
        // $inner=INNER JOIN users ON users.User_ID  = drivers.UserID 
    }
     
    
  

    



}
class users extends model{

}
class drivers extends model{

}
class categories extends model{

}
class cars extends model{

}
class contacts extends model{

}
class uprofiles extends model{

}
class chats extends model{

}
class feedback extends model{

}
class trips extends model{

}
class reports extends model{

}

class memberships extends model{

}




