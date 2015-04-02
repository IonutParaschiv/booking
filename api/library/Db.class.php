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
 * @return [object]          
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
 * @return [object]         in case of success , returns account object
 */
    public function createAccount($params){
        if( empty($params['email']) || empty($params['password']) ){
            return array("status"=>400, "message"=>"missing parameter");
        }else{
            $conn = self::conn();
            $query =    "INSERT INTO " .self::DATABASE_NAME. ".account ( id ,  name ,  surname ,  email ,  password ,  join_date , salt, token, apiKey ) 
                        VALUES ('', :name, :surname, :email, :password, NOW(), :salt, :token, :apiKey)";
            $stmt = $conn->prepare($query);

            $apiKey = Security::hashString($params['name'].$params['email'].time());
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
                return "The account could not be created";
            }
        }
    }
/**
 * This function inserts a company into the database
 * @param  [object] $params [parameters to be added into the database]
 * @return [object]         [in case of success returns the created company]
 */
    public function createCompany($params){
        $conn = self::conn();
        $query = "INSERT INTO " . self::DATABASE_NAME. ".company (id, account_id, name, email, address, opening_h) 
                    VALUES ('', :account_id, :name, :email, :address, :opening_h)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':account_id', $params->account_id);
        $stmt->bindParam(':name', $params->name);
        $stmt->bindParam(':email', $params->email);
        $stmt->bindParam(':address', $params->address);
        $stmt->bindParam(':opening_h', $params->opening_h);

        $result = $stmt->execute();

        if($result){
            return self::getLatest('company');
        }else{
            return "The company could not be created";
        }
    }
    /**
     * gets entire row from company table
     * @param  [int] $company_id [company id]
     * @return [object]             [company object]
     */
    public function getCompany($company_id){
        $conn = self::conn();
        $query = "SELECT * FROM ". self::DATABASE_NAME. ".company WHERE id = :company_id";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':company_id', $company_id);

        $result = $stmt->execute();

        if($result){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }

    }
//UPDATE `bachelor`.`company` SET `name` = 'my new company again', `email` = 'me@my_newcompany.com', `address` = 'myaddress new' WHERE `company`.`id` = 2;
    public function editCompany($company_id, $params){
        $conn = self::conn();

        $query = "UPDATE ". self::DATABASE_NAME. ".company SET name = :name, email = :email, address = :address, opening_h = :opening_h WHERE company.id = :company_id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':name', $params->name);
        $stmt->bindParam(':email', $params->email);
        $stmt->bindParam(':address', $params->address);
        $stmt->bindParam(':opening_h', $params->opening_h);
        $stmt->bindParam(':company_id', intval($company_id));
        // var_dump($query);die();
        $result = $stmt->execute();

        if($result){
            return self::getCompany($company_id);
        }else{
            return false;
        }
    }

/**
 * This function inserts a service into the database
 * @param  [array] $params [parameters to be added into the database]
 * @return [object]         [in case of success it returns an object of the created service]
 */
    public function createService($params){
        $conn = self::conn();

        $query = "INSERT INTO ". self::DATABASE_NAME. ".service (id, company_id, name, price, description, duration)
                    VALUES ('', :company_id, :name, :price, :description, :duration)";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':company_id', $params['company_id']);
        $stmt->bindParam(':name', $params['name']);
        $stmt->bindParam(':price', $params['price']);
        $stmt->bindParam(':description', $params['description']);
        $stmt->bindParam(':duration', $params['duration']);

        $result = $stmt->execute();

        if($result){
            return self::getLatest('service');
        }else{
            return "The service could not be created";
        }
    }


/**
 * This function inserts a staff member into the database
 * @param  [array] $params [parameters to be added in the staf table]
 * @return [object]         [in case of success returns the created staff object]
 */
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
            }else{
                return "Staff member could not be created";
            }
        }
    }

    public function createBooking($params){
        $conn = self::conn();
        $query = "INSERT INTO ". self::DATABASE_NAME .".booking ( id, company_id, staff_id, service_id, start, end)
                    VALUES ('', :company_id, :staff_id, :service_id, :start, :end)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':company_id', $params['company_id']);
        $stmt->bindParam(':staff_id', $params['staff_id']);
        $stmt->bindParam(':service_id', $params['service_id']);
        $stmt->bindParam(':start', $params['start']);
        $stmt->bindParam(':end', $params['end']);

        $result = $stmt->execute();

        if($result){
            return self::getLatest('booking');
        }else{
            return "Booking could not be created";
        }
    }

/**
 * gets the latest entry from the specified table
 * @param  [string] $table subject of the query
 * @return [object]      latest row of table
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
    
    public function verifyKey($apiKey){
        $conn = self::conn();
        $query = "SELECT id, name FROM ". self::DATABASE_NAME .".account WHERE apiKey = :key";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':key', $apiKey);

        $result = $stmt->execute();
        if($result){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return "key " .$apiKey;
    }

    public function getLogin($user){
        $conn = self::conn();
        $query = "SELECT email, password, salt, apiKey FROM " .self::DATABASE_NAME . ".account WHERE email = :email";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':email', $user);

        $result = $stmt->execute();
        if($result){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

}

