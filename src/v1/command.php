<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
$app->group('/command', function () use ($app) {
    $app->post('/list_history', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $db = connect_db($server = $this['settings']["mysql"]["server"]
            ,$this['settings']["mysql"]["user"]
            ,$this['settings']["mysql"]["pass"]
            ,$this['settings']["mysql"]["database"]);
        $sql = "SELECT b.`date_start`, b.`date_end`, b.`price`, c.`end_date`, v.`car_brand`, v.`model`, v.`image`, v.`place_number`  FROM commands AS c
                JOIN bill AS b
                ON b.idcommands = c.`idcommands`
                JOIN offers AS o
                ON o.`idoffer` = c.`offers_idoffer`
                JOIN vehicles AS v
                ON v.`idvehicle` = o.`id_vehicle`
                JOIN users AS u
                ON u.`iduser` = c.`users_iduser`
                WHERE u.`iduser` = ".$data['id'].";";
        $result = $db->query($sql);
        while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
            $data[] = $row;
        }
        return $response->withJson(['success' => true, 'data' => $data]);
    });

    $app->post('/add', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $dev = new Commands();
        $dev->users_iduser = $data['users'];
        $dev->offers_idoffer = $data['offers'];
        $dev->start_date = $data['start_date'];
        $dev->end_date = $data['end_date'];
        $dev->save();

        return $response->withJson(['success' => true, 'data' => $data]);
    });


});