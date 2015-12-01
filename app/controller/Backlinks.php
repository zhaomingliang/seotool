<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer as Renderer;
use MysqliDb as DB;

class Backlinks
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
        $model = new \App\Model\Backlinks($this->request, $this->response, $this->db);
        $model->setTitle('index');
        $model->setProjectData();
        $model->getBacklinks();

        $view = new \App\View\Backlinks($this->request, $this->response, $this->renderer, $model->getModelData());
        $view->loadProjectData();
        $view->setBacklinkTable();
        $view->create();

    }

    public function add()
    {
        $model = new \App\Model\Backlinks($this->request, $this->response, $this->db);
        $model->setTitle('add');
        $model->setProjectData();
        $model->getLinkTypes();
        $model->getLinkSourceTypes();
        $model->getRelations();


        $view = new \App\View\Backlinks($this->request, $this->response, $this->renderer, $model->getModelData());
        $view->loadProjectData();
        $view->setProjectList();
        $view->setLinkTypes();
        $view->setLinkSourceTypes();
        $view->setRelations();
        $view->create('add');

    }

    public function edit($blID)
    {
        $model = new \App\Model\Backlinks($this->request, $this->response, $this->db);
        $model->setTitle('edit');
        $model->setProjectData();
        $model->getLinkTypes();
        $model->getLinkSourceTypes();
        $model->getRelations();
        $model->getSaveBLDataFor($blID);


        $view = new \App\View\Backlinks($this->request, $this->response, $this->renderer, $model->getModelData());
        $view->loadProjectData();
        $view->setProjectList();
        $view->setLinkTypes();
        $view->setLinkSourceTypes();
        $view->setRelations();
        $view->setTextValueForBacklinkEdit();
        $view->setBacklinkID($blID);
        $view->create('edit');

    }

    public function __call($name, $arguments)
    {

        echo 'Methode "' . $name . '" via "' . __METHOD__ . '" wurde nicht implementiert.';

    }

}
