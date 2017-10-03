<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
$app->group('/stripe', function () use ($app) {
    $app->post('/buy', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $stripe = new Sprite("sk_test_fi7MDnkHSkN1bickk45lMLG3");
        $stripe->buy($data['stripeToken'], 5000, 'test');
        return $response->withJson(['success' => true, 'data' => $data]);
    });
});