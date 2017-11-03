#!/usr/bin/env php
<?php
require __DIR__ . '/../vendor/autoload.php';
array_shift($argv);
$pathInfo = array_shift($argv);

$settings = include __DIR__ . '/../src/settings.php';
$settings['environment'] = \Slim\Http\Environment::mock([
    'REQUEST_METHOD' => 'GET',
    'REQUEST_URI' => '/' . $pathInfo, ]);
unset($settings['settings']['routerCacheFile']);
$app = new \Slim\App($settings);
require __DIR__ . '/../src/dependencies.php';
function connect_db($server, $user, $pass, $database) {
    $connection = new mysqli($server, $user, $pass, $database);
    return $connection;
}
$app->any('/--cron', $help = function() use ($app) {

    $transport =  Swift_SmtpTransport::newInstance('smtp.gmail.com', 587,'tls')
        ->setUsername('emotion.projet@gmail.com')
        ->setPassword('MaQ^+5d[gvu&.{d$');

    $mailer = new Swift_Mailer($transport);

    $mailer = Swift_Mailer::newInstance($transport);
    $data = [];
    $db = connect_db($server = $this['settings']["mysql"]["server"]
        ,$this['settings']["mysql"]["user"]
        ,$this['settings']["mysql"]["pass"]
        ,$this['settings']["mysql"]["database"]);

    $sql = "select DATEDIFF(CURDATE(), c.`end_date`), u.`name`, u.`surname`,u.`email`, v.`car_brand`, v.`model`, v.`numberplate`
            from users as u
            join commands as c
            on c.`idcommands` = u.`iduser`
            join offers as o
            on o.`idoffer` = c.`offers_idoffer`
            join vehicles as v
            on v.`idvehicle` = o.`id_vehicle` 
            where c.`end_date` < CURDATE();";
    $result = $db->query($sql);
    while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
        $row;
        $welcomeEmail = 'Bonjour '.$row['name'].' '.$row['surname'].',<br><br>

Nous vous informons qu\'à ce jour, vous avez '.$row['DATEDIFF(CURDATE(), c.`end_date`)'].' jours de retard sur la restitution du véhicule que vous avez loué :<br>

'.$row['car_brand'].' '.$row['model'].' (numéro de plaque : '.$row['numberplate'].')<br><br>

La sanction est de 20% par jour par rapport au prix de la location journaliere<br><br>


Nous vous souhaitons une agréable journée,<br><br>
Cordialement,<br><br>
L\'équipe eMotion<br><br>

(ceci est un e-mail autmatique, merci de ne pas y répondre)';

        $message = Swift_Message::newInstance('Retard de votre vehicule eMotion')
            ->setFrom(array('emotion.projet@gmail.com' => 'Emotion'))
            ->setTo(array($row['email'] => 'You'))
            ->setBody($welcomeEmail)
            ->setContentType("text/html");

         $mailer->send($message);
    }
});

$app->run();

