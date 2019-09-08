<?php
use Slim\Routing\RouteCollectorProxy as RouteCollectorProxy;

require_once __DIR__ . '/../data/Notes.php';

$app->group('/notes', function (RouteCollectorProxy $group) {
    
    $group->get('[/]', function ($req, $res, $params) {
        $payload = json_encode(Notes::get_all());
        $res->getBody()->write($payload);
        return $res->withHeader('Content-Type', 'application/json');
    });

    $group->post('[/]', function ($req, $res, $params) {
        $parsedbody = json_decode($req->getBody()->getContents());
        try {
            $id = Notes::create($parsedbody->name, $parsedbody->body);
            $res->getBody()->write(json_encode(["Creado!"=>$id]));
        } catch(Exception $e) {
            $res->getBody()->write(json_encode(["Status"=>"Error"]));
        }
        return $res->withHeader('Content-Type', 'application/json');
    });

    $group->get('/{id}', function ($req, $res, $params) {
        $payload = json_encode(Notes::get_by_id($params['id']));
        $res->getBody()->write($payload);
        return $res->withHeader('Content-Type', 'application/json');
    });

    $group->put('/{id}', function ($req, $res, $params) {
        $parsedbody = json_decode($req->getBody()->getContents());
        try {
            $id = Notes::update_by_id($params['id'], $parsedbody->name, $parsedbody->body);
            $res->getBody()->write(json_encode(["Actualizado!"=>$id]));
        } catch(Exception $e) {
            $res->getBody()->write(json_encode(["Status"=>"Error"]));
        }
        return $res->withHeader('Content-Type', 'application/json');
    });

    $group->delete('/{id}', function ($req, $res, $params) {
        try {
            $id = Notes::delete_by_id($params['id']);
            $res->getBody()->write(json_encode(["Eliminado!"=>$id]));
        } catch(Exception $e) {
            $res->getBody()->write(json_encode(["Status"=>"Error"]));
        }
        return $res->withHeader('Content-Type', 'application/json');
    });

});