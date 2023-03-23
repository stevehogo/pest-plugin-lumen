<?php

use function Pest\Lumen\{withoutMiddleware};

withoutMiddleware()->get('/')->seeJson(['laravel']);
