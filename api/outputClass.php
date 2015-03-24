<?php
require_once('config/autoloader.php');
class outputClass {
    public $testvar = 'this variable';


    public function __construct() {
        $array = array(
            "company_id" => 1,
            "name" => 'Jax',
            "surname" => 'Seymour',
            "email" => 'jax@seymour.com',
            "available_h" => '1234',
            );
        // var_dump(Db::createAccount($array));
        // var_dump(Security::saltPassword('hehe'));
        
        var_dump(Db::createStaff($array));
    }
}
$output = new outputClass();