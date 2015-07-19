<?php 
	class company_service{
	public function create($params, $accountid, $companyid){

		$response = Db::createService($companyid, $params);


    	return json_encode($response);
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