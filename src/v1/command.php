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
        $db = connect_db($server = $this['settings']["mysql"]["server"]
            ,$this['settings']["mysql"]["user"]
            ,$this['settings']["mysql"]["pass"]
            ,$this['settings']["mysql"]["database"]);
        $dev = new Commands();
        $dev->users_iduser = $data['users'];
        $dev->offers_idoffer = $data['offers'];
        $dev->start_date = $data['start_date'];
        $dev->end_date = $data['end_date'];
        $dev->save();

        $sql = "SELECT u.name, '30 rue ipssi', u.zip, '', u.`phone`, CURDATE(), u.adress, v.`car_brand`, v.`model`, o.`price`
                from users as u
                join commands as c
                on c.`users_iduser` = u.`iduser`
                join offers as o
                on o.`idoffer` = c.`offers_idoffer`
                join vehicles as v
                on v.`idvehicle` = o.`id_vehicle`
                
                where u.`iduser` = ".$data['users']."
                and o.`idoffer` = ".$data['offers']."
                
                group by u.`iduser`";
        $result = $db->query($sql);
        while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
            $data[] = $row;
        }
        data_Vehicule ($data['users'].'_'.$data['offers'],$data[0]['name'],'30 rue ipssi',75011,'',$data[0]['phone'],$data[0]['CURDATE()'],$data[0]['adress'],$data[0]['car_brand'],$data[0]['model'],$data[0]['price']);

        return $response->withJson(['success' => true, 'data' => $data]);
    });

	    $app->post('/update', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        foreach ($data['data'] as $key => $item){
            Commands::where('idcommands', $data['id'])
                ->update([$key => $item]);
        }
        return $response->withJson(['success' => true]);
    });
	
	 $app->post('/one_command', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $dev = Commands::select('*')
            ->where('idcommands', '=', $data['id'])
            ->get();
        return $response->withJson(['success' => true, 'data' => $dev[0]]);
    });
	
    $app->post('/delete', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        Commands::where('idcommands', $data['id'])->delete();
        return $response->withJson(['success' => true]);
    });


});