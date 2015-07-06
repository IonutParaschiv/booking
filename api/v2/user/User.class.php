<?php 
/**
 * This class handles the user calls
 */

class user{

    /**
     * This function will route the request to the desired class
     * @param  string $method [HTTP request method (POST, GET, DELETE)]
     * @param  array  $paths  [The http request uri]
     * @return [object]         
     */
    public function route($method='', $paths = array()){

        $identifier = !empty($paths['0']) ? $paths['0'] : '';
        //format the response
        $response = '';
        //the default class will be user
        $class = 'user';

        #check if the paths are empty. if they are, it is a call to master endpoint
        if(empty($paths)){
            $class = 'user';

        }elseif(!empty($paths['0']) && !is_numeric($paths['0'])){#check if the first parameter is numeric. if it's not, it is an invalid call
            echo 'HTTP/1.1 404 Not Found from 27';
            header('HTTP/1.1 404 Not Found');
            die();
        }elseif(!empty($paths['1'])){
            #if all is fine, route to desired class
            $class = new $paths['1'];
            $identifier = !empty($paths['2']) ? $paths['2'] : '';

        }
        switch ($method) {
            case 'GET':
                if(empty($identifier) || !is_numeric($identifier)){
                    echo 'HTTP/1.1 404 Not Found';
                    header('HTTP/1.1 404 Not Found');
                    die();
                }
                $response = $class::get($identifier);
                break;
            case 'POST':
                $response = $class::create('string');
                break;
            case 'PUT':
                if(empty($identifier) || !is_numeric($identifier)){
                    echo 'HTTP/1.1 404 Not Found';
                    header('HTTP/1.1 404 Not Found');
                    die();
                }
                $response = $class::edit('string');
                break;
            case 'DELETE':
                if(empty($identifier) || !is_numeric($identifier)){
                    echo 'HTTP/1.1 404 Not Found';
                    header('HTTP/1.1 404 Not Found');
                    die();
                }
                $response = $class::delete();
                break;
            default:
                header('HTTP/1.0 501 Not implemented');
                die();
                break;
        }
        return $response;
    }

    public function create($params){
        return 'this is create user';
    }

    public function edit($params){
        return 'this is edit user';
    }

    public function get($identifier){
        return 'this is get user';
    }

    public function delete(){
        return 'this is delete user';
    }
}
 ?>
