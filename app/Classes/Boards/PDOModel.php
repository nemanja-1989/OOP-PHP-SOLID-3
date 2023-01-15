<?php 

namespace App\Classes\Boards;

use App\Services\PDOService;
use PDO;

class PDOModel {

    public static function schoolBoardByName($name) {
        $sql= "SELECT * FROM zeaL.school_boards WHERE name = :name"; 
        $stmt = PDOService::pdoConnect()->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR); 
        $stmt->execute();
        try {
            return $stmt->fetchObject()->id; 
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}