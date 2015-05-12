<?php

switch ($_POST['method']) {
    case 'register':
        unset($_POST['method']);
        foreach ($_POST as $key => $value) {
            $value = htmlentities($value);
            $value = htmlspecialchars($value);
            if(empty($value)){
                $response = array(
                    'success' => false,
                    'message' => "Please fill in your ".$key
                    );
                echo json_encode($response);
                die();
            }
        }

        $args = new stdClass();
        $args->name = $_POST['name'];
        $args->surname = $_POST['surname'];
        $args->email = $_POST['email'];
        $args->password = $_POST['password'];

        $auth = array(
            'email' => 'master@api.com',
            'password' => 'ionut280590'
            );

        $result = PostRequest('http://localhost/bachelor/api/account', $args, $auth);
        if($result->success){
            echo json_encode($result);
        }


        break;
    case 'login':
        unset($_POST['method']);
        foreach ($_POST as $key => $value) {
            $value = htmlentities($value);
            $value = htmlspecialchars($value);
            if(empty($value)){
                $response = array(
                    'success' => false,
                    'message' => "Please fill in your ".$key
                    );
                echo json_encode($response);
                die();
            }
        }
        $args = new stdClass();
        $args->email = $_POST['email'];
        $args->password = $_POST['password'];

        $auth = array(
            "email" => $args->email,
            "password" => $args->password
            );

        $result = GetRequest('http://localhost/bachelor/api/account/', $args, $auth);

        if($result->success){
            $responseJson = json_decode($result->data);
            if($responseJson->success){
                $response = array(
                    'success' =>true
                    );
                session_start();
                $_SESSION['token'] = $responseJson->token;
                $_SESSION['uid'] = $responseJson->uid;
                session_write_close();
                $usrArray = array(
                    'token' => $responseJson->token,
                    'uid' => $responseJson->uid
                    );
                $secure = isset($_SERVER['HTTPS']);
                $httponly = true;
                $path = '/';
                setcookie("userSession", json_encode($usrArray), time()+360*5, $path, NULL, $secure, $httponly);

            }else{
                $response = array(
                    'success' => false,
                    'message' => "Your username or password are wrong. Please try again"
                    );
            }
        }else{
             $response = array(
                    'success' => false,
                    'message' => "Your username or password are wrong. Please try again"
                    );
        }


            echo json_encode($response);
            die();
        break;
    
    default:
        # code...
        break;
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


function GetRequest($host, $args, $authArgs = array()){
     $params = array(
            'key' => 'ec75c64b295ed40a799c924e663a807b',
            'json' => json_encode($args)
        );
    $email = $authArgs['email'];
    $password = $authArgs['password'];
    $query_string = http_build_query($params);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host."?".$query_string);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, $email.":".$password);
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

    $response->success = false;
    $response->status = 500;
    $response->statusText = 'Unknown API error';

    return $response; 
}












