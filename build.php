<?php

use PS\Source\Core\Builder\ClassBuilder;

require_once __DIR__ . '/autoload.php';

$t = new ClassBuilder();
$t->buildClass();
die();
