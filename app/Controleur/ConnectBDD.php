<?php

class ConnectBDD
{
    private $server;
    private $user;
    private $pass;
    private $database;
    function __construct($server, $user, $pass, $database)
    {
        $this->server = $server;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
    }

    function connect_db() {
        $connection = new mysqli($this->sserver, $this->user, $this->pass, $this->database);
        return $connection;
    }
}