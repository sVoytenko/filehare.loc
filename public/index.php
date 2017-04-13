<?php
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
require '../app/autoload.php';
require '../vendor/autoload.php';

/* ----- роуты ----- */

require '../app/container.php';
$app = new \Slim\App($container);
$app->map(['post', 'get'], '/', \Controllers\IndexController::class . ":index");
$app->get('/file/{fileId}', \Controllers\IndexController::class . ":file");
$app->get('/filelist', \Controllers\IndexController::class . ":filelist");
$app->get('/download/{fileId}', \Controllers\IndexController::class . ":download");
$app->run();
