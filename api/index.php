<?php 
require_once('config/autoloader.php');
$access = false;
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'This page requires authenthication';
        exit;
    }else {
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        $response = Security::checkLogin($username, $password);
        if($response['success']){
            $access = true;
            // if($_POST['key'] === $response['key']){
            //     $access = true;
            //     $accountId = $response['uid'];
            // }else{

            //     $keyCheck = Db::verifyKey($_POST['key']);
            //     if($keyCheck['0']['master']){
            //         $access = true;
            //     }else{
            //         header('HTTP/1.0 401 Unauthorized');
            //         echo 'Invalid Key';
            //         die();
            //     }
            // }
        }


    }




if($access){
    $paths = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];
    $resource = explode('/', $paths);
    unset($resource['0'], $resource['1'], $resource['2']);
    $resource = array_values($resource);

    switch ($resource['0']) {
        case 'company':
             switch ($method) {
                case 'POST':
                    $key = $_POST['key'];
                    if(!empty($resource['1'])){
                        $response = Db::editCompany($resource['1'], json_decode($_POST['json']) );
                        if($response){
                            echo json_encode($response);
                        }else{
                            echo "error";
                        }
                    }else{
                        $response = Db::createCompany($accountId, json_decode($_POST['json']));
                        echo json_encode($response);
                    }
                    break;
                case 'GET':

                    if(!empty($resource['1'])){
                        $response = Db::getCompany( intval( $resource['1']) );
                        if($response){
                             echo json_encode($response);
                        }else{
                            echo 'HTTP/1.1 404 Not Found';
                            header('HTTP/1.1 404 Not Found');
                        }
                       
                    }else{
                        header('HTTP/1.1 404 Not Found');
                    }
                    break;
                default:
                    header('HTTP/1.0 501 Not Implemented');
                    die();
                    break; 

                }
            break;
        case 'account':
            switch ($method) {
                case 'POST':
                    $response = Db::createAccount(json_decode($_POST['json']), false, '', $_POST['key']);
                    header("HTTP/1.0 200 OK");
                    echo json_encode($response);
                    break;
                case 'GET':
                    $params = json_decode($_GET['json']);
                    $response = Security::checkLogin($params->email, $params->password);
                    echo json_encode($response);
                    break;
                default:
                    header('HTTP/1.0 501 Not Implemented');
                    die();
                    break;
            }
        default:
            header('HTTP/1.0 404 Not Found');
            die();
            break;
    }
}else{
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'This page requires authenthication';
}

?>