<?php

namespace App\Ajax;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MysqliDb as DB;

class Backlinks
{

    private $request;
    private $response;
    private $db;
    private $postArray = [];
    private $error     = 0;
    private $message   = '';

    public function __construct(Request $request, Response $response, DB $db)
    {

        $this->request  = $request;
        $this->response = $response;
        $this->db       = $db;


        if(!$request->withMethod('POST')) {
            die('Not allowed');
        }

    }

    public function update()
    {

        $this->extractBacklinks('update');
        $this->isPostDataComplete();
        if($this->error == 0) {
            $this->updateBacklink();
        }

        $this->finish();

    }

    private function updateBacklink()
    {

        $this->db->where('backlinkID', $this->postArray['backlinkID']);
        $data = [
            'backlinkSource'         => $this->postArray['linkSource'],
            'backlinkTarget'         => $this->postArray['linkTo'],
            'backlinkProject'        => $this->postArray['project'],
            'backlinkCategory'       => $this->postArray['linkType'],
            'backlinkSourceCategory' => $this->postArray['linkSourceType'],
            'backlinkRelation'       => $this->postArray['linkRelation'],
            'backlinkComment'        => $this->postArray['linkComment'],
            'backlinkLinktext'       => $this->postArray['linkText'],
        ];

        $backlinkID = $this->db->update('backlinks', $data);

        if($backlinkID > 0) {
            $this->message = '<strong>Alles klar:</strong> Der Backlink wurde mit der ID ' . $this->postArray['backlinkID'] . ' aktualisiert. Die Felder werden zurückgesetzt. Du kannst direkt den nächsten Backlink speichern.';
        }

    }

    public function add()
    {

        $this->extractBacklinks('add');
        $this->isPostDataComplete();
        if($this->error == 0) {
            $this->saveBacklink();
        }
        $this->finish();

    }

    public function remove()
    {
        $bID = $this->request->getParsedBody()['backlinkID'];

        if($bID > 0) {
            $this->db->where('backlinkID', $bID);

            if(!$this->db->delete('backlinks')) {
                $this->error   = 1;
                $this->message = '<strong>错误!</strong> 反向链接无法正常删除。';
            }
            else {
                $this->message = '<strong>成功!</strong> 反向链接已经被删除。';
            }
        }

        $this->finish();

    }

    private function saveBacklink()
    {

        $data = [
            'backlinkSource'         => $this->postArray['linkSource'],
            'backlinkTarget'         => $this->postArray['linkTo'],
            'backlinkProject'        => $this->postArray['project'],
            'backlinkCategory'       => $this->postArray['linkType'],
            'backlinkSourceCategory' => $this->postArray['linkSourceType'],
            'backlinkRelation'       => $this->postArray['linkRelation'],
            'backlinkComment'        => $this->postArray['linkComment'],
            'backlinkLinktext'       => $this->postArray['linkText'],
        ];

        $backlinkID = $this->db->insert('backlinks', $data);

        if($backlinkID > 0) {
            $this->message = '<strong>成功:</strong> 反向链接是使用ID创建 ' . $backlinkID . ' 输入。字段复位。您可以直接救下的反向链接。';
        }

    }

    private function isPostDataComplete()
    {
        if(!isset($this->postArray['linkSource']) || $this->postArray['linkSource'] == '') {
            $this->error   = 1;
            $this->message = '<strong>Fehler:</strong> Linkquelle muss gesetzt werden!';
        }
        else {
            //$this->postArray['linkSource'] = htmlspecialchars($this->postArray['linkSource']);
        }

        if(!isset($this->postArray['linkTo']) || $this->postArray['linkTo'] == '') {
            $this->error   = 1;
            $this->message = '<strong>Fehler:</strong> Linkziel muss gesetzt werden!';
        }
        else {
            $this->postArray['linkTo'] = htmlspecialchars($this->postArray['linkTo']);
        }

        if(!isset($this->postArray['project']) || intval($this->postArray['project']) == 0) {
            $this->error   = 1;
            $this->message = '<strong>Fehler:</strong> Manipulation an der Projekt ID!';
        }

        if(!isset($this->postArray['linkType']) || intval($this->postArray['linkType']) == 0) {
            $this->error   = 1;
            $this->message = '<strong>Fehler:</strong> Manipulation am Linktyp!';
        }

        if(!isset($this->postArray['linkSourceType']) || intval($this->postArray['linkSourceType']) == 0) {
            $this->error   = 1;
            $this->message = '<strong>Fehler:</strong> Manipulation an der Linkquellenbezeichnung!';
        }

        if(!isset($this->postArray['linkRelation']) || intval($this->postArray['linkRelation']) == 0) {
            $this->error   = 1;
            $this->message = '<strong>Fehler:</strong> Manipulation an der Relationen ID!';
        }

        if(isset($this->postArray['linkComment']) && $this->postArray['linkComment'] != '') {
            $this->postArray['linkComment'] = htmlspecialchars($this->postArray['linkComment']);
        }

        if(isset($this->postArray['linkText']) && $this->postArray['linkText'] != '') {
            $this->postArray['linkText'] = htmlspecialchars($this->postArray['linkText']);
        }

    }

    private function extractBacklinks($type = 'add')
    {


        $bDataString = $this->request->getParsedBody()[$type];
        $bDataString = explode("&", $bDataString);

        foreach ($bDataString as $package) {
            $eachPackage = explode("=", $package);

            $this->postArray[$eachPackage[0]] = $eachPackage[1];
        }

    }

    private function finish()
    {

        $body = $this->response->withHeader('Content-type', 'application/json');
        $body->write(
                json_encode(
                        [
                            'error'   => $this->error,
                            'message' => $this->message
                        ]
                )
        );

    }

}
