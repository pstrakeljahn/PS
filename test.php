<?php

use PS\Source\Core\Builder\ClassBuilder;

require_once __DIR__ . '/autoload.php';

$t = new ClassBuilder();
$t->buildClass();
$check = new PS\Source\Classes\User();
// $check->add(User::NAME, 'aaa');
// $check->add(User::RANDNUMBER, 3);
// $res = $check->go();
// $id = $res[0]->getID();
// $ccc = $check->add('sda', 'ccc')->add('randNumber', '3')->go();
// $ddd = $check->getByPK(2);
// $ddd->setRandNumber(96);
// $ddd->delete();
// $eee = new sfdfBasic();
// $eee->setName('adas')->setRandNumber(2)->setSda('ccc');
// $eee->save();
$t = 1;
