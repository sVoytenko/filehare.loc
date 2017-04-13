<?php

namespace Models;

/**
 * Класс для загрузки файлов на сервер.
 */
class UploadService
{
    protected $path;
    protected $fileName;

    public function upload(\Slim\Http\UploadedFile $file, File $fileModel)
    {
        /* Смена кодироки на случай если на сервере стоит винда, это позволяет
         * сохранять имена файло кирилицей.
         */
        $this->path = $fileModel->link;
        if (PHP_OS == 'WINNT') {
            $this->path = iconv('utf-8', 'windows-1251', $this->path);
            $this->fileName = iconv('utf-8', 'windows-1251', $fileModel->realName);
        }
        $year = date('y');
        $month = date('m');
        if (!is_dir("../uploads/$year")) mkdir("../uploads/$year");
        if (!is_dir("../uploads/$year/$month")) mkdir("../uploads/$year/$month");
        $path = $fileModel->link;
        if (PHP_OS == 'WINNT') {
            $path = iconv('utf-8', 'windows-1251', $path);
        }
        $file->moveTo("../" . $path);
    }
/* Метод длеает превьюшки для изображений. Не уверен, что стоит тащить целую 
 * библиотеку ради одного метода, по крайней мере все точно хорошо работает. Стоит так же сделать
 * аналогичный метод стандартными средствами php 
 */
    public function makePreview(File $fileModel)
    {
        $imagine = new \Imagine\Gd\Imagine();
        $image = $imagine->open("../" . $this->path);
        $width = ($image->getSize()->getWidth()) / 2;
        $heigth = ($image->getSize()->getHeight()) / 2;
        $meta = $image->metadata()->toArray();
        $image->resize(new \Imagine\Image\Box($width, $heigth))->save("previews/{$this->fileName}");
    }

}
