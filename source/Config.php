<?php

define("ROOT", "YOUR_DOMAIN_HERE");
define("THEMES", __DIR__."/../themes");
define("NOME", "YOU NAME");
define("EMAIL", "YOUR EMAIL");

/**
 * Database config
 */
define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "",
    "username" => "",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

/**
 * Email config
 */
define("MAIL", [
    "host" => "",
    "port" => "465",
    "user" => "",
    "passwd" => "",
    "from_name" => "",
    "from_email" => ""
]);

/**
 * @param string|null $uri
 * @return string
 */
function url(string $uri = null): string
{
    if ($uri) {
        return ROOT . "/{$uri}";
    }

    return ROOT;
}
