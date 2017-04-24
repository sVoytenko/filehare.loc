<?php

namespace Controllers;

//контроллер для заглавной страницы
class IndexController
{
    protected $container;
    public $test;
    public function __construct(\ContainerWrapper $container)
    {
        $this->container = $container;

    }

    public function index(\Slim\Http\Request $request, \Slim\Http\Response $response, $args)
    {
        /* Загрузка файла на сервер*/
        if ($request->getUploadedFiles()['file']) {
            $authorComment = $request->getParsedBody()['authorComment'];
            $file = $request->getUploadedFiles()['file'];
            $fileModel = new \Models\File;
            $fileModel->fill($file, $authorComment);
            $this->container->getUploadService()->setParams($fileModel);
            $this->container->getUploadService()->upload($file);
            if (stristr($fileModel->type, '/', TRUE)  == 'image' ) {
                $this->container->getUploadService()->makePreview();
            }
            $this->container->getFilesGateaway()->insertFile($fileModel);
        }
        /* Загрузка шаблона */
        $this->container->getTwig()->display('index.html.php');
        return $response;
    }

    public function filelist(\Slim\Http\Request $request, \Slim\Http\Response $response, $args)
    {
        $files = $this->container->getFilesGateaway()->getFiles();
        $data = ['title' => 'Список файлов', 'files' => $files];
        $template = $this->container->getTwig()->load('filelist.html.php');
        echo $template->render($data);
        return $response;
    }
    
    public function file(\Slim\Http\Request $request, \Slim\Http\Response $response, $args)
    {
        $id = $request->getAttribute('fileId');
        /* Вставка комента при наличии пост-запроса*/
        $file = $this->container->getFilesGateaway()->getFileByID($id);
        if($request->getMethod() == "POST"){
            $comment = $request->getParsedBody()["text"];
            $commentModel = new \Models\Comment();
            $commentModel->text = $comment;
            $commentModel->date = "testDate";
            $commentModel->time = "testTime";
            $commentModel->fileId = $id;
            $commentModel->insert();
        }
        /* Загрузка всех коментов файла по id */
        $comments = \Models\Comment::getCommentsOfFile($id);
        foreach ($comments as $comment){
            echo $comment->text . "<br>";
        }
        /* Загрузка шаблона */
        $template = $this->container->getTwig()->load('file.html.php');
        $data = ['title' => $file->realName, 'file' => $file];
        echo $template->render($data);
    }
    
    /* Метод для отдачи файлов с сервера */
    public function download(\Slim\Http\Request $request, \Slim\Http\Response $response, $args)
    {
        $id = $request->getAttribute('fileId');
        $file = $this->container->getFilesGateaway()->getFileByID($id);
        $this->container->getDownloadService()->setParams($file);
        $res = $this->container->getDownloadService()->downloadWithPHP($request, $response);
        return $res;
    }

}
