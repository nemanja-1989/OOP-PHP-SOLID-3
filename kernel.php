<?php

use App\Console\Schedule;

require_once dirname(__DIR__) . '/zeaL/vendor/autoload.php';

/**
 * CRON
 */
$exe = new Schedule();
$exe->exe();