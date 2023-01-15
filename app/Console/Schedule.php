<?php 

namespace App\Console;

use App\Contracts\RedisDependency;
use App\Contracts\StudentGradesDependency;

final class Schedule extends ScheduleDependency {

    private function prepareStudentExePDO(StudentGradesDependency $studentGradesDependency) {
        $studentGradesDependency->checkStudentsGrades();
    }

    private function prepareStudentExeRedis(RedisDependency $redisDependency) {
        $redisDependency->redis();
    }

    private function prepareStudentExeMethodsPDO() {
        foreach($this->getStudentsDependenciesPDO() as $studentDependency) {
            $this->prepareStudentExePDO($studentDependency);
        }
    }

    private function prepareStudentExeMethodsRedis() {
        foreach($this->getStudentsDependenciesRedis() as $redisDependency) {
            $this->prepareStudentExeRedis($redisDependency);
        }
    }

    final public function exe(): Schedule{
        /** Execution final method for all dependencies classes methods */
        $this->prepareStudentExeMethodsPDO();
        $this->prepareStudentExeMethodsRedis();
        return $this;
    }
}