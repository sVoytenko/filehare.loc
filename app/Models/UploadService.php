<?php

namespace Models;

/**
 * Класс для загрузки файлов на сервер.
 */
class UploadService
{
    protected $path;
    protected $fileName;

    public function setParams(File $file)
    {
        /* Если на сервере стоит виндоус - меняется кодировки для нормального
         * сохранения имен файлов на кирилице */
        $this->path = \Util::checkEncoding(UPLOAD_DIR . $file->link);
        $this->fileName = \Util::checkEncoding($file->name);
    }

    public function upload(\Slim\Http\UploadedFile $file)
    {

        $year = date('y');
        $month = date('m');
        if (!is_dir(UPLOAD_DIR . "$year/")) mkdir (UPLOAD_DIR . "$year/");
        if (!is_dir(UPLOAD_DIR . "$year/$month")) mkdir(UPLOAD_DIR . "$year/$month");
        $file->moveTo($this->path);
    }
/* Метод длеает превьюшки для изображений. Не уверен, что стоит тащить целую 
 * библиотеку ради одного метода, по крайней мере все точно хорошо работает. Стоит так же сделать
 * аналогичный метод стандартными средствами php 
 */
    public function makePreview()
    {
        $imagine = new \Imagine\Gd\Imagine();
        $image = $imagine->open($this->path);
        $width = ($image->getSize()->getWidth()) / 2;
        $heigth = ($image->getSize()->getHeight()) / 2;
        $image->resize(new \Imagine\Image\Box($width, $heigth))->save( PREVIEW_DIR . $this->fileName);
    }

}
