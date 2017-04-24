<?php
/* модель файла в БД */
namespace Models;

class File
{

    public $id;
    public $link;
    public $type;
    public $name;
    public $size;
    public $authorComment;
    public $uploadDate;
    public $realName;
    public function __set($name, $value)
    {
        if (property_exists($this, $name))
            $this->$name = $value;
    }

    public function __get($param)
    {
        if (property_exists($this, $param))
            return $this->$param;
    }

    public function fill(\Slim\Http\UploadedFile $file, $comment)
    {
        $this->id = \Util::generateRandomString() . "_";
        if (stristr($file->getClientMediaType(), '/', TRUE) == "image") {
            $this->name = $file->getClientFilename();
        } else {
            $this->name = $file->getClientFilename() . ".txt";
        }
        $year = date('y');
        $month = date('m');
        $this->link = "$year\\$month\\$this->id$this->name";
        $this->type = $file->getClientMediaType();
        $this->size = $file->getSize();
        $this->authorComment = $comment;
        $this->uploadDate = "$year + $month + " . time();
        $this->realName = $this->name = $file->getClientFilename();
    }

}
