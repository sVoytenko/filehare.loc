<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

/**
 * Description of ActiveRecord
 *
 * @author home
 */
class ActiveRecord
{

    const TABLE = '';

    protected $dbh;
    protected $fields = [];
    protected static $staticDbh;

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
    
    protected static function getStaticDbConnection()
    {
        $settings = parse_ini_file("../db config.ini");
        $dsn = "mysql:host={$settings['host']};dbname={$settings['dbname']}";
        $username = $settings['user'];
        $password = $settings['password'];
        $dbh = new \PDO($dsn, $username, $password);
        $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        return $dbh;
    }

    protected function getParamsForSql()
    {
        $params = new \stdClass();
        $params->keys = implode(",", array_keys($this->fields));
        $params->values = array_values($this->fields);
        $params->safeString = '';
        foreach ($this->fields as $field) {
            $params->safeString .= ',?';
        }
        $params->safeString = trim($params->safeString, ',');
        return $params;
    }

    public static function getAll()
    {
        $dbh = static::getStaticDbConnection();
        $sql = "SELECET * FROM " . static::TABLE;
        $sth = $dbh->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    public function insert()
    {
        $params = $this->getParamsForSql();
        $sql = "INSERT INTO " . static::TABLE . "($params->keys) VALUES ($params->safeString)";
        $sth = $this->dbh->prepare($sql);
        $sth->execute($params->values);
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        };
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
            $this->fields[$name] = $value;
        }
    }

}
