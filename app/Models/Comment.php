<?php

namespace Models;

/**
 * Description of Comment
 *
 * @author home
 */
class Comment extends ActiveRecord
{
    protected $fileId;
    protected $text;
    protected $date;
    protected $time;
    const TABLE = 'comments';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public static function getCommentsOfFile($fileId)
    {
        $dbh = static::getStaticDbConnection();
        $sql = "SELECT text, date, time FROM comments WHERE fileId = :fileId";
        $sth = $dbh->prepare($sql);
        $sth->bindParam(":fileId", $fileId);
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_CLASS, self::class);
    }
}
