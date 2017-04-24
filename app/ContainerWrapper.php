<?php
/**
 * Решил сделать обертку для контейнера слима, что бы в IDE работала автоподсказка с помощью phpdoc.
 * На самом деле довольно уродливый вариант, т.к. приходится каждый раз приходится не только 
 * добавлять сервис в контейнер, но и метод к данному классу. Возможно лучше было бы реализоват
 * вариант с контроллерром как сервис в контейнере.
 */
class ContainerWrapper extends \Slim\Container
{
    public function __construct(array $values = [])
    {
        parent::__construct($values);
    }
    /**
     * @return Twig_Environment|null
     **/
    public function getTwig()
    {
        return $this->get('twig');
    }
    /**
     * @return Models\FilesGateaway|null
     **/
    public function getFilesGateaway()
    {
        return $this->get('filesGateaway');
    }
    /**
     * @return Models\UploadService|null
     **/
    public function getUploadService()
    {
        return $this->get('UploadService');
    }
    
     /**
     * @return Models\DownloadService|null
     **/
    public function getDownloadService()
    {
        return $this->get('DownloadService');
    }
}
