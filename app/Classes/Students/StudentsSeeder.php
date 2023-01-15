<?php

namespace App\Classes\Students;

use App\Classes\Boards\PDOModel;
use App\Constants\Student;

class StudentsSeeder {

    protected static $instance;

    public static function getInstance(): self {
        if(is_null(self::$instance))
            self::$instance = new self;
        
            return self::$instance;
    }

    private function __construct() {
        /** PRIVATE */
    }

    public static function seed() {
        self::getInstance();
        return [
            [
                'school_board_id' => PDOModel::schoolBoardByName(Student::CSM),
                'name' => 'John Doe',
                'grades' => '5,4,4,2'
            ],
            [
                'school_board_id' => PDOModel::schoolBoardByName(Student::CSMB),
                'name' => 'Jane Doe',
                'grades' => '2,5,6,8'
            ],
            [
                'school_board_id' => PDOModel::schoolBoardByName(Student::CSM),
                'name' => 'John Smith',
                'grades' => '1,2,3,4'
            ],
        ];
    }
}