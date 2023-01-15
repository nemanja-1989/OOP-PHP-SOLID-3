<?php 

namespace App\Classes\Students;

use App\Classes\ErrorLog;
use App\Classes\Students\PDOModel;
use App\Constants\Student as ConstantsStudent;
use App\Contracts\StudentContract;
use App\Contracts\StudentGradesDependency;
use App\ServiceModels\Redis;

class Student implements StudentContract, StudentGradesDependency {

    public static function checkStudentsGrades() {
        $students = PDOModel::getStudents();
        try{
            foreach($students as $student) {
                self::getStudentExtension($student['id']);
            }
        }catch(\Exception $e) {
            ErrorLog::logInfo(log: $e->getMessage());
        }
    }

    public static function getStudentExtension($id) {
        try{
            if(! is_null(\json_decode(Redis::getCache('student/json/' . $id)))) {
                //return student grades from Redis cache json format
                    return Redis::getCache('student/json/' . $id);   
            }else if(! is_null(\json_decode(Redis::getCache('student/xml/' . $id)))) {
                //return student grades from Redis cache xml format
                    return Redis::getCache('student/xml/' . $id); 
            }else {
                //calculate, prepare for REDIS and return student grades from Database
                    $student = PDOModel::getStudentById($id);
                    $grades = explode(",", $student->grades);
                    $average = array_sum($grades) / count($grades);
                    if($student->board_name === ConstantsStudent::CSM) {
                        $average >= 7 ? Student::calculate($student, ConstantsStudent::PASS, $id, $average, ConstantsStudent::CSM) : Student::calculate($student, ConstantsStudent::FAIL, $id, $average, ConstantsStudent::CSM); 
                    }else {
                        $grades = Student::calculateStudentGradesCSMB($grades);
                        (int)max($grades) > 8 ? Student::calculate($student, ConstantsStudent::PASS, $id, $average, ConstantsStudent::CSMB) : Student::calculate($student, ConstantsStudent::FAIL, $id, $average, ConstantsStudent::CSMB);
                    }  
           }
        }catch(\Exception $e) {
            ErrorLog::logInfo($e->getMessage());
        }
    }

    private static function calculate($student, $result, $id, $average, $schoolBoardName) {
        $data = [
            'average' => $average, 
            'result' => $result, 
            'id' => $student->id, 
            'updated_at' => date('d-m-y h:i:s')
        ];
        try{
            PDOModel::updateStudent($data);
            if($schoolBoardName === ConstantsStudent::CSM) { 
                Redis::setCache('student/json/' . $id, PDOModel::getStudentByJson($id));
                echo PDOModel::getStudentByJson($id);
            }else {
                Redis::setCache('student/xml/' . $id, PDOModel::getStudentByXML($id));
                echo PDOModel::getStudentByXML($id);
            }
        }catch(\Exception $e) {
            ErrorLog::logInfo($e->getMessage());
        }
    }
    
    private static function calculateStudentGradesCSMB($grades): array {
            $minGrade = min($grades);
              if(count($grades) > 2) {
                $grades = array_filter($grades, function($value) use ($minGrade) {
                    if((int)$value === (int)$minGrade) {
                        unset($value);
                    }
                    if(isset($value)) {
                        return $value;
                    }else {
                        return null;
                    }
                });
            }
            return $grades;
    }
}
