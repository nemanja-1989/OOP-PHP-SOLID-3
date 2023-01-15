<?php

use App\Classes\Students\PDOModel;

require_once dirname(__DIR__) . '/zeaL/vendor/autoload.php';

/**
 * Seeder - uncomment, and run script for seed
 */

PDOModel::studentsSeederBulk();
