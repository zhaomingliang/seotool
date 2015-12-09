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
                $this->additionalData['title'] = 'SEO Tool: Rankingwert der Konkurrenten';
                break;
            case 'valueindex':
                $this->additionalData['title'] = 'SEO Tool: Rankingwertindex aller Konkurrenten';
                break;
            case 'keywords':
                $this->additionalData['title'] = 'SEO Tool: Verarbeitete Keywords';
                break;
            case 'competition':
                $this->additionalData['title'] = 'SEO Tool: Konkurrenz-Zusammenfassung';
                break;
            case 'positions':
                $this->additionalData['title'] = 'SEO Tool: Positionsverteilung';
                break;
        }

    }

    public function getPositionDistributions()
    {

        $daySteps = [
            0 => 0,
            1 => 1,
            2 => 7,
            3 => 30,
            4 => 60,
            5 => 180,
        ];

        foreach ($daySteps as $dayKey => $dayValue) {

            $theDate = date('Y-m-d', strtotime('-' . $dayValue . ' day'));

            $query = 'SELECT '
                    . '(SELECT COUNT(*) FROM st_rankings WHERE projectID=' . $this->projectData['currentProjectID'] . ' AND rankingAddedDay=\'' . $theDate . '\' AND rankingPosition BETWEEN 1 AND 5)  as p1,'
                    . '(SELECT COUNT(*) FROM st_rankings WHERE projectID=' . $this->projectData['currentProjectID'] . ' AND rankingAddedDay=\'' . $theDate . '\' AND rankingPosition BETWEEN 6 AND 10)  as p2,'
                    . '(SELECT COUNT(*) FROM st_rankings WHERE projectID=' . $this->projectData['currentProjectID'] . ' AND rankingAddedDay=\'' . $theDate . '\' AND rankingPosition BETWEEN 11 AND 20)  as p3,'
                    . '(SELECT COUNT(*) FROM st_rankings WHERE projectID=' . $this->projectData['currentProjectID'] . ' AND rankingAddedDay=\'' . $theDate . '\' AND rankingPosition BETWEEN 21 AND 35)  as p4,'
                    . '(SELECT COUNT(*) FROM st_rankings WHERE projectID=' . $this->projectData['currentProjectID'] . ' AND rankingAddedDay=\'' . $theDate . '\' AND rankingPosition BETWEEN 35 AND 50)  as p5,'
                    . '(SELECT COUNT(*) FROM st_rankings WHERE projectID=' . $this->projectData['currentProjectID'] . ' AND rankingAddedDay=\'' . $theDate . '\' AND rankingPosition BETWEEN 51 AND 75)  as p6,'
                    . '(SELECT COUNT(*) FROM st_rankings WHERE projectID=' . $this->projectData['currentProjectID'] . ' AND rankingAddedDay=\'' . $theDate . '\' AND rankingPosition BETWEEN 76 AND 100)  as p7,'
                    . '(\'1 - 5\') as n1,'
                    . '(\'6 - 10\') as n2,'
                    . '(\'11 - 20\') as n3,'
                    . '(\'21 - 35\') as n4,'
                    . '(\'36 - 50\') as n5,'
                    . '(\'51 - 75\') as n6,'
                    . '(\'76 - 100\') as n7';

            $this->modelData['posDist'][$dayKey]['date'] = $theDate;
            $this->modelData['posDist'][$dayKey]['data'] = $this->db->rawQuery($query);
        }

    }

    public function getValueRankings()
    {

        /*
         * TODO: rewrite using much simpler and fast query
         * EXAMPLE:
         *
         * SELECT
         *  r.rankingAddedDay, r.projectID, ROUND(AVG(ifNull(r.rankingPosition,150)*k.keywordTraffic),2)
         * FROM
         *  st_rankings r
         * LEFT JOIN
         *  st_keywords k
         * ON
         *  r.keywordID=k.keywordID
         * WHERE
         *  r.projectID IN (10,11,12,13,14)
         * AND
         *  (r.rankingAddedDay='2015-12-06' OR r.rankingAddedDay='2015-12-05')
         * GROUP BY
         *  r.rankingAddedDay, r.projectID
         * ORDER BY
         *  rankingAddedDay DESC,projectID ASC
         *
         */

        $query         = [];
        $query_middle  = [];
        $posIfNotFound = 150;

        $daySteps = [
            0 => 0,
            1 => 1,
            2 => 7,
            3 => 30,
            4 => 60,
            5 => 180,
        ];

        $query[] = 'SELECT p.projectID,p.projectURL,';

        foreach ($daySteps as $valKey => $valDayCount) {
            $query_middle[] = "(SELECT ROUND(AVG(ifNull(r1.rankingPosition,$posIfNotFound)*k1.keywordTraffic),2) FROM st_rankings r1 LEFT JOIN st_keywords k1 ON r1.keywordID=k1.keywordID WHERE r1.projectID=p.projectID AND r1.rankingAddedDay='" . $this->generateStaticDate($valDayCount) . "') as val$valKey";
        }

        $query[] = implode(',', $query_middle);
        $query[] = 'FROM st_projects p WHERE p.parentProjectID=' . $this->projectData['currentProjectParentID'] . ' ORDER BY val0 ASC';

        $this->query = implode(" ", $query);

    }

    public function getValueIndex()
    {

        $posIfNotFound = 150;
        $this->getCompetitionIDsString();

        $this->db->join("keywords k", "r.keywordID=k.keywordID", "LEFT");
        $this->db->where('r.projectID', $this->competitionString, 'IN');
        $this->db->where("r.rankingAddedDay > '" . $this->chartInterval['min'] . "'");

        $this->db->groupBy('r.rankingAddedDay,r.projectID');

        $this->db->orderBy('r.rankingAddedDay', 'ASC');
        $this->db->orderBy('r.projectID', 'ASC');

        $this->modelData['queryresultData'] = $this->db->get('rankings r', null, 'r.rankingAddedDay, r.projectID, ROUND(AVG(ifNull(r.rankingPosition,' . $posIfNotFound . ')*k.keywordTraffic),2) as rankIndex');

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

        $query = [];
        $this->getCompetitionIDsString();

        $this->db->where('projectID', $this->competitionString, 'IN');
        $this->db->where('rankingAddedDay', $this->chartInterval['min'], '>');
        $this->db->groupBy('projectID,rankingAddedDay');
        $this->db->orderBy('projectID', 'ASC');
        $this->db->orderBy('rankingAddedDay', 'ASC');

        $this->modelData['queryresultData'] = $this->db->get('rankings', null, 'projectID,ROUND(AVG(ifNull(rankingPosition,100)),2) as ranking,rankingAddedDay');

    }

    private function getCompetitionIDsString()
    {

        $str = [];

        foreach ($this->projectData['competitorList'] as $comp) {
            $str[] = $comp['projectID'];
        }

        if(!empty($str)) {
            $this->competitionString = $str;
        }
        else {
            $this->competitionString = [0];
        }

    }

    public function generateRankingDataForCurrentProject()
    {
        $this->db->where('projectID', $this->projectData['currentProjectID']);
        $this->db->where('rankingAddedDay', $this->chartInterval['min'], '>');
        $this->db->groupBy('rankingAddedDay');
        $this->db->orderBy('rankingAddedDay', 'ASC');

        $this->modelData['queryresultData'] = $this->db->get('rankings', null, 'rankingAddedDay,ROUND( AVG( IFNULL( rankingPosition, 100 ) ) , 2 ) as ranking');

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
