<?php

require_once __DIR__ . '/vendor/autoload.php'; 

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application(); 

session_start();

$app->get('/', function() {
  return file_get_contents(__DIR__ . "/views/index.html");
});

$app->post('/session', function(Request $req) use($app) {
  $_SESSION['lat'] = (!isset($_SESSION['lat']) || empty($_SESSION['lat'])) ? $req->get('lat') : $_SESSION['lat'];
  $_SESSION['long'] = (!isset($_SESSION['long']) || empty($_SESSION['lat'])) ? $req->get('long') : $_SESSION['long'];
  //return new Response($req->get('lat') . " - " . $req->get('long') . print_r($_POST), 200);
  return new Response('OK', 200);
});

$app->get('/chat', function() { 
  // return 'Hello '.$_SESSION['lat'].' '.$_SESSION['long'] . print_r($_SESSION); 
  return 'Hello '.$_SESSION['lat'].' '.$_SESSION['long']; 
}); 

$app->run();

class Dados {
  private $host     = "localhost";
  private $user     = "root";
  private $password = "";
  private $database = "geolochat";
  
  private $dns;
  private $db;
  
  private $error = array();
  private static $instance;
  
  private function __construct() {
    return;
  }
  public static function get_instance() {
    if (!isset(self::$instance)) {
        $c = __CLASS__;
        self::$instance = new $c;
        self::$instance->init();
    }
    return self::$instance;
  }
  private function init() {
    $this->dns = "mysql:host={$this->host};dbname={$this->database};port=3306;";
    try {
      $this->db = new PDO($this->dns, $this->user, $this->password);
    } 
    catch (PDOException $e) {
        $this->error[] = "[error] ".$e->getMessage();
        die();
    }
  }
}