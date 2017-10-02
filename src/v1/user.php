<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
$app->group('/user', function () use ($app) {
    $app->post('/add', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $dev = new Users();
        $dev->name = $data['name'];
        $dev->surname = $data['surname'];
        $dev->login = $data['login'];
        $dev->password = $data['password'];
        $dev->email = $data['email'];
        $dev->adress = $data['adress'];
        $dev->city = $data['city'];
        $dev->country = $data['country'];
        $dev->zip = $data['zip'];
        $dev->phone = $data['phone'];
        $dev->nbr_driver_license = $data['nbr_driver_license'];
        $dev->save();
        return $response->withJson(['success' => true]);
    });

    $app->get('/list', function (Request $request, Response $response, $args) {
        return $response->withJson(['success' => true, 'data' => Users::all()]);
    });

    $app->post('/delete', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        Users::where('iduser', $data['id'])->delete();
        return $response->withJson(['success' => true]);
    });

    $app->post('/update', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        foreach ($data['data'] as $key => $item){
            Users::where('iduser', $data['id'])
                ->update([$key => $item]);
        }
        return $response->withJson(['success' => true]);
    });

    $app->post('/test', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        var_dump($data);
        return $response->withJson(['success' => true, 'data' => $data]);
    });
});