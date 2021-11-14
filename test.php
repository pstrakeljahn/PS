<?php

use PS\Source\BasicClasses\UserBasic;
use PS\Source\Classes\sfdf;
use PS\Source\Classes\User;
use PS\Source\Core\ClassBuilder;

require_once __DIR__ . '/autoload.php';

$t = new ClassBuilder();
$t->buildClass();
$check = new User();
$check->add('name', 'aaa');
$check->add('randNumber', 3);
$res = $check->go();
$id = $res[0]->getID();
// $ccc = $check->add('sda', 'ccc')->add('randNumber', '3')->go();
// $ddd = $check->getByPK(2);
// $ddd->setRandNumber(96);
// $ddd->delete();
// $eee = new sfdfBasic();
// $eee->setName('adas')->setRandNumber(2)->setSda('ccc');
// $eee->save();
$t = 1;
