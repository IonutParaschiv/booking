<?php
switch ($_POST['method']) {
    case 'register':
        unset($_POST['method']);
        foreach ($_POST as $key => $value) {
            $value = htmlentities($value);
            $value = htmlspecialchars($value);
            if(empty($value)){
                echo "Please fill in your ".$key;
                die();
            }
        }

        $result = PostRequest('http://localhost/bachelor/api/account', $_POST);
        if($result->success){
            echo json_encode($result);
        }


        break;
    
    default:
        # code...
        break;
}

function PostRequest($host, $args){

    $params = array(
            'key' => '2304aae54ac705ae3b8fdb29a1ab48ac',
            'json' => json_encode($args)
        );

    $query_string = http_build_query($params);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "master@api.com:1234");
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















