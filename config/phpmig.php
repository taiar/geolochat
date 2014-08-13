<?php

# phpmig.php

use \Phpmig\Adapter,
    \Pimple;

$container = new Pimple();

$config = array(
  'host' => 'localhost',
  'user' => 'root',
  'pass' => 'ahtahviu',
  'dbas' => 'geolochat'
);

$container['db'] = $container->share(function() use($config)  {
    $dbh = new PDO("mysql:dbname={$config['dbas']};host={$config['host']}",$config['user'],
      $config['pass']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
});

$container['phpmig.adapter'] = $container->share(function() use ($container) {
    return new Adapter\PDO\Sql($container['db'], 'migrations');
});

$container['phpmig.migrations_path'] = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'migrations';

return $container;