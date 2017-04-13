<?php

/* 
 * Решил вынести контейнер в отдельный файл что бы индексный файл не сильно разрастался
 */
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$container = new ContainerWrapper($configuration);
$container['twig'] = function() {
    $loader = new \Twig_Loader_Filesystem('../app/Templates/');
    $twig = new Twig_Environment($loader);
    return $twig;
};
$container['filesGateaway'] = function (){
    return new Models\FilesGateaway();
};
$container['UploadService'] = function (){
    return new Models\UploadService();
};
