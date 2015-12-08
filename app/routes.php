<?php

$app->get('/login/', function ($request, $response) {

    $session = new \RKA\Session();

    if($session->loggedin === '1') {
        return $response->withStatus(301)->withHeader('Location', '/dashboard/index/');
    }

    $c = new App\Controller\Login($request, $response, $this->renderer);
    $c->showlogin();
});

$app->post('/login/', function ($request, $response) {

    return $response->withStatus(301)->withHeader('Location', '/dashboard/index/');
})->add(new App\SimpleAuth());

$app->get('/logout/', function ($request, $response) {
    return $response->withStatus(301)->withHeader('Location', '/login/');
})->add(new App\Logout());

$app->get('/{class:dashboard|settings}/index/', function ($request, $response, $args) {

    $className  = 'App\\Controller\\' . ucfirst($args['class']);
    $controller = new $className($request, $response, $this->db, $this->renderer);
    $controller->index();
})->add(new App\CheckAuth());

$app->get('/system/{action:index|logging}/', function ($request, $response, $args) {

    $controller = new App\Controller\System($request, $response, $this->db, $this->renderer);
    $controller->$args['action']();
})->add(new App\CheckAuth());


$app->get('/summary/{action:ranking|competition|keywords|value|positions}/', function ($request, $response, $args) {

    $controller = new App\Controller\Summary($request, $response, $this->db, $this->renderer);
    $controller->$args['action']();
})->add(new App\CheckAuth());


$app->group('/keywords', function () {
    $this->get('/{action:index|add|competition|chances|export}/', function ($request, $response, $args) {
        $controller = new App\Controller\Keywords($request, $response, $this->db, $this->renderer);
        $controller->$args['action']();
    });

    $this->get('/chart/{id:\d+}/', function ($request, $response, $args) {
        $controller = new App\Controller\Keywords($request, $response, $this->db, $this->renderer);
        $controller->chart($args['id']);
    });
})->add(new App\CheckAuth());


$app->group('/projects', function () {
    $this->get('/{action:index|add}/', function ($request, $response, $args) {
        $controller = new App\Controller\Projects($request, $response, $this->db, $this->renderer);
        $controller->$args['action']();
    });

    $this->get('/edit/{id:\d+}/', function ($request, $response, $args) {
        $controller = new App\Controller\Projects($request, $response, $this->db, $this->renderer);
        $controller->edit($args['id']);
    });

    $this->get('/select/{id:\d+}/', function ($request, $response, $args) {
        $session = new \RKA\Session();
        $session->set('currentProject', $args['id']);
        return $response->withStatus(301)->withHeader('Location', '/dashboard/index/');
    });
})->add(new App\CheckAuth());


$app->group('/backlinks', function () {
    $this->get('/{action:index|add}/', function ($request, $response, $args) {
        $controller = new App\Controller\Backlinks($request, $response, $this->db, $this->renderer);
        $controller->$args['action']();
    });

    $this->get('/edit/{id:\d+}/', function ($request, $response, $args) {
        $controller = new App\Controller\Backlinks($request, $response, $this->db, $this->renderer);
        $controller->edit($args['id']);
    });
})->add(new App\CheckAuth());

$app->group('/ajax', function () {

    $this->post('/{class:projects|keywords|settings|backlinks}/{action:add|remove|update}/', function ($request, $response, $args) {

        $className = '\\App\\Ajax\\' . ucfirst($args['class']);

        $c = new $className($request, $response, $this->db);
        $c->$args['action']();
    });
})->add(new App\CheckAuth());


#########################################
## Mocking some random data
#########################################
$app->get('/mocker/', function() {

    $projects = $this->db->get('projects');

    foreach ($projects as $project) {
        $this->db->where('projectID', $project['projectID']);
        $this->db->delete('projects');
    }


    $projectsAdd = [
        1 => [
            'projectID'       => '1',
            'projectIsParent' => '1',
            'parentProjectID' => '1',
            'projectURL'      => 'http://www.project1.de',
        ],
        2 => [
            'projectID'       => '2',
            'projectIsParent' => '0',
            'parentProjectID' => '1',
            'projectURL'      => 'http://www.p1-comp1.de',
        ],
        3 => [
            'projectID'       => '3',
            'projectIsParent' => '0',
            'parentProjectID' => '1',
            'projectURL'      => 'http://www.p1-comp2.de',
        ],
        4 => [
            'projectID'       => '4',
            'projectIsParent' => '0',
            'parentProjectID' => '1',
            'projectURL'      => 'http://www.p1-comp3.de',
        ],
        5 => [
            'projectID'       => '5',
            'projectIsParent' => '1',
            'parentProjectID' => '5',
            'projectURL'      => 'http://www.project2.de',
        ],
        6 => [
            'projectID'       => '6',
            'projectIsParent' => '0',
            'parentProjectID' => '5',
            'projectURL'      => 'http://www.p2-comp1.de',
        ],
        7 => [
            'projectID'       => '7',
            'projectIsParent' => '0',
            'parentProjectID' => '5',
            'projectURL'      => 'http://www.p2-comp2.de'
        ],
    ];

    foreach ($projectsAdd as $project) {
        $this->db->insert('projects', $project);
    }

    $startID     = 1;
    $endID       = 25;
    $pattern     = 'kw-p1-';
    $keywordsOne = [];

    while ($startID <= $endID) {

        $keywordsOne[$startID] = $pattern . $startID;


        $this->db->insert('keywords', [
            'keywordID'       => $startID,
            'keywordName'     => $pattern . $startID,
            'keywordTraffic'  => rand(100, 2000),
            'parentProjectID' => 1,
        ]);

        $startID++;
    }

    $projectsOne = [
        1,
        2,
        3,
        4
    ];

    $days = 30;

    while ($days >= 0) {

        foreach ($projectsOne as $projectsID) {
            foreach ($keywordsOne as $kwID => $kwText) {
                $mockPosition = rand(0, 108);
                if($mockPosition == 0) {
                    $mockPosition = NULL;
                }

                $this->db->insert('rankings', [
                    'keywordID'       => $kwID,
                    'projectID'       => $projectsID,
                    'rankingPosition' => $mockPosition,
                    'rankingURL'      => 'http://www.' . $kwID . '-' . $mockPosition . '-' . $projectsID . '-1.de/',
                    'rankingAdded'    => date('Y-m-d G:i:s', strtotime('-' . $days . ' day')),
                    'rankingAddedDay' => date('Y-m-d', strtotime('-' . $days . ' day')),
                ]);
            }
        }
        $days--;
    }

    foreach ($projectsOne as $projectID) {

        $backlinks = rand(20, 40);
        while ($backlinks > 0) {
            $commentR = rand(0, 1);
            $comment  = 'Langer Kommentar voller Einfallslosigkeit für Projekt ID ' . $projectID . ' Zufall: ' . rand(100, 200);
            if($commentR > 0) {
                $comment = '';
            }

            $data = [
                'backlinkSource'         => 'http://beispiel-quelle-' . $projectID . rand(100, 200) . '.de',
                'backlinkTarget'         => 'http://beispiel-ziel-' . $projectID . rand(100, 200) . '.de',
                'backlinkCategory'       => rand(1, 6),
                'backlinkSourceCategory' => rand(1, 6),
                'backlinkRelation'       => rand(1, 2),
                'backlinkLinkText'       => 'Linktext ' . $projectID . rand(100, 200),
                'backlinkProject'        => $projectID,
                'backlinkComment'        => $comment,
            ];

            $this->db->insert('backlinks', $data);
            $backlinks--;
        }
    }

    // Rest

    $startID     = 26;
    $endID       = 70;
    $pattern     = 'kw-p2-';
    $keywordsOne = [];

    while ($startID <= $endID) {

        $keywordsOne[$startID] = $pattern . $startID;


        $this->db->insert('keywords', [
            'keywordID'       => $startID,
            'keywordName'     => $pattern . $startID,
            'keywordTraffic'  => rand(100, 2000),
            'parentProjectID' => 5,
        ]);

        $startID++;
    }

    $projectsOne = [
        5,
        6,
        7
    ];

    $days = 45;

    while ($days >= 0) {

        foreach ($projectsOne as $projectsID) {
            foreach ($keywordsOne as $kwID => $kwText) {
                $mockPosition = rand(0, 108);
                if($mockPosition == 0) {
                    $mockPosition = NULL;
                }

                $this->db->insert('rankings', [
                    'keywordID'       => $kwID,
                    'projectID'       => $projectsID,
                    'rankingPosition' => $mockPosition,
                    'rankingURL'      => 'http://www.' . $kwID . '-' . $mockPosition . '-' . $projectsID . '-1.de/',
                    'rankingAdded'    => date('Y-m-d G:i:s', strtotime('-' . $days . ' day')),
                    'rankingAddedDay' => date('Y-m-d', strtotime('-' . $days . ' day')),
                ]);
            }
        }
        $days--;
    }

    foreach ($projectsOne as $projectID) {

        $backlinks = rand(20, 40);
        while ($backlinks > 0) {
            $commentR = rand(0, 1);
            $comment  = 'Langer Kommentar voller Einfallslosigkeit für Projekt ID ' . $projectID . ' Zufall: ' . rand(100, 200);
            if($commentR > 0) {
                $comment = '';
            }

            $data = [
                'backlinkSource'         => 'http://beispiel-quelle-' . $projectID . rand(100, 200) . '.de',
                'backlinkTarget'         => 'http://beispiel-ziel-' . $projectID . rand(100, 200) . '.de',
                'backlinkCategory'       => rand(1, 6),
                'backlinkSourceCategory' => rand(1, 6),
                'backlinkRelation'       => rand(1, 2),
                'backlinkLinkText'       => 'Linktext ' . $projectID . rand(100, 200),
                'backlinkProject'        => $projectID,
                'backlinkComment'        => $comment,
            ];

            $this->db->insert('backlinks', $data);
            $backlinks--;
        }
    }

    $c = new \App\ReorderKeywords($this->db, '0,1,2,3,4,5,6,7,8,9');
    $c->start();


    echo 'Done';
    echo '<br />';
})->add(new App\CheckAuth());
