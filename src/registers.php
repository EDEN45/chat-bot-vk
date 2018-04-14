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
    'db.options' => array(
        'driver'    => 'pdo_pgsql',
        'host'      => 'ec2-174-129-41-64.compute-1.amazonaws.com:5432',
        'dbname'    => 'd76l0a42f7b9j1',
        'user'      => 'xninooviqjwgve',
        'password'  => '375e5a70565f5930263fc48e26705c5ba28d63f408fa8e47abb7a0b913405011',
        'charset'   => 'utf8mb4',
    ),
));