<?php
require_once('config/autoloader.php');
class outputClass {
    public $testvar = 'this variable';


    public function __construct() {
        var_dump(Database::getAll('account'));
    }
}
$bar = new outputClass();