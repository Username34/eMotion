<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
    $app->post('/enregistrement', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $db = connect_db($this['settings']["mysql"]["server"]
            ,$this['settings']["mysql"]["user"]
            ,$this['settings']["mysql"]["pass"]
            ,$this['settings']["mysql"]["database"]);
        $sql =<<<SQL
INSERT INTO `enregistrements` (`titre`, `description`, `prix`, `marque`, `modele`, `numero_serie`, `couleur`,
 `plaque_immatriculation`, `nombre_kilometres`, `date_achat`, `pays`, `ville`, `code_postal`, `id_user`, 
 `type_vehicule`, `image`, `hidden`)
VALUES
	('{$data['titre']}', '{$data['description']}', '{$data['prix']}', '{$data['marque']}', '{$data['modele']}', '{$data['numero_serie']}', '{$data['couleur']}', '{$data['plaque_immatriculation']}',
	 '{$data['nombre_kilometres']}', '{$data['date_achat']}', '{$data['pays']}', '{$data['ville']}', '{$data['code_postal']}',
	  '{$data['id_user']}', '{$data['type_vehicule']}', 'https://images.caradisiac.com/logos/6/0/5/7/196057/S5-marche-de-l-occasion-la-voiture-type-est-une-renault-clio-diesel-113410.jpg',1);
SQL;
        $result = $db->query($sql);

        return $response->withJson(['success' => true, 'data' => $data]);
    });

$app->post('/add-enregistrement', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    $db = connect_db($this['settings']["mysql"]["server"]
        ,$this['settings']["mysql"]["user"]
        ,$this['settings']["mysql"]["pass"]
        ,$this['settings']["mysql"]["database"]);
    $sql = <<<SQL
UPDATE enregistrements
SET hidden=0
WHERE id = {$data['id']};
SQL;
    $result = $db->query($sql);
    return $response->withJson(['success' => true, 'data' => $data]);
});

$app->post('/hidden-enregistrement', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    $db = connect_db($this['settings']["mysql"]["server"]
        ,$this['settings']["mysql"]["user"]
        ,$this['settings']["mysql"]["pass"]
        ,$this['settings']["mysql"]["database"]);
    $sql = <<<SQL
UPDATE enregistrements
SET hidden=1
WHERE id = {$data['id']};
SQL;
    $result = $db->query($sql);
    return $response->withJson(['success' => true, 'data' => $data]);
});

$app->post('/change-enregistrement', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    $db = connect_db($this['settings']["mysql"]["server"]
        ,$this['settings']["mysql"]["user"]
        ,$this['settings']["mysql"]["pass"]
        ,$this['settings']["mysql"]["database"]);

    foreach ($data["data"][0] as $key => $item){
        $sql = <<<SQL
        UPDATE enregistrements
        SET {$key}="{$item}"
        WHERE id = {$data['id']};
SQL;
        $result = $db->query($sql);
    }
   /* $sql = <<<SQL
UPDATE enregistrements
SET hidden=1
WHERE id = {$data['id']};
SQL;
    $result = $db->query($sql);*/
    return $response->withJson(['success' => true, 'data' => $data]);
});


$app->post('/delete-enregistrement', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    $db = connect_db($this['settings']["mysql"]["server"]
        ,$this['settings']["mysql"]["user"]
        ,$this['settings']["mysql"]["pass"]
        ,$this['settings']["mysql"]["database"]);
    $sql = <<<SQL
DELETE FROM enregistrementss
WHERE id = {$data['id']};
SQL;
    $result = $db->query($sql);
    return $response->withJson(['success' => true, 'data' => $data]);
});