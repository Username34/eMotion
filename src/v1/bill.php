<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
$app->group('/bill', function () use ($app) {
    $app->post('/add', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $dev = new Bills();
        $dev->date_start = $data['date_start'];
        $dev->date_end = $data['date_end'];
        $dev->price = $data['price'];
        $dev->user_id = $data['user_id'];
        $dev->offer_id = $data['offer_id'];
        $dev->save();
        return $response->withJson(['success' => true]);
    });

    $app->get('/list', function (Request $request, Response $response, $args) {
        return $response->withJson(['success' => true, 'data' => Bills::all()]);
    });

    $app->post('/delete', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        Bills::where('idfacture', $data['id'])->delete();
        return $response->withJson(['success' => true]);
    });

    $app->post('/update', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        foreach ($data['data'] as $key => $item){
            Bills::where('idfacture', $data['id'])
                ->update([$key => $item]);
        }
        return $response->withJson(['success' => true]);
    });
});