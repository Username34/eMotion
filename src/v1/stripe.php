<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
$app->group('/stripe', function () use ($app) {
    $app->post('/buy', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $api = new Api();
        if (!$api->checkout($data['api_key'])){
            return $response->withJson(['success' => false]);
        }
        $stripe = new Sprite("sk_test_fi7MDnkHSkN1bickk45lMLG3");
        $stripe->buy($data['stripeToken'], $data["money"], $data["description"]);
        return $response->withJson(['success' => true]);
    });
});