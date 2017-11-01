<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
$app->group('/vehicle', function () use ($app){
    $app->post('/add', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $api = new Api();
        if (!$api->checkout($data['api_key'])){
            return $response->withJson(['success' => false]);
        }
        $dev = new Vehicles();
        $dev->car_brand = $data['marque'];
        $dev->model = $data['model'];
        $dev->color = $data['color'];
        $dev->place_number = $data['place_number'];
        $dev->idtype_vehicle = $data['idtype_vehicle'];
        $dev->numberplate = $data['numberplate'];
        $dev->image = $data['image'];
        $dev->save();

        return $response->withJson(['success' => true, 'data' => $data]);
    });

    $app->post('/delete', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();

         Vehicles::where('idvehicle', $data['id'])->delete();
        return $response->withJson(['success' => true, 'data' => "test"]);
    });

    $app->post('/list', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $api = new Api();
        if (!$api->checkout($data['api_key'])){
            return $response->withJson(['success' => false]);
        }
        return $response->withJson(['success' => true, 'data' => Vehicles::all()]);
    });

    $app->post('/update', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $api = new Api();
        if (!$api->checkout($data['api_key'])){
            return $response->withJson(['success' => false]);
        }
        foreach ($data['data'] as $key => $item){
            Vehicles::where('idvehicle', $data['id'])
                ->update([$key => $item]);
        }
        return $response->withJson(['success' => true]);
    });
});