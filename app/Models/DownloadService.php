<?php

/*
 * Класс для отдачи файлов из сервера
 */

namespace Models;

class DownloadService
{
    protected $path;
    protected $fileName;
    
    public function setParams(File $file)
    {
        $this->path = \Util::checkEncoding($file->link);
        $this->fileName = \Util::checkEncoding($file->realName);
    }

    public function downloadWithPHP(\Slim\Http\Request $request, \Slim\Http\Response $response)
    {
        $fhandler = fopen(UPLOAD_DIR . $this->path, "r");
        $body = new \Slim\Http\Body($fhandler);
        return $response->withHeader('Content-Type', 'application/force-download')
                        ->withHeader('Content-Type', 'application/octet-stream')
                        ->withHeader('Content-Type', 'application/download')
                        ->withHeader('Content-Description', 'File Transfer')
                        ->withHeader('Content-Transfer-Encoding', 'binary')
                        ->withHeader('Content-Disposition', 'attachment; filename="' . $this->fileName . '"')
                        ->withHeader('Expires', '0')
                        ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                        ->withHeader('Pragma', 'public')
                        ->withBody($body);
    }
}
