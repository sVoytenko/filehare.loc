<?php
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
require '../app/autoload.php';
require '../vendor/autoload.php';
require '../configuration.php';
require '../app/container.php';
/* ----- роуты ----- */

$app = new \Slim\App($container);
$app->map(['post', 'get'], '/', \Controllers\IndexController::class . ":index");
$app->map(['post', 'get'], '/file/{fileId}', \Controllers\IndexController::class . ":file");
$app->get('/filelist', \Controllers\IndexController::class . ":filelist");
$app->get('/download/{fileId}', \Controllers\IndexController::class . ":download");
$app->get('/test', function(Request $request, Response $response){
    echo UPLOAD_DIR;
});
$app->run();
