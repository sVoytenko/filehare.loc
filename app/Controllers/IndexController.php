<?php

namespace Controllers;

//контроллер для заглавной страницы
class IndexController
{

    protected $container;

    public function __construct(\ContainerWrapper $container)
    {
        $this->container = $container;
    }

    public function index(\Slim\Http\Request $request, \Slim\Http\Response $response, $args)
    {
        if ($request->getUploadedFiles()['file']) {
            $authorComment = $request->getParsedBody()['authorComment'];
            $file = $request->getUploadedFiles()['file'];
            $fileModel = new \Models\File;
            $fileModel->fill($file, $authorComment);
            $this->container->getUploadService()->upload($file, $fileModel);
            if (stristr($fileModel->type, '/', TRUE)  == 'image' ) {
                $this->container->getUploadService()->makePreview($fileModel);
            }
            $this->container->getFilesGateaway()->insertFile($fileModel);
        }
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
        $file = $this->container->getFilesGateaway()->getFileByID($id);
        $data = ['title' => $file->realName, 'file' => $file];
        $template = $this->container->getTwig()->load('file.html.php');
        echo $template->render($data);
    }
    /* Метод для отдачи файлов с сервера. Возможно стоит попробовать реализовать и другими способами, например апачевский x sendfile */
    public function download(\Slim\Http\Request $request, \Slim\Http\Response $response, $args)
    {
        $id = $request->getAttribute('fileId');
        $file = $this->container->getFilesGateaway()->getFileByID($id);
        $path = '..\\' . $file->link;
        $fileName = $file->realName;
        if (PHP_OS == 'WINNT') {
            $path = iconv('utf-8', 'windows-1251', $path);
            $fileName = iconv('utf-8', 'windows-1251', $fileName);
        }
        $newResponse = $response->withHeader('Content-type', 'application/octet-stream')
                ->withHeader('Content-Description', 'File Transfer')
                ->withHeader('Content-Disposition', 'attachment; filename=' . $fileName)
                ->withHeader('Content-Length', filesize($path));
       readfile($path);
       return($newResponse);
    }

}
