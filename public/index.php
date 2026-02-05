<?php 

    require __DIR__.'/../vendor/autoload.php';

    use SimpleApi\Api;

    $app = new Api();


    $app->get('/a/{test}', function($args){
        
        if (!array_key_exists("404",$args)){
            print json_encode($args);
        }else{
            echo "Since the route does not exist. You can redirect this to 404";
            http_response_code(404);
        }

    });

    $app->get('/api/v1/{id}', function($args){
        print_r($args);
        if (!array_key_exists("404",$args)){
            print json_encode($args);
        }else{
            echo "Since the route does not exist. You can redirect this to 404";
            http_response_code(404);
        }

    });

    $app->dispatch();

?>