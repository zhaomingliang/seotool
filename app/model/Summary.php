<?php

namespace App\Model;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MysqliDb as DB;

class Summary
{

    private $request;
    private $response;
    private $db;
    private $session;
    private $modelData = [];
    private $projectData;
    private $chartInterval;
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

    public function setTitle($page)
    {
        switch ($page) {
            case 'ranking':
                $this->additionalData['title'] = 'SEO Tool: Ranking-Zusammenfassung';
                break;
            case 'value':
                $this->additionalData['title'] = 'SEO Tool: Ranking-Value der Konkurrenten';
                break;
            case 'keywords':
                $this->additionalData['title'] = 'SEO Tool: Verarbeitete Keywords';
                break;
            case 'competition':
                $this->additionalData['title'] = 'SEO Tool: Konkurrenz-Zusammenfassung';
                break;
        }

    }

    public function getValueRankings()
    {

        $query   = [];
        $query[] = 'SELECT p.projectID,p.projectURL,';

        $posIfNotFound = 150;

        //heute
        $query[] = "(SELECT ROUND(AVG(ifNull(r1.rankingPosition,$posIfNotFound)*k1.keywordTraffic),2) FROM st_rankings r1 LEFT JOIN st_keywords k1 ON r1.keywordID=k1.keywordID WHERE r1.projectID=p.projectID AND r1.rankingAddedDay='" . $this->generateStaticDate(0) . "') as val0,";
        //gestern
        $query[] = "(SELECT ROUND(AVG(ifNull(r1.rankingPosition,$posIfNotFound)*k1.keywordTraffic),2) FROM st_rankings r1 LEFT JOIN st_keywords k1 ON r1.keywordID=k1.keywordID WHERE r1.projectID=p.projectID AND r1.rankingAddedDay='" . $this->generateStaticDate(1) . "') as val1,";
        //vor 7 Tagen
        $query[] = "(SELECT ROUND(AVG(ifNull(r1.rankingPosition,$posIfNotFound)*k1.keywordTraffic),2) FROM st_rankings r1 LEFT JOIN st_keywords k1 ON r1.keywordID=k1.keywordID WHERE r1.projectID=p.projectID AND r1.rankingAddedDay='" . $this->generateStaticDate(6) . "') as val2,";
        // vor 30 Tagen
        $query[] = "(SELECT ROUND(AVG(ifNull(r1.rankingPosition,$posIfNotFound)*k1.keywordTraffic),2) FROM st_rankings r1 LEFT JOIN st_keywords k1 ON r1.keywordID=k1.keywordID WHERE r1.projectID=p.projectID AND r1.rankingAddedDay='" . $this->generateStaticDate(29) . "') as val3,";
        // vor 60 Tagen
        $query[] = "(SELECT ROUND(AVG(ifNull(r1.rankingPosition,$posIfNotFound)*k1.keywordTraffic),2) FROM st_rankings r1 LEFT JOIN st_keywords k1 ON r1.keywordID=k1.keywordID WHERE r1.projectID=p.projectID AND r1.rankingAddedDay='" . $this->generateStaticDate(59) . "') as val4,";
        // vor 180 Tagen
        $query[] = "(SELECT ROUND(AVG(ifNull(r1.rankingPosition,1)*k1.keywordTraffic),2) FROM st_rankings r1 LEFT JOIN st_keywords k1 ON r1.keywordID=k1.keywordID WHERE r1.projectID=p.projectID AND r1.rankingAddedDay='" . $this->generateStaticDate(179) . "') as val5";
        $query[] = 'FROM st_projects p WHERE p.parentProjectID=' . $this->projectData['currentProjectParentID'] . ' ORDER BY val0 ASC';

        $this->query = implode(" ", $query);

    }

    private function generateStaticDate($dayCounter, $format = 'Y-m-d')
    {

        if($dayCounter < 0)
            $dayCounter = 0;

        return date($format, strtotime('-' . $dayCounter . ' day'));

    }

    public function sendQueryToDB()
    {

        $this->modelData['queryresultData'] = $this->db->rawQuery($this->query);

    }

    public function prepareCompetitionResultset()
    {

        $countCompetitors = count($this->modelData['queryresultData']);

        $tpmmodelData = [];

        foreach ($this->modelData['queryresultData'] as $currentProjectDataResultKey => $currentProjectDataResultData) {

            $projectID = $this->modelData['queryresultData'][$currentProjectDataResultKey]['projectID'];

            $tpmmodelData[$projectID] = $currentProjectDataResultData;
        }

        $this->modelData['queryresultData'] = $tpmmodelData;

    }

    public function getTrackedKeywordData()
    {

        $this->db->where('projectID', $this->projectData['currentProjectID']);
        $this->db->where('rankingAddedDay', date('Y-m-d', strtotime('-' . ($this->chartInterval['interval'] - 1) . ' day')), '>=');
        $this->db->groupBy('rankingAddedDay');
        $this->db->orderBy('rankingAddedDay', 'ASC');

        $this->modelData['queryresultData'] = $this->db->get('rankings', null, 'rankingAddedDay , COUNT(*) as nr');

    }

    public function generateRankingDataForCompetition()
    {
        $query  = [];
        $queryM = [];

        $query[] = 'SELECT r.projectID, ';

        $dayIterator  = 1;
        $nameIterator = 1;
        $dayInterval  = $this->chartInterval['interval'];

        while ($dayIterator <= $this->chartInterval['interval']) {


            $day = date('Y-m-d', strtotime('-' . ($dayInterval - 1) . ' day'));

            $queryM[] = "'$day' as d$nameIterator";
            $queryM[] = "(SELECT ROUND(AVG(ifNull(rankingPosition,100)),2) FROM st_rankings WHERE projectID=r.projectID AND rankingAddedDay='$day') as r$nameIterator";

            $dayIterator++;
            $nameIterator++;
            $dayInterval--;
        }

        $query[] = implode(',', $queryM);
        $query[] = " FROM st_rankings r LEFT JOIN st_projects pr ON r.projectID=pr.projectID WHERE pr.parentProjectID=" . $this->projectData['currentProjectParentID'] . " AND r.rankingAddedDay BETWEEN '" . $this->chartInterval['min'] . "' AND '" . $this->chartInterval['max'] . "' GROUP BY r.projectID";

        $this->query = implode(' ', $query);

    }

    public function generateRankingDataForCurrentProject()
    {
        $query  = [];
        $queryM = [];

        $query[] = 'SELECT r.projectID, ';

        $dayIterator  = 1;
        $nameIterator = 1;
        $dayInterval  = $this->chartInterval['interval'];

        while ($dayIterator <= $this->chartInterval['interval']) {


            $day = date('Y-m-d', strtotime('-' . ($dayInterval - 1) . ' day'));

            $queryM[] = "(SELECT '$day') as d$nameIterator";
            $queryM[] = "(SELECT ROUND(AVG(ifNull(rankingPosition,100)),2) FROM st_rankings WHERE projectID=r.projectID AND rankingAddedDay='$day') as r$nameIterator";

            $dayIterator++;
            $nameIterator++;
            $dayInterval--;
        }

        $query[] = implode(',', $queryM);
        $query[] = " FROM st_rankings r WHERE r.projectID= " . $this->projectData['currentProjectID'] . " AND r.rankingAdded BETWEEN '" . $this->chartInterval['min'] . " 00:00:00' AND '" . $this->chartInterval['max'] . " 23:59:59' GROUP BY r.projectID";

        $this->query = implode(' ', $query);

    }

    public function setTimeInterval($getParams)
    {

        if(isset($getParams['last'])) {

            if(intval($getParams['last']) <= 0) {
                $getParams['last'] = 1;
            }
            $this->chartInterval = [
                'interval' => intval($getParams['last']),
                'min'      => date('Y-m-d', strtotime('-' . intval($getParams['last']) . ' day')),
                'max'      => date('Y-m-d', strtotime('-0 day')),
            ];
        }
        else {
            $this->chartInterval = [
                'interval' => '7',
                'min'      => date('Y-m-d', strtotime('-7 day')),
                'max'      => date('Y-m-d', strtotime('-0 day')),
            ];
        }

        $this->modelData['timeData'] = $this->chartInterval;

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

    public function setAdditionalData(array $additionalData)
    {



        foreach ($additionalData as $dataKey => $dataValue) {
            $this->modelData[$dataKey] = $dataValue;
        }

    }

}
