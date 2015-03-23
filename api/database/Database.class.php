<?php
class Database{
/**
 * this function connects to the database
 * @return [type] [description]
 */
    private function conn(){
        $dbun = "root";
        $dbpw = "";
        $host = "localhost";
        $db = "bachelor";

        $conn = new PDO('mysql:host='.$host.';dbname='.$db,$dbun,$dbpw);
        // Check connection
        if (!$conn) {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
          exit();
        }
        return $conn;
    }

/**
 * gets everything from specified table
 * @param  [string] $subject table to be queried
 * @return [json]          
 */
    public function getAll($subject){
        $conn = self::conn();
        $query = "SELECT * FROM ".$subject;
        $stmt = $conn->prepare($query);
        $result = $stmt->execute();
        if($result){
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $row = array("error" =>"Could not process request");
        }
        return json_encode($row);
    }


}