<?php
require_once('Database.php');

class Notes {

    static function create($note_name, $note_body) {
        try {
            $db = new Database();
            $dbconnection = $db->connect();
            $stmt = $dbconnection->prepare(
                "INSERT INTO notes(note_user, note_name, note_body) VALUES
                (1, :note_name, :note_body)"
            );
            $stmt->execute(
                [
                    ':note_name'=>$note_name, 
                    ':note_body'=>$note_body
                ]
            );
            return $dbconnection->lastInsertId();
        } catch(PDOException $e) {
            echo "Error al insertar<br>";
            echo $e->getMessage();
            exit;
        }
    }

    static function get_all() {
        try {
            $db = new Database();
            $dbconnection = $db->connect();
            $stmt = $dbconnection->prepare("SELECT note_id, note_name, note_body, created_at, updated_at FROM notes");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $stmt = null;
            return $rows;
        } catch(PDOException $e) {
            echo "Error en la consulta<br>";
            echo $e->getMessage();
            exit;
        }
    }

    static function get_by_id($note_id) {
        try {
            $db = new Database();
            $dbconnection = $db->connect();
            $stmt = $dbconnection->prepare("SELECT note_id, note_name, note_body, created_at, updated_at FROM notes WHERE note_id = :note_id");
            $stmt->execute(
                [':note_id'=>$note_id]
            );
            $rows = $stmt->fetchAll();
            $stmt = null;
            return $rows[0];
        } catch(PDOException $e) {
            echo "Error en la consulta<br>";
            echo $e->getMessage();
            exit;
        }
    }

    static function update_by_id($note_id, $note_name, $note_body) {
        try {
            $db = new Database();
            $dbconnection = $db->connect();
            $stmt = $dbconnection->prepare(
                "UPDATE notes SET 
                note_name = :note_name, 
                note_body = :note_body
                WHERE note_id = :note_id"
            );
            $stmt->execute(
                [
                    ':note_name'=>$note_name, 
                    ':note_body'=>$note_body, 
                    ':note_id'=>$note_id
                ]
            );
            $stmt->execute();
            return $note_id;
        } catch(PDOException $e) {
            echo "Error al actualizar<br>";
            echo $e->getMessage();
            exit;
        }
    }

    static function delete_by_id($note_id) {
        try {
            $db = new Database();
            $dbconnection = $db->connect();
            $stmt = $dbconnection->prepare(
                "DELETE FROM notes WHERE note_id = :note_id"
            );
            $stmt->execute(
                [':note_id'=>$note_id]
            );
            $stmt->execute();
            return $note_id;
        } catch(PDOException $e) {
            echo "Error al actualizar<br>";
            echo $e->getMessage();
            exit;
        }
    }

}