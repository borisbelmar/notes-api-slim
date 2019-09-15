<?php
use Slim\Routing\RouteCollectorProxy as RouteCollectorProxy;

require_once __DIR__ . '/../data/Notes.php';

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Content-Type', 'application/json');
});

$app->group('/notes', function (RouteCollectorProxy $group) {

    $group->get('[/]', function ($req, $res, $params) {
        $payload = json_encode(Notes::get_all());
        $res->getBody()->write($payload);
        return $res;
    });

    $group->post('[/]', function ($req, $res, $params) {
        $parsed_body = json_decode($req->getBody()->getContents());
        try {
            $id = Notes::create($parsed_body->note_name, $parsed_body->note_body);
            $res->getBody()->write(json_encode(["Creado!"=>$id]));
        } catch(Exception $e) {
            $res->getBody()->write(json_encode(["Status"=>"Error"]));
        }
        return $res;
    });

    $group->get('/{id}', function ($req, $res, $params) {
        $payload = json_encode(Notes::get_by_id($params['id']));
        $res->getBody()->write($payload);
        return $res;
    });

    $group->put('/{id}', function ($req, $res, $params) {
        $parsed_body = json_decode($req->getBody()->getContents());
        try {
            $id = Notes::update_by_id($params['id'], $parsed_body->note_name, $parsed_body->note_body);
            $res->getBody()->write(json_encode(["Actualizado!"=>$id]));
        } catch(Exception $e) {
            $res->getBody()->write(json_encode(["Status"=>"Error"]));
        }
        return $res;
    });

    $group->delete('/{id}', function ($req, $res, $params) {
        try {
            $id = Notes::delete_by_id($params['id']);
            $res->getBody()->write(json_encode(["Eliminado!"=>$id]));
        } catch(Exception $e) {
            $res->getBody()->write(json_encode(["Status"=>"Error"]));
        }
        return $res;
    });

});