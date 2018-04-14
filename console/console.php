<?php
/**
 * Created by PhpStorm.
 * User: vyacheslav
 * Date: 14.04.2018
 * Time: 18:57
 */

require_once '../vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

//Migrations commands
$application->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand());
$application->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand());
$application->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand());
$application->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand());
$application->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand());
$application->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand());

$application->run();