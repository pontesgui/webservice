<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

require 'Logging.php';

require 'config.php';
require 'functions.php';
require 'handlers.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

//Routes
/**
 * GET /passagens
 * 
 * @return string conteúdo no formato JSON
 */
$app->get('/passagem', function (Request $request, Response $response) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(get_passagens());

    return $response;
});

/**
 * GET /passagem/{id}
 * 
 * @return string conteúdo no formato JSON
 */
$app->get('/passagem/{id:[0-9]+}', function (Request $request, Response $response, array $args) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(get_passagem($args['id']));
    
    return $response;
});

/**
 * GET /passagem/{key}/{value}
 * 
 * @return string conteúdo filtrado, no formato JSON
 */
$app->get('/passagem/{key}/{value}', function (Request $request, Response $response, array $args) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(search_passagem($args['key'], $args['value']));

    return $response;
});

/**
 * POST /passagem/comprar
 * 
 * @return string conteúdo resultante da requisição de compra
 */
$app->post('/passagem/comprar', function (Request $request, Response $response) {

    $params = $request->getParsedBody();
    $response->withHeader('Content-Type', 'application/json');
    /*$response->getBody()->write(json_encode($params));*/
    $response->getBody()->write(post_passagem($params));
    //criaLog(post_passagem($params));

    return $response;
});

/**
 * GET /hospedagens
 * 
 * @return string conteúdo no formato JSON
 */
$app->get('/hospedagem', function (Request $request, Response $response) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(get_hospedagens());
    
    return $response;
});

/**
 * GET /hospedagem/{id}
 * 
 * @return string conteúdo no formato JSON
 */
$app->get('/hospedagem/{id:[0-9]+}', function (Request $request, Response $response, array $args) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(get_hospedagem($args['id']));

    return $response;
});

/**
 * GET /hospedagem/{key}/{value}
 * 
 * @return string conteúdo filtrado, no formato JSON
 */
$app->get('/hospedagem/{key}/{value}', function (Request $request, Response $response, array $args) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(search_hospedagem($args['key'], $args['value']));

    return $response;
});

/**
 * POST /hospedagem/comprar
 * 
 * @return string conteúdo resultante da requisição de compra
 */
$app->post('/hospedagem/comprar', function (Request $request, Response $response) {

    $params = $request->getParsedBody();
    $response->withHeader('Content-Type', 'application/json');
    /*$response->getBody()->write(json_encode($params));*/
    $response->getBody()->write(post_hospedagem($params));

    return $response;
});


/**
 * GET /compras/passagem/{id}
 * 
 * @return string conteúdo no formato JSON
 */
$app->get('/compras/passagem/{id}', function (Request $request, Response $response, array $args) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(get_compra_passagem($args['id']));

    return $response;
});

/**
 * GET /compras/hospedagem/{id}
 * 
 * @return string conteúdo no formato JSON
 */
$app->get('/compras/hospedagem/{id}', function (Request $request, Response $response, array $args) {
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(get_compra_hospedagem($args['id']));

    return $response;
});

/* Inicializa o app */
$app->run();
