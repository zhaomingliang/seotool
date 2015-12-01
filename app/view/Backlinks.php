<?php

namespace App\View;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer as Renderer;

class Backlinks
{

    private $request;
    private $response;
    private $renderer;
    private $modelData;

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

    public function setBacklinkID($blID)
    {
        $this->viewData['backlinkID'] = $blID;

    }

    private function makeTargetLinkPretty($url)
    {
        $url_final = $url;
        $url       = parse_url(urldecode($url));

        if(isset($url['host'])) {
            $url_final = $url['host'];
        }
        else if($url['path']) {
            $url_final = $url['path'];
        }

        return $url_final;

    }

    public function setBacklinkTable()
    {
        $html = [];

        foreach ($this->modelData['backlinkList'] as $backlinkItem) {
            $html[] = '<tr class="b' . $backlinkItem['backlinkID'] . '">';
            $html[] = '<td>' . $backlinkItem['backlinkID'] . '</td>';
            $html[] = '<td><a href="' . urldecode($backlinkItem['backlinkSourceURL']) . '" target="_blank">' . $this->makeTargetLinkPretty($backlinkItem['backlinkSourceURL']) . '</a> [' . urldecode($backlinkItem['backlinkLinkText']) . ']</td>';
            $html[] = '<td><a href="' . urldecode($backlinkItem['backlinkTarget']) . '" target="_blank">' . $this->makeTargetLinkPretty($backlinkItem['backlinkTarget']) . '</a></td>';
            $html[] = '<td>' . $backlinkItem['backlinkCategory'] . '</td>';
            $html[] = '<td>' . $backlinkItem['backlinkSource'] . '</td>';
            $html[] = '<td>' . $backlinkItem['backlinkRelation'] . '</td>';
            if($backlinkItem['backlinkComment'] != '') {
                $html[] = '<td><i data-toggle="modal" data-target="#commentModal" class="fa fa-comment green" data-comment="' . htmlspecialchars(urldecode($backlinkItem['backlinkComment'])) . '"></i></td>';
            }
            else {
                $html[] = '<td></td>';
            }

            $html[] = '<td><a href="/backlinks/edit/' . $backlinkItem['backlinkID'] . '/"><i class="fa fa-edit backlinkEdit"></i></a></td>';
            $html[] = '<td><i data-bid="' . $backlinkItem['backlinkID'] . '" class="fa fa-remove backlinkRemove"></i></td>';
            $html[] = '</tr>';
        }

        $this->viewData['backlinkTable'] = implode("\n", $html);

    }

    public function setRelations()
    {
        $html = [];

        foreach ($this->modelData['linkRelations'] as $linkRelations) {
            $selected = '';
            if(isset($this->modelData['backlinkData']['backlinkRelation']) && $linkRelations['backlinkRelationID'] == $this->modelData['backlinkData']['backlinkRelation']) {
                $selected = 'selected="selected"';
            }
            $html[] = '<option ' . $selected . ' value="' . $linkRelations['backlinkRelationID'] . '">' . $linkRelations['backlinkRelation'] . ' </option>';
        }

        $this->viewData['linkRelations'] = implode("\n", $html);

    }

    public function setLinkSourceTypes()
    {
        $html = [];

        foreach ($this->modelData['linkSourceTypes'] as $linkSourceType) {
            $selected = '';

            if(isset($this->modelData['backlinkData']['backlinkSourceCategory']) && $linkSourceType['backlinkSourceID'] == $this->modelData['backlinkData']['backlinkSourceCategory']) {
                $selected = 'selected="selected"';
            }
            $html[] = '<option ' . $selected . ' value="' . $linkSourceType['backlinkSourceID'] . '">' . $linkSourceType['backlinkSource'] . ' </option>';
        }

        $this->viewData['linkSourceTypes'] = implode("\n", $html);

    }

    public function setLinkTypes()
    {
        $html = [];

        foreach ($this->modelData['linkTypes'] as $linkType) {
            $selected = '';
            if(isset($this->modelData['backlinkData']['backlinkCategory']) && $linkType['backlinkCategoryID'] == $this->modelData['backlinkData']['backlinkCategory']) {
                $selected = 'selected="selected"';
            }
            $html[] = '<option ' . $selected . ' value="' . $linkType['backlinkCategoryID'] . '">' . $linkType['backlinkCategory'] . ' </option>';
        }

        $this->viewData['linkTypes'] = implode("\n", $html);

    }

    public function setProjectList()
    {
        $html = [];

        foreach ($this->modelData['projectData']['competitorList'] as $project) {

            $selected   = '';
            $subproject = 'Konkurrent: ';

            if(( isset($this->modelData['backlinkData']['backlinkProject']) && ($this->modelData['backlinkData']['backlinkProject'] == $project['projectID']) ) || ($project['projectID'] == $this->modelData['projectData']['currentProjectParentID'])) {
                $selected   = 'selected="selected"';
                $subproject = '';
            }
            $html[] = '<option ' . $selected . ' value="' . $project['projectID'] . '">' . $subproject . \App\Tool::removeSchemeFromURL($project['projectURL']) . ' </option>';
        }
        $this->viewData['projectListSelect'] = implode("\n", $html);

    }

    public function setTextValueForBacklinkEdit()
    {

        $this->viewData['backlinkSource']   = urldecode($this->modelData['backlinkData']['backlinkSource']);
        $this->viewData['backlinkTarget']   = urldecode($this->modelData['backlinkData']['backlinkTarget']);
        $this->viewData['backlinkComment']  = urldecode($this->modelData['backlinkData']['backlinkComment']);
        $this->viewData['backlinkLinkText'] = urldecode($this->modelData['backlinkData']['backlinkLinktext']);

    }

    public function loadProjectData()
    {
        $this->viewData['projectData'] = $this->modelData['projectData'];

        $this->viewData['projectData']['currentProjectURL'] = \App\Tool::removeSchemeFromURL($this->viewData['projectData']['currentProjectURL']);

    }

    public function create($template = 'index')
    {
        $this->renderer->render($this->response, 'header.php', $this->viewData);
        $this->renderer->render($this->response, 'navigation.php', $this->viewData);
        $this->renderer->render($this->response, 'backlinks/' . $template . '.php', $this->viewData);
        $this->renderer->render($this->response, 'backlinks/footer.php', $this->viewData);

    }

}
