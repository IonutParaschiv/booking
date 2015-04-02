<?php 
require_once('config/autoloader.php');
$access = false;
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Text to send if user hits Cancel button';
        exit;
    }else {
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        $access = Security::checkLogin($username, $password);

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
                        $response = Db::createCompany(json_decode($_POST['json']));
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
                }
            break;
        
        default:
            # code...
            break;
    }
}else{
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
}

?>