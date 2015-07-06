<?php
require_once('utils/autoloader.php');

//by default, all requests are invalid
$valid = false;

//get the request method
$method = $_SERVER['REQUEST_METHOD'];
//Get the raw request uri
$rawPath = $_SERVER['REQUEST_URI'];
//transform it into an array and unset unwanted routes
$path = explode('/', $rawPath);
unset(
    $path['0'],
    $path['1'],
    $path['2'],
    $path['3']
);
//reset array indexes
$path = array_values($path);



$accepted_paths = array(
    'user',
    'company'
    );
$accepted_methods = array(
    'GET',
    'POST',
    'DELETE',
    'PUT'
    );

if(in_array($method, $accepted_methods) &&
   in_array($path['0'], $accepted_paths)){
    $valid = true;
}


if($valid){

    $class = new $path['0']();
    unset($path['0']);
    $path = array_values($path);

    $response = $class->route($method, $path);
    
}else{
    header('HTTP/1.0 501 Not implemented');
    echo('HTTP/1.0 501 Not implemented');
    die();
}




//format the response
// $response = '';

// switch ($method) {
//     case 'GET':
//         $response = $class->get(1);
//         break;
//     case 'POST':
//         $response = $class->create('string');
//         break;
//     case 'PUT':
//         $response = $class->edit('string');
//         break;
//     case 'DELETE':
//         $response = $class->delete();
//         break;
//     default:
//         header('HTTP/1.0 501 Not implemented');
//         die();
//         break;
// }

echo $response;

 ?>