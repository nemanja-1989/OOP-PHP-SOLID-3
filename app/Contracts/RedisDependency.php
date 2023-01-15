<?php 

namespace App\Contracts;

interface RedisDependency {
    public function redis();
}