<?php

use function Pest\Lumen\{get};

get('/')->assertJson('["laravel"]');
