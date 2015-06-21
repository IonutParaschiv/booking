<?php
require_once('utils/autoloader.php');

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


$method = $_SERVER['REQUEST_METHOD'];

$accepted_paths = array(
    'user',
    'company'
    );

//check if request is an implemented method
if(in_array($path['0'], $accepted_methods)){
    $class = new $path['0']();
}else{
    header('HTTP/1.0 501 Not implemented');
    die();
}

$response = '';

switch ($method) {
    case 'GET':
        $response = $class->get(1);
        break;
    case 'POST':
        $response = $class->create('string');
        break;
    case 'PUT':
        $response = $class->edit('string');
        break;
    case 'DELETE':
        $response = $class->delete();
        break;
    default:
        header('HTTP/1.0 501 Not implemented');
        die();
        break;
}

echo $response;

 ?>