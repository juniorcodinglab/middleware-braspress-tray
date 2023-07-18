<?php

use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/', function (Request $request, Response $response, array $args) {
    return $response->withJson(array(
        "msg" => "Olá o que procura aqui?"
    ), 200); 
});

$app->get('/cotacao', "App\Controller\TrackController:freightBraspress");