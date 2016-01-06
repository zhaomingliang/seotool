<?php

namespace App\Model;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MysqliDb as DB;

class Keywords
{

    private $request;
    private $response;
    private $db;
    private $session;
    private $modelData      = [];
    private $additionalData = [];
    private $projectData;
    private $query;
    private $competitorList;
    private $competitorStringWithoutCurrentID;

    public function __construct(Request $request, Response $response, DB $db)
    {

        $this->request  = $request;
        $this->response = $response;
        $this->db       = $db;
        $this->session  = new \RKA\Session();

        $this->additionalData['currentProjectNameData'] = new \App\CurrentProject_TopBar($this->db);

        $this->additionalData['projectListData'] = new \App\ProjectList_TopBar($this->db);

    }

    public function setTitle($page)
    {

        switch ($page) {
            case 'add':
                $this->additionalData['title'] = '搜索引擎优化工具：添加关键字';
                break;
            case 'chances':
                $this->additionalData['title'] = '搜索引擎优化工具：关键字提示';
                break;
            case 'competition':
                $this->additionalData['title'] = '搜索引擎优化工具：关键字提示';
                break;
            case 'chart':
                $this->additionalData['title'] = '搜索引擎优化工具：关键字图';
                break;
            case 'export':
                $this->additionalData['title'] = '搜索引擎优化工具：导入';
                break;
            default:
                $this->additionalData['title'] = '搜索引擎优化工具';
        }

    }

    public function getKeywordList()
    {

        $this->db->where('parentProjectID', $this->projectData['currentProjectParentID']);
        $this->db->orderBy('keywordID', 'ASC');
        $this->modelData['exportList'] = $this->db->get('keywords', null, 'keywordName');

    }

    public function generateChartData()
    {

        $this->db->where('keywordID', $this->modelData['keywordID']);
        $this->db->where('projectID', $this->projectData['currentProjectID']);
        $this->db->where('rankingAddedDay', $this->modelData['lastDay'], '>=');
        $this->db->orderBy('rankingID', 'ASC');

        $this->modelData['rankingData'] = $this->db->get('rankings', null, 'rankingAddedDay,rankingPosition');

    }

    public function setKeywordData($keywordID)
    {

        $this->modelData['keywordID']   = intval($keywordID);
        $this->db->where('keywordID', $this->modelData['keywordID']);
        $this->modelData['keywordName'] = $this->db->getOne('keywords');

        return $this->db->count;

    }

    public function setChartInterval($chartInterval)
    {

        $this->modelData['chartInterval'] = 0;

        if(isset($chartInterval['interval'])) {
            $this->modelData['chartInterval'] = intval($chartInterval['interval']);
        }

        $this->modelData['chartInterval'] = ($this->modelData['chartInterval'] > 0) ? $this->modelData['chartInterval'] : 30;

        $this->modelData['lastDay'] = date('Y-m-d', strtotime('-' . ($this->modelData['chartInterval'] - 1) . ' day'));

    }

    public function setSelectDate($getParams)
    {

        if(isset($getParams['date'])) {

            if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $getParams['date'])) {
                $this->additionalData['currentDate'] = $getParams['date'];
            }
            else {
                $this->additionalData['currentDate'] = date('Y-m-d', strtotime('-0 day'));
            }
        }
        else {
            $this->additionalData['currentDate'] = date('Y-m-d', strtotime('-0 day'));
        }

    }

    public function generateDaySelectList($days)
    {

        $this->additionalData['selectedDate'] = [];

        while ($days >= 0) {
            $thisDate = date('Y-m-d', strtotime('-' . $days . ' day'));

            $this->additionalData['selectedDate'][$days]['date'] = $thisDate;

            if($thisDate == $this->additionalData['currentDate']) {
                $this->additionalData['selectedDate'][$days]['selected'] = '1';
            }
            $days--;
        }

        usort($this->additionalData['selectedDate'], function ($item1, $item2) {
            if($item1['date'] == $item2['date'])
                return 0;
            return $item1['date'] < $item2['date'] ? 1 : -1;
        });

    }

    public function sendQueryToDB()
    {

        $this->modelData['rankingData'] = $this->db->rawQuery($this->query);

    }

    public function generateQueryForCurrentProject()
    {

        $lastDaysEnd = 4;
        $lastDay     = date('Y-m-d', strtotime('-' . $lastDaysEnd . ' day'));
        $query       = [];

        $query[] = "SELECT k1.keywordID, k1.keywordName, k1.keywordTraffic, ";
        $query[] = "(SELECT DATE_FORMAT(MAX(k3.rankingAdded),'%d.%m.%Y %H:%i') FROM st_rankings k3 WHERE k3.keywordID=k1.keywordID AND k3.projectID=" . $this->projectData['currentProjectID'] . ") as updated,";
        $query[] = "(SELECT MIN(k3.rankingPosition) FROM st_rankings k3 WHERE k3.keywordID=k1.keywordID AND k3.projectID=" . $this->projectData['currentProjectID'] . ") as bestPos,";

        $midQuery     = [];
        $lastDays     = 0;
        $nameCounter  = 0;
        $deltaCounter = 1;


        while ($lastDays <= $lastDaysEnd) {

            $today     = date('Y-m-d', strtotime('-' . $lastDays . ' day'));
            $yesterday = date('Y-m-d', strtotime('-' . ($lastDays + 1) . ' day'));

            $midQuery[] = "(SELECT k3.rankingPosition FROM st_rankings k3 WHERE k3.keywordID=k1.keywordID AND k3.projectID=" . $this->projectData['currentProjectID'] . " AND k3.rankingAddedDay = '" . $today . "') AS tag" . $nameCounter;
            $midQuery[] = "(SELECT k3.rankingURL FROM st_rankings k3 WHERE k3.keywordID=k1.keywordID AND k3.projectID=" . $this->projectData['currentProjectID'] . " AND k3.rankingAddedDay = '" . $today . "') AS url" . $nameCounter;
            $midQuery[] = "((SELECT k3.rankingPosition FROM st_rankings k3 WHERE k3.keywordID=k1.keywordID AND k3.projectID=" . $this->projectData['currentProjectID'] . " AND k3.rankingAddedDay = '" . $yesterday . "')-(SELECT k3.rankingPosition FROM st_rankings k3 WHERE k3.keywordID=k1.keywordID AND k3.projectID=" . $this->projectData['currentProjectID'] . " AND k3.rankingAddedDay = '" . $today . "')) as delta" . $nameCounter . $deltaCounter;

            $lastDays++;
            $nameCounter++;
            $deltaCounter++;
        }

        $query[] = implode(',', $midQuery);
        $query[] = 'FROM st_keywords k1 LEFT JOIN st_projects pr ON k1.parentProjectID=pr.parentProjectID WHERE k1.parentProjectID=' . $this->projectData['currentProjectParentID'] . ' GROUP BY k1.keywordID ORDER BY k1.keywordTraffic DESC';

        $this->query = implode(' ', $query);

    }

    public function getAllCompetitors()
    {

        $this->db->where('parentProjectID', $this->projectData['currentProjectParentID']);
        $this->db->orderBy('projectID', 'ASC');
        $this->modelData['competitorList'] = $this->db->get('projects', NULL, 'projectID,projectURL');

    }

    public function deleteSelectedCompetitorFromList()
    {

        $this->competitorStringWithoutCurrentID = [];

        foreach ($this->modelData['competitorList'] as $compKey => $compArray) {
            if($compArray['projectID'] == $this->projectData['currentProjectID']) {
                unset($this->modelData['competitorList'][$compKey]);
            }
            else {
                $this->competitorStringWithoutCurrentID[] = $compArray['projectID'];
            }
        }
        $this->competitorStringWithoutCurrentID = implode(',', $this->competitorStringWithoutCurrentID);

    }

    public function generateChancesQuery()
    {

        $query = [];


        if($this->competitorStringWithoutCurrentID != '') {
            $query[] = 'SELECT DISTINCT r.keywordID, k.keywordName, k.keywordTraffic, r.rankingPosition, r.rankingURL,';
            $query[] = '(SELECT MIN(rC.rankingPosition) FROM st_rankings rC WHERE rC.keywordID=k.keywordID AND rC.projectID!=' . $this->projectData['currentProjectID'] . ' AND rC.projectID IN (' . $this->competitorStringWithoutCurrentID . ') AND rC.rankingAddedDay=\'' . $this->additionalData['currentDate'] . '\') as bestComp,';
            $query[] = '(SELECT MAX(rC.rankingPosition) FROM st_rankings rC WHERE rC.keywordID=k.keywordID AND rC.projectID!=' . $this->projectData['currentProjectID'] . ' AND rC.projectID IN (' . $this->competitorStringWithoutCurrentID . ') AND rC.rankingAddedDay=\'' . $this->additionalData['currentDate'] . '\') as worstComp ';
        }
        else {
            $query[] = 'SELECT DISTINCT r.keywordID, k.keywordName, r.rankingPosition, r.rankingURL ';
        }
        $query[] = 'FROM st_rankings r JOIN st_keywords k ON r.keywordID=k.keywordID WHERE r.projectID=' . $this->projectData['currentProjectID'] . ' AND r.rankingAddedDay=\'' . $this->additionalData['currentDate'] . '\' AND r.rankingPosition BETWEEN 4 AND 25 ORDER BY r.rankingPosition ASC';

        $this->query = implode(' ', $query);

    }

    public function generateQueryForCurrentProjectWithCompetition()
    {

        $query      = [];
        $midQuery   = [];
        $compHTMLID = 0;

        $query[] = 'SELECT k1.keywordID, k1.keywordName, k1.keywordTraffic, ';

        if(!empty($this->modelData['competitorList'])) {
            foreach ($this->modelData['competitorList'] as $compKey => $compArray) {

                $midQuery[] = "(SELECT rankingPosition FROM st_rankings WHERE k1.keywordID=keywordID AND projectID=" . $compArray['projectID'] . " AND rankingAddedDay='" . $this->additionalData['currentDate'] . "') as comp" . $compHTMLID;
                $midQuery[] = "(SELECT rankingURL FROM st_rankings WHERE k1.keywordID=keywordID AND projectID=" . $compArray['projectID'] . " AND rankingAddedDay='" . $this->additionalData['currentDate'] . "') as url" . $compHTMLID;

                $compHTMLID++;
            }
        }
        else {
            $midQuery[] = '1 as comp0';
            $midQuery[] = '1 as url0';
        }


        $query[] = implode(',', $midQuery);
        $query[] = 'FROM st_keywords k1 WHERE k1.parentProjectID=' . $this->projectData['currentProjectParentID'] . ' ORDER BY k1.keywordTraffic DESC';

        $this->query = implode(' ', $query);

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

    public function getModelData()
    {

        $this->setAdditionalData($this->additionalData);
        return $this->modelData;

    }

    private function setAdditionalData(array $additionalData)
    {

        foreach ($additionalData as $dataKey => $dataValue) {
            $this->modelData[$dataKey] = $dataValue;
        }

    }

}
