<?php

namespace App\Ajax;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MysqliDb as DB;

class System
{

    private $request;
    private $response;
    private $db;
    private $error   = 0;
    private $message = '';

    public function __construct(Request $request, Response $response, DB $db)
    {

        $this->request  = $request;
        $this->response = $response;
        $this->db       = $db;

        if(!$request->withMethod('POST')) {
            die('Not allowed');
        }

    }

    public function cleanlog()
    {
        $this->db->delete('logs');
        $this->message = 'Logs vollständig gelöscht!';

        $this->finish();

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
