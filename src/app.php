<?php
/**
 * Created by PhpStorm.
 * User: vyacheslav
 * Date: 14.04.2018
 * Time: 12:18
 */

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

require __DIR__.'/registers.php';
require __DIR__.'/controllers.php';
return $app;