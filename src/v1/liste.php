<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use App\Controleur;
$app->get('/liste', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();

   /* $db = connect_db($server = $this['settings']["mysql"]["server"]
        ,$this['settings']["mysql"]["user"]
        ,$this['settings']["mysql"]["pass"]
        ,$this['settings']["mysql"]["database"]);

    $sql = "select id,titre,description,prix,image  from enregistrements;";
    $result = $db->query($sql);
    while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
            $data[] = $row;
    }*/



    return $response->withJson(['success' => true, 'data' => "test"]);
});

function connect_db($server, $user, $pass, $database) {
    $connection = new mysqli($server, $user, $pass, $database);
    return $connection;
}