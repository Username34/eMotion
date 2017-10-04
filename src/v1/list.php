<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as DB;
$app->group('/list', function () use ($app) {
    $app->get('/offer', function (Request $request, Response $response, $args) {
        $date_day = new DateTime();
         $data =  Offers::select('*')->where('hidden', '0')->where('date_start','>=', $date_day->format('Ymd'))->get();
         return $response->withJson(['success' => true, 'data' => $data]);
    });
    $app->post('/offerbydate', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        //$data =  Offers::select('*')->where('hidden', '0')->get();
        //return $response->withJson(['success' => true, 'data' => $data]);
        return $response->withJson(['success' => true, 'data' => $data]);
    });
});