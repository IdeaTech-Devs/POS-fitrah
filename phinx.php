<?php

include_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

return [
  'paths' => [
    'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
    'seeds'      => '%%PHINX_CONFIG_DIR%%/db/seeds',
  ],
  'environments' => [
    'default_migration_table' => 'phinxlog',
    'default_environment'     => 'development',
    'production'              => [
      'adapter' => 'mysql',
      'host'    => isset($_ENV['DB_HOSTNAME']) ? $_ENV['DB_HOSTNAME'] : 'localhost',
      'name'    => isset($_ENV['DB_DATABASE']) ? $_ENV['DB_DATABASE'] : 'mysql',
      'user'    => isset($_ENV['DB_USERNAME']) ? $_ENV['DB_USERNAME'] : 'root',
      'pass'    => isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : '',
      'port'    => isset($_ENV['DB_PORT']) ? $_ENV['DB_PORT'] : '3306',
      'charset' => 'utf8',
    ],
    'development' => [
      'adapter' => 'mysql',
      'host'    => isset($_ENV['DB_HOSTNAME']) ? $_ENV['DB_HOSTNAME'] : 'localhost',
      'name'    => isset($_ENV['DB_DATABASE']) ? $_ENV['DB_DATABASE'] : 'mysql',
      'user'    => isset($_ENV['DB_USERNAME']) ? $_ENV['DB_USERNAME'] : 'root',
      'pass'    => isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : '',
      'port'    => isset($_ENV['DB_PORT']) ? $_ENV['DB_PORT'] : '3306',
      'charset' => 'utf8',
    ],
    'testing' => [
      'adapter' => 'mysql',
      'host'    => isset($_ENV['DB_HOSTNAME']) ? $_ENV['DB_HOSTNAME'] : 'localhost',
      'name'    => isset($_ENV['DB_DATABASE']) ? $_ENV['DB_DATABASE'] : 'mysql',
      'user'    => isset($_ENV['DB_USERNAME']) ? $_ENV['DB_USERNAME'] : 'root',
      'pass'    => isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : '',
      'port'    => isset($_ENV['DB_PORT']) ? $_ENV['DB_PORT'] : '3306',
      'charset' => 'utf8',
    ],
  ],
  'version_order' => 'creation',
];
