<?php

use function Pest\Lumen\startSession;

startSession(['foo' => 'bar'])->assertGuest();
