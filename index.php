<?php
header('Access-Control-Allow-Origin: *');
session_start();

require __DIR__ . "/vendor/autoload.php";

use Stonks\Router\Router;

$router = new Router(ROOT);

/*
 * Contorllers
 */

$router->namespace("Source\App");

/*
 * Web
 */
$router->group(null);
$router->get("/", "Web:home", "web.home");
$router->post("/uploadFile", "Web:uploadFile", "web.uploadFile");
$router->get("/downloadFile/{fileId}", "Web:downloadFile", "web.downloadFile");
$router->get("/deleteFile/{fileId}", "Web:deleteFile", "web.deleteFile");

/*
 * ERROS
 */
$router->group("ooops");
$router->get("/{errcode}", "Web:error", "web.error");

/**
 * PROCESS
 */
$router->dispatch();

if ($router->error()) {
    $router->redirect("/ooops/{$router->error()}");
}
