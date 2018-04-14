<?php
/**
 * Created by PhpStorm.
 * User: vyacheslav
 * Date: 14.04.2018
 * Time: 12:19
 */

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => 'php://stderr',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => [
        'host'      => getenv('DATABASE_HOST'),
        'driver'    => getenv('DATABASE_DRIVER'),
        'port'      => getenv('DATABASE_PORT'),
        'dbname'    => getenv('DATABASE_NAME'),
        'user'      => getenv('DATABASE_USER'),
        'password'  => getenv('DATABASE_PASSWORD'),
        'charset'   => 'utf8mb4',
    ]
    ,
));