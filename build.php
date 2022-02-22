<?php

use PS\Source\Classes\User;
use PS\Source\Core\Builder\ClassBuilder;

require_once __DIR__ . '/autoload.php';

$builderInstance = new ClassBuilder();
$builderInstance->buildClass();

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
