<?php 
define('API_URL', 'http://localhost/bachelor');
if(!empty($_POST)){
    switch ($_POST['method']) {
    case 'getServices':
        $email = 'ionut@htd.ro';
        $password = '1234';

        $data = $_POST;


        $auth = array(
            'email' => $email,
            'password' => $password
            );
        $url = API_URL.'/api/company/'.$data['company_id'].'/service';
        $result = getData($url , $auth);
        if($result->success){
            echo json_encode($result);
        }
        break;
    
    default:
        # code...
        break;
}
}
function PostRequest($host, $args, $authArgs = array()){
    $params = array(
            'key' => 'ec75c64b295ed40a799c924e663a807b',
            'json' => json_encode($args)
        );
    $email = $authArgs['email'];
    $password = $authArgs['password'];
    $query_string = http_build_query($params);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, $email.":".$password);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    
    $jsondata = curl_exec($ch);
    curl_close($ch);
    # Decode JSON String
    if($data = json_decode($jsondata)) {
        $response = new stdClass();
        $response->status = 200;
        $response->success = true;
        $response->data = json_encode($data);

        return $response;
    
    }

    $response = new stdClass();

    $response->statusCode = 500;
    $response->statusText = 'Unknown API error';

    return $response; 
}
function getData($path, $authArgs){
    $email = $authArgs['email'];
    $password = $authArgs['password'];
    // var_dump($path);die();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $path);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, $email.":".$password);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    
    $jsondata = curl_exec($ch);
    curl_close($ch);

    // var_dump($jsondata);die();
    if($data = json_decode($jsondata)) {
        $response = new stdClass();
        $response->status = 200;
        $response->success = true;
        $response->data = json_encode($data);

        return $response;
    
    }

    $response = new stdClass();

    $response->success = false;
    $response->status = 500;
    $response->statusText = 'Unknown API error';

    return $response; 
}

 ?>