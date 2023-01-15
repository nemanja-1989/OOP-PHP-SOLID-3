<?php 

namespace App\Console;

use App\Classes\Students\Student;
use App\Classes\Students\CacheStudent;

class ScheduleDependency {

    private function studentsDependencies(): array {
        return [
            new Student
        ];
    }

    private function studentsRedis(): array {
        return [
            new CacheStudent
        ];
    }

    public function getStudentsDependenciesPDO(): array {
        
        return $this->studentsDependencies();
    }

    public function getStudentsDependenciesRedis(): array {
        
        return $this->studentsRedis();
    }
}