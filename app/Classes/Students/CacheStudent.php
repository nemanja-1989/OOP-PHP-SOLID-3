<?php

namespace App\Classes\Students;

use App\Classes\ErrorLog;
use App\Classes\Students\PDOModel;
use App\Contracts\RedisDependency;
use App\ServiceModels\Redis;
use Predis\PredisException;

class CacheStudent implements RedisDependency
{

    public function redis(): void
    {
        $this->redisStudents();
        $this->redisStudent();
    }

    private function redisStudents(): void
    {
        try{
            Redis::setCache(name: 'students', data: \json_encode(PDOModel::getStudents()));
        }catch(PredisException $e) {
            ErrorLog::logInfo(log: $e->getMessage());
        }
    }

    private function redisStudent(): void
    {
        try{
            if (Redis::getCache(name: 'students')) {
                foreach (\json_decode(Redis::getCache(name: 'students'), TRUE) as $student) {
                    Student::getStudentExtension($student['id']);
                }
            }
        }catch(PredisException $e) {
            ErrorLog::logInfo(log: $e->getMessage());
        }
    }
}