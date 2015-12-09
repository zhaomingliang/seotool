<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer as Renderer;
use MysqliDb as DB;

class Summary
{

    private $request;
    private $response;
    private $db;
    private $renderer;
    private $getParams;

    public function __construct(Request $request, Response $response, DB $db, Renderer $renderer)
    {

        $this->request  = $request;
        $this->response = $response;
        $this->db       = $db;
        $this->renderer = $renderer;

        $this->getParams = $this->request->getQueryParams();

    }

    public function positions()
    {

        $model = new \App\Model\Summary($this->request, $this->response, $this->db);
        $model->setTitle('positions');
        $model->setProjectData();
        $model->getPositionDistributions();


        $view = new \App\View\Summary($this->request, $this->response, $this->renderer, $model->getModelData());
        $view->loadProjectData();
        $view->setPositionDistributionChartsHTML();
        $view->setPositionDistributionChartsData();
        $view->create('positions');

    }

    public function value()
    {

        $model = new \App\Model\Summary($this->request, $this->response, $this->db);
        $model->setTitle('value');
        $model->setProjectData();
        $model->getValueRankings();
        $model->sendQueryToDB();

        $view = new \App\View\Summary($this->request, $this->response, $this->renderer, $model->getModelData());
        $view->loadProjectData();
        $view->setTableContentForValue();
        $view->create('value');

    }

    public function valueindex()
    {

        $model = new \App\Model\Summary($this->request, $this->response, $this->db);
        $model->setTitle('valueindex');
        $model->setProjectData();
        $model->setTimeInterval($this->getParams);
        $model->getValueIndex();

        $view = new \App\View\Summary($this->request, $this->response, $this->renderer, $model->getModelData());
        $view->loadProjectData();
        $view->generateValueIndexJSData();
        $view->generateDatePicker('valueindex');
        $view->create('valueindex');

    }

    public function ranking()
    {

        $model = new \App\Model\Summary($this->request, $this->response, $this->db);
        $model->setTitle('ranking');
        $model->setProjectData();
        $model->setTimeInterval($this->getParams);
        $model->generateRankingDataForCurrentProject();

        $view = new \App\View\Summary($this->request, $this->response, $this->renderer, $model->getModelData());
        $view->loadProjectData();
        $view->generateSingleRankingJSData();
        $view->generateDatePicker('ranking');
        $view->create('ranking');

    }

    public function competition()
    {

        $model = new \App\Model\Summary($this->request, $this->response, $this->db);
        $model->setTitle('competition');
        $model->setProjectData();
        $model->setTimeInterval($this->getParams);
        $model->generateRankingDataForCompetition();

        $view = new \App\View\Summary($this->request, $this->response, $this->renderer, $model->getModelData());
        $view->loadProjectData();
        $view->generateCompetitionRankingJSData();
        $view->generateDatePicker('competition');
        $view->create('competition');

    }

    public function keywords()
    {

        $model = new \App\Model\Summary($this->request, $this->response, $this->db);
        $model->setTitle('keywords');
        $model->setProjectData();
        $model->setTimeInterval($this->getParams);
        $model->getTrackedKeywordData();

        $view = new \App\View\Summary($this->request, $this->response, $this->renderer, $model->getModelData());
        $view->loadProjectData();
        $view->generateTrackedKeywordJSData();
        $view->generateDatePicker('keywords');
        $view->create('keywords');

    }

}
