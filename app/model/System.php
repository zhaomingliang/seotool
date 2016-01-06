<?php

namespace App\Model;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MysqliDb as DB;

class System
{

    private $request;
    private $response;
    private $db;
    private $modelData      = [];
    private $additionalData = [];
    private $session;
    private $projectData    = [];
    private $query;

    public function __construct(Request $request, Response $response, DB $db)
    {

        $this->request  = $request;
        $this->response = $response;
        $this->db       = $db;
        $this->session  = new \RKA\Session();

        $this->additionalData['currentProjectNameData'] = new \App\CurrentProject_TopBar($this->db);

        $this->additionalData['projectListData'] = new \App\ProjectList_TopBar($this->db);

    }

    public function getSettings()
    {
        $tempSettings = $this->db->get('settings');
        foreach ($tempSettings as $settings) {
            $this->modelData['settings'][$settings['optionName']] = $settings['value'];
        }

    }

    public function getLoggingData()
    {
        $this->db->orderBy('logID', 'DESC');
        $this->modelData['logData'] = $this->db->get('logs', 25, 'logTime,REPLACE(logMessage,\'\n\',\'<br />\') AS logMessage');

    }

    public function getKeywordUpdateInfo()
    {
        $this->db->groupBy('keywordUpdateHour');
        $this->modelData['keywordUpdateInfo'] = $this->db->get('keywords', null, 'keywordUpdateHour,COUNT(*) as countKW');

    }

    public function setTitle($page)
    {
        switch ($page) {
            case 'logging':
                $this->additionalData['title'] = '搜索引擎优化工具：记录';
                break;
            default:
                $this->additionalData['title'] = '搜索引擎优化工具：系统状态';
        }

    }

    public function setProjectData()
    {

        $projectIDinSession = $this->session->get('currentProject');

        $this->db->where('projectID', $projectIDinSession);
        $currentProjectData = $this->db->getOne('projects');

        if($this->db->count == 1) {

            $this->saveProjectData($currentProjectData);
        }
        else {

            $this->db->where('projectDefault', 1);
            $alternativeProjectData = $this->db->getOne('projects');

            if($this->db->count == 1) {
                $this->saveProjectData($this->db->getOne('projects'));
            }
            else {
                $this->db->orderBy('projectID', 'ASC');
                $this->saveProjectData($this->db->getOne('projects'));
            }
        }

        $this->saveCompetition();
        $this->modelData['projectData'] = $this->projectData;

    }

    private function saveProjectData($dataSrc)
    {

        $this->projectData['currentProjectID']       = intval($dataSrc['projectID']);
        $this->projectData['currentProjectURL']      = $dataSrc['projectURL'];
        $this->projectData['currentProjectParentID'] = intval($dataSrc['parentProjectID']);
        $this->session->set('currentProject', intval($dataSrc['projectID']));

    }

    private function saveCompetition()
    {
        $this->db->where('parentProjectID', $this->projectData['currentProjectParentID']);
        $this->db->orderBy('projectID', 'ASC');
        $this->projectData['competitorList'] = $this->db->get('projects', NULL, 'projectID,projectURL');

    }

    public function setAdditionalData(array $additionalData)
    {

        foreach ($additionalData as $dataKey => $dataValue) {
            $this->modelData[$dataKey] = $dataValue;
        }

    }

    public function getModelData()
    {

        $this->setAdditionalData($this->additionalData);
        return $this->modelData;

    }

}
