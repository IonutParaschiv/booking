<?php 
/**
 * This class handles the staff calls
 */

class company_staff{

    public function create($params, $accountid, $companyid){
        var_dump($params, $companyid);die();
        return 'this is create staff';
    }

    public function edit($params){
        return 'this is edit staff';
    }

    public function get($companyid, $staffid){
        $response = Db::getStaff($companyid, $staffid);


        return json_encode($response);
    }

    public function delete(){
        return 'this is delete staff';
    }

    public function getAll($companyid){

    }
}
 ?>