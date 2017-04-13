<?php
/* шлюз для данных о файлах в БД */ 
namespace Models;

class FilesGateaway
{

    protected $dbh;

    public function __construct()
    {
        $settings = parse_ini_file("../db config.ini");
        $dsn = "mysql:host={$settings['host']};dbname={$settings['dbname']}";
        $username = $settings['user'];
        $password = $settings['password'];
        $this->dbh = new \PDO($dsn, $username, $password);
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function insertFile(File $file)
    {
        $params = array($file->id, $file->name,$file->realName, $file->link, $file->type, $file->size, $file->authorComment, $file->uploadDate);
        $sql = "INSERT INTO files(id, name, realName, link, type, size, authorComment, uploadDate) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
    }

    public function getFiles()
    {
        $sql = "SELECT * FROM files";
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_CLASS, 'Models\File');
    }

    public function getFileByID($id)
    {
        $sql = 'SELECT * FROM files WHERE id=:id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->fetchObject("Models\File");
    }

    public function getLastId()
    {
        return $this->dbh->lastInsertId();
    }

}
