<?php
/**
 * Created by PhpStorm.
 * User: vyacheslav
 * Date: 14.04.2018
 * Time: 19:24
 */

return [
    'host'      => getenv('DATABASE_HOST'),
    'driver'    => getenv('DATABASE_DRIVER'),
    'port'      => getenv('DATABASE_PORT'),
    'dbname'    => getenv('DATABASE_NAME'),
    'user'      => getenv('DATABASE_USER'),
    'password'  => getenv('DATABASE_PASSWORD'),
];