<?php

use PS\Source\Classes\User;
use PS\Source\Core\Builder\ClassBuilder;
use PS\Source\Core\Logging\Logging;

require_once __DIR__ . '/autoload.php';

$builderInstance = new ClassBuilder();
$builderInstance->buildClass();
Logging::generateFiles();

// Insert admin
$user = User::getInstance();
$user->setUsername('admin')
    ->setPassword(password_hash('admin', PASSWORD_DEFAULT))
    ->setMail('admin@admin.de')
    ->setFirstname('admin')
    ->setSurname('admin')
    ->setRole(User::ENUM_ROLE_ADMIN)
    ->save();
echo 'Admin added';
die();
