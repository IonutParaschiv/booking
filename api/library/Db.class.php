<?php
class Db{
    const DATABASE_NAME = "bachelor";
/**
 * this function connects to the database
 * @return [type] [description]
 */
    private function conn(){
        $dbun = "root";
        $dbpw = "";
        $host = "localhost";
        $db = self::DATABASE_NAME;

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
        return $row;
    }

    /**
     * This function creates a new account
     * @param  [array] $params parameters to be used in the account creation
     * @return [json]         in case of success , returns account object
     */
    public function createAccount($params){
        if( empty($params['email']) || empty($params['password']) ){
            return array("status"=>400, "message"=>"missing parameter");
        }else{
            $conn = self::conn();
            $query =    "INSERT INTO " .self::DATABASE_NAME. ".account ( id ,  name ,  surname ,  email ,  password ,  join_date , salt, token, apiKey ) 
                        VALUES ('', :name, :surname, :email, :password, NOW(), :salt, :token, :apiKey)";
            $stmt = $conn->prepare($query);

            $apiKey = Utils::getRandom(32);

            $passComponents = Security::saltPassword($params['password']);

            $stmt->bindParam(':name', $params['name']);
            $stmt->bindParam(':surname', $params['surname']);
            $stmt->bindParam(':email', $params['email']);
            $stmt->bindParam(':password',$passComponents['password']);
            $stmt->bindParam(':apiKey', $apiKey);
            $stmt->bindParam(':salt', $passComponents['salt']);
            $stmt->bindParam(':token', $apiKey);

            $result = $stmt->execute();

            if($result){
                return self::getLatest('account');
            }else{
                return "error";
            }
        }
    }

    public function createStaff($params){
        if(empty($params['company_id'])){
            return array("status"=>400, "message"=>"missing parameter");
        }else{
            $conn = self::conn();
            $query = "INSERT INTO ". self::DATABASE_NAME .".staff ( id, company_id, name, surname, email, available_h ) 
            VALUES ( '', :company_id, :name, :surname, :email, :available_h )";

            $stmt = $conn->prepare($query);


            $stmt->bindParam(':company_id', $params['company_id']);
            $stmt->bindParam(':name', $params['name']);
            $stmt->bindParam(':surname', $params['surname']);
            $stmt->bindParam(':email', $params['email']);
            $stmt->bindParam(':available_h', $params['available_h']);

            $result = $stmt->execute();

            if($result){
                return self::getLatest('staff');
            }
        }
    }
/**
 * gets the latest entry from the specified table
 * @param  [string] $table subject of the query
 * @return [array]        row of table
 */
    private function getLatest($table){
        $conn = self::conn();
        $getLastEntry = $conn->prepare("SELECT * FROM ". self::DATABASE_NAME ."." . $table ." ORDER BY id DESC LIMIT 1");
        $row = $getLastEntry->execute();
        if($row){
            $lastEntry = $getLastEntry->fetchAll(PDO::FETCH_ASSOC);
            return $lastEntry;
        }
    }

}


