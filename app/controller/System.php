<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer as Renderer;
use MysqliDb as DB;

class System
{

    private $request;
    private $response;
    private $db;
    private $renderer;

    public function __construct(Request $request, Response $response, DB $db, Renderer $renderer)
    {

        $this->request  = $request;
        $this->response = $response;
        $this->db       = $db;
        $this->renderer = $renderer;

    }

    public function index()
    {
        $model = new \App\Model\System($this->request, $this->response, $this->db);
        $model->setTitle('index');
        $model->getSettings();
        $model->setProjectData();
        $model->getKeywordUpdateInfo();

        $view = new \App\View\System($this->request, $this->response, $this->renderer, $model->getModelData());
        $view->loadProjectData();
        $view->setTimeUpdateInfo();
        $view->setWarning();
        $view->create();

    }

}
