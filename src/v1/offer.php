<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
$app->group('/offer', function () use ($app) {
    $app->post('/add', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $dev = new Offers();
        $dev->id_vehicle = $data['id_vehicle'];
        $dev->price = $data['price'];
        $dev->date_start = $data['date_start'];
        $dev->date_end = $data['date_end'];
        $dev->save();
        return $response->withJson(['success' => true]);
    });
    $app->get('/list', function (Request $request, Response $response, $args) {
        return $response->withJson(['success' => true, 'data' => Offers::all()]);
    });
    $app->post('/delete', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        Offers::where('idoffer', $data['id'])->delete();
        return $response->withJson(['success' => true]);
    });

    $app->post('/hidden', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        Offers::where('idoffer', $data['id'])
            ->update(['hidden' => 1]);
        return $response->withJson(['success' => true]);
    });
    $app->post('/update', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        foreach ($data['data'] as $key => $item){
            Offers::where('idoffer', $data['id'])
                ->update([$key => $item]);
        }
        return $response->withJson(['success' => true]);
    });
});