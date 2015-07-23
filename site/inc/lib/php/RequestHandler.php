<?php
if(!isset($_SESSION)){
    session_start(); 
}
define('API_URL', 'http://localhost/bachelor');
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

        $result = PostRequest('/api/v2/user', $args, $auth);
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

        $result = GetRequest(API_URL.'/api/v2/login/', $args, $auth);
        if($result->success){
            $responseJson = json_decode($result->data);

            if($responseJson->success){
                $response = array(
                    'success' =>true
                    );
                $_SESSION['token'] = $responseJson->token;
                $_SESSION['uid'] = $responseJson->uid;
                $_SESSION['email'] = $responseJson->email;
                session_write_close();
                $usrArray = array(
                    'token' => $responseJson->token,
                    'uid' => $responseJson->uid
                    );
                $secure = isset($_SERVER['HTTPS']);
                $httponly = true;
                $path = '/';
                setcookie("userSession", base64_encode(json_encode($usrArray)), time()+360*5, $path, NULL, $secure, $httponly);

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
        case 'logout':

          if (isset($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[0]);
                    setcookie($name, '', time()-1000);
                    setcookie($name, '', time()-1000, '/');
                }
            }
            break;
        case "getAccount":

            $password = $_SESSION['token'];
            $email = $_SESSION['email'];
            $auth = array(
                'email' => $email,
                'password' => $password
                );

            $response = getData(API_URL.'api/v2/user/'.$_POST['id'], $auth);
            if($response->success){
                echo $response->data;
            }
            // echo json_encode($response);
            // echo $_POST['id'];
        break;
        case "editAccount":
            unset($_POST['method']);
            foreach ($_POST as $key => $value) {
                $value = htmlentities($value);
                $value = htmlspecialchars($value);
            }
            $args = new stdClass();
            $args->name = $_POST['name'];
            $args->surname = $_POST['surname'];
            $args->email = $_POST['email'];

            $password = $_SESSION['token'];
            $email = $_SESSION['email'];
            $auth = array(
                'email' => $email,
                'password' => $password
                );
            $response = PostRequest(API_URL.'/api/v2/user/'.$_SESSION['uid'], $args, $auth);

            if($response->success){
                echo json_encode($response->data);
            }

        break;
        case "createCompany":
            unset($_POST['method']);
            $data = cleanData($_POST);

            $args = new stdClass();
            $args->name = $data['name'];
            $args->email = $data['email'];
            $args->address = $data['address'];
            $args->opening_h = $data['openingH'];

            $password = $_SESSION['token'];
            $email = $_SESSION['email'];

            $auth = array(
                'email' => $email,
                'password' => $password
                );
            $response = PostRequest(API_URL.'/api/v2/user/'.$_SESSION['uid'].'/company', $args, $auth);
            if($response->success){
                echo json_encode($response);
            }else{
                $response = array(
                    'success' =>false,
                    'message' =>'There has been an issue'
                    );
                echo json_encode($response);
            }
        break;

        case 'editCompany':
            unset($_POST['method']);
            $data = cleanData($_POST);

            $args = new stdClass();
            $args->name = $data['name'];
            $args->email = $data['email'];
            $args->address = $data['address'];
            $args->opening_h = $data['openingH'];

            $password = $_SESSION['token'];
            $email = $_SESSION['email'];

            $auth = array(
                'email' => $email,
                'password' => $password
                );
            $response = PostRequest(API_URL.'/api/v2/user/'.$_SESSION['uid'].'/company/'.$data['companyId'], $args, $auth);
            if($response->success){
                echo json_encode($response);
            }else{
                $response = array(
                    'success' =>false,
                    'message' =>'There has been an issue'
                    );
                echo json_encode($response);
            }

            break;
        case 'deleteCompany':
            unset($_POST['method']);
            $data = cleanData($_POST);

            $password = $_SESSION['token'];
            $email = $_SESSION['email'];

            $auth = array(
                'email' => $email,
                'password' => $password
                );
            $url = API_URL.'/api/v2/user/'. $_SESSION['uid'].'/company/'.$data['companyId'];
            $response = deleteEntry($url ,$auth);

            echo $response;


            break;
        case 'getSingleCompany':
            unset($_POST['method']);
            $data = cleanData($_POST);
            $email = $_SESSION['email'];
            $password = $_SESSION['token'];

            $auth = array(
                'email' => $email,
                'password' => $password
                );
            $url = API_URL.'/api/v2/user/'.$_SESSION['uid'].'/company/'.$data['companyid'];
            $result = GetRequest($url ,array(), $auth);
            if($result->success){
                echo json_encode($result);
            }
            break;
        case 'getAllCompanies':
            unset($_POST['method']);

            $email = $_SESSION['email'];
            $password = $_SESSION['token'];

            $auth = array(
                'email' => $email,
                'password' => $password
                );
            $url = API_URL.'/api/v2/user/'.$_SESSION['uid'].'/company';
            $result = getData($url , $auth);
            if($result->success){
                echo json_encode($result);
            }
            break;
        case 'createService':
            if(empty($_POST['companyId']) || $_POST['companyId'] == 0){
                $json = array(
                        'success' => false,
                        'message' => 'Please select a company first'
                    );
                echo json_encode($json);die();
            }


            unset($_POST['method']);

            $email = $_SESSION['email'];
            $password = $_SESSION['token'];
            $data = cleanData($_POST);

            $auth = array(
                'email' => $email,
                'password' => $password
                );

            $args = new stdClass();
            $args->name = $data['name'];
            $args->price = $data['price'];
            $args->description = $data['description'];
            $args->duration = $data['duration'];

            $url = API_URL.'/api/v2/company/'.$data['companyId'].'/service';

            $result = PostRequest($url, $args, $auth);
            if($result->success){
                echo json_encode($result);
            }else{
                $json = array(
                        'success' => false,
                        'message' => 'There has been an issue'
                    );
                echo json_encode($json);die();
            }
            break;
        case 'createStaff':
            if(empty($_POST['companyId']) || $_POST['companyId'] == 0){
                $json = array(
                        'success' => false,
                        'message' => 'Please select a company first'
                    );
                echo json_encode($json);die();
            }


            unset($_POST['method']);

            $email = $_SESSION['email'];
            $password = $_SESSION['token'];
            $data = $_POST;

            $auth = array(
                'email' => $email,
                'password' => $password
                );
            $args = new stdClass();
            $args->name = $data['name'];
            $args->surname = $data['surname'];
            $args->email = $data['email'];
            $args->services = $data['services'];

            $url = API_URL.'/api/v2/company/'.$data['companyId'].'/staff';

            $result = PostRequest($url, $args, $auth);
            if($result->success){
                echo json_encode($result);
            }else{
                $json = array(
                        'success' => false,
                        'message' => 'There has been an issue'
                    );
                echo json_encode($json);die();
            }
            break;
        case 'getAllServices':
            unset($_POST['method']);
            $email = $_SESSION['email'];
            $password = $_SESSION['token'];

            $data = cleanData($_POST);


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
        echo "Unknown service";
        die;
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


function GetRequest($host, $args = array(), $authArgs = array()){


     $params = array(
            'key' => 'ec75c64b295ed40a799c924e663a807b',
            'json' => json_encode($args)
        );
    $email = $authArgs['email'];
    $password = $authArgs['password'];
    $query_string = http_build_query($params);  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host);
    // curl_setopt($ch, CURLOPT_URL, $host);
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

function getData($path, $authArgs){
    $email = $authArgs['email'];
    $password = $authArgs['password'];
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


function deleteEntry($path, $authArgs){
    $email = $authArgs['email'];
    $password = $authArgs['password'];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $path);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, $email.":".$password);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    
    $jsondata = curl_exec($ch);
    curl_close($ch);

    if($jsondata) {
        return $jsondata;
    }

    $response = new stdClass();

    $response->success = false;
    $response->status = 500;
    $response->statusText = 'Unknown API error';

    return $response; 
}


function cleanData($data = array()){
    foreach ($data as $key => $value) {
        $value = htmlentities($value);
        $value = htmlspecialchars($value);
    }
    return $data;
}








