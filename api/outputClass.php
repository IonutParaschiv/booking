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

        $company = array(
            "account_id" => 1,
            "name" => "My company",
            "email" => "company@company.com",
            "address" => "my address",
            "opening_h" => "all day"
            );
        $service = array(
            "company_id" => 1,
            "name" => "service name",
            "price" => 200,
            "description" => "it is awesome",
            "duration" => 100
            );
        $booking = array(
            "company_id" => 1,
            "staff_id" =>2,
            "service_id" => 2,
            "start" => '2015-03-24 18:31:22',
            "end" => '2015-03-24 20:31:22'
            );
        $account = array(
            "name" => 'Master',
            "surname" => 'Master',
            "email" => 'master@api.com',
            "password" => '1234',

            );
         var_dump(Db::createAccount($account));
        
        //var_dump(Security::checkLogin('ionut@htd.ro', '1234')); 
        
    }
}
$output = new outputClass();