<?php

use \Phpmig\Pimple\Pimple,
\Illuminate\Database\Capsule\Manager as Capsule;

$container = new Pimple();

$cfg = array(
  "driver"    => "",
  "host"      => "",
  "port"      => null,
  "database"  => "",
  "username"  => "",
  "password"  => "",
  "prefix"    => "",
  "charset"   => "utf8",
  "collation" => "utf8_unicode_ci"
);

$container['config'] = $cfg;

$container['db'] = $container->share(function() use ($cfg) {
  return new PDO("mysql:host={$cfg['host']};dbname={$cfg['database']}", $cfg['username'],
    $cfg['password']);
});

$container['schema'] = $container->share(function($c) {
  $capsule = new Capsule;
  $capsule->addConnection($c['config']);
  $capsule->setAsGlobal();
  return Capsule::schema();
});

$container['phpmig.adapter'] = $container->share(function() use ($container) {
  return new \Phpmig\Adapter\PDO\Sql($container['db'], 'migrations');
});

$container['phpmig.migrations_path'] = function() {
  return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'migrations';
};

return $container;
