<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
$app->group('/user', function () use ($app) {
    $app->post('/add', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $api = new Api();
        if (!$api->checkout($data['api_key'])){
            return $response->withJson(['success' => false]);
        }
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
        $dev->session = $data['session'];
        $dev->save();
        return $response->withJson(['success' => true]);
    });

    // FONCTION LOGIN
    // reçoit en paramètre : login, et mdp.
    // Si les login & mdp sont bons, générer une clef de session et la stocker dans la colonne "session" de la table "user"
    // Puis renvoyer pour l'appli front l'id de l'user, son pseudo et la clef de session.

    $app->post('/login', function(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        // Récupérer l'utilisateur demandé
        $db = connect_db($server = $this['settings']["mysql"]["server"]
            ,$this['settings']["mysql"]["user"]
            ,$this['settings']["mysql"]["pass"]
            ,$this['settings']["mysql"]["database"]);
        $sql = "select iduser, name from users where (email = '" . $data['login'] . "' or login = '" . $data['login'] . "') and password = '" . $data['password'] . "'";
        $result = $db->query($sql);

        while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
            $data[] = $row;
        }

        // On vérifie qu'il y a bien eu un résultat
        if (isset($data[0])) { // RESULTAT

            // generer la clef de session
            $code = "";
            $chaine = "abcdefghijklmnpqrstuvwxy";
            srand((double)microtime()*1000000);
            for($i=0; $i<50; $i++) {
                $code .= $chaine[rand()%strlen($chaine)];
            }
            
            // mise a jour de la clef dans la bdd
            Users::where('iduser', $data[0]['iduser'])
                ->update(array('session' => $code));
    
            // retourner les donnees
            return $response->withJson(['success' => true, 'id' => $data[0]['iduser'], 'username' => $data[0]['name'], 'session' => $code]);
        } else { // PAS DE RESULTAT
            return $response->withJson(['success' => false]);
        }

    });

    $app->post('/list', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $api = new Api();
        if (!$api->checkout($data['api_key'])){
            return $response->withJson(['success' => false]);
        }
        return $response->withJson(['success' => true, 'data' => Users::all()]);
    });

    $app->post('/delete', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $api = new Api();
        if (!$api->checkout($data['api_key'])){
            return $response->withJson(['success' => false]);
        }
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
	
	$app->post('/one_user', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $dev = new Users();
        $res =  Users::select('*')->where('iduser', $data['id'])->get();
        return $response->withJson(['success' => true, 'data' => $res]);
    });
	
});