<?php

/**
 * пагинация
 * curentPage = параметр передается из контроллера и означает страницу, полученную из гет-запроса
 * startPage = стартовое поле, с которого идет отображение записей
 * totalPages = общее количество страниц
 */
class Paginator
{

    public $startPage;
    public $totalPages;

    public function __construct($currentPage, $count, $limit)
    {
        
        if (empty($currentPage) || $currentPage == 1) {
            $this->startPage = 0;
        } else {
            $this->startPage = ($currentPage - 1) * $limit;
        }
        $this->totalPages = ceil($count / $limit);
    }

}
