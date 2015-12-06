<?php

namespace App\View;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer as Renderer;

class Summary
{

    private $request;
    private $response;
    private $renderer;
    private $modelData;
    private $viewData;
    private $compIdentifiers;

    public function __construct(Request $request, Response $response, Renderer $renderer, array $modelData)
    {

        $this->request   = $request;
        $this->response  = $response;
        $this->renderer  = $renderer;
        $this->modelData = $modelData;

        $this->viewData['title'] = $this->modelData['title'];

        $this->viewData['currentProjectNameSet'] = $this->modelData['currentProjectNameData']->getCurrentProjectName();

        $this->viewData['projectList'] = $this->modelData['projectListData']->getProjectList();

    }

    public function setTableContentForValue()
    {
        $html = [];

        foreach ($this->modelData['queryresultData'] as $valueData) {
            $html[] = '<tr>';
            $html[] = '<td>' . \App\Tool::removeSchemeFromURL($valueData['projectURL']) . '</td>';
            $html[] = $this->markBestValuePerDay($valueData);
            $html[] = '</tr>';
        }

        $this->viewData['valueTable'] = implode("\n", $html);

    }

    private function markBestValuePerDay($valueData)
    {

        $css = [
            0 => '',
            1 => '',
            2 => '',
            3 => '',
            4 => '',
            5 => '',
        ];

        $valueData['val00'] = $valueData['val0'];
        $valueData['val01'] = $valueData['val1'];
        $valueData['val02'] = $valueData['val2'];
        $valueData['val03'] = $valueData['val3'];
        $valueData['val04'] = $valueData['val4'];
        $valueData['val05'] = $valueData['val5'];



        if(is_null($valueData['val0']))
            $valueData['val00'] = 9999999999999999999; // big fake nr
        if(is_null($valueData['val1']))
            $valueData['val01'] = 9999999999999999999; // big fake nr
        if(is_null($valueData['val2']))
            $valueData['val02'] = 9999999999999999999; // big fake nr
        if(is_null($valueData['val3']))
            $valueData['val03'] = 9999999999999999999; // big fake nr
        if(is_null($valueData['val4']))
            $valueData['val04'] = 9999999999999999999; // big fake nr
        if(is_null($valueData['val5']))
            $valueData['val05'] = 9999999999999999999; // big fake nr


        $positions = [
            0 => $valueData['val00'],
            1 => $valueData['val01'],
            2 => $valueData['val02'],
            3 => $valueData['val03'],
            4 => $valueData['val04'],
            5 => $valueData['val05'],
        ];

        $keyOfMin = array_keys($positions, min($positions))[0];


        if($positions[$keyOfMin] < 9999999999999999999) {
            $css[$keyOfMin] = 'class="bestPos"';
        }

        $html = [];

        $html[] = '<td ' . $css[0] . '>' . $valueData['val0'] . '</td>';
        $html[] = '<td ' . $css[1] . '>' . $valueData['val1'] . '</td>';
        $html[] = '<td ' . $css[2] . '>' . $valueData['val2'] . '</td>';
        $html[] = '<td ' . $css[3] . '>' . $valueData['val3'] . '</td>';
        $html[] = '<td ' . $css[4] . '>' . $valueData['val4'] . '</td>';
        $html[] = '<td ' . $css[5] . '>' . $valueData['val5'] . '</td>';

        return implode("\n", $html);

    }

    public function generateTrackedKeywordJSData()
    {
        $lineChart = new \App\LineChart();
        $lineChart->setConfig([
            'element'        => 'summary-keywords',
            'xkey'           => 'd',
            'ykeys'          => "['nr']",
            'labels'         => "['Getrackte Keywords']",
            'smooth'         => 'false',
            'resize'         => 'true',
            'continuousLine' => 'true'
        ]);

        $lineChart->setDataString(
                $this->prepareTrackedKeywordDataForLineChart()
        );

        $this->viewData['rankingLineJSData'] = $lineChart->generate();

    }

    private function prepareTrackedKeywordDataForLineChart()
    {
        $html = [];


        foreach ($this->modelData['queryresultData'] as $pointKey => $pointData) {
            $value = $pointData['nr'];
            if(is_null($value)) {
                $value = 'null';
            }
            $html[] = "{
                        d: '" . $pointData['rankingAddedDay'] . "',
                        nr: " . $value . "
                   }";
        }



        return implode(',', $html);

    }

    public function generateCompetitionRankingJSData()
    {
        $lineChart = new \App\LineChart();

        $dataString = $this->prepareCompetitionRankingDataForLineChart();

        $lineChart->setConfig([
            'element'         => 'summary-competition',
            'xkey'            => 'd',
            'xLabels'         => 'day',
            'ykeys'           => "['comp" . implode("','comp", $this->compIdentifiers) . "']",
            'labels'          => "[" . $this->competitionNames() . "]",
            'smooth'          => 'false',
            'resize'          => 'true',
            'continuousLine'  => 'true',
            'ymin'            => 100,
            'ymax'            => 0,
            'goals'           => '[0, 25]',
            'goalStrokeWidth' => '1',
            'goalLineColors'  => "['#d9534f']",
            'grid'            => 'true'
        ]);

        $lineChart->setDataString(
                $dataString
        );

        $this->viewData['rankingLineJSData'] = $lineChart->generate();

    }

    private function competitionNames()
    {
        $html = [];

        foreach ($this->modelData['projectData']['competitorList'] as $compDefaultKey => $compData) {

            foreach ($this->compIdentifiers as $compID) {
                if($compID == $this->modelData['projectData']['competitorList'][$compDefaultKey]['projectID']) {
                    $html[] = "'" . \App\Tool::removeSchemeFromURL($this->modelData['projectData']['competitorList'][$compDefaultKey]['projectURL']) . "'";
                }
            }
        }

        return implode(',', $html);

    }

    private function prepareCompetitionRankingDataForLineChart()
    {

        $tempData              = [];
        $this->compIdentifiers = [];
        $setCompID             = 0;

        foreach ($this->modelData['queryresultData'] as $compData) {
            $tempData[$compData['rankingAddedDay']][$compData['projectID']] = $compData['ranking'];
        }


        $html_inner = [];

        foreach ($tempData as $theDate => $projectToRank) {

            $html_dat   = [];
            $html_dat[] = "d: '$theDate'";

            foreach ($projectToRank as $pID => $pRankAvg) {
                if($setCompID == 0) {
                    $this->compIdentifiers[] = $pID;
                }
                $html_dat[] = "comp$pID:$pRankAvg";
            }

            $setCompID    = 1;
            $html_inner[] = '{' . implode(',', $html_dat) . '}';
        }


        $html_outter = implode(',', $html_inner);

        return $html_outter;

    }

    public function generateDatePicker($action = 'ranking', $add = 0)
    {
        $html = [];

        $intervals = [
            3,
            7,
            14,
            30,
            60,
            90,
            120,
            180,
            240,
            360,
            720
        ];

        foreach ($intervals as $interval) {
            $html[] = '<option ' . $this->isSelected($interval) . ' value="/summary/' . $action . '/?last=' . $interval . '">Intervall: die letzten ' . $interval . ' Tage</option>';
        }

        $this->viewData['datePicker'] = implode("\n", $html);

    }

    private function isSelected($value)
    {

        if($value == $this->modelData['timeData']['interval']) {
            return 'selected';
        }

    }

    public function generateSingleRankingJSData()
    {

        $lineChart = new \App\LineChart();
        $lineChart->setConfig([
            'element'         => 'summary-ranking',
            'xkey'            => 'd',
            'ykeys'           => "['avg']",
            'labels'          => "['Ranking im Durchschnitt']",
            'smooth'          => 'false',
            'resize'          => 'true',
            'ymin'            => 100,
            'ymax'            => 0,
            'continuousLine'  => 'true',
            'goals'           => '[0, 25]',
            'goalStrokeWidth' => '1',
            'goalLineColors'  => "['#d9534f']",
            'grid'            => 'true'
        ]);

        $lineChart->setDataString(
                $this->prepareSingleRankingDataForLineChart()
        );

        $this->viewData['rankingLineJSData'] = $lineChart->generate();

    }

    public function loadProjectData()
    {
        $this->viewData['projectData']                      = $this->modelData['projectData'];
        $this->viewData['projectData']['currentProjectURL'] = \App\Tool::removeSchemeFromURL($this->viewData['projectData']['currentProjectURL']);

    }

    private function prepareSingleRankingDataForLineChart()
    {
        $html = [];

        $iteratorPos = 1;
        $days        = 0;

        if(isset($this->modelData['queryresultData'][0])) {
            $days = (count($this->modelData['queryresultData'][0]) - 1) / 2;
        }


        while ($iteratorPos <= $days) {

            $value = $this->modelData['queryresultData'][0]['r' . $iteratorPos];
            if(is_null($value)) {
                $value = 'null';
            }
            $html[] = "{
                        d: '" . $this->modelData['queryresultData'][0]['d' . $iteratorPos] . "',
                        avg: " . $value . "
                   }";
            $iteratorPos++;
        }


        return implode(',', $html);

    }

    public function create($template = 'ranking')
    {
        $this->renderer->render($this->response, 'header.php', $this->viewData);
        $this->renderer->render($this->response, 'navigation.php', $this->viewData);
        $this->renderer->render($this->response, 'summary/' . $template . '.php', $this->viewData);
        $this->renderer->render($this->response, 'summary/footer.php', $this->viewData);

    }

}
