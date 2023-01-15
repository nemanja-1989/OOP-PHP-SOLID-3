<?php

namespace App\Classes\Students;

use App\Classes\Students\StudentsSeeder as StudentsStudentsSeeder;
use App\Constants\Student;
use PDO;
use App\Services\PDOService;
use SimpleXMLElement;

class PDOModel
{
    public static function getStudentById(int $id) {
        
        $sql= "SELECT students.id as id, school_boards.id as school_board_id,
         school_boards.name as board_name, students.name as student_name ,
          students.grades, students.average, students.result, students.updated_at
        FROM zeaL.students LEFT JOIN zeaL.school_boards
            ON zeaL.students.school_board_id=zeaL.school_boards.id  WHERE students.id = :id"; 
        $stmt = PDOService::pdoConnect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
        $stmt->execute();
        try {
            return $stmt->fetchObject();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getStudentByJson(int $id): string {
        $sql= "SELECT * FROM zeaL.students WHERE id = :id"; 
        $stmt = PDOService::pdoConnect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        try {
            return json_encode($results);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getStudentByXML(int $id): string {
        $student = self::getStudentById(id: $id);
        $xmlStr = <<<XML
<?xml version='1.0' standalone='yes'?>
<student>
</student>
XML;
        $xml = new SimpleXMLElement($xmlStr);   
        $xml->addChild('id', $student->id);   
        $xml->addChild('name', $student->student_name);   
        $xml->addChild('grades', $student->grades);   
        $xml->addChild('average', $student->average);  
        $xml->addChild('result', $student->result === 0 ? Student::FAIL : Student::PASS);
        try {
            return $xml->asXML();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getStudents(): array {

        $sql= "SELECT * FROM zeaL.students"; 
        $stmt = PDOService::pdoConnect()->query($sql);
        $stmt->execute();
        try {
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function updateStudent($data): void {
        $sql = "UPDATE zeaL.students SET 
        average=:average, 
        result=:result, 
        updated_at=:updated_at WHERE id=:id";
        try {
            $stmt= PDOService::pdoConnect()->prepare($sql);
            $stmt->execute($data);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function studentsSeederBulk() {
        $sql = "INSERT INTO zeaL.students (school_board_id, name, grades) VALUES(:school_board_id, :name, :grades)";
        $stmt = PDOService::pdoConnect()->prepare($sql);
        foreach(StudentsStudentsSeeder::seed() as $row) {
            try {
                $stmt->execute($row); 
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
    }
}
