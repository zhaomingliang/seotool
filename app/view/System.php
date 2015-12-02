<?php

namespace App\View;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer as Renderer;

class System
{

    private $request;
    private $response;
    private $renderer;
    private $modelData;
    private $viewData;
    private $warning = 0;

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

    public function setTimeUpdateInfo()
    {
        $html = [];

        $this->calcPauseMinMax();

        foreach ($this->modelData['keywordUpdateInfo'] as $updateData) {
            $html[] = '<tr>';
            $html[] = '<td>' . $updateData['keywordUpdateHour'] . ':00 Uhr</td>';
            $html[] = '<td>' . $updateData['countKW'] . '</td>';
            $html[] = '<td>' . $this->viewData['minPause'] . ' Sek.</td>';
            $html[] = '<td>' . $this->viewData['maxPause'] . ' Sek.</td>';
            $html[] = '<td>' . $this->inMinutes($this->viewData['minPause'] * $updateData['countKW']) . ' Min.</td>';
            $html[] = '<td>' . $this->inMinutes($this->viewData['maxPause'] * $updateData['countKW']) . ' Min.</td>';
            $html[] = '</tr>';
        }

        $this->viewData['updateTimeInfo'] = implode("\n", $html);

    }

    private function inMinutes($sekValue)
    {
        $minutes = $sekValue / 60;

        if($minutes > 50) {
            $this->warning = 1;
        }

        return round($minutes, 2);

    }

    public function setWarning()
    {
        $this->viewData['systemWarning'] = '';
        if($this->warning == 1) {
            $this->viewData['systemWarning'] = '<div class="alert alert-danger"><i class="fa fa-info-circle"></i> <strong>ACHTUNG:</strong> Es gibt Zeiträume in denen kalkulatorisch der Prozess länger als 50 Minuten braucht, was vermutlich daran liegt, dass du zu viele Keywords trackst. Der Prozess <strong>darf NICHT LÄNGER ALS 1 Stunden</strong> dauern. Im optimalen Fall dauert er nicht länger als 30-40 Minuten, damit zwischen den einzelnen Aktualisierungsintervallen 20-30 Minuten Pause ohne Zugriffe auf Google sind. Das verhindert, dass Google den Crawler blockiert! <strong>Die Lösung:</strong> Verteil die hohe Anzahl an Keywords auf eine größere Anzahl von Stunden (siehe <a href="/settings/index/">Einstellungen</a>), d.h. statt "0,1,2,3,4" mach beispielsweise "0,1,2,3,4,5,6,7,8,10" draus und prüfe diese Seite wieder!</div>';
        }
        else {
            $this->viewData['systemWarning'] = '<div class="alert alert-success"><i class="fa fa-info-circle"></i> <strong>SUPER:</strong> Die Einstellungen sind soweit korrekt und es sollte keine Probleme mit geblockten Requests seitens Google geben. Ist deine Server-IP allerdings aus irgendeinem Grund vorbestraft, kann man das nicht ausschließen!</div>';
        }

    }

    private function calcPauseMinMax()
    {
        $this->viewData['minPause'] = $this->modelData['settings']['pauseStatic'];
        $this->viewData['maxPause'] = $this->modelData['settings']['pauseStatic'] + $this->modelData['settings']['pauseVariable'];

    }

    public function loadProjectData()
    {

        $this->viewData['projectData'] = $this->modelData['projectData'];

        $this->viewData['projectData']['currentProjectURL'] = \App\Tool::removeSchemeFromURL($this->viewData['projectData']['currentProjectURL']);

    }

    public function create()
    {

        $this->renderer->render($this->response, 'header.php', $this->viewData);
        $this->renderer->render($this->response, 'navigation.php', $this->viewData);
        $this->renderer->render($this->response, 'system/index.php', $this->viewData);
        $this->renderer->render($this->response, 'footer.php', $this->viewData);

    }

}
